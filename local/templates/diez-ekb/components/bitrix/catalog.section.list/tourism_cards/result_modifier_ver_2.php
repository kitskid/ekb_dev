<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Цвета для карточек в том же порядке, что и в верстке
$colors = ['red', 'orange', 'purple', 'purple', 'green', 'yellow', 'blue', 'red', 'green'];
$colorIndex = 0;

// Получаем ID разделов для загрузки дополнительных данных
$sectionIds = array_column($arResult['SECTIONS'], 'ID');

if (!empty($sectionIds)) {
    // Загрузим дополнительные данные для разделов с пользовательскими полями
    $sectionsExtra = array();
    $rsSections = CIBlockSection::GetList(
        array(),
        array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $sectionIds),
        false,
        array("ID", "UF_*") // Загружаем все пользовательские поля
    );

    while ($section = $rsSections->Fetch()) {
        $sectionsExtra[$section["ID"]] = $section;
    }

    // Если есть поле с тегами, загружаем связанные разделы
    $tagSections = array();
    foreach ($sectionsExtra as $sectionId => $sectionData) {
        // Ищем поле с тегами (может называться UF_TAGS, UF_TAGS_SECTION и т.д.)
        $tagsField = null;
        foreach ($sectionData as $key => $value) {
            if (strpos($key, 'UF_') === 0 && strpos(strtolower($key), 'tag') !== false && !empty($value)) {
                $tagsField = $value;
                break;
            }
        }

        if ($tagsField && is_array($tagsField)) {
            $rsTagSections = CIBlockSection::GetList(
                array("SORT" => "ASC"),
                array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $tagsField),
                false,
                array("ID", "NAME", "SECTION_PAGE_URL")
            );

            $tagSections[$sectionId] = array();
            while ($tagSection = $rsTagSections->GetNext()) {
                $tagSections[$sectionId][] = array(
                    "ID" => $tagSection["ID"],
                    "NAME" => $tagSection["NAME"],
                    "URL" => $tagSection["SECTION_PAGE_URL"]
                );
            }
        }
    }

    // Обрабатываем каждый раздел
    foreach ($arResult['SECTIONS'] as &$section) {
        // Добавляем теги
        $section["TAGS"] = isset($tagSections[$section["ID"]]) ? $tagSections[$section["ID"]] : array();

        // Добавляем цвет карточки
        // Сначала проверяем, есть ли пользовательское поле с цветом
        $colorField = null;
        if (isset($sectionsExtra[$section["ID"]])) {
            foreach ($sectionsExtra[$section["ID"]] as $key => $value) {
                if (strpos($key, 'UF_') === 0 && strpos(strtolower($key), 'color') !== false && !empty($value)) {
                    $colorField = $value;
                    break;
                }
            }
        }

        $section["COLOR"] = $colorField ? $colorField : $colors[$colorIndex % count($colors)];
        $colorIndex++;

        // Подготавливаем изображение
        if ($section["PICTURE"]) {
            $section["PICTURE"] = CFile::ResizeImageGet(
                $section["PICTURE"],
                array("width" => 800, "height" => 600),
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true
            );
        }

        // Формируем правильный URL для детальной страницы
        $section["SECTION_PAGE_URL"] = "/tourism/" . $section["CODE"] . "/";
    }
    unset($section);
}

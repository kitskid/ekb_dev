<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Цвета для карточек в том же порядке, что и в верстке
$colors = ['red', 'orange', 'purple', 'purple', 'green', 'yellow', 'blue', 'red', 'green'];
$colorIndex = 0;

// Получаем ID разделов для дальнейшей работы
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
        // Ищем поле с тегами
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

    // Получаем элементы для каждого раздела (по одному элементу на раздел)
    $sectionElements = array();
    foreach ($sectionIds as $sectionId) {
        $rsElements = CIBlockElement::GetList(
            array("SORT" => "ASC"),
            array(
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $sectionId,
                "ACTIVE" => "Y"
            ),
            false,
            array("nTopCount" => 1), // Берем только первый элемент
            array("ID", "CODE", "NAME")
        );

        if ($element = $rsElements->GetNext()) {
            $sectionElements[$sectionId] = $element;
        }
    }

    // Обрабатываем каждый раздел
    foreach ($arResult['SECTIONS'] as &$section) {
        // Добавляем теги
        $section["TAGS"] = isset($tagSections[$section["ID"]]) ? $tagSections[$section["ID"]] : array();

        // Добавляем цвет карточки
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

        // Формируем URL на основе кода элемента (а не раздела)
        if (isset($sectionElements[$section["ID"]]) && !empty($sectionElements[$section["ID"]]["CODE"])) {
            $section["SECTION_PAGE_URL"] = "/tourism/" . $sectionElements[$section["ID"]]["CODE"];
            $section["ELEMENT_CODE"] = $sectionElements[$section["ID"]]["CODE"];
        } else {
            // Если элемента нет, используем код раздела как fallback
            $section["SECTION_PAGE_URL"] = "/tourism/" . $section["CODE"] . "/";
            $section["ELEMENT_CODE"] = $section["CODE"];
        }
    }
    unset($section);
}

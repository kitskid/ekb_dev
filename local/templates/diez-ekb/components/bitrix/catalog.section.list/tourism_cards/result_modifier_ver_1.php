<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Цвета для карточек (можно настроить по своему усмотрению)
$colors = ['red', 'orange', 'purple', 'green', 'yellow', 'blue'];
$colorIndex = 0;

// Получаем пользовательские поля разделов
$sectionIds = array_column($arResult['SECTIONS'], 'ID');
if (!empty($sectionIds)) {
    $rsUserFields = CUserFieldEnum::GetList(array(), array(
        "ENTITY_ID" => "IBLOCK_" . $arParams["IBLOCK_ID"] . "_SECTION",
        "FIELD_NAME" => "UF_TAGS_SECTION"
    ));

    $userFieldValues = array();
    while ($userField = $rsUserFields->Fetch()) {
        $userFieldValues[$userField["ID"]] = $userField;
    }

    // Загрузим дополнительные данные для разделов
    $sectionsExtra = array();
    $rsSections = CIBlockSection::GetList(
        array(),
        array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $sectionIds),
        false,
        array("ID", "UF_TAGS_SECTION")
    );

    while ($section = $rsSections->Fetch()) {
        $sectionsExtra[$section["ID"]] = $section;
    }

    // Загрузим информацию о связанных разделах (теги)
    $tagSections = array();
    if (!empty($sectionsExtra)) {
        foreach ($sectionsExtra as $sectionId => $sectionData) {
            if (!empty($sectionData["UF_TAGS_SECTION"]) && is_array($sectionData["UF_TAGS_SECTION"])) {
                $tagIds = $sectionData["UF_TAGS_SECTION"];

                $rsTagSections = CIBlockSection::GetList(
                    array("SORT" => "ASC"),
                    array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $tagIds),
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
    }

    // Добавляем полученные данные в результирующий массив
    foreach ($arResult['SECTIONS'] as &$section) {
        // Добавляем теги
        $section["TAGS"] = isset($tagSections[$section["ID"]]) ? $tagSections[$section["ID"]] : array();

        // Добавляем цвет карточки
        $section["COLOR"] = $colors[$colorIndex % count($colors)];
        $colorIndex++;

        // Подготовим изображение для показа
        if ($section["PICTURE"]) {
            $section["PICTURE"] = CFile::ResizeImageGet(
                $section["PICTURE"],
                array("width" => 800, "height" => 600),
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true
            );
        }
    }
    unset($section);
}

// Добавляем заголовок раздела
$arResult["SECTION_TITLE"] = "Гостям города";
$arResult["BUTTON_TEXT"] = "Виды туризма";

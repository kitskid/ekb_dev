<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Подготавливаем данные для отображения
foreach ($arResult["ITEMS"] as $key => &$arItem) {
    // Проверяем наличие свойства TOP
    $arItem["PROPERTIES"]["TOP"]["VALUE"] = !empty($arItem["PROPERTIES"]["TOP"]["VALUE"]) ? "Y" : "";

    // Обрабатываем галерею изображений
    if (!empty($arItem["PROPERTIES"]["GALLERY"]["VALUE"]) && is_array($arItem["PROPERTIES"]["GALLERY"]["VALUE"])) {
        $arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"] = array();
        foreach ($arItem["PROPERTIES"]["GALLERY"]["VALUE"] as $fileId) {
            $file = CFile::GetFileArray($fileId);
            if ($file) {
                $arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"][] = $file;
            }
        }
    }

    // Если нет превью, но есть галерея, используем первое изображение из галереи как превью
    if (!$arItem["PREVIEW_PICTURE"] && !empty($arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"][0])) {
        $arItem["PREVIEW_PICTURE"] = array(
            "SRC" => $arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"][0]["SRC"]
        );
    }
}

// Проверяем, есть ли фильтр по кухне в запросе
if (isset($_REQUEST['cuisine']) && $_REQUEST['cuisine'] != 'all' && !empty($_REQUEST['cuisine'])) {
    $filterCategory = $_REQUEST['cuisine'];

    // Фильтруем элементы по выбранной категории
    $filteredItems = array();
    foreach ($arResult["ITEMS"] as $arItem) {
        if (isset($arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"]) &&
            $arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"] == $filterCategory) {
            $filteredItems[] = $arItem;
        }
    }

    // Заменяем элементы отфильтрованными
    if (!empty($filteredItems)) {
        $arResult["ITEMS"] = $filteredItems;
    }
}
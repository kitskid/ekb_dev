<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Фильтруем существующие элементы - оставляем только для самостоятельных туристов
$filteredItems = array();

if (!empty($arResult["ITEMS"])) {
    foreach ($arResult["ITEMS"] as $arItem) {
        $found = false;

        // Проверяем свойство TYPE (множественное)
        if (!empty($arItem["PROPERTIES"]["TYPE"]["VALUE_ENUM"])) {
            $typeValues = $arItem["PROPERTIES"]["TYPE"]["VALUE_ENUM"];

            if (is_array($typeValues)) {
                if (in_array("для самостоятельных туристов", $typeValues)) {
                    $found = true;
                }
            } else {
                if ($typeValues == "для самостоятельных туристов") {
                    $found = true;
                }
            }
        }

        // Альтернативная проверка через VALUE (ID)
        if (!$found && !empty($arItem["PROPERTIES"]["TYPE"]["VALUE"])) {
            $typeValues = $arItem["PROPERTIES"]["TYPE"]["VALUE"];

            if (is_array($typeValues)) {
                if (in_array("81", $typeValues)) {
                    $found = true;
                }
            } else {
                if ($typeValues == "81") {
                    $found = true;
                }
            }
        }

        if ($found) {
            $filteredItems[] = $arItem;
        }
    }
}

$arResult["ITEMS"] = $filteredItems;
?>

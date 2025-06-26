<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Фильтруем существующие элементы - оставляем только топовые
$filteredItems = array();

if (!empty($arResult["ITEMS"])) {
    foreach ($arResult["ITEMS"] as $arItem) {
        // Проверяем свойство TOP
        if (!empty($arItem["PROPERTIES"]["TOP"]["VALUE_ENUM"]) &&
            $arItem["PROPERTIES"]["TOP"]["VALUE_ENUM"] == "да") {
            $filteredItems[] = $arItem;
        }
        // Альтернативная проверка через VALUE
        elseif (!empty($arItem["PROPERTIES"]["TOP"]["VALUE"]) &&
            $arItem["PROPERTIES"]["TOP"]["VALUE"] == "73") {
            $filteredItems[] = $arItem;
        }
    }
}

$arResult["ITEMS"] = $filteredItems;
?>
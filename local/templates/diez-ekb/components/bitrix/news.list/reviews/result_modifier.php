<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult["ITEMS"] as &$arItem) {
    // Обрезаем длинный текст отзыва если нужно
    if (strlen($arItem["PREVIEW_TEXT"]) > 300) {
        $arItem["PREVIEW_TEXT"] = substr($arItem["PREVIEW_TEXT"], 0, 300) . "...";
    }

    // Форматируем рейтинг
    if ($arItem["PROPERTIES"]["RATING"]["VALUE"]) {
        $arItem["RATING_INT"] = intval($arItem["PROPERTIES"]["RATING"]["VALUE"]);
        if ($arItem["RATING_INT"] < 1) $arItem["RATING_INT"] = 1;
        if ($arItem["RATING_INT"] > 5) $arItem["RATING_INT"] = 5;
    }
}
unset($arItem);
?>

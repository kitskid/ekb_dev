<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Дополнительная обработка изображений
foreach ($arResult["ITEMS"] as &$arItem) {
// Проверяем, что изображение есть и это ID
    if ($arItem["PREVIEW_PICTURE"] && is_numeric($arItem["PREVIEW_PICTURE"])) {
        $arItem["PREVIEW_PICTURE_RESIZED"] = CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"],
            ["width" => 400, "height" => 300],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
    } elseif ($arItem["PREVIEW_PICTURE"] && is_array($arItem["PREVIEW_PICTURE"])) {
        // Если уже массив, то ресайзим по ID
        $arItem["PREVIEW_PICTURE_RESIZED"] = CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"]["ID"],
            ["width" => 400, "height" => 300],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
    }

    // То же самое для детального изображения
    if ($arItem["DETAIL_PICTURE"] && is_numeric($arItem["DETAIL_PICTURE"])) {
        $arItem["DETAIL_PICTURE_RESIZED"] = CFile::ResizeImageGet(
            $arItem["DETAIL_PICTURE"],
            ["width" => 400, "height" => 300],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
    } elseif ($arItem["DETAIL_PICTURE"] && is_array($arItem["DETAIL_PICTURE"])) {
        $arItem["DETAIL_PICTURE_RESIZED"] = CFile::ResizeImageGet(
            $arItem["DETAIL_PICTURE"]["ID"],
            ["width" => 400, "height" => 300],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
    }

    // Обработка свойства TOP для удобства
    $arItem["IS_TOP"] = ($arItem["PROPERTIES"]["TOP"]["VALUE"] == "да" || $arItem["PROPERTIES"]["TOP"]["VALUE"] == "1");
}
unset($arItem);
?>

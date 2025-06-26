<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
// Убираем SetTitle - он будет установлен автоматически компонентом

// Получаем код элемента из URL
$elementCode = $_REQUEST["ELEMENT_CODE"] ?: $_REQUEST["CODE"];

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "hotel.detail",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_ELEMENT_CHAIN" => "Y",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BROWSER_TITLE" => "-",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "Y",
        "ELEMENT_CODE" => $elementCode,
        "ELEMENT_ID" => "",
        "FIELD_CODE" => array("DETAIL_TEXT", "DETAIL_PICTURE"),
        "IBLOCK_ID" => "26",
        "IBLOCK_TYPE" => "content",
        "IBLOCK_URL" => "/hotels/",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
        "MESSAGE_404" => "",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_TEMPLATE" => "",
        "PAGER_TITLE" => "Страница",
        "PROPERTY_CODE" => array(
            "ADDRESS", "PHONE", "OPEN_HOURS", "SITE", "EMAIL",
            "FEATURES", "GALLERY", "COORDINATES", "PRICE",
            "RATING", "STARS", "TOP"
        ),
        "SET_BROWSER_TITLE" => "Y", // Заголовок браузера будет установлен из названия элемента
        "SET_CANONICAL_URL" => "Y",
        "SET_LAST_MODIFIED" => "Y",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "Y", // Заголовок страницы будет установлен из названия элемента
        "SHOW_404" => "Y",
        "STRICT_SECTION_CHECK" => "N",
        "USE_PERMISSIONS" => "N",
        "USE_SHARE" => "N"
    )
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>

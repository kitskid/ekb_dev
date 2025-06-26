<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

// Получаем ELEMENT_CODE из разных источников
$elementCode = '';
if (!empty($_REQUEST["ELEMENT_CODE"])) {
    $elementCode = $_REQUEST["ELEMENT_CODE"];
} elseif (!empty($_GET["ELEMENT_CODE"])) {
    $elementCode = $_GET["ELEMENT_CODE"];
} else {
    // Парсим из REQUEST_URI
    if (preg_match('#^/routes/([^/]+)/?$#', $_SERVER['REQUEST_URI'], $matches)) {
        $elementCode = $matches[1];
    }
}

if (empty($elementCode)) {
    CHTTP::SetStatus("404 Not Found");
    include($_SERVER["DOCUMENT_ROOT"]."/404.php");
    die();
}

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "route_detail",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_ELEMENT_CHAIN" => "Y",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "/routes/#ELEMENT_CODE#",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_CODE" => $elementCode,
        "ELEMENT_ID" => "",
        "FIELD_CODE" => array("DETAIL_TEXT", "DETAIL_PICTURE", "PREVIEW_PICTURE"),
        "IBLOCK_ID" => "31",
        "IBLOCK_TYPE" => "routes",
        "IBLOCK_URL" => "/routes/",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
        "PROPERTY_CODE" => array(
            "TYPE",
            "DIFFICULTY",
            "DURATION",
            "DISTANCE",
            "CIRCULAR",
            "GALLERY"
        ),
        "SET_BROWSER_TITLE" => "Y",
        "SET_CANONICAL_URL" => "Y",
        "SET_LAST_MODIFIED" => "Y",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "Y",
        "SHOW_404" => "Y",
        "STRICT_SECTION_CHECK" => "N",
        "USE_PERMISSIONS" => "N",
        "USE_SHARE" => "N",
    ),
    false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Проверяем, что запрос выполнен через AJAX
if(!isset($_REQUEST["ajax"]) || $_REQUEST["ajax"] != "Y") {
    die("Access denied");
}

// Получение параметров из запроса
$selectedTypes = array();
if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
    if (is_array($_REQUEST['type'])) {
        $selectedTypes = $_REQUEST['type'];
    } else {
        $selectedTypes = [$_REQUEST['type']];
    }
    // Удаляем пустые значения
    $selectedTypes = array_filter($selectedTypes);
}
$page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;

// Формируем параметры компонента
$componentParams = array(
    "IBLOCK_TYPE" => "content",
    "IBLOCK_ID" => "21",
    "ACTIVE_DATE_FORMAT" => "d.m.Y",
    "ADD_SECTIONS_CHAIN" => "N",
    "AJAX_MODE" => "N",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "CACHE_TIME" => "0", // Отключаем кеш для AJAX запросов
    "CACHE_TYPE" => "N",
    "CHECK_DATES" => "Y",
    "DETAIL_URL" => "",
    "DISPLAY_BOTTOM_PAGER" => "Y",
    "DISPLAY_DATE" => "N",
    "DISPLAY_NAME" => "Y",
    "DISPLAY_PICTURE" => "Y",
    "DISPLAY_PREVIEW_TEXT" => "N",
    "DISPLAY_TOP_PAGER" => "N",
    "FIELD_CODE" => array("", ""),
    "FILTER_NAME" => "",
    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
    "INCLUDE_SUBSECTIONS" => "Y",
    "MESSAGE_404" => "",
    "NEWS_COUNT" => "20",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => ".default",
    "PAGER_TITLE" => "Рестораны",
    "PARENT_SECTION" => "",
    "PARENT_SECTION_CODE" => "",
    "PREVIEW_TRUNCATE_LEN" => "",
    "PROPERTY_CODE" => array(
        "TYPE", "ADDRESS", "TOP", "GALLERY", "COORDINATES", "CUISINE", "PRICE_LEVEL", "FEATURES", "CITY", "RATING", "PRICE", "EMAIL", "PHONE", "OPEN_HOURS", "SITE", "SOCIAL_NETWORKS"
    ),
    "SET_BROWSER_TITLE" => "N",
    "SET_LAST_MODIFIED" => "N",
    "SET_META_DESCRIPTION" => "N",
    "SET_META_KEYWORDS" => "N",
    "SET_STATUS_404" => "N",
    "SET_TITLE" => "N",
    "SHOW_404" => "N",
    "SORT_BY1" => "PROPERTY_TOP",
    "SORT_BY2" => "SORT",
    "SORT_ORDER1" => "DESC",
    "SORT_ORDER2" => "ASC",
    "STRICT_SECTION_CHECK" => "N"
);

// Если указан номер страницы, настраиваем пагинацию
if($page > 1) {
    $componentParams["PAGER_PARAMS_NAME"] = "arrPager";
    $componentParams["arrPager"] = array("page" => $page);
}

// Выводим компонент с запрошенными параметрами
global $APPLICATION;
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "restaurants.news.list",
    $componentParams
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");

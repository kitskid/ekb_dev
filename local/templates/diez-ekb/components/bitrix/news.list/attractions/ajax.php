<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Проверяем AJAX запрос
if(!isset($_POST['params']) || empty($_POST['params']) || !isset($_POST['page'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    die();
}

// Получаем параметры компонента
$componentParams = unserialize(base64_decode($_POST['params']));
$page = intval($_POST['page']) + 1;

// Устанавливаем номер страницы для выборки
$componentParams["PAGER_TEMPLATE"] = ".default";
$componentParams["DISPLAY_TOP_PAGER"] = "N";
$componentParams["DISPLAY_BOTTOM_PAGER"] = "N";
$componentParams["NEWS_COUNT"] = intval($componentParams["ATTRACTIONS_COUNT"]) ?: 8;
$componentParams["PAGER_DESC_NUMBERING_CACHE_TIME"] = 0;
$navParams = [
    "nPageSize" => $componentParams["NEWS_COUNT"],
    "bDescPageNumbering" => false,
    "bShowAll" => false,
    "iNumPage" => $page
];

// Обновляем URL для ЧПУ
$componentParams["DETAIL_URL"] = "/attractions/#ELEMENT_CODE#/";

// Временно отключаем буферизацию для отлова результата
$content = null;
ob_start();

// Вызываем компонент для получения новых элементов
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "attractions",
    Array(
        "ACTIVE_DATE_FORMAT" => $componentParams["ACTIVE_DATE_FORMAT"],
        "ADD_SECTIONS_CHAIN" => $componentParams["ADD_SECTIONS_CHAIN"],
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "CACHE_TIME" => "0",
        "CACHE_TYPE" => "N",
        "CHECK_DATES" => $componentParams["CHECK_DATES"],
        "DETAIL_URL" => $componentParams["DETAIL_URL"],
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => $componentParams["DISPLAY_DATE"],
        "DISPLAY_NAME" => $componentParams["DISPLAY_NAME"],
        "DISPLAY_PICTURE" => $componentParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT" => $componentParams["DISPLAY_PREVIEW_TEXT"],
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => $componentParams["FIELD_CODE"],
        "FILTER_NAME" => $componentParams["FILTER_NAME"],
        "HIDE_LINK_WHEN_NO_DETAIL" => $componentParams["HIDE_LINK_WHEN_NO_DETAIL"],
        "IBLOCK_ID" => $componentParams["IBLOCK_ID"],
        "IBLOCK_TYPE" => $componentParams["IBLOCK_TYPE"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => $componentParams["INCLUDE_IBLOCK_INTO_CHAIN"],
        "INCLUDE_SUBSECTIONS" => $componentParams["INCLUDE_SUBSECTIONS"],
        "MESSAGE_404" => $componentParams["MESSAGE_404"],
        "NEWS_COUNT" => $componentParams["NEWS_COUNT"],
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "0",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => $componentParams["PAGER_TITLE"],
        "PARENT_SECTION" => $componentParams["PARENT_SECTION"],
        "PARENT_SECTION_CODE" => $componentParams["PARENT_SECTION_CODE"],
        "PREVIEW_TRUNCATE_LEN" => $componentParams["PREVIEW_TRUNCATE_LEN"],
        "PROPERTY_CODE" => $componentParams["PROPERTY_CODE"],
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => $componentParams["SORT_BY1"],
        "SORT_BY2" => $componentParams["SORT_BY2"],
        "SORT_ORDER1" => $componentParams["SORT_ORDER1"],
        "SORT_ORDER2" => $componentParams["SORT_ORDER2"],
        "STRICT_SECTION_CHECK" => $componentParams["STRICT_SECTION_CHECK"],
        "LOAD_ON_SCROLL" => "Y", // Флаг что это AJAX-подгрузка
        "NAV_PARAMS" => $navParams
    )
);

$content = ob_get_clean();

// Находим данные JSON с точками для карты
$mapDataPattern = '/window\.attractionsData\s*=\s*({.*?});/s';
preg_match($mapDataPattern, $content, $mapMatches);
$mapData = [];

if (isset($mapMatches[1])) {
    // Извлекаем JSON строку и преобразуем её обратно в массив
    $mapDataJson = $mapMatches[1];
    $mapData = json_decode($mapDataJson, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $mapData = [];
    }
}

// Очищаем полученный контент от скрипта с данными карты
$content = preg_replace('/<script>\s*window\.attractionsData\s*=.*?<\/script>/s', '', $content);

// Извлекаем только HTML карточек достопримечательностей
$cardPattern = '/<div class="col-md-4 col-sm-6 mb-4 attraction-item">.*?<\/div>/s';
preg_match_all($cardPattern, $content, $matches);
$items = $matches[0] ?? [];

// Возвращаем результат в формате JSON
echo json_encode([
    'success' => true,
    'items' => $items,
    'mapData' => $mapData,
    'hasMore' => $page < intval($_POST['totalPages'])
]);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');

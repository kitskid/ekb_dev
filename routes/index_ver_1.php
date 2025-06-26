<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

// Определяем тип запроса: главная страница или детальная страница маршрута
$requestURI = $APPLICATION->GetCurPage(false);

// Соответствует ли URL формату детальной страницы маршрута
$isDetailPage = preg_match('#^/routes/([^/]+)/?$#', $requestURI, $matches);

if ($isDetailPage && $matches[1] !== 'index.php') {
    // Это детальная страница маршрута
    $elementCode = $matches[1];

    // Проверяем существование маршрута
    \Bitrix\Main\Loader::includeModule('iblock');

    $element = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => 31, // ID инфоблока маршрутов
            'CODE' => $elementCode,
            'ACTIVE' => 'Y'
        ],
        false,
        false,
        ['ID', 'NAME', 'IBLOCK_ID']
    )->Fetch();

    if (!$element) {
        // Если маршрут не найден, показываем 404
        \Bitrix\Main\Application::getInstance()->getContext()->getResponse()->setStatus(404);
        $APPLICATION->SetTitle("Маршрут не найден");
        include($_SERVER["DOCUMENT_ROOT"] . "/404.php");
        die();
    }

    // Устанавливаем заголовок страницы
    $APPLICATION->SetTitle($element['NAME']);

    // Выводим компонент детальной страницы маршрута
    $APPLICATION->IncludeComponent(
        "bitrix:news.detail",
        "route_detail",
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
            "DETAIL_URL" => "/routes/#ELEMENT_CODE#/",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "ELEMENT_CODE" => $elementCode,
            "ELEMENT_ID" => "",
            "FIELD_CODE" => array("", ""),
            "IBLOCK_ID" => "31",
            "IBLOCK_TYPE" => "routes",
            "IBLOCK_URL" => "/routes/",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
            "MESSAGE_404" => "",
            "META_DESCRIPTION" => "-",
            "META_KEYWORDS" => "-",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Страница",
            "PROPERTY_CODE" => array(
                "TYPE",
                "DIFFICULTY",
                "DURATION",
                "DISTANCE",
                "CIRCULAR"
            ),
            "SET_BROWSER_TITLE" => "Y",
            "SET_CANONICAL_URL" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "Y",
            "SET_META_KEYWORDS" => "Y",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "Y",
            "SHOW_404" => "N",
            "STRICT_SECTION_CHECK" => "N",
            "USE_PERMISSIONS" => "N",
            "USE_SHARE" => "N",

            // Параметры шаблона route_detail
            "DISPLAY_MAP" => "Y",
            "DISPLAY_POINTS" => "Y",
            "DISPLAY_GALLERY" => "Y",
            "DISPLAY_RELATED" => "Y",
            "MAP_HEIGHT" => "500",
            "RELATED_ROUTES_COUNT" => "3",
            "YANDEX_MAP_API_KEY" => "" // Укажите ваш API ключ, если нужен
        )
    );
} else {
    // Это главная страница с маршрутами (существующий контент)
    $APPLICATION->SetPageProperty("title", "Лучшие маршруты Екатеринбурга");
    $APPLICATION->SetTitle("Лучшие маршруты Екатеринбурга");
    ?>

    <!-- Блок с главным баннером -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>ЛУЧШИЕ МАРШРУТЫ ЕКАТЕРИНБУРГА</h1>
            <div class="hero-description">
                <p>Откройте для себя самые интересные места и маршруты города. Мы собрали уникальные туристические маршруты для незабываемых впечатлений от Екатеринбурга.</p>
            </div>
        </div>
    </section>

    <!-- Блок "Выбери свой маршрут" -->
    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "route_cards_block",
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "/routes/#ELEMENT_CODE#/",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array("", ""),
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "31", // ID инфоблока с маршрутами
            "IBLOCK_TYPE" => "routes",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "4", // Количество карточек для вывода
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Маршруты",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => array("TYPE", "DURATION", "DISTANCE"),
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SORT_BY1" => "SORT",
            "SORT_BY2" => "NAME",
            "SORT_ORDER1" => "ASC",
            "SORT_ORDER2" => "ASC",
            "STRICT_SECTION_CHECK" => "N",

            // Параметры шаблона
            "TITLE" => "ВЫБЕРИ СВОЙ МАРШРУТ",
            "DISPLAY_ROUTE_TYPE" => "Y",
            "DISPLAY_ROUTE_DURATION" => "Y",
            "DISPLAY_ROUTE_DISTANCE" => "Y"
        )
    );?>

    <!-- Блок "Достопримечательности" -->
    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "landmarks_block",
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "/routes/points/#ELEMENT_CODE#/",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array("", ""),
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "32", // ID инфоблока с точками маршрута
            "IBLOCK_TYPE" => "routes",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "4", // Количество карточек для вывода
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Достопримечательности",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => array("COORDINATES"),
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SORT_BY1" => "SORT",
            "SORT_BY2" => "NAME",
            "SORT_ORDER1" => "ASC",
            "SORT_ORDER2" => "ASC",
            "STRICT_SECTION_CHECK" => "N",

            // Параметры шаблона
            "TITLE" => "ДОСТОПРИМЕЧАТЕЛЬНОСТИ",
            "DISPLAY_RATING" => "Y"
        )
    );?>

    <!-- Блок "Ваш гид по Екатеринбургу" -->
    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "guides_block",
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "/guides/#ELEMENT_CODE#/",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array("", ""),
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "33", // ID инфоблока с гидами
            "IBLOCK_TYPE" => "guides",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "3", // Количество гидов для вывода
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Гиды",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => array("PHONE", "EMAIL", "SOCIAL_MEDIA", "BINDING_ROUTES"),
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SORT_BY1" => "SORT",
            "SORT_BY2" => "NAME",
            "SORT_ORDER1" => "ASC",
            "SORT_ORDER2" => "ASC",
            "STRICT_SECTION_CHECK" => "N",

            // Параметры шаблона
            "TITLE" => "ВАШ ГИД ПО ЕКАТЕРИНБУРГУ",
            "DISPLAY_CONTACTS" => "Y"
        )
    );?>

    <!-- Блок "Топ маршрутов" -->
    <?
    $GLOBALS["topRoutesFilter"] = array("PROPERTY_TOP_VALUE" => "Да");
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "top_routes_block",
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "/routes/#ELEMENT_CODE#/",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array("", ""),
            "FILTER_NAME" => "topRoutesFilter",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "31", // ID инфоблока с маршрутами
            "IBLOCK_TYPE" => "routes",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "3", // Количество карточек для вывода
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Маршруты",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => array("TYPE", "DURATION", "DISTANCE"),
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SORT_BY1" => "SORT",
            "SORT_BY2" => "NAME",
            "SORT_ORDER1" => "ASC",
            "SORT_ORDER2" => "ASC",
            "STRICT_SECTION_CHECK" => "N",

            // Параметры шаблона
            "TITLE" => "ТОП МАРШРУТОВ",
            "DISPLAY_ROUTE_TYPE" => "Y",
            "DISPLAY_ROUTE_DURATION" => "Y",
            "DISPLAY_ROUTE_DISTANCE" => "Y"
        )
    );?>

    <!-- Блок "Топ маршрутов для самостоятельных туристов" -->
    <?
    $GLOBALS["selfTouristsFilter"] = array("PROPERTY_TOP_VALUE" => "Да", "PROPERTY_TYPE_VALUE" => "Пешеходный");
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "top_routes_block", // Используем тот же шаблон, что и для блока "Топ маршрутов"
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "/routes/#ELEMENT_CODE#/",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array("", ""),
            "FILTER_NAME" => "selfTouristsFilter",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "31", // ID инфоблока с маршрутами
            "IBLOCK_TYPE" => "routes",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "3", // Количество карточек для вывода
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Маршруты",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => array("TYPE", "DURATION", "DISTANCE"),
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SORT_BY1" => "SORT",
            "SORT_BY2" => "NAME",
            "SORT_ORDER1" => "ASC",
            "SORT_ORDER2" => "ASC",
            "STRICT_SECTION_CHECK" => "N",

            // Параметры шаблона
            "TITLE" => "ТОП МАРШРУТОВ ДЛЯ САМОСТОЯТЕЛЬНЫХ ТУРИСТОВ",
            "DISPLAY_ROUTE_TYPE" => "Y",
            "DISPLAY_ROUTE_DURATION" => "Y",
            "DISPLAY_ROUTE_DISTANCE" => "Y"
        )
    );?>
    <?
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>

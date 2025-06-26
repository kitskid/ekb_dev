<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Лучшие маршруты Екатеринбурга");
?>

<main class="main">
    <section class="section section--intro" style="--background: url('/local/templates/diez-ekb/assets/images/main-bg-4.jpg')">
        <div class="container">
            <div class="intro">
                <div class="breadcrumbs breadcrumbs--intro">
                    <a href="/" class="breadcrumbs__link">Главная</a>
                    <p class="breadcrumbs__link">Маршруты</p>
                </div>
                <h1 class="title title--light">
                    Лучшие маршруты Екатеринбурга
                </h1>
                <p class="subtitle">
                    Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света, соединивший в себе Европу и Азию.
                </p>
            </div>
        </div>
    </section>

    <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-45">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "route_cards_block",
            Array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "IBLOCK_ID" => "31",
                "IBLOCK_TYPE" => "routes",
                "NEWS_COUNT" => "6",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "PROPERTY_CODE" => array("TYPE", "DURATION", "DISTANCE"),
                "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"),
                "DETAIL_URL" => "/routes/#ELEMENT_CODE#/",
                "SET_TITLE" => "N",
                "DISPLAY_ROUTE_TYPE" => "Y",
            )
        );
        ?>
    </section>

    <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-45">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "landmarks_block",
            Array(
                "IBLOCK_TYPE" => "routes",
                "IBLOCK_ID" => "32",
                "NEWS_COUNT" => "8",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"),
                "PROPERTY_CODE" => array("ADDRESS", "TOP"),
                "DETAIL_URL" => "/landmarks/#ELEMENT_CODE#/",
                "SET_TITLE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
            )
        );
        ?>
        <svg class="mob-hidden blockAttractionsDirections__decor">
            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-attractions"></use>
        </svg>
    </section>

    <section class="section section--guides pt-130 ptm-70 pb-130 pbm-100">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "guides_block",
            Array(
                "IBLOCK_TYPE" => "routes", // или какой у вас тип для гидов
                "IBLOCK_ID" => "33",
                "NEWS_COUNT" => "3", // Показываем 3 гида как в верстке
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "NAME",
                "SORT_ORDER2" => "ASC",
                "FIELD_CODE" => array("NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PICTURE", "DETAIL_PAGE_URL"),
                "PROPERTY_CODE" => array("PHONE", "EMAIL", "SOCIAL_MEDIA", "BINDING_ROUTES"),
                "DETAIL_URL" => "/guides/#ELEMENT_CODE#/",
                "SET_TITLE" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_META_DESCRIPTION" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "Y",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            )
        );
        ?>
    </section>

    <section class="section section--routes pt-130 ptm-70 pb-130 pbm-100">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "routes_top_block",
            Array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "CACHE_TYPE" => "N",
                "CACHE_TIME" => "36000000",
                "IBLOCK_ID" => "31",
                "IBLOCK_TYPE" => "routes",
                "NEWS_COUNT" => "6",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "NAME",
                "SORT_ORDER2" => "ASC",
                "PROPERTY_CODE" => array("TYPE", "DURATION", "DISTANCE", "TOP"),
                "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"),
                "DETAIL_URL" => "/routes/#ELEMENT_CODE#",
                "SET_TITLE" => "N",
                "DISPLAY_ROUTE_TYPE" => "Y",
                "BLOCK_TITLE" => "топ маршрутов",
            )
        );
        ?>
    </section>

    <section class="section section--routes-self pt-130 ptm-70 pb-130 pbm-100">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "routes_self_block",
            Array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "CACHE_TYPE" => "N",
                "CACHE_TIME" => "36000000",
                "IBLOCK_ID" => "31",
                "IBLOCK_TYPE" => "routes",
                "NEWS_COUNT" => "6",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "NAME",
                "SORT_ORDER2" => "ASC",
                "PROPERTY_CODE" => array("TYPE", "DURATION", "DISTANCE"),
                "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"),
                "DETAIL_URL" => "/routes/#ELEMENT_CODE#",
                "SET_TITLE" => "N",
                "DISPLAY_ROUTE_TYPE" => "Y",
                "BLOCK_TITLE" => "топ маршрутов для самостоятельных туристов",
            )
        );
        ?>
        <svg class="blockTopRoutes--forSelf__decor">
            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-lines"></use>
        </svg>
    </section>
</main>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>

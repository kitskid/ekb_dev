<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Город развивается");
$APPLICATION->SetPageProperty("title", "Город развивается | Официальный портал города");
$APPLICATION->SetPageProperty("description", "Информация о развитии города, проектах благоустройства, инфраструктурных проектах и реставрации");
?>

    <!-- Баннер/Заголовок -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">ГОРОД РАЗВИВАЕТСЯ</h1>
                <p class="hero-description">
                    В 2023-2024 ГОДАХ В ГОРОДЕ РЕАЛИЗУЮТСЯ МАСШТАБНЫЕ ПРОЕКТЫ
                    ПО БЛАГОУСТРОЙСТВУ, РАЗВИТИЮ ИНФРАСТРУКТУРЫ, РЕСТАВРАЦИИ
                    ИСТОРИЧЕСКИХ ОБЪЕКТОВ.
                </p>
            </div>
        </div>
    </section>

    <!-- Блок "Итоги благоустройства" -->
    <section class="results-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2 class="section-title">ИТОГИ БЛАГОУСТРОЙСТВА</h2>
                    <div class="results-text">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/city_development/results.php"
                            )
                        );?>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="results-image">
                        <img src="/local/templates/.default/images/city-view-1.jpg" alt="Итоги благоустройства">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Блок "Город для тебя" -->
    <section class="city-for-you-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2 class="section-title">ГОРОД ДЛЯ ТЕБЯ</h2>
                    <div class="city-for-you-text">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/city_development/city_for_you.php"
                            )
                        );?>
                    </div>
                    <a href="/city-for-you/" class="btn btn-primary">Подробнее</a>
                </div>
                <div class="col-md-5">
                    <div class="city-for-you-image">
                        <img src="/local/templates/.default/images/city-view-2.jpg" alt="Город для тебя">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Блок "Образование и карьера" -->
    <section class="education-career-section">
        <div class="container">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "education",
                Array(
                    "IBLOCK_TYPE" => "o_ekaterinburge",
                    "IBLOCK_ID" => "28",
                    "SECTION_ID" => "215",
                    "SECTION_CODE" => "",
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "N",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => array(
                        "ID",
                        "NAME",
                        "PICTURE",
                        "DESCRIPTION",
                        "SECTION_PAGE_URL"
                    ),
                    "SECTION_USER_FIELDS" => array(),
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_FILTER" => "N"
                ),
                false
            );
            ?>
<!--            <div class="row">-->
<!--                <div class="col-md-7">-->
<!--                    <h2 class="section-title">ОБРАЗОВАНИЕ И КАРЬЕРА</h2>-->
<!--                    --><?//$APPLICATION->IncludeComponent(
//                        "bitrix:catalog.section.list",
//                        "education_career",
//                        Array(
//                            "ADD_SECTIONS_CHAIN" => "N",
//                            "CACHE_GROUPS" => "Y",
//                            "CACHE_TIME" => "36000000",
//                            "CACHE_TYPE" => "A",
//                            "COUNT_ELEMENTS" => "N",
//                            "IBLOCK_ID" => "28",
//                            "IBLOCK_TYPE" => "content",
//                            "SECTION_CODE" => "",
//                            "SECTION_FIELDS" => array("ID", "NAME", "DESCRIPTION", "PICTURE", "DETAIL_PICTURE"),
//                            "SECTION_ID" => "",
//                            "SECTION_URL" => "",
//                            "SECTION_USER_FIELDS" => array("", ""),
//                            "SHOW_PARENT_NAME" => "Y",
//                            "TOP_DEPTH" => "1",
//                            "VIEW_MODE" => "LINE"
//                        )
//                    );?>
<!--                </div>-->
<!--                <div class="col-md-5">-->
<!--                    <div class="education-image">-->
<!--                        <img src="/local/templates/.default/images/education-career.jpg" alt="Образование и карьера">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </section>

    <!-- Блок "Проекты благоустройства" -->
    <section class="improvement-projects-section">
        <div class="container">
            <div class="section-header">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "improvement_projects",
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
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "29",
                        "IBLOCK_TYPE" => "content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "3",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Проекты",
                        "PARENT_SECTION" => "217",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("STATUS", "LOCATION"),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "DESC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N",
                        "USE_FILTER" => "N"
                    )
                );?>
                <div class="section-actions">
                    <a href="/city/development/improvement/" class="btn btn-outline-primary">Смотреть все</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Блок "Инфраструктурные проекты" -->
    <section class="infrastructure-projects-section">
        <div class="container">
            <div class="section-header">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "infrastructure_projects",
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
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "29",
                        "IBLOCK_TYPE" => "content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "3",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Проекты",
                        "PARENT_SECTION" => "218",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("STATUS", "LOCATION"),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "DESC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N",
                        "USE_FILTER" => "N"
                    )
                );?>
                <div class="section-actions">
                    <a href="/city/development/infrastructure/" class="btn btn-outline-primary">Смотреть все</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Блок "Реставрация" -->
    <section class="restoration-section">
        <div class="container">
            <div class="section-header">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "restoration_projects",
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
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "29",
                        "IBLOCK_TYPE" => "content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "3",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Проекты",
                        "PARENT_SECTION" => "219",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("STATUS", "LOCATION"),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "DESC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N",
                        "USE_FILTER" => "N"
                    )
                );?>
                <div class="section-actions">
                    <a href="/city/development/restoration/" class="btn btn-outline-primary">Смотреть все</a>
                </div>
            </div>
        </div>
    </section>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
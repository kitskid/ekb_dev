<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("год уральского рока 2026");
?>
<main class="main">
    <?php
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "rock_club_info",
        Array(
            "IBLOCK_TYPE" => "rock_year",
            "IBLOCK_ID" => "37",
            "NEWS_COUNT" => "1", // Только один элемент
            "SORT_BY1" => "SORT",
            "SORT_ORDER1" => "ASC",
            "SORT_BY2" => "ID",
            "SORT_ORDER2" => "DESC",
            "FIELD_CODE" => array(
                "ID",
                "NAME",
                "PREVIEW_PICTURE",   // Для фонового изображения
                "PREVIEW_TEXT",
                "DETAIL_TEXT"
            ),
            "PROPERTY_CODE" => array(
                "BANNER_TITLE",      // Заголовок для H1 (с поддержкой <br>)
                "ARTICLE_TITLE"      // Заголовок для H2 (с поддержкой HTML)
            ),
            "SET_TITLE" => "N",
            "SET_BROWSER_TITLE" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_LAST_MODIFIED" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "INCLUDE_SUBSECTIONS" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "PREVIEW_TRUNCATE_LEN" => "",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "USE_PERMISSIONS" => "N",
            "GROUP_PERMISSIONS" => array(),
            "FILTER_NAME" => "",
            "CHECK_DATES" => "Y"
        ),
        false
    );
    ?>
    <section class="section section--picture pt-87 ptm-40 pb-94 pbm-90"
             style="--background: url('/local/templates/diez-ekb/assets/images/festival-bg.jpg')">
        <!-- Компонент битрикса для вывода афиши событий -->
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "events_list",
            Array(
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "IBLOCK_TYPE" => "bill",
                "IBLOCK_ID" => "23",
                "NEWS_COUNT" => "6",  // Увеличено количество для слайдера
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_ORDER1" => "DESC",
                "SORT_BY2" => "SORT",
                "SORT_ORDER2" => "ASC",
                "FIELD_CODE" => array(
                    "ID",
                    "NAME",
                    "PREVIEW_PICTURE",
                    "PREVIEW_TEXT",
                    "ACTIVE_FROM",
                    "DETAIL_PAGE_URL",
                    "IBLOCK_SECTION_ID"
                ),
                "PROPERTY_CODE" => array(
                    "EVENT_DATE",
                    "EVENT_PLACE",
                    "TOP"  // Добавлено свойство для топовых событий
                ),
                "SET_TITLE" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_LAST_MODIFIED" => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "INCLUDE_SUBSECTIONS" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "PREVIEW_TRUNCATE_LEN" => "",
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "USE_PERMISSIONS" => "N",
                "GROUP_PERMISSIONS" => array(),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "CHECK_DATES" => "Y",
            ),
            false
        );
        ?>
    </section>
    <section class="section pt-165 ptm-60 pb-145 pbm-40">
        <div class="container">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "rock_groups",
                Array(
                    "IBLOCK_TYPE" => "rock_year",
                    "IBLOCK_ID" => "35",
                    "NEWS_COUNT" => "10", // Количество групп в слайдере
                    "SORT_BY1" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "SORT_BY2" => "ID",
                    "SORT_ORDER2" => "DESC",
                    "FIELD_CODE" => array(
                        "ID",
                        "NAME",
                        "PREVIEW_PICTURE",
                        "PREVIEW_TEXT",
                        "DETAIL_PAGE_URL"
                    ),
                    "PROPERTY_CODE" => array(),
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "USE_PERMISSIONS" => "N",
                    "GROUP_PERMISSIONS" => array(),
                    "FILTER_NAME" => "",
                    "CHECK_DATES" => "Y"
                ),
                false
            );
            ?>
        </div>
    </section>
    <section class="section section--gray pt-100 ptm-35 pb-100 pbm-150">
        <div class="container">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "video_block",
            Array(
                "IBLOCK_TYPE" => "rock_year",
                "IBLOCK_ID" => "36",
                "NEWS_COUNT" => "1", // Только один элемент
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "ID",
                "SORT_ORDER2" => "DESC",
                "FIELD_CODE" => array(
                    "ID",
                    "NAME",
                    "PREVIEW_PICTURE",   // Для постера видео (если нужно)
                    "PREVIEW_TEXT"
                ),
                "PROPERTY_CODE" => array(
                    "VIDEO"  // Свойство с видео файлом
                ),
                "SET_TITLE" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_LAST_MODIFIED" => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "INCLUDE_SUBSECTIONS" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "PREVIEW_TRUNCATE_LEN" => "",
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "USE_PERMISSIONS" => "N",
                "GROUP_PERMISSIONS" => array(),
                "FILTER_NAME" => "",
                "CHECK_DATES" => "Y"
            ),
            false
        );
        ?>
        </div>
    </section>
    <section class="section section--logo-bg section--logo-bg-center pt-165 ptm-75 pb-145 pbm-65">
        <div class="container">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "interesting_places",
                Array(
                    "IBLOCK_TYPE" => "rock_year",
                    "IBLOCK_ID" => "34",
                    "NEWS_COUNT" => "10", // Количество элементов в слайдере
                    "SORT_BY1" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "SORT_BY2" => "ID",
                    "SORT_ORDER2" => "DESC",
                    "FIELD_CODE" => array(
                        "ID",
                        "NAME",
                        "PREVIEW_PICTURE",
                        "DETAIL_PAGE_URL"
                    ),
                    "PROPERTY_CODE" => array(
                        "ADDRESS"  // Свойство с адресом
                    ),
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "USE_PERMISSIONS" => "N",
                    "GROUP_PERMISSIONS" => array(),
                    "FILTER_NAME" => "",
                    "CHECK_DATES" => "Y"
                ),
                false
            );
            ?>
        </div>
    </section>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

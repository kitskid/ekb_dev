<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Достопримечательности Екатеринбурга");
$APPLICATION->SetPageProperty("description", "Популярные туристические места в Екатеринбурге");
?>

<!-- Верхний блок с фоновым изображением -->
<div class="attractions-hero" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/ekb-aerial-view.jpg');">
    <div class="container">
        <h1>ДОСТОПРИМЕЧАТЕЛЬНОСТИ ЕКАТЕРИНБУРГА</h1>
        <div class="attractions-hero__description">
            <p>В 2023 году Екатеринбургу исполняется свое 300-летие. Хотя город был основан еще 18 ноября 1723 года, когда были открыты цех и крепость в России, переименованные в Екатеринбург.</p>
        </div>
    </div>
</div>

<!-- Блок с карточками достопримечательностей -->
<section class="attractions-list">
    <div class="container">
        <h2>ДОСТОПРИМЕЧАТЕЛЬНОСТИ</h2>

        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "attractions",
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
                "DETAIL_URL" => "/attractions/#ELEMENT_CODE#/",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL", "CODE"),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "32", // ID инфоблока с достопримечательностями
                "IBLOCK_TYPE" => "routes",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "8", // Изначально показываем 8 элементов
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
                "PROPERTY_CODE" => array("ADDRESS", "COORDINATES", "SORT", "BINDING"),
                "SET_BROWSER_TITLE" => "Y",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "Y",
                "SET_META_KEYWORDS" => "Y",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "PROPERTY_SORT",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N",
                "ATTRACTIONS_COUNT" => "8" // Количество элементов для подгрузки
            ),
            false
        );
        ?>
    </div>
</section>

<!-- Карта достопримечательностей -->
<section class="attractions-map">
    <div class="container">
        <h2>КАРТА ДОСТОПРИМЕЧАТЕЛЬНОСТЕЙ</h2>
        <div id="yandexMap" class="yandex-map" data-iblock="32" data-iblock-type="routes"></div>
    </div>
</section>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

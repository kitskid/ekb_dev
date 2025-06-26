<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Гостям");
?>
<section class="section">
    <div class="container">
        <!-- Компонент битрикса для вывода разделов инфоблока "Гостям Города" -->
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "guest_cards",
            array(
                "IBLOCK_TYPE" => "guests",
                "IBLOCK_ID" => "24",
                "COUNT_ELEMENTS" => "Y",
                "TOP_DEPTH" => "1",
                "SECTION_FIELDS" => array(
                    0 => "ID",
                    1 => "NAME",
                    2 => "DESCRIPTION",
                    3 => "PICTURE",
                ),
                "SECTION_URL" => "",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "SHOW_PARENT_NAME" => "N",
                "HIDE_SECTION_NAME" => "N",
                "SORT_BY" => "SORT",
                "SORT_ORDER" => "ASC",
            )
        );
        ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">ГДЕ ОСТАНОВИТЬСЯ</h2>
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "world_level",
            Array(
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "IBLOCK_TYPE" => "infrastructure",
                "IBLOCK_ID" => "26",
                "NEWS_COUNT" => "4",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT"),
                "PROPERTY_CODE" => array(),
                "SET_TITLE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
            )
        );
        ?>

        <div class="section-more">
            <a href="/achievements/" class="btn-more">Подробнее</a>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2 class="section-title">ГДЕ ПОЕСТЬ</h2>
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "world_level",
            Array(
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "IBLOCK_TYPE" => "infrastructure",
                "IBLOCK_ID" => "21",
                "NEWS_COUNT" => "4",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT"),
                "PROPERTY_CODE" => array(),
                "SET_TITLE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
            )
        );
        ?>

        <div class="section-more">
            <a href="/achievements/" class="btn-more">Подробнее</a>
        </div>
    </div>
</section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

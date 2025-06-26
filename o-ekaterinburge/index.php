<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("О Екатеринбурге");
$APPLICATION->SetPageProperty("title", "О Екатеринбурге и городах спутниках");
$APPLICATION->SetPageProperty("description", "Информация о Екатеринбурге, его истории, образовании и других аспектах городской жизни");
?>

<!-- Hero секция с заголовком и интро текстом -->
<section class="city-hero" id="city-hero">
    <?$APPLICATION->IncludeComponent(
        "bitrix:news.detail",
        "city_hero",
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_ELEMENT_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
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
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "ELEMENT_CODE" => "city_hero",
            "ELEMENT_ID" => "",
            "FIELD_CODE" => array("NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "DETAIL_PICTURE"),
            "IBLOCK_ID" => "25", // ID инфоблока с информацией о городе
            "IBLOCK_TYPE" => "content",
            "IBLOCK_URL" => "",
            "MESSAGE_404" => "",
            "META_DESCRIPTION" => "-",
            "META_KEYWORDS" => "-",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "",
            "PROPERTY_CODE" => array("HERO_BACKGROUND"),
            "SET_BROWSER_TITLE" => "N",
            "SET_CANONICAL_URL" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "USE_PERMISSIONS" => "N",
            "USE_SHARE" => "N"
        )
    );?>
</section>

<!-- Блок "Главное в истории Екатеринбурга" -->
<section class="city-main-info">
    <div class="container">
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "main_about_ekb",
            array(
                "IBLOCK_TYPE" => "education_career",
                "IBLOCK_ID" => "28",
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

<!-- Блок "История" -->
<section class="city-history">
    <div class="container">
        <h2 class="section-title">ИСТОРИЯ</h2>
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "guest_cards",
            array(
                "IBLOCK_TYPE" => "guests",
                "IBLOCK_ID" => "27",
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

<!-- Блок "Образование и карьера" -->
<section class="city-education">
    <div class="container">
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "education_career",
            array(
                "IBLOCK_TYPE" => "education_career",
                "IBLOCK_ID" => "28",
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

<!-- Блок "Пять вопросов про Екатеринбург" -->
<section class="city-faq">
    <div class="container">
        <h2 class="section-title">ПЯТЬ ВОПРОСОВ ПРО ЕКАТЕРИНБУРГ</h2>
<!--        --><?//$APPLICATION->IncludeComponent(
//            "bitrix:news.list",
//            "city_faq",
//            Array(
//                "ACTIVE_DATE_FORMAT" => "d.m.Y",
//                "ADD_SECTIONS_CHAIN" => "N",
//                "AJAX_MODE" => "N",
//                "AJAX_OPTION_ADDITIONAL" => "",
//                "AJAX_OPTION_HISTORY" => "N",
//                "AJAX_OPTION_JUMP" => "N",
//                "AJAX_OPTION_STYLE" => "Y",
//                "CACHE_FILTER" => "N",
//                "CACHE_GROUPS" => "Y",
//                "CACHE_TIME" => "36000000",
//                "CACHE_TYPE" => "A",
//                "CHECK_DATES" => "Y",
//                "DETAIL_URL" => "",
//                "DISPLAY_BOTTOM_PAGER" => "N",
//                "DISPLAY_DATE" => "N",
//                "DISPLAY_NAME" => "Y",
//                "DISPLAY_PICTURE" => "Y",
//                "DISPLAY_PREVIEW_TEXT" => "Y",
//                "DISPLAY_TOP_PAGER" => "N",
//                "FIELD_CODE" => array("NAME", "PREVIEW_TEXT"),
//                "FILTER_NAME" => "",
//                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
//                "IBLOCK_ID" => "28", // ID инфоблока с FAQ
//                "IBLOCK_TYPE" => "content",
//                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
//                "INCLUDE_SUBSECTIONS" => "Y",
//                "MESSAGE_404" => "",
//                "NEWS_COUNT" => "5",
//                "PAGER_BASE_LINK_ENABLE" => "N",
//                "PAGER_DESC_NUMBERING" => "N",
//                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
//                "PAGER_SHOW_ALL" => "N",
//                "PAGER_SHOW_ALWAYS" => "N",
//                "PAGER_TEMPLATE" => ".default",
//                "PAGER_TITLE" => "",
//                "PARENT_SECTION" => "",
//                "PARENT_SECTION_CODE" => "",
//                "PREVIEW_TRUNCATE_LEN" => "",
//                "PROPERTY_CODE" => array("ANSWER"),
//                "SET_BROWSER_TITLE" => "N",
//                "SET_LAST_MODIFIED" => "N",
//                "SET_META_DESCRIPTION" => "N",
//                "SET_META_KEYWORDS" => "N",
//                "SET_STATUS_404" => "N",
//                "SET_TITLE" => "N",
//                "SHOW_404" => "N",
//                "SORT_BY1" => "SORT",
//                "SORT_BY2" => "ACTIVE_FROM",
//                "SORT_ORDER1" => "ASC",
//                "SORT_ORDER2" => "DESC"
//            )
//        );?>
        <? $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "city_faq",
            [
                "ACTIVE_DATE_FORMAT"              => "d.m.Y",
                "ADD_SECTIONS_CHAIN"              => "Y",
                "AJAX_MODE"                       => "N",
                "AJAX_OPTION_ADDITIONAL"          => "",
                "AJAX_OPTION_HISTORY"             => "N",
                "AJAX_OPTION_JUMP"                => "N",
                "AJAX_OPTION_STYLE"               => "Y",
                "CACHE_FILTER"                    => "N",
                "CACHE_GROUPS"                    => "Y",
                "CACHE_TIME"                      => "36000000",
                "CACHE_TYPE"                      => "A",
                "CHECK_DATES"                     => "Y",
                "COMPONENT_TEMPLATE"              => "city_faq",
                "DETAIL_URL"                      => "",
                "DISPLAY_BOTTOM_PAGER"            => "Y",
                "DISPLAY_DATE"                    => "Y",
                "DISPLAY_NAME"                    => "Y",
                "DISPLAY_PICTURE"                 => "Y",
                "DISPLAY_PREVIEW_TEXT"            => "Y",
                "DISPLAY_TOP_PAGER"               => "N",
                "FIELD_CODE"                      => [
                    0 => "",
                    1 => "",
                ],
                "FILTER_NAME"                     => "",
                "HIDE_LINK_WHEN_NO_DETAIL"        => "N",
                "IBLOCK_ID"                       => "6",
                "IBLOCK_TYPE"                     => "Faq",
                "INCLUDE_IBLOCK_INTO_CHAIN"       => "N",
                "INCLUDE_SUBSECTIONS"             => "Y",
                "MESSAGE_404"                     => "",
                "NEWS_COUNT"                      => "20",
                "PAGER_BASE_LINK_ENABLE"          => "N",
                "PAGER_DESC_NUMBERING"            => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL"                  => "N",
                "PAGER_SHOW_ALWAYS"               => "N",
                "PAGER_TEMPLATE"                  => ".default",
                "PAGER_TITLE"                     => "Афиша",
                "PARENT_SECTION"                  => "",
                "PARENT_SECTION_CODE"             => "",
                "PREVIEW_TRUNCATE_LEN"            => "",
                "PROPERTY_CODE"                   => [
                    0 => "DATE",
                    1 => "",
                ],
                "SET_BROWSER_TITLE"               => "N",
                "SET_LAST_MODIFIED"               => "N",
                "SET_META_DESCRIPTION"            => "N",
                "SET_META_KEYWORDS"               => "N",
                "SET_STATUS_404"                  => "Y",
                "SET_TITLE"                       => "N",
                "SHOW_404"                        => "N",
                "SORT_BY1"                        => "ACTIVE_FROM",
                "SORT_BY2"                        => "SORT",
                "SORT_ORDER1"                     => "DESC",
                "SORT_ORDER2"                     => "ASC",
                "STRICT_SECTION_CHECK"            => "N",
            ],
            false,
        ); ?>
    </div>
</section>

<!-- Блок карты с информационными пунктами -->
<section class="city-map">
    <div class="container">
        <h2 class="section-title">ИНФОРМАЦИОННО-ТУРИСТИЧЕСКИЕ ПУНКТЫ ГОРОДА ЕКАТЕРИНБУРГ</h2>
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "city_info_points_map",
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
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("NAME", "PREVIEW_TEXT"),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "29", // ID инфоблока с инфо-пунктами
                "IBLOCK_TYPE" => "content",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "10",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("ADDRESS", "PHONE", "WORKING_HOURS", "COORDINATES"),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "ACTIVE_FROM",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "DESC"
            )
        );?>
    </div>
</section>

<style>
    /* Общие стили */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .section-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    /* Стили для Hero секции */
    .city-hero {
        background-size: cover;
        background-position: center;
        color: #fff;
        padding: 100px 0;
        position: relative;
    }

    .city-hero:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 700px;
    }

    .hero-title {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    .hero-description {
        font-size: 18px;
        line-height: 1.6;
    }

    /* Стили для блока основной информации */
    .city-main-info {
        padding: 80px 0;
    }

    .info-grid {
        display: flex;
        align-items: center;
        gap: 40px;
    }

    .info-image {
        width: 45%;
    }

    .info-image img {
        width: 100%;
        border-radius: 10px;
    }

    .info-content {
        width: 55%;
    }

    /* Стили для блока истории */
    .city-history {
        padding: 60px 0;
        background-color: #f9f9f9;
    }

    .history-blocks {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .history-block {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        width: 32%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .history-block-image {
        height: 200px;
        overflow: hidden;
    }

    .history-block-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .history-block-content {
        padding: 20px;
    }

    .history-block-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* Стили для блока образования */
    .city-education {
        padding: 80px 0;
    }

    .education-grid {
        display: flex;
        align-items: center;
        gap: 40px;
    }

    .education-content {
        width: 55%;
    }

    .education-image {
        width: 45%;
    }

    .education-image img {
        width: 100%;
        border-radius: 10px;
    }

    /* Стили для блока FAQ */
    .city-faq {
        padding: 60px 0;
        background-color: #f9f9f9;
    }

    .faq-list {
        margin-top: 30px;
    }

    .faq-item {
        margin-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 15px;
    }

    .faq-question {
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .faq-question:after {
        content: '+';
        font-size: 24px;
        transition: transform 0.3s ease;
    }

    .faq-question.active:after {
        transform: rotate(45deg);
    }

    .faq-answer {
        display: none;
        padding: 10px 0;
        line-height: 1.6;
    }

    .faq-answer.active {
        display: block;
    }

    /* Стили для блока карты */
    .city-map {
        padding: 80px 0;
    }

    .map-container {
        margin-bottom: 30px;
        height: 500px;
    }

    .info-points {
        margin-top: 30px;
    }

    .info-point {
        padding: 15px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .info-point-title {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .info-point-address,
    .info-point-phone,
    .info-point-hours {
        display: flex;
        align-items: flex-start;
        margin-bottom: 5px;
    }

    .info-point-address i,
    .info-point-phone i,
    .info-point-hours i {
        margin-right: 10px;
        min-width: 16px;
    }

    /* Адаптивные стили */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 36px;
        }

        .info-grid, .education-grid {
            flex-direction: column;
        }

        .info-image, .info-content, .education-content, .education-image {
            width: 100%;
        }

        .history-blocks {
            flex-direction: column;
        }

        .history-block {
            width: 100%;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 576px) {
        .city-hero {
            padding: 60px 0;
        }

        .hero-title {
            font-size: 28px;
        }

        .section-title {
            font-size: 24px;
        }

        .city-main-info, .city-education, .city-faq, .city-map {
            padding: 40px 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ accordion functionality
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                const answer = this.nextElementSibling;

                // Toggle active class on question
                this.classList.toggle('active');

                // Toggle active class on answer
                answer.classList.toggle('active');

                // Close other answers
                faqQuestions.forEach(otherQuestion => {
                    if (otherQuestion !== question) {
                        otherQuestion.classList.remove('active');
                        otherQuestion.nextElementSibling.classList.remove('active');
                    }
                });
            });
        });
    });
</script>

<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Гостиницы города");
?>
<?//$APPLICATION->IncludeComponent(
//    "bitrix:news.list",
//    "hotels.news.list",
//    Array(
//        "ACTIVE_DATE_FORMAT" => "d.m.Y",
//        "ADD_SECTIONS_CHAIN" => "N",
//        "AJAX_MODE" => "N",
//        "AJAX_OPTION_ADDITIONAL" => "",
//        "AJAX_OPTION_HISTORY" => "N",
//        "AJAX_OPTION_JUMP" => "N",
//        "AJAX_OPTION_STYLE" => "Y",
//        "CACHE_FILTER" => "N",
//        "CACHE_GROUPS" => "Y",
//        "CACHE_TIME" => "36000000",
//        "CACHE_TYPE" => "A",
//        "CHECK_DATES" => "Y",
//        "DETAIL_URL" => "",
//        "DISPLAY_BOTTOM_PAGER" => "Y",
//        "DISPLAY_DATE" => "N",
//        "DISPLAY_NAME" => "Y",
//        "DISPLAY_PICTURE" => "Y",
//        "DISPLAY_PREVIEW_TEXT" => "N",
//        "DISPLAY_TOP_PAGER" => "N",
//        "FIELD_CODE" => array("",""),
//        "FILTER_NAME" => "",
//        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
//        "IBLOCK_ID" => "26",
//        "IBLOCK_TYPE" => "content",
//        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
//        "INCLUDE_SUBSECTIONS" => "Y",
//        "MESSAGE_404" => "",
//        "NEWS_COUNT" => "20",
//        "PAGER_BASE_LINK_ENABLE" => "N",
//        "PAGER_DESC_NUMBERING" => "N",
//        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
//        "PAGER_SHOW_ALL" => "N",
//        "PAGER_SHOW_ALWAYS" => "N",
//        "PAGER_TEMPLATE" => ".default",
//        "PAGER_TITLE" => "Гостиницы",
//        "PARENT_SECTION" => "",
//        "PARENT_SECTION_CODE" => "",
//        "PREVIEW_TRUNCATE_LEN" => "",
//        "PROPERTY_CODE" => array("TYPE", "ADDRESS", "TOP", "GALLERY", "COORDINATES"),
//        "SET_BROWSER_TITLE" => "N",
//        "SET_LAST_MODIFIED" => "N",
//        "SET_META_DESCRIPTION" => "N",
//        "SET_META_KEYWORDS" => "N",
//        "SET_STATUS_404" => "N",
//        "SET_TITLE" => "N",
//        "SHOW_404" => "N",
//        "SORT_BY1" => "ACTIVE_FROM",
//        "SORT_BY2" => "SORT",
//        "SORT_ORDER1" => "DESC",
//        "SORT_ORDER2" => "ASC",
//        "STRICT_SECTION_CHECK" => "N"
//    )
//);?>
<main class="main">
    <section class="section section--intro" style="--background: url('/local/templates/diez-ekb/assets/images/main-bg-3.jpg')">
        <div class="container">
            <div class="intro">
                <h1 class="title title--light">
                    Гостиницы города
                </h1>
                <p class="subtitle">
                    В 2023 году Екатеринбург отпразднует свое 300-летие. Свою историю город отсчитывает с 18 ноября 1723
                    года, когда были запущены цеха крупнейшего в России железоделательного Екатерининского завода.
                </p>
            </div>
        </div>
    </section>

    <?php
    // Компонент с гостиницами
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "hotels.news.list",
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
            "DETAIL_URL" => "/hotels/#ELEMENT_CODE#/",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array("", ""),
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "26",
            "IBLOCK_TYPE" => "content",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "4", // Показываем по 8 элементов для удобства пагинации
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Гостиницы",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => array("TYPE", "ADDRESS", "TOP", "GALLERY", "COORDINATES"),
            "SET_BROWSER_TITLE" => "Y",
            "SET_LAST_MODIFIED" => "Y",
            "SET_META_DESCRIPTION" => "Y",
            "SET_META_KEYWORDS" => "Y",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SORT_BY1" => "PROPERTY_TOP",
            "SORT_BY2" => "SORT",
            "SORT_ORDER1" => "DESC",
            "SORT_ORDER2" => "ASC",
            "STRICT_SECTION_CHECK" => "N"
        )
    );
    ?>
<!--    <section class="section section--gradient pt-130 ptm-64 pb-125 pbm-30">-->
<!--        <div class="container">-->
<!--            <div class="header-block">-->
<!--                <h2 class="title">Где остановиться</h2>-->
<!--            </div>-->
<!--            <div class="hotels">-->
<!--                <div class="filter tags">-->
<!--                    <a href="#" class="tag tag--filter active" target="_blank">-->
<!--                        <span>гостиницы 5</span>-->
<!--                        <svg>-->
<!--                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-star"></use>-->
<!--                        </svg>-->
<!--                    </a>-->
<!--                    <a href="#" class="tag tag--filter active" target="_blank">-->
<!--                        <span>гостиницы 4</span>-->
<!--                        <svg>-->
<!--                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-star"></use>-->
<!--                        </svg>-->
<!--                    </a>-->
<!--                    <a href="#" class="tag tag--filter active" target="_blank">-->
<!--                        <span>гостиницы 3</span>-->
<!--                        <svg>-->
<!--                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-star"></use>-->
<!--                        </svg>-->
<!--                    </a>-->
<!--                    <a href="#" class="tag tag--filter" target="_blank">хостелы</a>-->
<!--                    <a href="#" class="tag tag--filter" target="_blank">кемпинги</a>-->
<!--                    <a href="#" class="tag tag--filter" target="_blank">глемпинги</a>-->
<!--                </div>-->
<!--                <div class="hotels__list">-->
<!--                    <a href="#" class="article-news article-news--max-size article-news--attraction article-news--light">-->
<!--                    <span class="article-news__badges">-->
<!--                        <span class="badge">топ!</span>-->
<!--                    </span>-->
<!--                        <picture class="article-news__picture">-->
<!--                            <img src="/local/templates/diez-ekb/assets/images/hotel-1.png" alt="">-->
<!--                        </picture>-->
<!--                        <div class="article-news__info">-->
<!--                            <h2 class="article-news__title">-->
<!--                                Отель-гостиница Мегалайт-->
<!--                            </h2>-->
<!--                            <p class="article-news__place">-->
<!--                                <svg>-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                </svg>-->
<!--                                <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                    <a href="#" class="article-news article-news--max-size article-news--attraction article-news--light">-->
<!--                    <span class="article-news__badges">-->
<!--                        <span class="badge">топ!</span>-->
<!--                    </span>-->
<!--                        <picture class="article-news__picture">-->
<!--                            <img src="/local/templates/diez-ekb/assets/images/hotel-2.jpg" alt="">-->
<!--                        </picture>-->
<!--                        <div class="article-news__info">-->
<!--                            <h2 class="article-news__title">-->
<!--                                Отель-гостиница Мегалайт-->
<!--                            </h2>-->
<!--                            <p class="article-news__place">-->
<!--                                <svg>-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                </svg>-->
<!--                                <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                    <a href="#" class="article-news article-news--max-size article-news--attraction article-news--light">-->
<!--                    <span class="article-news__badges">-->
<!--                        <span class="badge">топ!</span>-->
<!--                    </span>-->
<!--                        <picture class="article-news__picture">-->
<!--                            <img src="/local/templates/diez-ekb/assets/images/hotel-3.png" alt="">-->
<!--                        </picture>-->
<!--                        <div class="article-news__info">-->
<!--                            <h2 class="article-news__title">-->
<!--                                Отель-гостиница Мегалайт-->
<!--                            </h2>-->
<!--                            <p class="article-news__place">-->
<!--                                <svg>-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                </svg>-->
<!--                                <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                    <a href="#" class="article-news article-news--max-size article-news--attraction article-news--light">-->
<!--                    <span class="article-news__badges">-->
<!--                        <span class="badge">топ!</span>-->
<!--                    </span>-->
<!--                        <picture class="article-news__picture">-->
<!--                            <img src="/local/templates/diez-ekb/assets/images/hotel-4.png" alt="">-->
<!--                        </picture>-->
<!--                        <div class="article-news__info">-->
<!--                            <h2 class="article-news__title">-->
<!--                                Отель-гостиница Мегалайт-->
<!--                            </h2>-->
<!--                            <p class="article-news__place">-->
<!--                                <svg>-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                </svg>-->
<!--                                <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </a>-->
<!--                </div>-->
<!--                <button class="button button--down">-->
<!--                    <span>Показать больше</span>-->
<!--                    <span class="button__icon">-->
<!--                    <svg>-->
<!--                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                    </svg>-->
<!--                </span>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
<!---->
<!--    <section class="section section--logo-bg section--logo-bg-top pt-130 ptm-55 pb-130 pbm-80">-->
<!--        <div class="container">-->
<!--            <div class="header-block">-->
<!--                <h2 class="title">Карта гостиниц</h2>-->
<!--            </div>-->
<!--            <div class="map">-->
<!--                <iframe src="https://yandex.ru/map-widget/v1/?ll=60.599925%2C56.828213&z=13.62" width="560" height="400"-->
<!--                        frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->

</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

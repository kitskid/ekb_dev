<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Екатеринбург - Город Контрастов');

// Устанавливаем мета-теги для SEO
$APPLICATION->SetPageProperty("title", "Екатеринбург - Город Контрастов | Официальный туристический портал");
$APPLICATION->SetPageProperty("description", "Откройте для себя Екатеринбург - столицу Урала. Информация для туристов, афиша событий, достопримечательности и многое другое.");
$APPLICATION->SetPageProperty("keywords", "Екатеринбург, туризм, город контрастов, Урал, достопримечательности");
?>
    <!-- Основное содержимое страницы -->
    <main class="main">
        <section class="section section--intro" style="--background: url('/local/templates/diez-ekb/assets/images/main-bg.jpg')">
            <div class="container">
                <div class="intro">
                    <h1 class="title title--light">
                        Екатеринбург <br>
                        город контрастов
                    </h1>
                    <a href="/about/" class="button">Подробнее</a>
                </div>
            </div>
        </section>
        <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-45">
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
            <div class="decor">
                <img style="--top: 15.7%; --left: 87.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-1.svg" alt="">
                <img style="--top: 7.94%; --left: 53.8%;" src="/local/templates/diez-ekb/assets/images/decor/circle-2.svg" alt="">
                <img style="--top: 26%; --left: 7%;" src="/local/templates/diez-ekb/assets/images/decor/triangle-1.svg" alt="">
            </div>
        </section>

        <section class="section section--gray pt-87 ptm-66 pb-94 pbm-120">
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
            <div class="decor">
                <img style="--top: 7%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/circle-3.svg" alt="">
                <img style="--top: 94%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/line-1.svg" alt="">
                <img style="--top: 86%; --left: 94.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-4.svg" alt="">
            </div>
        </section>

        <section class="section section--promo" style="--background: url('/local/templates/diez-ekb/assets/images/promo.png')">
            <div class="container">
                <div class="promo-block">
                    <h2 class="title title--light">
                        Год уральского<br>
                        рока 2026
                    </h2>
                    <button class="button button--orange" id="festival-button">
                        <span>Подробная информация</span>
                        <span class="button__icon">
                <svg>
                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                </svg>
            </span>
                    </button>
                </div>
            </div>
        </section>

        <section class="section section--gradient pt-130 ptm-77 pb-150 pbm-67">
            <div class="container">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "city_digest",
                    Array(
                        "IBLOCK_TYPE" => "news_new",
                        "IBLOCK_ID" => "38",
                        "NEWS_COUNT" => "6", // Показываем 6 новостей
                        "SORT_BY1" => "PROPERTY_PUBLICATION_DATE",
                        "SORT_ORDER1" => "DESC",
                        "SORT_BY2" => "ID",
                        "SORT_ORDER2" => "DESC",
                        "FIELD_CODE" => array(
                            "ID",
                            "NAME",
                            "PREVIEW_PICTURE",
                            "DETAIL_PAGE_URL",
                            "IBLOCK_SECTION_ID"
                        ),
                        "PROPERTY_CODE" => array(
                            "PUBLICATION_DATE" // Свойство с датой публикации
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
            <div class="decor">
                <img style="--top: 15.7%; --left: 87.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-1.svg" alt="">
                <img style="--top: 5.94%; --left: 53.8%;" src="/local/templates/diez-ekb/assets/images/decor/circle-2.svg" alt="">
                <img style="--top: 26%; --left: 7%;" src="/local/templates/diez-ekb/assets/images/decor/triangle-1.svg" alt="">
            </div>
        </section>

        <section class="section section--logo-bg pt-130 ptm-38 pb-130 pbm-70">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "world_level", // Название шаблона
                [
                    "IBLOCK_TYPE" => "main",
                    "IBLOCK_ID" => "22",
                    "NEWS_COUNT" => "20",
                    "SORT_BY1" => "PROPERTY_TOP",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "",
                    "FIELD_CODE" => [
                        "ID",
                        "NAME",
                        "PREVIEW_PICTURE",
                        "DETAIL_PICTURE",
                        "DETAIL_PAGE_URL",
                    ],
                    "PROPERTY_CODE" => [
                        "ADDRESS",
                        "TOP",
                    ],
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
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
                    "PAGER_TEMPLATE" => "",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                ]
            );
            ?>
<!--            <div class="container">-->
<!--                <div class="header-block">-->
<!--                    <h2 class="title">Мировой уровень</h2>-->
<!--                    <p class="text">-->
<!--                        В год 300-летия Екатеринбург с особым размахом<br>-->
<!--                        проведёт полюбившиеся многим и известные на<br>-->
<!--                        весь мир флагманские мероприятия города, а также<br>-->
<!--                        новые уникальные события.-->
<!--                    </p>-->
<!--                </div>-->
<!--                <div class="slider slider--auto slider--visible" data-slider="poster">-->
<!--                    <div class="swiper">-->
<!--                        <div class="swiper-wrapper">-->
<!--                            <div class="swiper-slide">-->
<!--                                <a href="#" class="article-news article-news--attraction article-news--green">-->
<!--                            <span class="article-news__badges">-->
<!--                                <span class="badge">топ!</span>-->
<!--                            </span>-->
<!--                                    <picture class="article-news__picture">-->
<!--                                        <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">-->
<!--                                    </picture>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            Шигирский идол-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                                        </p>-->
<!--                                        <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="swiper-slide">-->
<!--                                <a href="#" class="article-news article-news--attraction article-news--green">-->
<!--                            <span class="article-news__badges">-->
<!--                                <span class="badge">топ!</span>-->
<!--                            </span>-->
<!--                                    <picture class="article-news__picture">-->
<!--                                        <img src="/local/templates/diez-ekb/assets/images/pic-16.jpg" alt="">-->
<!--                                    </picture>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            УГМК Арена-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                                        </p>-->
<!--                                        <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="swiper-slide">-->
<!--                                <a href="#" class="article-news article-news--attraction article-news--green">-->
<!--                            <span class="article-news__badges">-->
<!--                            </span>-->
<!--                                    <picture class="article-news__picture">-->
<!--                                        <img src="/local/templates/diez-ekb/assets/images/pic-17.jpg" alt="">-->
<!--                                    </picture>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            Спас-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                                        </p>-->
<!--                                        <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="swiper-slide">-->
<!--                                <a href="#" class="article-news article-news--attraction article-news--green">-->
<!--                            <span class="article-news__badges">-->
<!--                            </span>-->
<!--                                    <picture class="article-news__picture">-->
<!--                                        <img src="/local/templates/diez-ekb/assets/images/pic-18.jpg" alt="">-->
<!--                                    </picture>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            Кампус-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                                        </p>-->
<!--                                        <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="swiper-slide">-->
<!--                                <a href="#" class="article-news article-news--attraction article-news--green">-->
<!--                            <span class="article-news__badges">-->
<!--                                <span class="badge">топ!</span>-->
<!--                            </span>-->
<!--                                    <picture class="article-news__picture">-->
<!--                                        <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">-->
<!--                                    </picture>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            УГМК Арена-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                                        </p>-->
<!--                                        <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="swiper-slide">-->
<!--                                <a href="#" class="article-news article-news--attraction article-news--green">-->
<!--                            <span class="article-news__badges">-->
<!--                                <span class="badge">топ!</span>-->
<!--                            </span>-->
<!--                                    <picture class="article-news__picture">-->
<!--                                        <img src="/local/templates/diez-ekb/assets/images/pic-16.jpg" alt="">-->
<!--                                    </picture>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            УГМК Арена-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>-->
<!--                                        </p>-->
<!--                                        <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="swiper-footer">-->
<!--                            <div class="swiper-control">-->
<!--                                <button class="swiper-btn swiper-btn--prev">-->
<!--                                    <svg>-->
<!--                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>-->
<!--                                    </svg>-->
<!--                                </button>-->
<!--                                <button class="swiper-btn swiper-btn--next">-->
<!--                                    <svg>-->
<!--                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>-->
<!--                                    </svg>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                            <button class="button button--mob-wide">-->
<!--                                <span>больше объектов</span>-->
<!--                                <span class="button__icon">-->
<!--                            <svg>-->
<!--                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                            </svg>-->
<!--                        </span>-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </section>

        <section class="section pb-112">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "reviews",
                Array(
                    "DISPLAY_DATE" => "Y", // Изменил на Y для получения дат
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "N",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "IBLOCK_TYPE" => "reviews",
                    "IBLOCK_ID" => "25",
                    "NEWS_COUNT" => "4",
                    "SORT_BY1" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "FIELD_CODE" => array("NAME", "PREVIEW_TEXT", "ACTIVE_FROM", "DATE_CREATE"), // Добавил даты
                    "PROPERTY_CODE" => array("RATING", "AUTHOR", "AVATAR"), // Добавил AVATAR
                    "SET_TITLE" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                )
            );
            ?>
<!--            <div class="container">-->
<!--                <div class="header-block">-->
<!--                    <h2 class="title">Отзывы</h2>-->
<!--                </div>-->
<!--                <div class="slider slider--auto-overflow slider--visible" data-slider="enhanced" data-slides="4">-->
<!--                    <div class="swiper">-->
<!--                        <div class="swiper-wrapper">-->
<!--                            <div class="swiper-slide">-->
<!--                                <article class="article-review">-->
<!--                                    <div class="article-review__header">-->
<!--                                        <picture class="article-review__avatar">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/user-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <h3 class="article-review__author">Иван</h3>-->
<!--                                    </div>-->
<!--                                    <p class="article-review__text">-->
<!--                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lectus risus, finibus ornare-->
<!--                                        vestibulum et, feugiat quis dui. Vivamus sit amet dolor et magna facilisis rhoncus. Curabitur-->
<!--                                        maximus est sed porta scelerisque. Sed suscipit, arcu volutpat feugiat posuere, eros nisi-->
<!--                                        tristique nibh, mollis vehicula lectus tortor eu purus.-->
<!--                                    </p>-->
<!--                                    <div class="article-review__footer">-->
<!--                                        <time class="article-review__time" datetime="2024.11.07">07.11.2024</time>-->
<!--                                        <svg class="article-review__icon">-->
<!--                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date"></use>-->
<!--                                        </svg>-->
<!--                                    </div>-->
<!--                                </article>-->
<!--                            </div>-->
<!--                            <div class="swiper-slide">-->
<!--                                <article class="article-review">-->
<!--                                    <div class="article-review__header">-->
<!--                                        <picture class="article-review__avatar">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/user-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <h3 class="article-review__author">Иван</h3>-->
<!--                                    </div>-->
<!--                                    <p class="article-review__text">-->
<!--                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lectus risus, finibus ornare-->
<!--                                        vestibulum et, feugiat quis dui. Vivamus sit amet dolor et magna facilisis rhoncus. Curabitur-->
<!--                                        maximus est sed porta scelerisque. Sed suscipit, arcu volutpat feugiat posuere, eros nisi-->
<!--                                        tristique nibh, mollis vehicula lectus tortor eu purus.-->
<!--                                    </p>-->
<!--                                    <div class="article-review__footer">-->
<!--                                        <time class="article-review__time" datetime="2024.11.07">07.11.2024</time>-->
<!--                                        <svg class="article-review__icon">-->
<!--                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date"></use>-->
<!--                                        </svg>-->
<!--                                    </div>-->
<!--                                </article>-->
<!--                            </div>-->
<!--                            <div class="swiper-slide">-->
<!--                                <article class="article-review">-->
<!--                                    <div class="article-review__header">-->
<!--                                        <picture class="article-review__avatar">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/user-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <h3 class="article-review__author">Иван</h3>-->
<!--                                    </div>-->
<!--                                    <p class="article-review__text">-->
<!--                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lectus risus, finibus ornare-->
<!--                                        vestibulum et, feugiat quis dui. Vivamus sit amet dolor et magna facilisis rhoncus. Curabitur-->
<!--                                        maximus est sed porta scelerisque. Sed suscipit, arcu volutpat feugiat posuere, eros nisi-->
<!--                                        tristique nibh, mollis vehicula lectus tortor eu purus.-->
<!--                                    </p>-->
<!--                                    <div class="article-review__footer">-->
<!--                                        <time class="article-review__time" datetime="2024.11.07">07.11.2024</time>-->
<!--                                        <svg class="article-review__icon">-->
<!--                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date"></use>-->
<!--                                        </svg>-->
<!--                                    </div>-->
<!--                                </article>-->
<!--                            </div>-->
<!--                            <div class="swiper-slide">-->
<!--                                <article class="article-review">-->
<!--                                    <div class="article-review__header">-->
<!--                                        <picture class="article-review__avatar">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/user-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <h3 class="article-review__author">Иван</h3>-->
<!--                                    </div>-->
<!--                                    <p class="article-review__text">-->
<!--                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lectus risus, finibus ornare-->
<!--                                        vestibulum et, feugiat quis dui. Vivamus sit amet dolor et magna facilisis rhoncus. Curabitur-->
<!--                                        maximus est sed porta scelerisque. Sed suscipit, arcu volutpat feugiat posuere, eros nisi-->
<!--                                        tristique nibh, mollis vehicula lectus tortor eu purus.-->
<!--                                    </p>-->
<!--                                    <div class="article-review__footer">-->
<!--                                        <time class="article-review__time" datetime="2024.11.07">07.11.2024</time>-->
<!--                                        <svg class="article-review__icon">-->
<!--                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date"></use>-->
<!--                                        </svg>-->
<!--                                    </div>-->
<!--                                </article>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="swiper-control mob-hidden">-->
<!--                            <button class="swiper-btn swiper-btn--prev">-->
<!--                                <svg>-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>-->
<!--                                </svg>-->
<!--                            </button>-->
<!--                            <button class="swiper-btn swiper-btn--next">-->
<!--                                <svg>-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>-->
<!--                                </svg>-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </section>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const festivalButton = document.getElementById('festival-button');

            if (festivalButton) {
                festivalButton.addEventListener('click', function() {
                    window.location.href = '/festival';
                });
            }
        });
    </script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php'); ?>
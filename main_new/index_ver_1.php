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
                <a href="#" class="button">Подробнее</a>
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
<!--        <div class="container">-->
<!--            <div class="grid">-->
<!--                <div class="grid__item grid__item--5 grid__item-mob--4">-->
<!--                    <div class="poster">-->
<!--                        <div class="poster__info">-->
<!--                            <h2 class="title">Афиша</h2>-->
<!--                            <p class="text">-->
<!--                                В год 300-летия Екатеринбург с особым размахом проведёт полюбившиеся многим и известные на-->
<!--                                весь-->
<!--                                мир флагманские мероприятия города, а также новые уникальные события.-->
<!--                            </p>-->
<!--                            <button class="button mob-hidden">-->
<!--                                <span>Все события</span>-->
<!--                                <span class="button__icon">-->
<!--                                <svg>-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                </svg>-->
<!--                            </span>-->
<!--                            </button>-->
<!--                        </div>-->
<!--                        <div class="tags">-->
<!--                            <a href="#" class="tag" target="_blank">Выставки</a>-->
<!--                            <a href="#" class="tag" target="_blank">Спектакли</a>-->
<!--                            <a href="#" class="tag" target="_blank">Спорт</a>-->
<!--                            <a href="#" class="tag" target="_blank">Фестивали</a>-->
<!--                            <a href="#" class="tag" target="_blank">Экскурсии</a>-->
<!--                            <a href="#" class="tag" target="_blank">Детям</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="grid__item grid__item--7 grid__item-mob--4">-->
<!--                    <div class="slider slider--auto slider--visible" data-slider="poster">-->
<!--                        <div class="swiper">-->
<!--                            <div class="swiper-wrapper">-->
<!--                                <div class="swiper-slide">-->
<!--                                    <a href="#" class="article-news article-news--yellow">-->
<!--                                        <span class="article-news__badges"></span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-10.jpg" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-news__info">-->
<!--                                            <div class="article-news__header">-->
<!--                                                <p class="article-news__tag">Концерт</p>-->
<!--                                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>-->
<!--                                            </div>-->
<!--                                            <h2 class="article-news__title">-->
<!--                                                Трибьют-концерт Свердловского рок-клуба-->
<!--                                            </h2>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                                <div class="swiper-slide">-->
<!--                                    <a href="#" class="article-news article-news--green">-->
<!--                                    <span class="article-news__badges">-->
<!--                                        <span class="badge">топ!</span>-->
<!--                                    </span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-11.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-news__info">-->
<!--                                            <div class="article-news__header">-->
<!--                                                <p class="article-news__tag">Фестиваль</p>-->
<!--                                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>-->
<!--                                            </div>-->
<!--                                            <h2 class="article-news__title">-->
<!--                                                Фестиваль уличных театров «Лица улиц»-->
<!--                                            </h2>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                                <div class="swiper-slide">-->
<!--                                    <a href="#" class="article-news article-news--green">-->
<!--                                    <span class="article-news__badges">-->
<!--                                        <span class="badge">топ!</span>-->
<!--                                    </span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-12.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-news__info">-->
<!--                                            <div class="article-news__header">-->
<!--                                                <p class="article-news__tag">Фестиваль</p>-->
<!--                                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>-->
<!--                                            </div>-->
<!--                                            <h2 class="article-news__title">-->
<!--                                                Фестиваль уличных театров «Лица улиц»-->
<!--                                            </h2>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                                <div class="swiper-slide">-->
<!--                                    <a href="#" class="article-news article-news--yellow">-->
<!--                                        <span class="article-news__badges"></span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-10.jpg" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-news__info">-->
<!--                                            <div class="article-news__header">-->
<!--                                                <p class="article-news__tag">Концерт</p>-->
<!--                                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>-->
<!--                                            </div>-->
<!--                                            <h2 class="article-news__title">-->
<!--                                                Трибьют-концерт Свердловского рок-клуба-->
<!--                                            </h2>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                                <div class="swiper-slide">-->
<!--                                    <a href="#" class="article-news article-news--green">-->
<!--                                    <span class="article-news__badges">-->
<!--                                        <span class="badge">топ!</span>-->
<!--                                    </span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-11.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-news__info">-->
<!--                                            <div class="article-news__header">-->
<!--                                                <p class="article-news__tag">Фестиваль</p>-->
<!--                                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>-->
<!--                                            </div>-->
<!--                                            <h2 class="article-news__title">-->
<!--                                                Фестиваль уличных театров «Лица улиц»-->
<!--                                            </h2>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                                <div class="swiper-slide">-->
<!--                                    <a href="#" class="article-news article-news--green">-->
<!--                                    <span class="article-news__badges">-->
<!--                                        <span class="badge">топ!</span>-->
<!--                                    </span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-12.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-news__info">-->
<!--                                            <div class="article-news__header">-->
<!--                                                <p class="article-news__tag">Фестиваль</p>-->
<!--                                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>-->
<!--                                            </div>-->
<!--                                            <h2 class="article-news__title">-->
<!--                                                Фестиваль уличных театров «Лица улиц»-->
<!--                                            </h2>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="swiper-control swiper-control--end">-->
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
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="grid__item grid__item-mob--4 desktop-hidden">-->
<!--                    <button class="button button--mob-wide">-->
<!--                        <span>Все события</span>-->
<!--                        <span class="button__icon">-->
<!--                        <svg>-->
<!--                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                        </svg>-->
<!--                    </span>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
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
                <button class="button button--orange">
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
            <div class="header-block">
                <h2 class="title">Городской дайджест</h2>
                <button class="button mob-hidden">
                    <span>больше текстов</span>
                    <span class="button__icon">
                    <svg>
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                    </svg>
                </span>
                </button>
            </div>
            <div class="grid">
                <div class="grid__item grid__item--4 grid__item-mob--4">
                    <a href="#" class="article-news article-news--full article-news--orange">
                        <span class="article-news__badges"></span>
                        <picture class="article-news__picture">
                            <img src="/local/templates/diez-ekb/assets/images/pic-13.png" alt="">
                        </picture>
                        <div class="article-news__info">
                            <div class="article-news__header">
                                <p class="article-news__tag">культура</p>
                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>
                            </div>
                            <h2 class="article-news__title">
                                Проекты Дня города будут не только развлекать, но и просвещать
                            </h2>
                            <div class="show-more">
                                <span>Узнать подробности</span>
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="grid__item grid__item--4 grid__item-mob--4">
                    <a href="#" class="article-news article-news--full article-news--blue">
                        <span class="article-news__badges"></span>
                        <picture class="article-news__picture">
                            <img src="/local/templates/diez-ekb/assets/images/pic-14.png" alt="">
                        </picture>
                        <div class="article-news__info">
                            <div class="article-news__header">
                                <p class="article-news__tag">транспорт</p>
                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>
                            </div>
                            <h2 class="article-news__title">
                                Запуск ретропоезда «Уральский экспресс»
                            </h2>
                            <div class="show-more">
                                <span>Узнать подробности</span>
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="grid__item grid__item--4 grid__item-mob--4">
                    <a href="#" class="article-news article-news--full article-news--orange">
                        <span class="article-news__badges"></span>
                        <picture class="article-news__picture">
                            <img src="/local/templates/diez-ekb/assets/images/pic-13.png" alt="">
                        </picture>
                        <div class="article-news__info">
                            <div class="article-news__header">
                                <p class="article-news__tag">культура</p>
                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>
                            </div>
                            <h2 class="article-news__title">
                                Проекты Дня города будут не только развлекать, но и просвещать
                            </h2>
                            <div class="show-more">
                                <span>Узнать подробности</span>
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="grid__item grid__item--4 grid__item-mob--4 mob-hidden">
                    <a href="#" class="article-news article-news--full article-news--blue">
                        <span class="article-news__badges"></span>
                        <picture class="article-news__picture">
                            <img src="/local/templates/diez-ekb/assets/images/pic-14.png" alt="">
                        </picture>
                        <div class="article-news__info">
                            <div class="article-news__header">
                                <p class="article-news__tag">транспорт</p>
                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>
                            </div>
                            <h2 class="article-news__title">
                                Запуск ретропоезда «Уральский экспресс»
                            </h2>
                            <div class="show-more">
                                <span>Узнать подробности</span>
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="grid__item grid__item--4 grid__item-mob--4 mob-hidden">
                    <a href="#" class="article-news article-news--full article-news--orange">
                        <span class="article-news__badges"></span>
                        <picture class="article-news__picture">
                            <img src="/local/templates/diez-ekb/assets/images/pic-13.png" alt="">
                        </picture>
                        <div class="article-news__info">
                            <div class="article-news__header">
                                <p class="article-news__tag">культура</p>
                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>
                            </div>
                            <h2 class="article-news__title">
                                Проекты Дня города будут не только развлекать, но и просвещать
                            </h2>
                            <div class="show-more">
                                <span>Узнать подробности</span>
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="grid__item grid__item--4 grid__item-mob--4 mob-hidden">
                    <a href="#" class="article-news article-news--full article-news--blue">
                        <span class="article-news__badges"></span>
                        <picture class="article-news__picture">
                            <img src="/local/templates/diez-ekb/assets/images/pic-14.png" alt="">
                        </picture>
                        <div class="article-news__info">
                            <div class="article-news__header">
                                <p class="article-news__tag">транспорт</p>
                                <time class="article-news__time" datetime="2025.02.12">12.02.2025</time>
                            </div>
                            <h2 class="article-news__title">
                                Запуск ретропоезда «Уральский экспресс»
                            </h2>
                            <div class="show-more">
                                <span>Узнать подробности</span>
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="decor">
            <img style="--top: 15.7%; --left: 87.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-1.svg" alt="">
            <img style="--top: 5.94%; --left: 53.8%;" src="/local/templates/diez-ekb/assets/images/decor/circle-2.svg" alt="">
            <img style="--top: 26%; --left: 7%;" src="/local/templates/diez-ekb/assets/images/decor/triangle-1.svg" alt="">
        </div>
    </section>

    <section class="section section--logo-bg pt-130 ptm-38 pb-130 pbm-70">
        <div class="container">
            <div class="header-block">
                <h2 class="title">Мировой уровень</h2>
                <p class="text">
                    В год 300-летия Екатеринбург с особым размахом<br>
                    проведёт полюбившиеся многим и известные на<br>
                    весь мир флагманские мероприятия города, а также<br>
                    новые уникальные события.
                </p>
            </div>
            <div class="slider slider--auto slider--visible" data-slider="poster">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="#" class="article-news article-news--attraction article-news--green">
                            <span class="article-news__badges">
                                <span class="badge">топ!</span>
                            </span>
                                <picture class="article-news__picture">
                                    <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">
                                </picture>
                                <div class="article-news__info">
                                    <h2 class="article-news__title">
                                        Шигирский идол
                                    </h2>
                                    <p class="article-news__place">
                                        <svg>
                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                        </svg>
                                        <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                                    </p>
                                    <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="article-news article-news--attraction article-news--green">
                            <span class="article-news__badges">
                                <span class="badge">топ!</span>
                            </span>
                                <picture class="article-news__picture">
                                    <img src="/local/templates/diez-ekb/assets/images/pic-16.jpg" alt="">
                                </picture>
                                <div class="article-news__info">
                                    <h2 class="article-news__title">
                                        УГМК Арена
                                    </h2>
                                    <p class="article-news__place">
                                        <svg>
                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                        </svg>
                                        <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                                    </p>
                                    <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="article-news article-news--attraction article-news--green">
                            <span class="article-news__badges">
                            </span>
                                <picture class="article-news__picture">
                                    <img src="/local/templates/diez-ekb/assets/images/pic-17.jpg" alt="">
                                </picture>
                                <div class="article-news__info">
                                    <h2 class="article-news__title">
                                        Спас
                                    </h2>
                                    <p class="article-news__place">
                                        <svg>
                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                        </svg>
                                        <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                                    </p>
                                    <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="article-news article-news--attraction article-news--green">
                            <span class="article-news__badges">
                            </span>
                                <picture class="article-news__picture">
                                    <img src="/local/templates/diez-ekb/assets/images/pic-18.jpg" alt="">
                                </picture>
                                <div class="article-news__info">
                                    <h2 class="article-news__title">
                                        Кампус
                                    </h2>
                                    <p class="article-news__place">
                                        <svg>
                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                        </svg>
                                        <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                                    </p>
                                    <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="article-news article-news--attraction article-news--green">
                            <span class="article-news__badges">
                                <span class="badge">топ!</span>
                            </span>
                                <picture class="article-news__picture">
                                    <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">
                                </picture>
                                <div class="article-news__info">
                                    <h2 class="article-news__title">
                                        УГМК Арена
                                    </h2>
                                    <p class="article-news__place">
                                        <svg>
                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                        </svg>
                                        <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                                    </p>
                                    <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="article-news article-news--attraction article-news--green">
                            <span class="article-news__badges">
                                <span class="badge">топ!</span>
                            </span>
                                <picture class="article-news__picture">
                                    <img src="/local/templates/diez-ekb/assets/images/pic-16.jpg" alt="">
                                </picture>
                                <div class="article-news__info">
                                    <h2 class="article-news__title">
                                        УГМК Арена
                                    </h2>
                                    <p class="article-news__place">
                                        <svg>
                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                        </svg>
                                        <span>г. Екатеринбург, пер. Мордвинский, пер.1</span>
                                    </p>
                                    <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-footer">
                        <div class="swiper-control">
                            <button class="swiper-btn swiper-btn--prev">
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                                </svg>
                            </button>
                            <button class="swiper-btn swiper-btn--next">
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                                </svg>
                            </button>
                        </div>
                        <button class="button button--mob-wide">
                            <span>больше объектов</span>
                            <span class="button__icon">
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                            </svg>
                        </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section pb-112">
        <div class="container">
            <div class="header-block">
                <h2 class="title">Отзывы</h2>
            </div>
            <div class="slider slider--auto-overflow slider--visible" data-slider="enhanced" data-slides="4">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <article class="article-review">
                                <div class="article-review__header">
                                    <picture class="article-review__avatar">
                                        <img src="/local/templates/diez-ekb/assets/images/user-1.png" alt="">
                                    </picture>
                                    <h3 class="article-review__author">Иван</h3>
                                </div>
                                <p class="article-review__text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lectus risus, finibus ornare
                                    vestibulum et, feugiat quis dui. Vivamus sit amet dolor et magna facilisis rhoncus. Curabitur
                                    maximus est sed porta scelerisque. Sed suscipit, arcu volutpat feugiat posuere, eros nisi
                                    tristique nibh, mollis vehicula lectus tortor eu purus.
                                </p>
                                <div class="article-review__footer">
                                    <time class="article-review__time" datetime="2024.11.07">07.11.2024</time>
                                    <svg class="article-review__icon">
                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date"></use>
                                    </svg>
                                </div>
                            </article>
                        </div>
                        <div class="swiper-slide">
                            <article class="article-review">
                                <div class="article-review__header">
                                    <picture class="article-review__avatar">
                                        <img src="/local/templates/diez-ekb/assets/images/user-1.png" alt="">
                                    </picture>
                                    <h3 class="article-review__author">Иван</h3>
                                </div>
                                <p class="article-review__text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lectus risus, finibus ornare
                                    vestibulum et, feugiat quis dui. Vivamus sit amet dolor et magna facilisis rhoncus. Curabitur
                                    maximus est sed porta scelerisque. Sed suscipit, arcu volutpat feugiat posuere, eros nisi
                                    tristique nibh, mollis vehicula lectus tortor eu purus.
                                </p>
                                <div class="article-review__footer">
                                    <time class="article-review__time" datetime="2024.11.07">07.11.2024</time>
                                    <svg class="article-review__icon">
                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date"></use>
                                    </svg>
                                </div>
                            </article>
                        </div>
                        <div class="swiper-slide">
                            <article class="article-review">
                                <div class="article-review__header">
                                    <picture class="article-review__avatar">
                                        <img src="/local/templates/diez-ekb/assets/images/user-1.png" alt="">
                                    </picture>
                                    <h3 class="article-review__author">Иван</h3>
                                </div>
                                <p class="article-review__text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lectus risus, finibus ornare
                                    vestibulum et, feugiat quis dui. Vivamus sit amet dolor et magna facilisis rhoncus. Curabitur
                                    maximus est sed porta scelerisque. Sed suscipit, arcu volutpat feugiat posuere, eros nisi
                                    tristique nibh, mollis vehicula lectus tortor eu purus.
                                </p>
                                <div class="article-review__footer">
                                    <time class="article-review__time" datetime="2024.11.07">07.11.2024</time>
                                    <svg class="article-review__icon">
                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date"></use>
                                    </svg>
                                </div>
                            </article>
                        </div>
                        <div class="swiper-slide">
                            <article class="article-review">
                                <div class="article-review__header">
                                    <picture class="article-review__avatar">
                                        <img src="/local/templates/diez-ekb/assets/images/user-1.png" alt="">
                                    </picture>
                                    <h3 class="article-review__author">Иван</h3>
                                </div>
                                <p class="article-review__text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lectus risus, finibus ornare
                                    vestibulum et, feugiat quis dui. Vivamus sit amet dolor et magna facilisis rhoncus. Curabitur
                                    maximus est sed porta scelerisque. Sed suscipit, arcu volutpat feugiat posuere, eros nisi
                                    tristique nibh, mollis vehicula lectus tortor eu purus.
                                </p>
                                <div class="article-review__footer">
                                    <time class="article-review__time" datetime="2024.11.07">07.11.2024</time>
                                    <svg class="article-review__icon">
                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date"></use>
                                    </svg>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="swiper-control mob-hidden">
                        <button class="swiper-btn swiper-btn--prev">
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                            </svg>
                        </button>
                        <button class="swiper-btn swiper-btn--next">
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php'); ?>
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
    <main class="main">
        <section class="section section--intro" style="--background: url('../assets/images/main-bg-4.jpg')">
            <div class="container">
                <div class="intro">
                    <div class="breadcrumbs breadcrumbs--intro">
                        <a href="#" class="breadcrumbs__link">Главная</a>
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
            <div class="container">
                <div class="blockPickYourRoute">
                    <div class="header-block">
                        <h2 class="title">
                            <span>Выбери</span> свой маршрут
                        </h2>
                    </div>

                    <div class="grid">
                        <div class="grid__item grid__item--5 grid__item-mob--4">
                            <div class="block-text">
                                <p class="text">
                                    Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света,
                                    соединивший в себе Европу и Азию. Поможем спланировать путешествие в Екатеринбург — город на
                                    пересечении двух частей света, соединивший в себе Европу и Азию.
                                </p>
                                <img class="mob-hidden" src="/local/templates/diez-ekb/assets/images/icon-route.svg" alt="">
                                <img class="block-text__icon desktop-hidden" src="/local/templates/diez-ekb/assets/images/icon-route-mob.svg" alt="">
                                <div class="block-text__icon swiper-control noselect mob-hidden">
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
                        <div class="grid__item grid__item--7 grid__item-mob--4">
                            <div class="slider slider--auto slider--visible" data-slider="enhanced">
                                <div class="swiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <article class="article-intro-card article-intro-card--narrow article-intro-card--green">
                                                <div class="article-intro-card__tags">
                                                    <a href="#" class="article-intro-card__tag">природный туризм</a>
                                                </div>
                                                <picture class="article-intro-card__picture">
                                                    <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">
                                                </picture>
                                                <div class="article-intro-card__info">
                                                    <h2 class="article-intro-card__title">
                                                        Экскурсионный маршрут на Уральские горы
                                                    </h2>
                                                    <a href="#" class="article-intro-card__link">
                                                        <span>Узнать подробности</span>
                                                        <svg class="article-intro-card__icon">
                                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="swiper-slide">
                                            <article class="article-intro-card article-intro-card--narrow article-intro-card--orange">
                                                <div class="article-intro-card__tags">
                                                    <a href="#" class="article-intro-card__tag">Музеи</a>
                                                    <a href="#" class="article-intro-card__tag">Театры</a>
                                                    <a href="#" class="article-intro-card__tag">Кинотеатры</a>
                                                </div>
                                                <picture class="article-intro-card__picture">
                                                    <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">
                                                </picture>
                                                <div class="article-intro-card__info">
                                                    <h2 class="article-intro-card__title">
                                                        Культурно-познавательный туризм
                                                    </h2>
                                                    <a href="#" class="article-intro-card__link">
                                                        <span>Узнать подробности</span>
                                                        <svg class="article-intro-card__icon">
                                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="swiper-slide">
                                            <article class="article-intro-card article-intro-card--narrow article-intro-card--purple">
                                                <div class="article-intro-card__tags">
                                                    <a href="#" class="article-intro-card__tag">Музеи</a>
                                                    <a href="#" class="article-intro-card__tag">Театры</a>
                                                    <a href="#" class="article-intro-card__tag">Кинотеатры</a>
                                                </div>
                                                <picture class="article-intro-card__picture">
                                                    <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">
                                                </picture>
                                                <div class="article-intro-card__info">
                                                    <h2 class="article-intro-card__title">
                                                        Культурно-познавательный туризм
                                                    </h2>
                                                    <a href="#" class="article-intro-card__link">
                                                        <span>Узнать подробности</span>
                                                        <svg class="article-intro-card__icon">
                                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-control swiper-control--static noselect desktop-hidden">
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
                    </div>
                </div>
            </div>
            <!--    <div class="decor mob-hidden blockPickYourRoute__decor">-->
            <!--        <img style="&#45;&#45;top: 15.7%; &#45;&#45;left: 87.3%;" src="./assets/images/decor/circle-1.svg" alt="">-->
            <!--        <img style="&#45;&#45;top: 7.94%; &#45;&#45;left: 53.8%;" src="./assets/images/decor/circle-2.svg" alt="">-->
            <!--        <img style="&#45;&#45;top: 26%; &#45;&#45;left: 7%;" src="./assets/images/decor/triangle-1.svg" alt="">-->
            <!--    </div>-->
        </section>

        <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-45">
            <div class="container">
                <div class="blockAttractionsDirections">
                    <div class="header-block">
                        <h2 class="title">
                            Достопримечательности
                        </h2>
                        <div class="swiper-control noselect mob-hidden">
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
                    <div class="slider slider--auto slider--visible" data-slider="enhanced">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a href="#" class="article-news article-news--attraction article-news--direction article-news--red">
                                        <div class="article-news__intro">
                                    <span class="article-news__badges">
                                        <span class="badge">топ!</span>
                                    </span>
                                            <picture class="article-news__picture">
                                                <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">
                                            </picture>
                                            <div class="article-news__more">
                                                <span>подробнее</span>
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="article-news__info">
                                            <h2 class="article-news__title">
                                                Музейный комплекс УГМК
                                            </h2>
                                            <p class="article-news__place">
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                                </svg>
                                                <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="#" class="article-news article-news--attraction article-news--direction article-news--blue">
                                        <div class="article-news__intro">
                                    <span class="article-news__badges">
                                        <span class="badge">топ!</span>
                                    </span>
                                            <picture class="article-news__picture">
                                                <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">
                                            </picture>
                                            <div class="article-news__more">
                                                <span>подробнее</span>
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="article-news__info">
                                            <h2 class="article-news__title">
                                                Музейный комплекс УГМК
                                            </h2>
                                            <p class="article-news__place">
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                                </svg>
                                                <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="#" class="article-news article-news--attraction article-news--direction article-news--purple">
                                        <div class="article-news__intro">
                                    <span class="article-news__badges">
                                        <span class="badge">топ!</span>
                                    </span>
                                            <picture class="article-news__picture">
                                                <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">
                                            </picture>
                                            <div class="article-news__more">
                                                <span>подробнее</span>
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="article-news__info">
                                            <h2 class="article-news__title">
                                                Музейный комплекс УГМК
                                            </h2>
                                            <p class="article-news__place">
                                                <svg>
                                                    <use xlink:href="./assets/sprite.svg#icon-location"></use>
                                                </svg>
                                                <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="#" class="article-news article-news--attraction article-news--direction article-news--yellow">
                                        <div class="article-news__intro">
                                    <span class="article-news__badges">
                                        <span class="badge">топ!</span>
                                    </span>
                                            <picture class="article-news__picture">
                                                <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">
                                            </picture>
                                            <div class="article-news__more">
                                                <span>подробнее</span>
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="article-news__info">
                                            <h2 class="article-news__title">
                                                Музейный комплекс УГМК
                                            </h2>
                                            <p class="article-news__place">
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                                </svg>
                                                <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="#" class="article-news article-news--attraction article-news--direction article-news--green">
                                        <div class="article-news__intro">
                                    <span class="article-news__badges">
                                        <span class="badge">топ!</span>
                                    </span>
                                            <picture class="article-news__picture">
                                                <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">
                                            </picture>
                                            <div class="article-news__more">
                                                <span>подробнее</span>
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="article-news__info">
                                            <h2 class="article-news__title">
                                                Музейный комплекс УГМК
                                            </h2>
                                            <p class="article-news__place">
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                                </svg>
                                                <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="#" class="article-news article-news--attraction article-news--direction article-news--red">
                                        <div class="article-news__intro">
                                    <span class="article-news__badges">
                                        <span class="badge">топ!</span>
                                    </span>
                                            <picture class="article-news__picture">
                                                <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">
                                            </picture>
                                            <div class="article-news__more">
                                                <span>подробнее</span>
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="article-news__info">
                                            <h2 class="article-news__title">
                                                Музейный комплекс УГМК
                                            </h2>
                                            <p class="article-news__place">
                                                <svg>
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                                </svg>
                                                <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="swiper-control noselect desktop-hidden">
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
                    <svg class="mob-hidden blockAttractionsDirections__decor">
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-attractions"></use>
                    </svg>
                </div>
            </div>
        </section>

        <section class="section section--guides pt-130 ptm-70 pb-130 pbm-100">
            <div class="container">
                <div class="header-block header-block--offset">
                    <h2 class="title">
                        Ваш гид по Екатеринбургу
                    </h2>
                    <div class="text">
                        Каждый уголок Екатеринбурга скрывает свою уникальную историю.<br>
                        Наши экскурсоводы помогут вам увидеть все самые интересные места города.<br>
                        Выберите экскурсовода, чтобы узнать подробности о туре и контакты для записи.
                    </div>
                </div>
                <div class="guides">
                    <article class="article-guide">
                        <picture class="article-guide__picture">
                            <img src="/local/templates/diez-ekb/assets/images/guide-1.png" alt="">
                        </picture>
                        <p class="article-guide__text">“Покажу<br>Уралмаш!”</p>
                    </article>
                    <article class="article-guide">
                        <picture class="article-guide__picture">
                            <img src="/local/templates/diez-ekb/assets/images/guide-2.png" alt="">
                        </picture>
                        <p class="article-guide__text">
                            “Я расскажу вам всё<br>
                            о метро Екатеринбурга!”
                        </p>
                    </article>
                    <article class="article-guide">
                        <picture class="article-guide__picture">
                            <img src="/local/templates/diez-ekb/assets/images/guide-3.png" alt="">
                        </picture>
                        <p class="article-guide__text">
                            “Раскрою тайны<br>
                            центра города!”
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section section--routes pt-130 ptm-70 pb-130 pbm-100">
            <div class="container">
                <div class="blockTopRoutes">
                    <div class="header-block">
                        <h2 class="title">
                            топ маршрутов
                        </h2>
                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item--5 grid__item-mob--4">
                            <div class="block-text">
                                <p class="text">
                                    Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света,
                                    соединивший в себе Европу и Азию. Поможем спланировать путешествие в Екатеринбург — город на
                                    пересечении двух частей света, соединивший в себе Европу и Азию.
                                </p>
                                <div class="swiper-control noselect mob-hidden">
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
                        <div class="grid__item grid__item--7 grid__item-mob--4">
                            <div class="slider slider--auto slider--visible" data-slider="enhanced">
                                <div class="swiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <article class="article-intro-card article-intro-card--narrow article-intro-card--green">
                                                <div class="article-intro-card__tags">
                                                    <a href="#" class="article-intro-card__tag">природный туризм</a>
                                                </div>
                                                <picture class="article-intro-card__picture">
                                                    <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">
                                                </picture>
                                                <div class="article-intro-card__info">
                                                    <h2 class="article-intro-card__title">
                                                        Экскурсионный маршрут на Уральские горы
                                                    </h2>
                                                    <a href="#" class="article-intro-card__link">
                                                        <span>Узнать подробности</span>
                                                        <svg class="article-intro-card__icon">
                                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="swiper-slide">
                                            <article class="article-intro-card article-intro-card--narrow article-intro-card--orange">
                                                <div class="article-intro-card__tags">
                                                    <a href="#" class="article-intro-card__tag">Музеи</a>
                                                    <a href="#" class="article-intro-card__tag">Театры</a>
                                                    <a href="#" class="article-intro-card__tag">Кинотеатры</a>
                                                </div>
                                                <picture class="article-intro-card__picture">
                                                    <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">
                                                </picture>
                                                <div class="article-intro-card__info">
                                                    <h2 class="article-intro-card__title">
                                                        Культурно-познавательный туризм
                                                    </h2>
                                                    <a href="#" class="article-intro-card__link">
                                                        <span>Узнать подробности</span>
                                                        <svg class="article-intro-card__icon">
                                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="swiper-slide">
                                            <article class="article-intro-card article-intro-card--narrow article-intro-card--purple">
                                                <div class="article-intro-card__tags">
                                                    <a href="#" class="article-intro-card__tag">Музеи</a>
                                                    <a href="#" class="article-intro-card__tag">Театры</a>
                                                    <a href="#" class="article-intro-card__tag">Кинотеатры</a>
                                                </div>
                                                <picture class="article-intro-card__picture">
                                                    <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">
                                                </picture>
                                                <div class="article-intro-card__info">
                                                    <h2 class="article-intro-card__title">
                                                        Культурно-познавательный туризм
                                                    </h2>
                                                    <a href="#" class="article-intro-card__link">
                                                        <span>Узнать подробности</span>
                                                        <svg class="article-intro-card__icon">
                                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-control desktop-hidden noselect">
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
                    </div>
                </div>
            </div>
        </section>

        <section class="section section--routes-self pt-130 ptm-70 pb-130 pbm-100">
            <div class="container">
                <div class="blockTopRoutes">
                    <div class="header-block">
                        <h2 class="title">
                            топ маршрутов для самостоятельных туристов
                        </h2>
                    </div>
                    <div class="grid">
                        <div class="grid__item grid__item--5 grid__item-mob--4">
                            <div class="block-text">
                                <p class="text">
                                    Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света,
                                    соединивший в себе Европу и Азию. Поможем спланировать путешествие в Екатеринбург — город на
                                    пересечении двух частей света, соединивший в себе Европу и Азию.
                                </p>
                                <div class="swiper-control mob-hidden noselect">
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
                        <div class="grid__item grid__item--7 grid__item-mob--4">
                            <div class="slider slider--auto slider--visible" data-slider="enhanced">
                                <div class="swiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <article class="article-intro-card article-intro-card--narrow article-intro-card--green">
                                                <div class="article-intro-card__tags">
                                                    <a href="#" class="article-intro-card__tag">природный туризм</a>
                                                </div>
                                                <picture class="article-intro-card__picture">
                                                    <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">
                                                </picture>
                                                <div class="article-intro-card__info">
                                                    <h2 class="article-intro-card__title">
                                                        Экскурсионный маршрут на Уральские горы
                                                    </h2>
                                                    <a href="#" class="article-intro-card__link">
                                                        <span>Узнать подробности</span>
                                                        <svg class="article-intro-card__icon">
                                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="swiper-slide">
                                            <article class="article-intro-card article-intro-card--narrow article-intro-card--orange">
                                                <div class="article-intro-card__tags">
                                                    <a href="#" class="article-intro-card__tag">Музеи</a>
                                                    <a href="#" class="article-intro-card__tag">Театры</a>
                                                    <a href="#" class="article-intro-card__tag">Кинотеатры</a>
                                                </div>
                                                <picture class="article-intro-card__picture">
                                                    <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">
                                                </picture>
                                                <div class="article-intro-card__info">
                                                    <h2 class="article-intro-card__title">
                                                        Культурно-познавательный туризм
                                                    </h2>
                                                    <a href="#" class="article-intro-card__link">
                                                        <span>Узнать подробности</span>
                                                        <svg class="article-intro-card__icon">
                                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="swiper-slide">
                                            <article class="article-intro-card article-intro-card--narrow article-intro-card--purple">
                                                <div class="article-intro-card__tags">
                                                    <a href="#" class="article-intro-card__tag">Музеи</a>
                                                    <a href="#" class="article-intro-card__tag">Театры</a>
                                                    <a href="#" class="article-intro-card__tag">Кинотеатры</a>
                                                </div>
                                                <picture class="article-intro-card__picture">
                                                    <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">
                                                </picture>
                                                <div class="article-intro-card__info">
                                                    <h2 class="article-intro-card__title">
                                                        Культурно-познавательный туризм
                                                    </h2>
                                                    <a href="#" class="article-intro-card__link">
                                                        <span>Узнать подробности</span>
                                                        <svg class="article-intro-card__icon">
                                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-control desktop-hidden noselect">
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
                    </div>
                </div>
            </div>
            <svg class="blockTopRoutes--forSelf__decor">
                <use xlink:href="./assets/sprite.svg#icon-lines"></use>
            </svg>
        </section>

    </main>
<!--    <main class="main">-->
<!--        <section class="section section--intro" style="--background: url('/local/templates/diez-ekb/assets/images/main-bg-4.jpg')">-->
<!--            <div class="container">-->
<!--                <div class="intro">-->
<!--                    <h1 class="title title--light">-->
<!--                        Лучшие маршруты Екатеринбурга-->
<!--                    </h1>-->
<!--                    <p class="subtitle">-->
<!--                        Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света, соединивший в себе Европу и Азию.-->
<!--                    </p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
<!--        <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-45">-->
<!--            <div class="container">-->
<!--                <div class="blockPickYourRoute">-->
<!--                    <h2 class="title">-->
<!--                        <span>Выбери</span> свой маршрут-->
<!--                    </h2>-->
<!---->
<!--                    <div class="slider slider--auto slider--visible" data-slider="pickYourRoute">-->
<!--                        <div class="text">-->
<!--                            Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света, соединивший в себе Европу и Азию. Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света, соединивший в себе Европу и Азию.-->
<!--                        </div>-->
<!--                        <div class="blockPickYourRoute__vectors">-->
<!--                            <div class="blockPickYourRoute__vectors__wrapper">-->
<!--                                <div class="blockPickYourRoute__vectors__wrapper__text">-->
<!--                                    Выбери любой интересующий маршрут-->
<!--                                </div>-->
<!--                                <svg class="blockPickYourRoute__vectors__wrapper__v1 desktop-hidden">-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-pick-your-route-1"></use>-->
<!--                                </svg>-->
<!--                                <svg class="blockPickYourRoute__vectors__wrapper__v1 mob-hidden">-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-pick-your-route-1-2"></use>-->
<!--                                </svg>-->
<!--                                <svg class="blockPickYourRoute__vectors__wrapper__v2 desktop-hidden">-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-pick-your-route-2"></use>-->
<!--                                </svg>-->
<!--                                <svg class="blockPickYourRoute__vectors__wrapper__v2 mob-hidden">-->
<!--                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-pick-your-route-2-2"></use>-->
<!--                                </svg>-->
<!--                            </div>-->
<!--                            <svg class="blockPickYourRoute__vectors__wave blockPickYourRoute__vectors__wave--1">-->
<!--                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-wave"></use>-->
<!--                            </svg>-->
<!--                            <svg class="blockPickYourRoute__vectors__wave blockPickYourRoute__vectors__wave--2">-->
<!--                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-wave"></use>-->
<!--                            </svg>-->
<!--                            <svg class="blockPickYourRoute__vectors__wave blockPickYourRoute__vectors__wave--3">-->
<!--                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-wave"></use>-->
<!--                            </svg>-->
<!--                        </div>-->
<!--                        <div class="swiper">-->
<!--                            <div class="swiper-wrapper">-->
<!--                                <article class="swiper-slide article-intro-card article-intro-card--green">-->
<!--                                    <div class="article-intro-card__tags">-->
<!--                                        <a href="#" class="article-intro-card__tag">Музеи</a>-->
<!--                                        <a href="#" class="article-intro-card__tag">Театры</a>-->
<!--                                        <a href="#" class="article-intro-card__tag">Кинотеатры</a>-->
<!--                                    </div>-->
<!--                                    <picture class="article-intro-card__picture">-->
<!--                                        <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">-->
<!--                                    </picture>-->
<!--                                    <div class="article-intro-card__info">-->
<!--                                        <h2 class="article-intro-card__title">-->
<!--                                            Культурно-познавательный туризм-->
<!--                                        </h2>-->
<!--                                        <a href="#" class="article-intro-card__link">-->
<!--                                            <span>Узнать подробности</span>-->
<!--                                            <svg class="article-intro-card__icon">-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                            </svg>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                </article>-->
<!--                                <article class="swiper-slide article-intro-card article-intro-card--orange">-->
<!--                                    <div class="article-intro-card__tags">-->
<!--                                        <a href="#" class="article-intro-card__tag">Музеи</a>-->
<!--                                        <a href="#" class="article-intro-card__tag">Театры</a>-->
<!--                                        <a href="#" class="article-intro-card__tag">Кинотеатры</a>-->
<!--                                    </div>-->
<!--                                    <picture class="article-intro-card__picture">-->
<!--                                        <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">-->
<!--                                    </picture>-->
<!--                                    <div class="article-intro-card__info">-->
<!--                                        <h2 class="article-intro-card__title">-->
<!--                                            Культурно-познавательный туризм-->
<!--                                        </h2>-->
<!--                                        <a href="#" class="article-intro-card__link">-->
<!--                                            <span>Узнать подробности</span>-->
<!--                                            <svg class="article-intro-card__icon">-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                            </svg>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                </article>-->
<!--                                <article class="swiper-slide article-intro-card article-intro-card--purple">-->
<!--                                    <div class="article-intro-card__tags">-->
<!--                                        <a href="#" class="article-intro-card__tag">Музеи</a>-->
<!--                                        <a href="#" class="article-intro-card__tag">Театры</a>-->
<!--                                        <a href="#" class="article-intro-card__tag">Кинотеатры</a>-->
<!--                                    </div>-->
<!--                                    <picture class="article-intro-card__picture">-->
<!--                                        <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">-->
<!--                                    </picture>-->
<!--                                    <div class="article-intro-card__info">-->
<!--                                        <h2 class="article-intro-card__title">-->
<!--                                            Культурно-познавательный туризм-->
<!--                                        </h2>-->
<!--                                        <a href="#" class="article-intro-card__link">-->
<!--                                            <span>Узнать подробности</span>-->
<!--                                            <svg class="article-intro-card__icon">-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                            </svg>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                </article>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="swiper-control swiper-control--static noselect">-->
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
<!--            <div class="decor mob-hidden blockPickYourRoute__decor">-->
<!--                <img style="--top: 15.7%; --left: 87.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-1.svg" alt="">-->
<!--                <img style="--top: 7.94%; --left: 53.8%;" src="/local/templates/diez-ekb/assets/images/decor/circle-2.svg" alt="">-->
<!--                <img style="--top: 26%; --left: 7%;" src="/local/templates/diez-ekb/assets/images/decor/triangle-1.svg" alt="">-->
<!--            </div>-->
<!--        </section>-->
<!---->
<!--        <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-45">-->
<!--            <div class="container">-->
<!--                <div class="blockAttractionsDirections">-->
<!--                    <h2 class="title">-->
<!--                        туристические объекты-->
<!--                    </h2>-->
<!--                    <div class="slider slider--visible" data-slider="attractions">-->
<!--                        <div class="swiper">-->
<!--                            <div class="swiper-wrapper">-->
<!--                                <a href="#" class="swiper-slide article-news article-news--attraction article-news--direction article-news--green">-->
<!--                                    <div class="picture-wrapper">-->
<!--                                <span class="article-news__badges">-->
<!--                                    <span class="badge">топ!</span>-->
<!--                                </span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="picture-wrapper__more">-->
<!--                                            подробнее-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                            </svg>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            Музейный комплекс УГМК-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                                <a href="#" class="swiper-slide article-news article-news--attraction article-news--direction article-news--blue">-->
<!--                                    <div class="picture-wrapper">-->
<!--                                <span class="article-news__badges">-->
<!--                                    <span class="badge">топ!</span>-->
<!--                                </span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="picture-wrapper__more">-->
<!--                                            подробнее-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                            </svg>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            Музейный комплекс УГМК-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                                <a href="#" class="swiper-slide article-news article-news--attraction article-news--direction article-news--purple">-->
<!--                                    <div class="picture-wrapper">-->
<!--                                <span class="article-news__badges">-->
<!--                                    <span class="badge">топ!</span>-->
<!--                                </span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="picture-wrapper__more">-->
<!--                                            подробнее-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                            </svg>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            Музейный комплекс УГМК-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                                <a href="#" class="swiper-slide article-news article-news--attraction article-news--direction article-news--yellow">-->
<!--                                    <div class="picture-wrapper">-->
<!--                                <span class="article-news__badges">-->
<!--                                    <span class="badge">топ!</span>-->
<!--                                </span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="picture-wrapper__more">-->
<!--                                            подробнее-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                            </svg>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            Музейный комплекс УГМК-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                                <a href="#" class="swiper-slide article-news article-news--attraction article-news--direction article-news--orange">-->
<!--                                    <div class="picture-wrapper">-->
<!--                                <span class="article-news__badges">-->
<!--                                    <span class="badge">топ!</span>-->
<!--                                </span>-->
<!--                                        <picture class="article-news__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-15.jpg" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="picture-wrapper__more">-->
<!--                                            подробнее-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                            </svg>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="article-news__info">-->
<!--                                        <h2 class="article-news__title">-->
<!--                                            Музейный комплекс УГМК-->
<!--                                        </h2>-->
<!--                                        <p class="article-news__place">-->
<!--                                            <svg>-->
<!--                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>-->
<!--                                            </svg>-->
<!--                                            <span>г. Верхняя Пышма, ул Александра Козицына, 2А</span>-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="swiper-control noselect">-->
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
<!--                    <svg class="mob-hidden blockAttractionsDirections__decor">-->
<!--                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-attractions"></use>-->
<!--                    </svg>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
<!---->
<!--        <section class="blockGuides section section--gradient pt-130 ptm-70 pb-130 pbm-100">-->
<!--            <div class="container">-->
<!--                <div class="flex flex-mob-col flex-ai-center gap-c-40 gap-r-20 mb-160 mbm-40">-->
<!--                    <h2 class="title flex-5">-->
<!--                        Ваш гид по Екатеринбургу-->
<!--                    </h2>-->
<!--                    <div class="text flex-7">-->
<!--                        Каждый уголок Екатеринбурга скрывает свою уникальную историю.<br>-->
<!--                        Наши экскурсоводы помогут вам увидеть все самые интересные места города.<br>-->
<!--                        Выберите экскурсовода, чтобы узнать подробности о туре и контакты для записи.-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="grid gap-c-85 gap-r-30">-->
<!--                    <article class="article-guide grid__item--4 grid__item-mob--4">-->
<!--                        <picture>-->
<!--                            <img src="/local/templates/diez-ekb/assets/images/guide-1.png" alt="">-->
<!--                        </picture>-->
<!--                        <p>-->
<!--                            “Покажу Уралмаш!”-->
<!--                        </p>-->
<!--                    </article>-->
<!--                    <article class="article-guide grid__item--4 grid__item-mob--4">-->
<!--                        <picture>-->
<!--                            <img src="/local/templates/diez-ekb/assets/images/guide-2.png" alt="">-->
<!--                        </picture>-->
<!--                        <p>-->
<!--                            “Я расскажу вам всё о метро Екатеринбурга!”-->
<!--                        </p>-->
<!--                    </article>-->
<!--                    <article class="article-guide grid__item--4 grid__item-mob--4">-->
<!--                        <picture>-->
<!--                            <img src="/local/templates/diez-ekb/assets/images/guide-3.png" alt="">-->
<!--                        </picture>-->
<!--                        <p>-->
<!--                            “Раскрою тайны центра города!”-->
<!--                        </p>-->
<!--                    </article>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="blockGuides__decor">-->
<!--                <svg class="blockGuides__decor__lines">-->
<!--                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-lines"></use>-->
<!--                </svg>-->
<!--                <svg class="blockGuides__decor__ekb">-->
<!--                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-ekb"></use>-->
<!--                </svg>-->
<!--            </div>-->
<!--        </section>-->
<!---->
<!--        <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-100">-->
<!--            <div class="container">-->
<!--                <div class="blockTopRoutes">-->
<!--                    <h2 class="title">-->
<!--                        <span>топ</span> маршрутов-->
<!--                    </h2>-->
<!---->
<!--                    <div class="slider slider--auto slider--visible" data-slider="pickYourRoute">-->
<!--                        <div class="text">-->
<!--                            Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света, соединивший в себе Европу и Азию. Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света, соединивший в себе Европу и Азию.-->
<!--                        </div>-->
<!--                        <div class="blockTopRoutes__bg mob-hidden"></div>-->
<!--                        <div class="blockTopRoutes__swiper-wrapper">-->
<!--                            <div class="swiper">-->
<!--                                <div class="swiper-wrapper">-->
<!--                                    <article class="swiper-slide article-intro-card article-intro-card--green">-->
<!--                                        <div class="article-intro-card__tags">-->
<!--                                            <a href="#" class="article-intro-card__tag">Музеи</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Театры</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Кинотеатры</a>-->
<!--                                        </div>-->
<!--                                        <picture class="article-intro-card__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-intro-card__info">-->
<!--                                            <h2 class="article-intro-card__title">-->
<!--                                                Культурно-познавательный туризм-->
<!--                                            </h2>-->
<!--                                            <a href="#" class="article-intro-card__link">-->
<!--                                                <span>Узнать подробности</span>-->
<!--                                                <svg class="article-intro-card__icon">-->
<!--                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                                </svg>-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                    </article>-->
<!--                                    <article class="swiper-slide article-intro-card article-intro-card--orange">-->
<!--                                        <div class="article-intro-card__tags">-->
<!--                                            <a href="#" class="article-intro-card__tag">Музеи</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Театры</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Кинотеатры</a>-->
<!--                                        </div>-->
<!--                                        <picture class="article-intro-card__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-intro-card__info">-->
<!--                                            <h2 class="article-intro-card__title">-->
<!--                                                Культурно-познавательный туризм-->
<!--                                            </h2>-->
<!--                                            <a href="#" class="article-intro-card__link">-->
<!--                                                <span>Узнать подробности</span>-->
<!--                                                <svg class="article-intro-card__icon">-->
<!--                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                                </svg>-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                    </article>-->
<!--                                    <article class="swiper-slide article-intro-card article-intro-card--purple">-->
<!--                                        <div class="article-intro-card__tags">-->
<!--                                            <a href="#" class="article-intro-card__tag">Музеи</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Театры</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Кинотеатры</a>-->
<!--                                        </div>-->
<!--                                        <picture class="article-intro-card__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-intro-card__info">-->
<!--                                            <h2 class="article-intro-card__title">-->
<!--                                                Культурно-познавательный туризм-->
<!--                                            </h2>-->
<!--                                            <a href="#" class="article-intro-card__link">-->
<!--                                                <span>Узнать подробности</span>-->
<!--                                                <svg class="article-intro-card__icon">-->
<!--                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                                </svg>-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                    </article>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="swiper-control noselect">-->
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
<!--            <svg class="blockTopRoutes__decor">-->
<!--                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-waves"></use>-->
<!--            </svg>-->
<!--        </section>-->
<!---->
<!--        <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-100">-->
<!--            <div class="container">-->
<!--                <div class="blockTopRoutes blockTopRoutes--forSelf">-->
<!--                    <h2 class="title">-->
<!--                        топ маршрутов для самостоятельных туристов-->
<!--                    </h2>-->
<!---->
<!--                    <div class="slider slider--auto slider--visible" data-slider="pickYourRoute">-->
<!--                        <div class="text">-->
<!--                            Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света, соединивший в себе Европу и Азию. Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света, соединивший в себе Европу и Азию.-->
<!--                        </div>-->
<!--                        <div class="blockTopRoutes__bg mob-hidden"></div>-->
<!--                        <div class="blockTopRoutes__swiper-wrapper">-->
<!--                            <div class="swiper">-->
<!--                                <div class="swiper-wrapper">-->
<!--                                    <article class="swiper-slide article-intro-card article-intro-card--green">-->
<!--                                        <div class="article-intro-card__tags">-->
<!--                                            <a href="#" class="article-intro-card__tag">Музеи</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Театры</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Кинотеатры</a>-->
<!--                                        </div>-->
<!--                                        <picture class="article-intro-card__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-intro-card__info">-->
<!--                                            <h2 class="article-intro-card__title">-->
<!--                                                Культурно-познавательный туризм-->
<!--                                            </h2>-->
<!--                                            <a href="#" class="article-intro-card__link">-->
<!--                                                <span>Узнать подробности</span>-->
<!--                                                <svg class="article-intro-card__icon">-->
<!--                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                                </svg>-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                    </article>-->
<!--                                    <article class="swiper-slide article-intro-card article-intro-card--orange">-->
<!--                                        <div class="article-intro-card__tags">-->
<!--                                            <a href="#" class="article-intro-card__tag">Музеи</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Театры</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Кинотеатры</a>-->
<!--                                        </div>-->
<!--                                        <picture class="article-intro-card__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-intro-card__info">-->
<!--                                            <h2 class="article-intro-card__title">-->
<!--                                                Культурно-познавательный туризм-->
<!--                                            </h2>-->
<!--                                            <a href="#" class="article-intro-card__link">-->
<!--                                                <span>Узнать подробности</span>-->
<!--                                                <svg class="article-intro-card__icon">-->
<!--                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                                </svg>-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                    </article>-->
<!--                                    <article class="swiper-slide article-intro-card article-intro-card--purple">-->
<!--                                        <div class="article-intro-card__tags">-->
<!--                                            <a href="#" class="article-intro-card__tag">Музеи</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Театры</a>-->
<!--                                            <a href="#" class="article-intro-card__tag">Кинотеатры</a>-->
<!--                                        </div>-->
<!--                                        <picture class="article-intro-card__picture">-->
<!--                                            <img src="/local/templates/diez-ekb/assets/images/pic-1.png" alt="">-->
<!--                                        </picture>-->
<!--                                        <div class="article-intro-card__info">-->
<!--                                            <h2 class="article-intro-card__title">-->
<!--                                                Культурно-познавательный туризм-->
<!--                                            </h2>-->
<!--                                            <a href="#" class="article-intro-card__link">-->
<!--                                                <span>Узнать подробности</span>-->
<!--                                                <svg class="article-intro-card__icon">-->
<!--                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>-->
<!--                                                </svg>-->
<!--                                            </a>-->
<!--                                        </div>-->
<!--                                    </article>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="swiper-control noselect">-->
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
<!--            <svg class="blockTopRoutes--forSelf__decor">-->
<!--                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-lines"></use>-->
<!--            </svg>-->
<!--        </section>-->
<!---->
<!--    </main>-->

<?php }?>

<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Волонтеры 300-летия");
?>

    <section class="section section--bg relative invert"
             style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/bg-single-special.jpg')">
        <div class="section__content section__content--overlay-30 section__content--flex section__content--full-650 pt-100 ptm-80 pb-120 pbm-40">
            <div class="container container--flex-between">
                <div class="mb-50 mbm-30">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:breadcrumb",
                        "breadcrumbs",
                        array(
                            "START_FROM" => "0",
                            "PATH" => "",
                            "SITE_ID" => "s1"
                        )
                    ); ?>
                </div>
                <div class="columns">
                    <div class="columns__col columns__col--8">
                        <h2 class="title mb-30 mbm-20">
                            Волонтёры 300-летия
                        </h2>
                        <div class="editor editor--24 mb-40 mbm-30">
                            <p>
                                К юбилею Екатеринбурга будет подготовлена профессиональная команда волонтёров.
                            </p>
                        </div>
                        <a class="button button--orange button--230" href="">
                                    <span class="button__text">
                                        Стать волонтером
                                    </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section bg-white pt-100 pb-100 ptm-40 pbm-40">
        <div class="container">
            <span class="tag mb-20">Узнавай</span>
            <h2 class="title mb-75 mbm-20">
                Кто такие <br>
                <strong class="purple">волонтеры 300-летия?</strong>
            </h2>
            <div class="columns columns--align">
                <div class="columns__col columns__col--5 mbm-180">
                    <div class="editor editor--24">
                        <p>
                            Волонтеры 300-летия — добровольческое движение, которое позволит горожанам стать
                            непосредственными участниками и соорганизаторами знаменательного события. Именно волонтёры
                            являются душой любого крупного события и помогают накомиться с городом его гостям.
                        </p>
                    </div>
                </div>
                <div class="columns__col columns__col--1 mob-hidden"></div>
                <div class="columns__col columns__col--6">
                    <div class="editor decor-3">
                        <picture>
                            <img alt="" src="<?= SITE_TEMPLATE_PATH ?>/assets/content/volonteers.jpg">
                        </picture>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section bg-grey pt-120 pb-145 ptm-40 pbm-40">
        <div class="container">
            <span class="tag mb-20">Действуй</span>
            <div class="columns mbm-40">
                <div class="columns__col columns__col--5">
                    <h2 class="title mb-45 mbm-30">
                        Как стать <strong class="purple">волонтёром?</strong>
                    </h2>
                    <a class="button button--orange button--230 mob-hidden" href="">
                                <span class="button__text">
                                    оставить заявку
                                </span>
                    </a>
                </div>
                <div class="columns__col columns__col--1 mob-hidden"></div>
                <div class="columns__col columns__col--6">
                    <div class="columns">
                        <div class="columns__col columns__col--6 mbm-35">
                            <article class="article-step">
                                <svg class="article-step__number">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-1"></use>
                                </svg>
                                <div class="article-step__main">
                                    <svg class="article-step__icon">
                                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-step-1"></use>
                                    </svg>
                                    <p class="article-step__text">
                                        Оставить заявку<br> на сайте
                                    </p>
                                </div>
                            </article>
                        </div>
                        <div class="columns__col columns__col--6 mbm-35">
                            <article class="article-step">
                                <svg class="article-step__number">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-2"></use>
                                </svg>
                                <div class="article-step__main">
                                    <svg class="article-step__icon">
                                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-step-2"></use>
                                    </svg>
                                    <p class="article-step__text">
                                        Заполнить<br> анкету
                                    </p>
                                </div>
                            </article>
                        </div>
                        <div class="columns__col columns__col--6 mbm-35">
                            <article class="article-step">
                                <svg class="article-step__number">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-3"></use>
                                </svg>
                                <div class="article-step__main">
                                    <svg class="article-step__icon">
                                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-step-3"></use>
                                    </svg>
                                    <p class="article-step__text">
                                        Дождаться<br> письма на email
                                    </p>
                                </div>
                            </article>
                        </div>
                        <div class="columns__col columns__col--6">
                            <article class="article-step">
                                <svg class="article-step__number">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-4"></use>
                                </svg>
                                <div class="article-step__main">
                                    <svg class="article-step__icon">
                                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-step-4"></use>
                                    </svg>
                                    <p class="article-step__text">
                                        Пройти <br>
                                        подготовку
                                    </p>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
            <div class="desktop-hidden">
                <a class="button button--orange button--230" href="">
                            <span class="button__text">
                                оставить заявку
                            </span>
                </a>
            </div>
        </div>
    </section>
    <section class="section bg-light pt-100 pb-100 ptm-40 pbm-30">
        <div class="container">
            <span class="tag mb-20">Читай</span>
            <div class="slider mbm-30" data-slider data-slider-quantity="3">
                <div class="toolbar toolbar--mob-block mb-50">
                    <h2 class="title">
                        новости <strong class="green">волонтеров</strong>
                    </h2>
                    <a class="button button--green button--fit-m mob-hidden" href="/news/">
                                <span class="button__text">
                                    Все новости
                                </span>
                        <svg class="button__icon">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-arrow-next-green"></use>
                        </svg>
                    </a>
                    <div class="toolbar__section mob-hidden">
                        <button class="button-scroll button-scroll--green disabled" data-slider-prev>
                            <svg class="button-scroll__icon">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-slider-prev"></use>
                            </svg>
                        </button>
                        <button class="button-scroll button-scroll--green" data-slider-next>
                            <svg class="button-scroll__icon">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-slider-next"></use>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="swiper-container slider__container slider__container--overflow slider__container--all">
                    <div class="swiper-wrapper slider__wrapper">
                        <div class="swiper-slide slider__slide slider__slide--mob-290">
                            <a class="article-post article-post--slide article-post--regular" href="">
                                <picture class="article-post__picture">
                                    <img alt="" src="<?= SITE_TEMPLATE_PATH ?>/assets/content/post-1.jpg">
                                </picture>
                                <div class="article-post__content">
                                    <div class="article-post__header">
                                                <span class="article-post__tag">
                                                    Выставка
                                                </span>
                                        <time class="article-post__date">
                                            12.02.22
                                        </time>
                                    </div>
                                    <div class="article-post__main">
                                        <h3 class="article-post__title">
                                            300-летие Екатеринбурга станет темой ледового городка
                                        </h3>
                                    </div>
                                    <div class="article-post__footer">
                                                <span class="article-post__link">
                                                    Подробнее
                                                </span>
                                        <svg class="article-post__icon">
                                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-arrow-next"></use>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide slider__slide slider__slide--mob-290">
                            <a class="article-post article-post--invert article-post--slide article-post--regular"
                               href="">
                                <div class="article-post__content">
                                    <div class="article-post__header">
                                        <span class="article-post__tag">
                                            Выставка
                                        </span>
                                        <time class="article-post__date">
                                            12.02.22
                                        </time>
                                    </div>
                                    <div class="article-post__main">
                                        <h3 class="article-post__title">
                                            На Макаровском мосту успешно прошел первый этап пусконаладочных работ новой
                                            системы
                                            иллюминации
                                        </h3>
                                        <div class="article-post__description">
                                            <p>
                                                На опорах уличного освещения установлены 30 световых конструкций.Новая
                                                иллюминация, расположенная на опорах освещения Макаровского моста, была
                                                запущена
                                                накануне в тестовом режиме.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="article-post__footer">
                                                <span class="article-post__link">
                                                    Подробнее
                                                </span>
                                        <svg class="article-post__icon">
                                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-arrow-next"></use>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide slider__slide slider__slide--mob-290">
                            <a class="article-post article-post--regular article-post--slide" href="">
                                <picture class="article-post__picture">
                                    <img alt="" src="<?= SITE_TEMPLATE_PATH ?>/assets/content/post-2.jpg">
                                </picture>
                                <div class="article-post__content">
                                    <div class="article-post__header">
                                        <span class="article-post__tag">
                                            Выставка
                                        </span>
                                        <time class="article-post__date">
                                            12.02.22
                                        </time>
                                    </div>
                                    <div class="article-post__main">
                                        <h3 class="article-post__title">
                                            Проекты Дня города будут не только развлекать, но и просвещать
                                        </h3>
                                    </div>
                                    <div class="article-post__footer">
                                                <span class="article-post__link">
                                                    Подробнее
                                                </span>
                                        <svg class="article-post__icon">
                                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-arrow-next"></use>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide slider__slide slider__slide--mob-290">
                            <a class="article-post article-post--regular article-post--slide" href="">
                                <picture class="article-post__picture">
                                    <img alt="" src="<?= SITE_TEMPLATE_PATH ?>/assets/content/post-3.jpg">
                                </picture>
                                <div class="article-post__content">
                                    <div class="article-post__header">
                                                <span class="article-post__tag">
                                                    Выставка
                                                </span>
                                        <time class="article-post__date">
                                            12.02.22
                                        </time>
                                    </div>
                                    <div class="article-post__main">
                                        <h3 class="article-post__title">
                                            Запуск ретропоезда «Уральский экспресс»
                                        </h3>
                                    </div>
                                    <div class="article-post__footer">
                                                <span class="article-post__link">
                                                    Подробнее
                                                </span>
                                        <svg class="article-post__icon">
                                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-arrow-next"></use>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="desktop-hidden">
                <a class="button button--green button--fit-m" href="/news/">
                            <span class="button__text">
                                Все новости
                            </span>
                    <svg class="button__icon">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-arrow-next-green"></use>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <section class="section invert bg-grey pt-100 pb-100 ptm-0 pbm-0">
        <div class="container">
            <div class="block-accent invert">
                <div class="block-accent__content">
                    <div class="columns columns--align">
                        <div class="columns__col columns__col--5 mbm-30">
                            <h2 class="title title--small">
                                Контакты <br>
                                волонтерского центра
                            </h2>
                        </div>
                        <div class="columns__col columns__col--3 mbm-25">
                            <a href="tel:+70001234567" class="link-contact">
                                <svg class="link-contact__icon">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-call"></use>
                                </svg>
                                <span class="link-contact__text">
                                            +7 (000) 123 - 45 -67
                                        </span>
                            </a>
                        </div>
                        <div class="columns__col columns__col--3">
                            <a href="mailto:name_email@email.net" class="link-contact">
                                <svg class="link-contact__icon">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-mail"></use>
                                </svg>
                                <span class="link-contact__text">
                                            name_email@email.net
                                        </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
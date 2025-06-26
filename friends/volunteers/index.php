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
                        <a class="button button--orange button--230" href="#volonteer">
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
                            Волонтеры 300-летия — добровольческое движение, которое позволит горожанам стать непосредственными участниками и соорганизаторами знаменательного события. Именно волонтёры являются душой любого крупного события и помогают знакомиться с городом его гостям. Работу с волонтёрами ведёт Управление молодёжной политики Администрации города Екатеринбурга.
                        </p>
                    </div>
                </div>
                <div class="columns__col columns__col--1 mob-hidden"></div>
                <div class="columns__col columns__col--6">
                    <div class="editor decor-3">
                        <picture>
                            <img alt="" src="<?= SITE_TEMPLATE_PATH ?>/assets/content/volonter.jpeg">
                        </picture>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section class="section bg-grey pt-120 pb-145 ptm-40 pbm-40" id="volonteer">
        <div class="container">
            <span class="tag mb-20">Действуй</span>
            <div class="columns mbm-40">
                <div class="columns__col columns__col--5">
                    <h2 class="title mb-45 mbm-30">
                        Как стать <strong class="purple">волонтёром?</strong>
                    </h2>
                    <a class="button button--orange button--230 mob-hidden button-form" data-fancybox="form-volonteers" href="#form-volonteers">
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
                                        Нажать на <br> Оставить заявку
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
                        <div class="columns__col columns__col--6">
                            <article class="article-step">
                                <svg class="article-step__number">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-3"></use>
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
                        <div class="columns__col columns__col--6 mbm-35">
                            <article class="article-step">
                                <svg class="article-step__number">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-4"></use>
                                </svg>
                                <div class="article-step__main">
                                    <svg class="article-step__icon">
                                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-step-3"></use>
                                    </svg>
                                    <p class="article-step__text">
                                        Стать частью<br> команды
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
<?$APPLICATION->IncludeComponent(
	"bitrix:form",
	"volunteers",
	Array(
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_ADDITIONAL" => "N",
		"EDIT_STATUS" => "Y",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"NAME_TEMPLATE" => "",
		"NOT_SHOW_FILTER" => array("",""),
		"NOT_SHOW_TABLE" => array("",""),
		"RESULT_ID" => $_REQUEST["RESULT_ID"],
		"SEF_MODE" => "N",
		"SHOW_ADDITIONAL" => "N",
		"SHOW_ANSWER_VALUE" => "N",
		"SHOW_EDIT_PAGE" => "N",
		"SHOW_LIST_PAGE" => "N",
		"SHOW_STATUS" => "N",
		"SHOW_VIEW_PAGE" => "N",
		"START_PAGE" => "new",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"VARIABLE_ALIASES" => Array("action"=>"action"),
		"WEB_FORM_ID" => "3"
	)
);?>
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
	 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"volunteers.list",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
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
		"COMPONENT_TEMPLATE" => "volunteers.list",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "News",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "300 историй Екатеринбурга, изменивших мир",
		"PARENT_SECTION" => "81",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"DATE",1=>"PRICE",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "PROPERTY_DATE_START",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?>
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
					+7 (343) 304-30-92
                                        </span>
                            </a>
                        </div>
                        <div class="columns__col columns__col--3">
                            <a href="mailto:name_email@email.net" class="link-contact">
                                <svg class="link-contact__icon">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-mail"></use>
                                </svg>
                                <span class="link-contact__text">
					molodezh@ekadm.ru
                                        </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
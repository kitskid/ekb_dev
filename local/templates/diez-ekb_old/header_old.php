<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use Bitrix\Main\Page\Asset;

?>
<!doctype html>
<html lang="<?= LANGUAGE_ID ?>">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible"
	      content="IE=edge">
	<meta name="viewport"
	      content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<meta name="msapplication-TileColor"
	      content="#da532c">
	<meta name="theme-color"
	      content="#ffffff">
	<?
	$asset = Asset::getInstance();
	$asset->addString("<link rel='mask-icon' href='" . SITE_TEMPLATE_PATH . "/assets/favicon/safari-pinned-tab.svg' color='#5bbad5'>");
	$asset->addString("<link rel='apple-touch-icon' sizes='120x120' href='" . SITE_TEMPLATE_PATH . "/assets/favicon/apple-touch-icon.png'>");
	$asset->addString("<link rel='icon' type='image/png' sizes='32x32' href='" . SITE_TEMPLATE_PATH . "/assets/favicon/favicon-32x32.png'>");
	$asset->addString("<link rel='icon' type='image/png' sizes='16x16' href='" . SITE_TEMPLATE_PATH . "/assets/favicon/favicon-16x16.png'>");
	$asset->addString("<link rel='manifest' href='" . SITE_TEMPLATE_PATH . "/assets/favicon/site.webmanifest'>");
	$asset->addString("<link rel='preconnect' href='https://fonts.googleapis.com'>");
	$asset->addString("<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>");
	$asset->addString("<link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap' rel='stylesheet'>");
//	$asset->addString('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=8402b9af-0b52-4248-8d3b-f584799c1c74" type="text/javascript"></script>');
    $asset->addString('<script src="https://api-maps.yandex.ru/2.1/?apikey=eadd6c34-2108-42a5-9a53-b9afc638fadb&lang=ru_RU"></script>');
	$asset->addCss(SITE_TEMPLATE_PATH . "/css/main.css");
    $asset->addCss(SITE_TEMPLATE_PATH . "/css/restaurants.css");
	$asset->addJs(SITE_TEMPLATE_PATH . "/js/bundle.js");
	$APPLICATION->ShowCSS();
	$APPLICATION->ShowHeadStrings();
	$APPLICATION->ShowHeadScripts();
	$APPLICATION->ShowMeta("robots");
	$APPLICATION->ShowMeta("description");
	?>
	<title>
		<? $APPLICATION->ShowTitle(); ?>
	</title>
    <!-- Подключаем Яндекс.Карты API -->
<!--    <script src="https://api-maps.yandex.ru/2.1/?apikey=eadd6c34-2108-42a5-9a53-b9afc638fadb&lang=ru_RU"></script>-->

	<!-- Yandex.Metrika counter -->
	<script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(92181505, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
	</script>
	<!-- /Yandex.Metrika counter -->
	<meta name="google-site-verification"
	      content="eTbaPQCwuhNNubYoBukrO6Gg5tneLCjRqJ9SPFmczeA" />

    <?$APPLICATION->ShowPanel();?>
</head>
<noscript>
	<div>
		<img src="https://mc.yandex.ru/watch/92181505"
		     style="position:absolute; left:-9999px;"
		     alt="" />
	</div>
</noscript>
<body class="body">
	<header class="header z-index-5">
		<section class="section section--header pt-10 pb-10 z-index-3">
			<div class="container">
				<div class="toolbar toolbar--27">
					<!-- На главной странице сайта тег <a> заменяем на тег <picture> и удаляем href -->
					<? if ($APPLICATION->GetCurPage(false) === '/') { ?>
						<div class="logo logo--sm">
							<? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"",
								[
									"AREA_FILE_SHOW" => "file",
									"EDIT_TEMPLATE"  => "",
									"PATH"           => "/include/header/header_logo.php"
								]
							);
							?>
						</div>
					<? } else { ?>
						<a href="/"
						   class="logo logo--sm">
							<? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"",
								[
									"AREA_FILE_SHOW" => "file",
									"EDIT_TEMPLATE"  => "",
									"PATH"           => "/include/header/header_logo.php"
								]
							);
							?>
						</a>
					<? } ?>
					<? $APPLICATION->IncludeComponent(
						"bitrix:menu",
						"menu.header.main",
						[
							"ALLOW_MULTI_SELECT"    => "N",
							"CHILD_MENU_TYPE"       => "left",
							"DELAY"                 => "N",
							"MAX_LEVEL"             => "4",
							"MENU_CACHE_GET_VARS"   => [],
							"MENU_CACHE_TIME"       => "3600",
							"MENU_CACHE_TYPE"       => "Y",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"ROOT_MENU_TYPE"        => "top",
							"COMPONENT_TEMPLATE"    => "menu.header.main",
							"USE_EXT"               => "Y"
						],
						false
					); ?>
					<div class="nav">
						<a href="/search/"
						   class="nav__button">
							<svg>
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-glass"></use>
							</svg>
						</a>
						<button class="nav__button mob-hidden"
						        data-link-vipanel>
							<svg>
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-eye"></use>
							</svg>
						</button>
						<button class="nav__button desktop-hidden"
						        data-menu-button>
							<svg class="closed">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-burger"></use>
							</svg>
							<svg class="opened">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-close"></use>
							</svg>
						</button>
					</div>
				</div>
			</div>
		</section>
		<? $APPLICATION->IncludeComponent(
			"bitrix:menu",
			"menu.header.dropdown.main",
			[
				"ALLOW_MULTI_SELECT"    => "N",
				"CHILD_MENU_TYPE"       => "left",
				"DELAY"                 => "N",
				"MAX_LEVEL"             => "4",
				"MENU_CACHE_GET_VARS"   => [],
				"MENU_CACHE_TIME"       => "3600",
				"MENU_CACHE_TYPE"       => "Y",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"ROOT_MENU_TYPE"        => "top",
				"COMPONENT_TEMPLATE"    => "menu.header.dropdown.main",
				"USE_EXT"               => "Y"
			],
			false
		); ?>
	</header>
	<div class="page">
		<main class="main">
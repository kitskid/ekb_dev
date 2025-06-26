<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Партнёры 300-летия");
?>

	<section class="section section--partners section--bg relative invert section--green"
	         style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/partners-bg.png')">
		<div class="section__content section__content--flex section__content--550 pt-100 ptm-80 pb-120 pbm-40">
			<div class="container">
				<div class="mb-110 mbm-30">
					<? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumbs", [
						"START_FROM" => "0",
						"PATH"       => "",
						"SITE_ID"    => "s1"
					]); ?>
				</div>
				<div class="columns">
					<div class="columns__col columns__col--12">
						<h2 class="title center mb-30 mbm-20">
							партнеры 300-летия
						</h2>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section pt-30 pb-100">
		<div class="container">
			<div class="partners">
				<div class="partners__item">
					<div class="partners__header">
						<span class="tag">Генеральный партнер</span>
					</div>
					<div class="partners__gallery">
						<a href="https://святаяекатерина.рф/"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-1.png"
								     alt="">
							</picture>
						</a>
					</div>
				</div>
				<div class="partners__item">
					<div class="partners__header">
						<span class="tag">Технологический партнер</span>
					</div>
					<div class="partners__gallery">
						<a href="http://www.sberbank.ru/ru/person"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-11.svg"
								     alt="">
							</picture>
						</a>
					</div>
				</div>
				<div class="partners__item">
					<div class="partners__header">
						<span class="tag">Генеральный информационный партнер</span>
					</div>
					<div class="partners__gallery">
						<a href="https://www.e1.ru/"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-2.png"
								     alt="">
							</picture>
						</a>
					</div>
				</div>
				<div class="partners__item">
					<div class="partners__header">
						<span class="tag">Официальные партнёры</span>
					</div>
					<div class="partners__gallery">
						<a href="https://www.vtb.ru/personal/karty/debetovye/multikarta/"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-3.png"
								     alt="">
							</picture>
						</a>
						<a href="https://stk-13.ru/"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-4.png"
								     alt="">
							</picture>
						</a>
					</div>
				</div>
				<div class="partners__item">
					<div class="partners__header">
						<span class="tag">Партнер программы</span>
					</div>
					<div class="partners__gallery">
						<a href="https://akademicheskiy.org/"
						   target="_blank">
							<picture class="partners__picture partners__picture--long">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-10.png"
								     alt="">
							</picture>
						</a>
					</div>
				</div>
				<div class="partners__item">
					<div class="partners__header">
						<span class="tag">Специальные партнеры</span>
					</div>
					<div class="partners__gallery">
						<a href="https://magnit.ru/"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-5.png"
								     alt="">
							</picture>
						</a>
						<a href="https://galamart.ru/"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-8.png"
								     alt="">
							</picture>
						</a>
						<a href="https://samokat.ru/"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-7.png"
								     alt="">
							</picture>
						</a>
						<a href="https://www.rusagromaslo.com/sites/EGK/SitePages/home.aspx"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-6.png"
								     alt="">
							</picture>
						</a>
					</div>
				</div>
				<div class="partners__item">
					<div class="partners__header">
						<span class="tag">Навигационный партнёр</span>
					</div>
					<div class="partners__gallery">
						<a href="https://2gis.ru/"
						   target="_blank">
							<picture class="partners__picture">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/partner-9.png"
								     alt="">
							</picture>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");

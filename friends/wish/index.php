<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Шкатулка желаний");
?>
	<section class="section section--bg section--bg-right relative invert"
	         style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/content/wish-index-bg.jpg')"
	>
		<div class="section__content section__content--flex section__content--overlay-30 section__content--full-650 pt-100 ptm-80 pb-120 pbm-40">
			<div class="container container--flex-between">
				<div class="mb-100 mbm-30">
					<?php
					$APPLICATION->IncludeComponent(
						"bitrix:breadcrumb",
						"breadcrumbs",
						[
							"START_FROM" => "0",
							"PATH"       => "",
							"SITE_ID"    => "s1"
						]);
					?>
				</div>
				<div class="columns columns--full">
					<div class="columns__col columns__col--flex columns__col--6 columns__col--mob-6">
						<h1 class="title mb-30 mbm-20">
							Шкатулка желаний
						</h1>
						<div class="editor editor--24 mb-30">
							<?php
							$APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"",
								[
									"AREA_FILE_SHOW" => "file",
									"EDIT_TEMPLATE"  => "",
									"PATH"           => "/include/wish/wish_subtitle.php"
								]
							);
							?>
						</div>
						<a class="button button--mob-auto button--230 button--orange button--fit-m"
						   href="#form-event"
						   data-fancybox="modal-form"
						>
                                    <span class="button__text">
                                        Стать спонсором
                                    </span>
						</a>
					</div>
				</div>
				<div class="mob-hidden"></div>
			</div>
		</div>
	</section>
	<section class="section pt-100 pb-210 pbm-40 ptm-40 pbm-40">
		<div class="container">
			<span class="tag mb-20">поддержи</span>
			<div class="articles"
			     data-articles
			>
				<div class="articles__header mb-60 mbm-35"
				     data-articles-header
				>
					<div class="toolbar toolbar--mob-block mb-50 mbm-0">
						<h2 class="title mb-25 mbm-30">
							проект
							<br>
							<strong class="purple">шкатулка желаний</strong>
						</h2>
					</div>
				</div>
				<div class="articles__content">
					<div class="columns"
					     data-articles-conten
					>
						<div class="columns__col columns__col--6 mbm-20">
							<div class="editor editor--l-32 editor--16">
								<?php
								$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									[
										"AREA_FILE_SHOW" => "file",
										"EDIT_TEMPLATE"  => "",
										"PATH"           => "/include/wish/wish_text.php"
									]
								);
								?>
							</div>
						</div>
						<div class="columns__col columns__col--6">
							<picture class="articles__decor desktop-hidden mbm-40">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/support-project-mob.svg"
								     alt=""
								>
							</picture>
							<div class="articles__gallery">
								<div class="articles__picture articles__picture--main">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/wish-1.png"
									     alt=""
									>
								</div>
								<div class="articles__picture  articles__picture--angle-minus">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/wish-2.png"
									     alt=""
									>
								</div>
								<div class="articles__picture  articles__picture--angle-plus">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/content/wish-3.png"
									     alt=""
									>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section section--bg pt-115 ptm-40 pbm-40 pb-115"
	         style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/wish-bg.jpg')"
	>
		<div class="container">
			<div class="wish">
				<div class="columns">
					<div class="columns__col columns__col--6 mbm-40">
						<div class="wish__about">
							<h2 class="title mb-75 mbm-30">
								узнайте о проекте
								<br>
								<strong class="purple">подробнее</strong>
							</h2>
						</div>
						<a href="/upload/iblock/d80/vghg5wen34wn6tvh31zqmje3gcz6hkcc.pdf"
						   class="wish__presentation"
						>
							<svg class="wish__icon">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-presentation"></use>
							</svg>
							<div class="wish__info">
								<h3 class="wish__title">
									Презентация
									<br>
									проекта
								</h3>
								<p class="wish__subtitle">
									Развитие объектов культуры, спорта, образования и здравоохранения
								</p>
							</div>
							<svg class="wish__icon-arrow">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#arrow-up-right"></use>
							</svg>
						</a>
					</div>
					<div class="columns__col columns__col--1 mob-hidden"></div>
					<div class="columns__col columns__col--5">
						<picture class="wish__picture">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/plan.png"
							     alt=""
							>
						</picture>
					</div>
				</div>
				<picture class="wish__decor">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/levers.png"
					     alt=""
					>
				</picture>
			</div>
		</div>
	</section>
	<section class="section pt-100 ptm-40 pbm-40 pb-100">
		<div class="container">
			<div class="columns mb-40 mbm-20">
				<div class="columns__col columns__col--6">
					<h2 class="title mb-15">
						Стать
						<strong class="purple">спонсором</strong>
					</h2>
				</div>
				<div class="columns__col columns__col--6">
					<figure class="figure max-220 mob-hidden right">
						<picture class="figure__picture">
							<img alt="Декоративная картинка"
							     src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo-decor.png"
							>
						</picture>
					</figure>
				</div>
			</div>
			<form class="form"
			      data-form="<?= SITE_TEMPLATE_PATH ?>/ajax/form.sponsors.ajax.php"
			>
				<div class="form__main">
					<label class="input mb-15"
					       data-input
					>
						<p class="input__caption">
							ФИО контактного лица
						</p>
						<p class="input__message">
							Обязательное поле. Введите ФИО контактного лица
						</p>
						<input class="input__field"
						       placeholder="ФИО контактного лица"
						       type="text"
						       name="USER_FIO"
						       required
						       data-input-field
						>
					</label>
					<label class="input mb-15"
					       data-input
					>
						<p class="input__caption">
							Название организации
						</p>
						<p class="input__message">
							Обязательное поле. Введите название организации
						</p>
						<input class="input__field"
						       placeholder="Название организации"
						       type="text"
						       name="USER_ORGANIZATION"
						       required
						       data-input-field
						>
					</label>
					<label class="input mb-15"
					       data-input
					>
						<p class="input__caption">
							Телефон контактного лица
						</p>
						<p class="input__message">
							Обязательное поле. Введите телефон контактного лица
						</p>
						<input class="input__field"
						       placeholder="Телефон контактного лица"
						       type="text"
						       name="USER_PHONE"
						       required
						       data-input-field
						>
					</label>
					<label class="input mb-15"
					       data-input
					>
						<p class="input__caption">
							E-mail контактного лица
						</p>
						<p class="input__message">
							Обязательное поле. Введите E-mail контактного лица
						</p>
						<input class="input__field"
						       placeholder="E-mail контактного лица"
						       type="text"
						       name="USER_EMAIL"
						       required
						       data-input-field
						>
					</label>
				</div>
				<div class="form__toolbar"
				     data-agreement
				>
					<button class="button button--orange button--230 button--center"
					        data-form-button
					        data-agreement-button
					>
					<span class="button__text"
					      data-form-field
					>
						Отправить
					</span>
					</button>
					<label class="checkbox"
					       data-checkbox
					>
						<input class="checkbox__input"
						       type="checkbox"
						       data-agreement-checkbox
						       data-checkbox-field
						       required
						>
						<div class="checkbox__box">
							<svg class="checkbox__icon">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-check"></use>
							</svg>
						</div>
						<p class="checkbox__caption">
							Нажимая кнопку "Отправить", вы согласшаетесь с
							<a href="/privacy_policy/">Условиями обработки персональных данных</a>
						</p>
					</label>
				</div>
				<!-- После успешной отправки удаляем атрибут hidden -->
				<div class="form__message"
				     data-form-message
				     hidden
				>
					<div class="editor mb-120">
						<h3>
							Заявка отправлена!
						</h3>
						<p>
							Спасибо, что помогаете сделать праздник 300-летия Екатеринбурга еще лучше!
							Мы свяжемся с контактным лицом с ближайшее время
						</p>
					</div>
					<a class="button button--orange button--230 button--center"
					   href="/"
					>
						<span class="button__text">
							На главную
						</span>
					</a>
				</div>
			</form>
		</div>
	</section>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
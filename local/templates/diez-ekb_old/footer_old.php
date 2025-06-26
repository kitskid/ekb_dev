<?
$localPath = SITE_TEMPLATE_PATH;
?>
<footer class="section invert bg-dark pt-60 pb-35">
	<div class="container">
		<div class="columns mb-35 mbm-25">
			<div class="columns__col columns__col--2 columns__col--mob-3 mbm-35">
				<? if ($APPLICATION->GetCurPage (false) === '/') { ?>
					<span class="logo logo--lg">
                        <? $APPLICATION->IncludeComponent (
	                        "bitrix:main.include",
	                        "",
	                        [
		                        "AREA_FILE_SHOW" => "file",
		                        "EDIT_TEMPLATE"  => "",
		                        "PATH"           => "/include/footer/footer_logo.php",
	                        ],
                        ); ?>
                    </span>
				<? } else { ?>
					<a
							class="logo logo--lg"
							href="/"
					>
						<? $APPLICATION->IncludeComponent (
							"bitrix:main.include",
							"",
							[
								"AREA_FILE_SHOW" => "file",
								"EDIT_TEMPLATE"  => "",
								"PATH"           => "/include/footer/footer_logo.php",
							],
						); ?>
					</a>
				<? } ?>
			</div>
			<div class="columns__col columns__col--mob-3 desktop-hidden mbm-35">
				<a
						class="link-footer link-footer--large mb-20"
						href="tel:+79220381940"
				>
					+ 7 (922) 038 19 40
				</a>
				<a
						class="link-footer"
						href="mailto:visitekb@ekadm.ru"
				>
					visitekb@ekadm.ru
				</a>
			</div>
			<? $APPLICATION->IncludeComponent (
				"bitrix:menu",
				"menu.footer.main",
				[
					"ALLOW_MULTI_SELECT"    => "N",
					"CHILD_MENU_TYPE"       => "left",
					"COMPONENT_TEMPLATE"    => "menu.footer.main",
					"DELAY"                 => "N",
					"MAX_LEVEL"             => "2",
					"MENU_CACHE_GET_VARS"   => [],
					"MENU_CACHE_TIME"       => "3600",
					"MENU_CACHE_TYPE"       => "Y",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"ROOT_MENU_TYPE"        => "top",
					"USE_EXT"               => "Y",
				],
			); ?>
		</div>
		<div class="columns columns--align mb-35 mbm-25">
			<div class="columns__col columns__col--4 mob-hidden">
				<a
						class="link-footer link-footer--large mb-20"
						href="tel:+79220381940"
				>
					+ 7 (922) 038 19 40
				</a>
				<a
						class="link-footer"
						href="mailto:visitekb@ekadm.ru"
				>
					visitekb@ekadm.ru
				</a>
			</div>
			<div class="columns__col columns__col--4">
				<hr class="hr desktop-hidden mbm-25">
				<div class="socials mbm-25">
					<p class="socials__title">
						Мы в соц. сетях:
					</p>
					<a
							href="https://t.me/glavaekbofficial"
							class="socials__link"
					>
						<svg class="socials__icon">
							<use xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-telegram"></use>
						</svg>
					</a>
					<a
							href="https://m.vk.com/ekb?from=groups"
							class="socials__link"
					>
						<svg class="socials__icon">
							<use xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-vk"></use>
						</svg>
					</a>

					<a
							href="https://www.youtube.com/@EKBURGru"
							class="socials__link"
					>
						<svg class="socials__icon">
							<use xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-youtube"></use>
						</svg>
					</a>
				</div>
				<hr class="hr desktop-hidden mbm-25">
			</div>
			<div class="columns__col columns__col--4">
				<? $APPLICATION->IncludeComponent (
					"bitrix:search.form",
					"footer.search",
					[
						"PAGE"        => "#SITE_DIR#search/index.php",
						"USE_SUGGEST" => "N",
					],
				); ?>
			</div>
		</div>
		<hr class="hr mb-20">
		<div class="toolbar toolbar--mob-block mb-20">
			<a
					class="logo logo--footer mbm-20"
					href="http://tourism.ekburg.ru/"
					target="_blank"
			>
				<? $APPLICATION->IncludeComponent (
					"bitrix:main.include",
					"",
					[
						"AREA_FILE_SHOW" => "file",
						"EDIT_TEMPLATE"  => "",
						"PATH"           => "/include/footer/footer_portal_logo.php",
					],
				); ?>
				<span>
                    <? $APPLICATION->IncludeComponent (
	                    "bitrix:main.include",
	                    "",
	                    [
		                    "AREA_FILE_SHOW" => "file",
		                    "EDIT_TEMPLATE"  => "",
		                    "PATH"           => "/include/footer/footer_portal_text.php",
	                    ],
                    ); ?>
                </span>
			</a>
			<a
					class="logo logo--footer mbm-20"
					href="https://osmisle-agency.ru/"
					target="_blank"
			>
				<? $APPLICATION->IncludeComponent (
					"bitrix:main.include",
					"",
					[
						"AREA_FILE_SHOW" => "file",
						"EDIT_TEMPLATE"  => "",
						"PATH"           => "/include/footer/footer_developer_logo.php",
					],
				); ?>
				<span>
                    <? $APPLICATION->IncludeComponent (
	                    "bitrix:main.include",
	                    "",
	                    [
		                    "AREA_FILE_SHOW" => "file",
		                    "EDIT_TEMPLATE"  => "",
		                    "PATH"           => "/include/footer/footer_developer_text.php",
	                    ],
                    ); ?>
                </span>
			</a>
			<a
					class="logo logo--footer mbm-20"
					href="http://3qholding.com/"
					target="_blank"
			>
				<? $APPLICATION->IncludeComponent (
					"bitrix:main.include",
					"",
					[
						"AREA_FILE_SHOW" => "file",
						"EDIT_TEMPLATE"  => "",
						"PATH"           => "/include/footer/footer_developer_second_logo.php",
					],
				); ?>
				<span>
                    <? $APPLICATION->IncludeComponent (
	                    "bitrix:main.include",
	                    "",
	                    [
		                    "AREA_FILE_SHOW" => "file",
		                    "EDIT_TEMPLATE"  => "",
		                    "PATH"           => "/include/footer/footer_developer_second_text.php",
	                    ],
                    ); ?>
                </span>
			</a>
			<a
					class="logo logo--footer mbm-20"
					href="http://%D0%B5%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3.%D1%80%D1%84"
					target="_blank"
			>
				<? $APPLICATION->IncludeComponent (
					"bitrix:main.include",
					"",
					[
						"AREA_FILE_SHOW" => "file",
						"EDIT_TEMPLATE"  => "",
						"PATH"           => "/include/footer/footer_official_logo.php",
					],
				); ?>
				<span>
                    <? $APPLICATION->IncludeComponent (
	                    "bitrix:main.include",
	                    "",
	                    [
		                    "AREA_FILE_SHOW" => "file",
		                    "EDIT_TEMPLATE"  => "",
		                    "PATH"           => "/include/footer/footer_official_text.php",
	                    ],
                    ); ?>
                </span>
			</a>
		</div>
		<hr class="hr mb-20">
		<div class="toolbar toolbar--mob-block">
			<div class="editor editor--footer editor--14 mbm-10">
                <span>
                    © Екатеринбург 300, <?= date ('Y') ?>
                </span>
			</div>
			<div class="editor editor--footer editor--14 mbm-10">
				<a href="">Политика конфиндециальности</a>
			</div>
			<div class="grow mob-hidden"></div>
			<div class="editor editor--14 editor--footer">
                <span>
                    Защита&nbsp;от&nbsp;спама reCAPTCHA.
                    <a
		                    href="https://policies.google.com/privacy?hl=ru"
		                    target="_blank"
		                    rel="noreferrer"
                    >
                        Конфиденциальность
                    </a> и&nbsp;
                    <a
		                    href="https://policies.google.com/terms?hl=ru"
		                    target="_blank"
		                    rel="noreferrer"
                    >
                        условия использования
                    </a>
                    .
                </span>
			</div>
		</div>
	</div>
</footer>

<div hidden>
	<section
			class="modal modal--970 fancybox__content"
			id="reg-del"
			style="display: none;"
	>
		<div class="columns mb-40 mbm-20">
			<div class="columns__col columns__col--6">
				<h2 class="title mb-15">
					Регистрация
					<strong class="purple">делегаций</strong>
				</h2>
				<div class="editor">
					<p>
						Данная форма создана для регистрации делегаций, планирующих приезд в Екатеринбург
						<br>
						с целью
						участия в торжественных мероприятиях по случаю 300-летия города.
					</p>
				</div>
			</div>
			<div class="columns__col columns__col--6">
				<figure class="figure max-270 mob-hidden right">
					<picture class="figure__picture">
						<img
								alt="Декоративная картинка"
								src="<?= $localPath ?>/assets/images/logo-decor.png"
						>
					</picture>
				</figure>
			</div>
		</div>
		<form
				class="form"
				data-form="<?= $localPath ?>/ajax/form.about.ajax.php"
		>
			<div
					class="form__wrapper"
					data-form-wrapper
			>
				<div
						class="form__main"
						data-form-main
				>
					<label
							class="input mb-15"
							data-input=""
					>
						<p class="input__caption">
							ФИО
						</p>
						<p class="input__message">
							Обязательное поле. Введите Ваше ФИО
						</p>
						<input
								class="input__field"
								placeholder="Ваше ФИО"
								type="text"
								name="USER_NAME"
								required=""
								data-input-field=""
								tabindex="0"
						>
					</label>
					<label
							class="input mb-15"
							data-input=""
					>
						<p class="input__caption">
							Город
						</p>
						<p class="input__message">
							Обязательное поле. Введите название Вашего города
						</p>
						<input
								class="input__field"
								placeholder="Ваш город"
								type="text"
								name="USER_CITY"
								required=""
								data-input-field=""
								tabindex="0"
						>
					</label>
					<label
							class="input mb-15"
							data-input=""
					>
						<p class="input__caption">
							Должность
						</p>
						<p class="input__message">
							Обязательное поле. Введите Вашу должность
						</p>
						<input
								class="input__field"
								placeholder="Ваша должность"
								type="text"
								name="USER_WORK"
								required=""
								data-input-field=""
								tabindex="0"
						>
					</label>
					<label
							class="input mb-15"
							data-input=""
					>
						<p class="input__caption">
							Контактный телефон
						</p>
						<p class="input__message">
							Обязательное поле. Введите Ваш контактный телефон
						</p>
						<input
								class="input__field"
								placeholder="Контактный телефон"
								type="text"
								name="USER_PHONE"
								required=""
								data-input-field=""
								tabindex="0"
						>
					</label>
					<label
							class="input mb-15"
							data-input=""
					>
						<p class="input__caption">
							Количество дней, которое планируете провести в Екатеринбурге
						</p>
						<p class="input__message">
							Обязательное поле. Введите количество дней
						</p>
						<input
								class="input__field"
								placeholder="Количество дней"
								type="text"
								name="USER_DAYS"
								required=""
								data-input-field=""
								tabindex="0"
						>
					</label>
					<label
							class="input mb-15"
							data-input=""
					>
						<p class="input__caption">
							Дата прибытия в Екатеринбург
						</p>
						<p class="input__message">
							Обязательное поле. Введите Вашу дату прибытия в Екатеринбург
						</p>
						<input
								class="input__field"
								placeholder="Дата прибытия в Екатеринбург"
								type="text"
								name="USER_DATE"
								required=""
								data-input-field=""
								tabindex="0"
						>
					</label>
					<label
							class="input mb-15"
							data-input=""
					>
						<p class="input__caption">
							Номер авиарейса/поезда
						</p>
						<p class="input__message">
							Обязательное поле. Введите Ваш номер авиарейса/поезда
						</p>
						<input
								class="input__field"
								placeholder="Номер авиарейса/поезда"
								type="text"
								name="USER_NUMBER"
								required=""
								data-input-field=""
								tabindex="0"
						>
					</label>
					<label
							class="input mb-15"
							data-input=""
					>
						<p class="input__caption">
							Нужна ли помощь в размещении в гостинице (Да, Нет)
						</p>
						<p class="input__message">
							Обязательное поле. Нужна ли помощь в размещении?
						</p>
						<input
								class="input__field"
								placeholder="Нужна ли помощь в размещении в гостинице?"
								type="text"
								name="USER_HELP"
								required=""
								data-input-field=""
								tabindex="0"
						>
					</label>
					<label
							class="input mb-15"
							data-input=""
					>
						<p class="input__caption">
							Код регистрации
						</p>
						<p class="input__message">
							Обязательное поле. Введите Код регистрации
						</p>
						<input
								class="input__field"
								placeholder="Введите код регистрации"
								type="text"
								name="USER_CODE"
								required=""
								data-input-field=""
								tabindex="0"
						>
					</label>
				</div>
			</div>
			<div class="form__add mb-50">
				<p class="form__text">Добавить участника делегации</p>
				<button
						type="button"
						class="button button--dark-green button--230 button--center"
						data-addmore-button
						tabindex="0"
				>
                <span
		                class="button__text"
		                data-form-field=""
                >
                    Добавить
                </span>
				</button>
			</div>
			<div
					class="form__toolbar"
					data-agreement=""
			>
				<button
						type="submit"
						class="button button--orange button--230 button--center"
						data-form-button=""
						data-agreement-button=""
						tabindex="0"
				>
                <span
		                class="button__text"
		                data-form-field=""
                >
                    Отправить
                </span>
				</button>
				<label
						class="checkbox"
						data-checkbox=""
				>
					<input
							class="checkbox__input"
							type="checkbox"
							data-agreement-checkbox=""
							data-checkbox-field=""
							required=""
							tabindex="0"
					>
					<div class="checkbox__box">
						<svg class="checkbox__icon">
							<use xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-check"></use>
						</svg>
					</div>
					<p class="checkbox__caption">
						Нажимая кнопку "Отправить", вы согласшаетесь с
						<a
								href="/privacy_policy/"
								tabindex="0"
						>Условиями
						 обработки
						 персональных данных
						</a>
					</p>
				</label>
			</div>
			<!-- После успешной отправки удаляем атрибут hidden -->
			<div
					class="form__message"
					data-form-message=""
					hidden=""
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
				<a
						class="button button--orange button--230 button--center"
						href="/"
						data-orig-tabindex="null"
						tabindex="-1"
				>
                <span class="button__text">
                    На главную
                </span>
				</a>
			</div>
		</form>
		<button
				class="carousel__button is-close"
				title="Close"
				tabindex="0"
		>
			<svg
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 24 24"
					tabindex="-1"
			>
				<path d="M20 20L4 4m16 0L4 20"></path>
			</svg>
		</button>
	</section>
	<section
			class="modal modal--970"
			id="form-event"
			style="display: none"
	>
		<div class="columns mb-40 mbm-20">
			<div class="columns__col columns__col--6">
				<h2 class="title mb-15">
					Предложить
					<strong class="purple">событие</strong>
				</h2>
				<div class="editor">
					<p>
						Чтобы ваше событие стало частью программы
						<br>
						Екатеринбург-300, заполните поля
					</p>
				</div>
			</div>
			<div class="columns__col columns__col--6">
				<figure class="figure max-270 mob-hidden right">
					<picture class="figure__picture">
						<img
								alt="Декоративная картинка"
								src="<?= $localPath ?>/assets/images/logo-decor.png"
						>
					</picture>
				</figure>
			</div>
		</div>
		<form
				class="form"
				data-form="<?= $localPath ?>/ajax/form.bill.ajax.php"
		>
			<div class="form__main">
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Название организации
					</p>
					<p class="input__message">
						Обязательное поле. Введите название организации
					</p>
					<input
							class="input__field"
							placeholder="Название организации"
							type="text"
							name="USER_ORGANIZATION"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Сайт
					</p>
					<p class="input__message">
						Обязательное поле. Введите сайт
					</p>
					<input
							class="input__field"
							placeholder="Сайт"
							type="text"
							name="USER_SITE"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Описание мероприятия
					</p>
					<p class="input__message">
						Обязательное поле. Введите описание мероприятия
					</p>
					<input
							class="input__field"
							placeholder="Описание мероприятия"
							type="text"
							name="USER_DESCRIPTION"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						ФИО контактного лица
					</p>
					<p class="input__message">
						Обязательное поле. Введите ФИО контактного лица
					</p>
					<input
							class="input__field"
							placeholder="ФИО контактного лица"
							type="text"
							name="USER_FIO"
							required
							data-input-field
					>
				</label>
				<label
						class="input"
						data-input
				>
					<p class="input__caption">
						Телефон контактного лица
					</p>
					<p class="input__message">
						Обязательное поле. Введите телефон контактного лица
					</p>
					<input
							class="input__field"
							placeholder="Телефон контактного лица"
							type="text"
							name="USER_PHONE"
							required
							data-input-field
					>
				</label>
			</div>
			<div
					class="form__toolbar"
					data-agreement
			>
				<button
						class="button button--orange button--230 button--center"
						data-form-button
						data-agreement-button
				>
                <span
		                class="button__text"
		                data-form-field
                >
                    Отправить
                </span>
				</button>
				<label
						class="checkbox"
						data-checkbox
				>
					<input
							class="checkbox__input"
							type="checkbox"
							data-agreement-checkbox
							data-checkbox-field
							required
					>
					<div class="checkbox__box">
						<svg class="checkbox__icon">
							<use xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-check"></use>
						</svg>
					</div>
					<p class="checkbox__caption">
						Нажимая кнопку "Отправить", вы согласшаетесь с
						<a href="/privacy_policy/">Условиями обработки
						                           персональных данных
						</a>
					</p>
				</label>
			</div>
			<!-- После успешной отправки удаляем атрибут hidden -->
			<div
					class="form__message"
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
				<a
						class="button button--orange button--230 button--center"
						href="/"
				>
                <span class="button__text">
                    На главную
                </span>
				</a>
			</div>
		</form>
	</section>
	<section
			class="modal modal--570"
			id="modal-form"
			style="display: none;"
	>
		<h2 class="title title--small mb-30">
			Отправить свое фото
			<br>
			в раздел
			<strong class="purple">“Горожане”</strong>
		</h2>
		<label class="input mb-20">
			<input
					type="text"
					class="input__field"
					placeholder="Ваше имя"
					required
			>
		</label>
		<label class="input mb-20">
			<input
					type="text"
					class="input__field"
					placeholder="Email"
					required
			>
		</label>
		<label class="input mb-30">
			<select class="input__select">
				<option
						value="Выберите рубрику"
						selected=""
				>Выберите рубрику
				</option>
				<option value="1">ЕКАТЕРИНБУРГ 60-Х</option>
				<option value="2">ЕКАТЕРИНБУРГ В 90-Е</option>
				<option value="3">Я В ИСТОРИЧЕСКОМ СКВЕРЕ</option>
				<option value="4">ЛЮБИМАЯ ДОСТОПРИМЕЧАТЕЛЬНОСТЬ</option>
			</select>
		</label>
		<div
				class="uploader mb-30"
				data-uploader=""
		></div>
		<button class="button button--orange button--fit-m full button--center">
            <span class="button__text">
                Отправить
            </span>
		</button>
	</section>
	<section
			class="modal modal--970"
			id="form-volonteers"
			style="display: none;"
	>
		<div class="columns mb-40 mbm-20">
			<div class="columns__col columns__col--6">
				<h2 class="title mb-15">
					Стать
					<strong class="purple">волонтером</strong>
				</h2>
				<div class="editor">
					<p>
						Чтобы стать волонтером, заполните анкету
					</p>
				</div>
			</div>
			<div class="columns__col columns__col--6">
				<figure class="figure max-270 mob-hidden right">
					<picture class="figure__picture">
						<img
								alt="Декоративная картинка"
								src="<?= $localPath ?>/assets/images/logo-decor.png"
						>
					</picture>
				</figure>
			</div>
		</div>
		<form
				class="form"
				data-form="<?= $localPath ?>/ajax/form.volonteers.ajax.php"
		>
			<div class="form__main">
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Фамилия
					</p>
					<p class="input__message">
						Обязательное поле. Введите свою фамилию
					</p>
					<input
							class="input__field"
							placeholder="Фамилия"
							name="USER_SURNAME"
							type="text"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Имя
					</p>
					<p class="input__message">
						Обязательное поле. Введите свое имя
					</p>
					<input
							class="input__field"
							placeholder="Имя"
							name="USER_NAME"
							type="text"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Отчество
					</p>
					<p class="input__message">
						Обязательное поле. Введите свое отчество
					</p>
					<input
							class="input__field"
							placeholder="Ваше отчество"
							name="USER_SECOND_NAME"
							type="text"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Дата рождения
					</p>
					<p class="input__message">
						Обязательное поле. Введите дату рождения
					</p>
					<input
							class="input__field"
							placeholder="__.__.____"
							name="USER_DATE"
							type="text"
							required
							data-input-field
					>
				</label>
				<div class="input mb-15">
					<p class="input__caption">
						Пол
					</p>
					<div class="input__columns columns">
						<div class="columns__col columns__col--6 columns__col--mob-6 mbm-10">
							<label
									class="checkbox"
									data-checkbox
							>
								<input
										class="checkbox__input"
										type="radio"
										checked
										data-checkbox-field
										name="USER_SEX"
										value="Мужской"
										required
								>
								<div class="checkbox__box">
									<svg class="checkbox__icon">
										<use
												xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-check"
										></use>
									</svg>
								</div>
								<p class="checkbox__caption">
									Мужской
								</p>
							</label>
						</div>
						<div class="columns__col columns__col--6 columns__col--mob-6">
							<label
									class="checkbox"
									data-checkbox
							>
								<input
										class="checkbox__input"
										type="radio"
										data-checkbox-field
										name="USER_SEX"
										value="Женский"
										required
								>
								<div class="checkbox__box">
									<svg class="checkbox__icon">
										<use
												xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-check"
										></use>
									</svg>
								</div>
								<p class="checkbox__caption">
									Женский
								</p>
							</label>
						</div>
					</div>
				</div>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Регион проживания
					</p>
					<p class="input__message">
						Обязательное поле. Введите ваш регион
					</p>
					<input
							class="input__field"
							placeholder="Регион"
							name="USER_REGION"
							type="text"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Населенный пункт
					</p>
					<p class="input__message">
						Обязательное поле. Укажите населенный пункт
					</p>
					<input
							class="input__field"
							placeholder="Название города"
							name="USER_CITY"
							type="text"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Email
					</p>
					<p class="input__message">
						Обязательное поле. Введите email для связи
					</p>
					<input
							class="input__field"
							placeholder="Email"
							type="text"
							name="USER_EMAIL"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Социальные сети
					</p>
					<p class="input__message">
						Обязательное поле. Укажите ссылки
					</p>
					<input
							class="input__field"
							placeholder="Ссылка на профиль"
							type="text"
							name="USER_SOCIAL"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Телефон
					</p>
					<p class="input__message">
						Обязательное поле. Укажите телефон для связи
					</p>
					<input
							class="input__field"
							placeholder="+7-___-___-__-__"
							type="text"
							name="USER_PHONE"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Образование
					</p>
					<p class="input__message">
						Обязательное поле. Укажите образование
					</p>
					<select
							class="input__select"
							name="USER_CAPTION"
							required
							data-input-field
					>
						<option
								value=""
								selected
								disabled
						>Не указано
						</option>
						<option value="Среднее">Среднее</option>
						<option value="Неполное среднее">Неполное среднее</option>
						<option value="Неполное высшее">Неполное высшее</option>
						<option value="Высшее">Высшее</option>
						<option value="Среднеспециальное">Среднеспециальное</option>
						<option value="Неполное среднеспециальное">Неполное среднеспециальное</option>
					</select>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Образовательное учреждение
					</p>
					<p class="input__message">
						Обязательное поле. Укажите название
					</p>
					<input
							class="input__field"
							placeholder="Название"
							type="text"
							name="USER_INSTITUT"
							required
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Ваш возраст старше четырнадцати лет?
					</p>
					<div class="input__columns columns">
						<div class="columns__col columns__col--6 columns__col--mob-6 mbm-10">
							<label
									class="checkbox"
									data-radio
							>
								<input
										class="checkbox__input"
										type="radio"
										checked
										data-radio-field
										name="USER_AGE"
										id="age_yes"
										value="Да"
										required
								>
								<div class="checkbox__box">
									<svg class="checkbox__icon">
										<use
												xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-check"
										></use>
									</svg>
								</div>
								<p class="checkbox__caption">
									Да
								</p>
							</label>
						</div>
						<div class="columns__col columns__col--6 columns__col--mob-6">
							<label
									class="checkbox"
									data-radio
							>
								<input
										class="checkbox__input"
										type="radio"
										data-radio-field
										name="USER_AGE"
										id="age_no"
										value="Нет"
										required
								>
								<div class="checkbox__box">
									<svg class="checkbox__icon">
										<use
												xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-check"
										></use>
									</svg>
								</div>
								<p class="checkbox__caption">
									Нет
								</p>
							</label>
						</div>
					</div>
				</label>
				<label
						class="input mb-15 hidden_question"
						data-input
				>
					<p class="input__caption">
						Фамилия родителя
					</p>
					<p class="input__message">
						Обязательное поле. Введите фамилию представителя
					</p>
					<input
							class="input__field"
							placeholder="Фамилия"
							name="PAREN_SURNAME"
							type="text"

							data-input-field
					>
				</label>
				<label
						class="input mb-15 hidden_question"
						data-input
				>
					<p class="input__caption">
						Имя родителя
					</p>
					<p class="input__message">
						Обязательное поле. Введите имя родителя
					</p>
					<input
							class="input__field"
							placeholder="Имя"
							name="PARENT_NAME"
							type="text"
							data-input-field
					>
				</label>
				<label
						class="input mb-15 hidden_question"
						data-input
				>
					<p class="input__caption">
						Отчество родителя
					</p>
					<p class="input__message">
						Обязательное поле. Введите отчество родителя
					</p>
					<input
							class="input__field"
							placeholder="Ваше отчество"
							name="PARENT_SECOND_NAME"
							type="text"
							data-input-field
					>
				</label>
				<label
						class="input mb-15 hidden_question"
						data-input
				>
					<p class="input__caption">
						Телефон родителя
					</p>
					<p class="input__message">
						Обязательное поле. Укажите телефон родителя
					</p>
					<input
							class="input__field"
							placeholder="+7-___-___-__-__"
							type="text"
							name="PARENT_PHONE"
							data-input-field
					>
				</label>
				<label
						class="input mb-15 hidden_question"
						data-input
				>
					<p class="input__caption">
						Место работы родителя
					</p>
					<p class="input__message">
						Обязательное поле. Место работы родителя
					</p>
					<input
							class="input__field"
							placeholder="Место работы родителя"
							type="text"
							name="PARENT_WORK"
							data-input-field
					>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Почему Вы решили стать волонтером?
					</p>
					<textarea
							class="input__textarea"
							name="USER_WHY"
							data-input-field
					></textarea>
				</label>
				<label
						class="input mb-15"
						data-input
				>
					<p class="input__caption">
						Что Вы ожидаете от работы волонтером?
					</p>
					<textarea
							class="input__textarea"
							name="USER_EXPECTATION"
							data-input-field
					></textarea>
				</label>
				<label
						class="input"
						data-input
				>
					<p class="input__caption">
						Есть ли у Вас опыт волонтерства?
						<br>
						(Если да, то уточните, какой — в какой сфере, с детьми
						или со взрослыми, как долго, а также любую другую существенную информацию)
					</p>
					<textarea
							class="input__textarea"
							name="USER_EXPERIANCE"
							data-input-field
					></textarea>
				</label>
			</div>
			<div
					class="form__toolbar"
					data-agreement
			>
				<button
						class="button button--orange button--230 button--center"
						data-form-button
						data-agreement-button
				>
                        <span
		                        class="button__text"
		                        data-form-field
                        >
                            Отправить
                        </span>
				</button>
				<label
						class="checkbox"
						data-checkbox
				>
					<input
							class="checkbox__input"
							type="checkbox"
							data-agreement-checkbox
							data-checkbox-field
							required
					>
					<div class="checkbox__box">
						<svg class="checkbox__icon">
							<use xlink:href="<?= $localPath ?>/assets/sprite/sprite.svg#icon-check"></use>
						</svg>
					</div>
					<p class="checkbox__caption">
						Нажимая кнопку "Отправить", вы соглашаетесь с
						<a href="/privacy_policy/">Условиями обработки персональных данных</a>
					</p>
				</label>
			</div>
			<!-- После успешной отправки удаляем атрибут hidden -->
			<div
					class="form__message"
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
				<a
						class="button button--orange button--230 button--center"
						href="./"
				>
                        <span class="button__text">
                            На главную
                        </span>
				</a>
			</div>
		</form>
	</section>
	<style>
		.hidden_question {
			display: none;
		}
	</style>
	<script>
		document.getElementById ("age_no").onclick = function () {
			var hidden_questions = document.querySelectorAll (".hidden_question");
			for (var i = 0, length = hidden_questions.length; i < length; i++) {
				hidden_questions[i].style.display = "initial";
			}
		};
		document.getElementById ("age_yes").onclick = function () {
			var hidden_questions = document.querySelectorAll (".hidden_question");
			for (var i = 0, length = hidden_questions.length; i < length; i++) {
				hidden_questions[i].style.display = "none";
			}
		};
	</script>
	<? $APPLICATION->IncludeComponent (
		"bitrix:menu",
		"menu.header.mobile",
		[
			"ALLOW_MULTI_SELECT"    => "N",
			"CHILD_MENU_TYPE"       => "left",
			"COMPONENT_TEMPLATE"    => "menu.header.mobile",
			"DELAY"                 => "N",
			"MAX_LEVEL"             => "2",
			"MENU_CACHE_GET_VARS"   => [],
			"MENU_CACHE_TIME"       => "3600",
			"MENU_CACHE_TYPE"       => "Y",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"ROOT_MENU_TYPE"        => "top",
			"USE_EXT"               => "Y",
		],
	); ?>
</div>
<div id="panel">
	<? $APPLICATION->ShowPanel (); ?>
</div>
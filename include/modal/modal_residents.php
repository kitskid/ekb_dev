<section class="modal modal--sm content-left" id="modal-vacancy-reply">
    <h1 class="modal__title mb-15 mbm-5">Откликнуться</h1>
    <div class="editor editor--16 mb-20">
        <p>Заполните свои данные и прикрепите резюме</p>
    </div>
    <form action="/local/templates/diez-white-cube/ajax/form.vacancy.ajax.php" class="form" data-form method="post">
        <div class="form__item">
            <label class="form__label">
                <span class="form__label-text">Ваше полное имя<mark>&#42;</mark></span>
                <input placeholder="Введите ваше имя" name="USER_FIO" required>
            </label>
        </div>
        <div class="form__item">
            <label class="form__label">
                <span class="form__label-text">Телефон<mark>&#42;</mark></span>
                <input data-tel type="tel" name="USER_PHONE"
                       placeholder="+7 (___) ___-___-__-__" required>
            </label>
        </div>
        <div class="form__item">
            <label class="form__label">
                <span class="form__label-text">Email<mark>&#42;</mark></span>
                <input inputmode="email" type="email" name="USER_EMAIL" placeholder="info@mail.ru" required>
            </label>
        </div>
        <div class="form__item">
            <label class="form__label">
                <span class="form__label-text">Дата рождения<mark>&#42;</mark></span>
                <input placeholder="Выберите дату рождения" name="USER_DATE" type="text" onfocus="(this.type='date')" required>
            </label>
        </div>
        <div class="form__item">
            <label class="form__label">
                <span class="form__label-text">Сообщение</span>
                <textarea placeholder="Сопроводительное письмо" name="USER_MESSAGE"></textarea>
            </label>
        </div>
        <div class="form__item-wrapper justify">
            <label class="file" data-uploader>
                <input class="file__field" data-uploader-field type="file" name="FILE" required>
                <svg class="form__label-icon">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-clip"></use>
                </svg>
                <span class="file__message file__message--black" data-uploader-title>
                   Прикрепить резюме
                </span>
            </label>
            <button class="button button--orange lowercase mob-width-100" data-form-field data-form-button>
                Отправить
            </button>
        </div>
        <div class="form__agreement">
            <div class="form__agreement-text">
                Нажимая кнопку, я даю свое согласие на обработку моих персональных данных в соответствии с законом №
                152-ФЗ «О персональных данных» от 27.07.2006 и принимаю условия
                <a class="form__agreement-link" href="#">Пользовательского соглашения.</a>
            </div>
        </div>
    </form>
</section>
<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Афиша событий - Екатеринбург 300");
?>

<!-- Баннер -->
<section class="section section--intro" style="--background: url('/local/templates/diez-ekb/assets/images/bg-afisha.png')">
    <div class="container">
        <div class="intro">
            <h1 class="title title--light">
                Афиша событий<br>
                Екатеринбурга
            </h1>
            <p class="subtitle">
                Откройте для себя удивительные события и мероприятия в честь 300-летия Екатеринбурга.
                Фестивали, концерты, выставки и многое другое ждет вас в нашем прекрасном городе.
            </p>
            <button class="button js-suggest-event">
                <span>Предложить событие</span>
                <span class="button__icon">
                    <svg>
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-plus"></use>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</section>

<!-- Программа событий -->
<section class="section pt-80 pb-80">
    <?php
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "events_program",
        Array(
            "IBLOCK_TYPE" => "bill",
            "IBLOCK_ID" => "23",
            "NEWS_COUNT" => "6",
            "SORT_BY1" => "PROPERTY_DATETIME",
            "SORT_ORDER1" => "ASC",
            "SORT_BY2" => "ID",
            "SORT_ORDER2" => "DESC",
            "FIELD_CODE" => array(
                "ID",
                "NAME",
                "PREVIEW_PICTURE",
                "PREVIEW_TEXT",
                "DETAIL_PAGE_URL",
                "IBLOCK_SECTION_ID"
            ),
            "PROPERTY_CODE" => array(
                "LOCATION",
                "DATETIME",
                "TAGS"
            ),
            "SET_TITLE" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CHECK_DATES" => "Y"
        ),
        false
    );
    ?>
</section>

<!-- Модальное окно для предложения события -->
<div id="suggest-event-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Предложить событие</h3>
            <button class="modal-close">&times;</button>
        </div>
        <form id="suggest-event-form" class="modal-body">
            <div class="form-group">
                <label for="phone">Номер телефона *</label>
                <input type="tel" id="phone" name="phone" required placeholder="+7 (___) ___-__-__">
            </div>

            <div class="form-group">
                <label for="city">Город *</label>
                <input type="text" id="city" name="city" required placeholder="Введите название города">
            </div>

            <div class="form-group">
                <label for="description">Описание предложения *</label>
                <textarea id="description" name="description" required rows="5" placeholder="Опишите ваше предложение..."></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="button button--secondary modal-close">Отмена</button>
                <button type="submit" class="button">Отправить предложение</button>
            </div>
        </form>
    </div>
</div>

    <style>
        /* Стили для модального окна */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: #fff;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            animation: modalAppear 0.3s ease;
        }

        @keyframes modalAppear {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            border-bottom: 1px solid #e0e0e0;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: #f0f0f0;
            color: #333;
        }

        .modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #008cd2;
            box-shadow: 0 0 0 3px rgba(0, 140, 210, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .button--secondary {
            background: #f5f5f5;
            color: #666;
            border: 1px solid #e0e0e0;
        }

        .button--secondary:hover {
            background: #e0e0e0;
            color: #333;
        }

        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                margin: 20px;
            }

            .modal-header,
            .modal-body {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .button {
                width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Инициализация модального окна
            const modal = document.getElementById('suggest-event-modal');
            const suggestBtn = document.querySelector('.js-suggest-event');
            const closeButtons = document.querySelectorAll('.modal-close');
            const form = document.getElementById('suggest-event-form');

            // Открытие модального окна
            if (suggestBtn) {
                suggestBtn.addEventListener('click', function() {
                    modal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Закрытие модального окна
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    closeModal();
                });
            });

            // Закрытие по клику на фон
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Закрытие по Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('show')) {
                    closeModal();
                }
            });

            function closeModal() {
                modal.classList.remove('show');
                document.body.style.overflow = '';
                form.reset();
            }

            // Маска для телефона
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.startsWith('8')) {
                        value = '7' + value.slice(1);
                    }
                    if (value.startsWith('7')) {
                        value = value.slice(0, 11);
                        const formatted = '+7 (' + value.slice(1, 4) + ') ' +
                            value.slice(4, 7) + '-' +
                            value.slice(7, 9) + '-' +
                            value.slice(9, 11);
                        e.target.value = formatted;
                    }
                });
            }

            // Отправка формы
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';

                // Здесь должна быть отправка данных на сервер
                // Симуляция отправки
                setTimeout(() => {
                    alert('Спасибо! Ваше предложение отправлено и будет рассмотрено в ближайшее время.');
                    closeModal();
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }, 1500);

                /* Реальная отправка формы:
                fetch('/ajax/suggest-event.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Спасибо! Ваше предложение отправлено и будет рассмотрено в ближайшее время.');
                        closeModal();
                    } else {
                        alert('Произошла ошибка при отправке. Попробуйте еще раз.');
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка при отправке. Попробуйте еще раз.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
                */
            });
        });
    </script>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
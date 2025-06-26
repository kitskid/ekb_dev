<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */

use Bitrix\Main\Page\Asset;
?>
<!-- Футер сайта -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3 class="footer-title">О Екатеринбурге</h3>
                <!-- Компонент битрикса для вывода меню "О городе" -->
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "footer_menu",
                    Array(
                        "ROOT_MENU_TYPE" => "about",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "",
                        "USE_EXT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => Array()
                    )
                );
                ?>
                <!-- Временное содержимое меню -->
                <ul class="footer-links">
                    <li><a href="/about/history/">История города</a></li>
                    <li><a href="/about/geography/">География и климат</a></li>
                    <li><a href="/about/infrastructure/">Инфраструктура</a></li>
                    <li><a href="/about/economy/">Экономика</a></li>
                    <li><a href="/about/culture/">Культура</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3 class="footer-title">Полезные ссылки</h3>
                <!-- Компонент битрикса для вывода меню "Полезные ссылки" -->
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "footer_menu",
                    Array(
                        "ROOT_MENU_TYPE" => "useful",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "",
                        "USE_EXT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => Array()
                    )
                );
                ?>
                <!-- Временное содержимое меню -->
                <ul class="footer-links">
                    <li><a href="/tourism/">Туризм</a></li>
                    <li><a href="/transport/">Транспорт</a></li>
                    <li><a href="/accommodation/">Проживание</a></li>
                    <li><a href="/safety/">Безопасность</a></li>
                    <li><a href="/faq/">Часто задаваемые вопросы</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3 class="footer-title">Контакты</h3>
                <!-- Компонент битрикса для вывода контактной информации -->
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/contacts.php"
                    )
                );
                ?>
                <!-- Временное содержимое контактов -->
                <p>Администрация города Екатеринбурга</p>
                <p>пр. Ленина, 24а, г. Екатеринбург, 620014</p>
                <p>Телефон: +7 (343) 304-32-09</p>
                <p>Email: tourism@ekburg.ru</p>

                <div class="social-links">
                    <a href="#" class="social-link"><i class="fa fa-vk"></i></a>
                    <a href="#" class="social-link"><i class="fa fa-telegram"></i></a>
                    <a href="#" class="social-link"><i class="fa fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Официальный туристический портал Екатеринбурга</p>
        </div>
    </div>
</footer>

<!-- Подключение скриптов -->
<?php
Asset::getInstance()->addJs("/bitrix/js/main/core/core.min.js");
Asset::getInstance()->addJs("https://unpkg.com/swiper/swiper-bundle.min.js");

// Подключаем jQuery только там, где это необходимо
Asset::getInstance()->addJs("https://code.jquery.com/jquery-3.6.0.min.js");
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация свайперов для слайдеров
        const initSwiper = function(selector, options) {
            const elements = document.querySelectorAll(selector);
            if (elements.length > 0) {
                elements.forEach(function(element) {
                    new Swiper(element, options);
                });
            }
        };

        // Мобильный слайдер для карточек гостей города (только для мобильных устройств)
        function initMobileSliders() {
            if (window.innerWidth < 768) {
                initSwiper('.mobile-swiper', {
                    slidesPerView: 1.2,
                    spaceBetween: 10,
                    centeredSlides: false,
                    loop: false,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    }
                });
            }
        }

        // Вызов функции инициализации при загрузке и изменении размера окна
        initMobileSliders();

        window.addEventListener('resize', function() {
            initMobileSliders();
        });

        // Анимация появления элементов при скролле
        function handleScrollAnimation() {
            const elements = document.querySelectorAll('.section-title, .guest-card, .event-card, .digest-card, .world-level-card, .review-card');

            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementBottom = element.getBoundingClientRect().bottom;
                const isVisible = (elementTop < window.innerHeight) && (elementBottom > 0);

                if (isVisible) {
                    element.classList.add('animate');
                }
            });
        }

        // Добавляем класс для анимации
        document.addEventListener('scroll', handleScrollAnimation);

        // Первичная проверка при загрузке страницы
        handleScrollAnimation();

        // Управление мобильным меню
        const burgerMenu = document.getElementById('burger-menu');
        const mobileNav = document.getElementById('mobile-nav');
        const closeMenu = document.getElementById('close-menu');

        if (burgerMenu && mobileNav && closeMenu) {
            burgerMenu.addEventListener('click', function() {
                mobileNav.classList.add('active');
                document.body.style.overflow = 'hidden'; // Запрет прокрутки страницы
            });

            closeMenu.addEventListener('click', function() {
                mobileNav.classList.remove('active');
                document.body.style.overflow = ''; // Восстановление прокрутки страницы
            });
        }

        // Функция для создания мобильных слайдеров из имеющихся карточек
        function createMobileSliders() {
            if (window.innerWidth < 768) {
                // Для секции "Гостям Города"
                const guestCards = document.querySelectorAll('#guest-cards-container .guest-card');
                const guestsSwiperWrapper = document.querySelector('.guests-mobile-swiper .swiper-wrapper');

                if (guestCards.length > 0 && guestsSwiperWrapper) {
                    guestsSwiperWrapper.innerHTML = '';

                    guestCards.forEach(card => {
                        const slide = document.createElement('div');
                        slide.className = 'swiper-slide';
                        slide.appendChild(card.cloneNode(true));
                        guestsSwiperWrapper.appendChild(slide);
                    });
                }

                // Аналогично можно создать для других секций
            }
        }

        // Вызываем функцию при загрузке и изменении размера окна
        createMobileSliders();

        window.addEventListener('resize', function() {
            createMobileSliders();
        });
    });
</script>
</body>
</html>

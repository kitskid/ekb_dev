document.addEventListener('DOMContentLoaded', function() {
    // Инициализация свайперов для слайдеров
    const initSliders = function() {
        // Проверяем ширину экрана для определения мобильного устройства
        const isMobile = window.innerWidth < 768;

        // Создаем объекты Swiper только на мобильных устройствах
        if (isMobile) {
            // Конфигурация слайдера
            const swiperConfig = {
                slidesPerView: 'auto',
                spaceBetween: 15,
                centeredSlides: true,
                loop: false,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                breakpoints: {
                    // Настройки для телефонов
                    320: {
                        slidesPerView: 1.15,
                        spaceBetween: 10,
                    },
                    // Настройки для больших телефонов
                    480: {
                        slidesPerView: 1.3,
                        spaceBetween: 15,
                    }
                }
            };

            // Инициализируем слайдеры для каждой секции
            const slidersSelectors = [
                '.guests-mobile-swiper',
                '.events-mobile-swiper',
                '.digest-mobile-swiper',
                '.world-level-mobile-swiper',
                '.reviews-mobile-swiper'
            ];

            // Создаем слайдеры
            slidersSelectors.forEach(selector => {
                const elements = document.querySelectorAll(selector);
                if (elements.length > 0) {
                    elements.forEach(element => {
                        // Клонируем конфигурацию, чтобы не менять оригинал
                        const config = {...swiperConfig};

                        // Специфические настройки для разных типов слайдеров
                        if (selector === '.reviews-mobile-swiper') {
                            config.slidesPerView = 1;
                        }

                        // Инициализация слайдера
                        new Swiper(element, config);
                    });
                }
            });
        }
    };

    // Вызов функции инициализации при загрузке страницы
    initSliders();

    // Повторная инициализация при изменении размера окна
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(initSliders, 250);
    });

    // Анимация появления элементов при скролле
    function handleScrollAnimation() {
        const elements = document.querySelectorAll('.section-title, .guest-card, .event-card, .digest-card, .world-level-card, .review-card');

        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            const isVisible = (elementTop < window.innerHeight - 100) && (elementBottom > 0);

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

        // Закрытие меню при клике на пункт
        const mobileMenuLinks = mobileNav.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileNav.classList.remove('active');
                document.body.style.overflow = ''; // Восстановление прокрутки страницы
            });
        });
    }

    // Плавный скролл для якорных ссылок
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Фиксированная шапка при скролле
    const header = document.querySelector('.header');
    let lastScrollTop = 0;

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > 100) {
            header.classList.add('header-fixed');

            // Скрываем/показываем шапку при скролле вверх/вниз
            if (scrollTop > lastScrollTop) {
                // Скролл вниз - скрываем шапку
                header.classList.add('header-hidden');
            } else {
                // Скролл вверх - показываем шапку
                header.classList.remove('header-hidden');
            }
        } else {
            header.classList.remove('header-fixed');
            header.classList.remove('header-hidden');
        }

        lastScrollTop = scrollTop;
    });

    // Функционал для создания мобильных слайдеров из существующих карточек
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

            // Другие секции можно добавить по аналогии
        }
    }

    // Вызываем функцию при загрузке страницы
    createMobileSliders();

    // Вызываем при изменении размера окна
    window.addEventListener('resize', function() {
        createMobileSliders();
    });
});
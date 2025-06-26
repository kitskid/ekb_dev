document.addEventListener('DOMContentLoaded', function() {
    // Переменные для десктопного меню
    const menuItems = document.querySelectorAll('.main-menu__item--has-children');
    const mobileMenuItems = document.querySelectorAll('.main-menu__mobile-item--has-children');

    // Обработка раскрытия/скрытия выпадающего меню на десктопе
    menuItems.forEach(function(item) {
        // Обработка событий наведения для десктоп-меню
        item.addEventListener('mouseenter', function() {
            this.classList.add('main-menu__item--open');
            // Обновляем атрибут aria-hidden для выпадающего меню
            const dropdown = this.querySelector('.main-menu__dropdown');
            if (dropdown) {
                dropdown.setAttribute('aria-hidden', 'false');
            }
        });

        item.addEventListener('mouseleave', function() {
            this.classList.remove('main-menu__item--open');
            // Обновляем атрибут aria-hidden для выпадающего меню
            const dropdown = this.querySelector('.main-menu__dropdown');
            if (dropdown) {
                dropdown.setAttribute('aria-hidden', 'true');
            }
        });

        // Событие при клике (для тач-устройств)
        const link = item.querySelector('.main-menu__link');
        link.addEventListener('click', function(e) {
            // Проверяем, не открыто ли уже подменю
            if (!item.classList.contains('main-menu__item--open')) {
                e.preventDefault();

                // Закрываем все другие открытые подменю
                menuItems.forEach(function(otherItem) {
                    if (otherItem !== item) {
                        otherItem.classList.remove('main-menu__item--open');
                        const otherDropdown = otherItem.querySelector('.main-menu__dropdown');
                        if (otherDropdown) {
                            otherDropdown.setAttribute('aria-hidden', 'true');
                        }
                    }
                });

                // Открываем текущее подменю
                item.classList.add('main-menu__item--open');
                const dropdown = item.querySelector('.main-menu__dropdown');
                if (dropdown) {
                    dropdown.setAttribute('aria-hidden', 'false');
                }

                // Добавляем обработчик для закрытия при клике вне меню
                const closeMenu = function(event) {
                    if (!item.contains(event.target)) {
                        item.classList.remove('main-menu__item--open');
                        const dropdown = item.querySelector('.main-menu__dropdown');
                        if (dropdown) {
                            dropdown.setAttribute('aria-hidden', 'true');
                        }
                        document.removeEventListener('click', closeMenu);
                    }
                };

                // Отложенное добавление обработчика, чтобы не сработать на текущем клике
                setTimeout(function() {
                    document.addEventListener('click', closeMenu);
                }, 0);
            }
        });

        // Обработка нажатия клавиши Escape для закрытия меню
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && item.classList.contains('main-menu__item--open')) {
                item.classList.remove('main-menu__item--open');
                const dropdown = item.querySelector('.main-menu__dropdown');
                if (dropdown) {
                    dropdown.setAttribute('aria-hidden', 'true');
                }
            }
        });
    });

    // Переменные для мобильного меню
    const menuToggle = document.querySelector('.main-menu__toggle');
    const mobileMenu = document.querySelector('.main-menu__mobile');
    const mobileClose = document.querySelector('.main-menu__mobile-close');
    const menuOverlay = document.querySelector('.main-menu__overlay');
    const mobileToggles = document.querySelectorAll('.main-menu__mobile-toggle');

    // Открытие мобильного меню
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.add('active');
            mobileMenu.setAttribute('aria-hidden', 'false');
            menuToggle.setAttribute('aria-expanded', 'true');
            document.body.classList.add('menu-open');

            // Показываем оверлей
            if (menuOverlay) {
                menuOverlay.classList.add('active');
            }
        });
    }

    // Закрытие мобильного меню
    if (mobileClose && mobileMenu) {
        mobileClose.addEventListener('click', function() {
            closeMobileMenu();
        });
    }

    // Закрытие по клику на оверлей
    if (menuOverlay) {
        menuOverlay.addEventListener('click', function() {
            closeMobileMenu();
        });
    }

    // Функция для закрытия мобильного меню
    function closeMobileMenu() {
        if (mobileMenu) {
            mobileMenu.classList.remove('active');
            mobileMenu.setAttribute('aria-hidden', 'true');

            if (menuToggle) {
                menuToggle.setAttribute('aria-expanded', 'false');
            }

            document.body.classList.remove('menu-open');

            // Скрываем оверлей
            if (menuOverlay) {
                menuOverlay.classList.remove('active');
            }
        }
    }

    // Обработка переключения подменю в мобильном режиме
    mobileToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const mobileItem = this.closest('.main-menu__mobile-item');
            const submenuId = this.getAttribute('aria-controls');
            const submenu = document.getElementById(submenuId);

            // Переключаем класс для текущего элемента меню
            if (mobileItem) {
                const isOpen = mobileItem.classList.toggle('main-menu__mobile-item--open');
                this.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }
        });
    });

    // Обработка нажатия клавиши Escape для закрытия мобильного меню
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu && mobileMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    // Обработка изменения размера окна
    window.addEventListener('resize', function() {
        // Если окно больше мобильного размера, закрываем мобильное меню
        if (window.innerWidth > 991 && mobileMenu && mobileMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });
});
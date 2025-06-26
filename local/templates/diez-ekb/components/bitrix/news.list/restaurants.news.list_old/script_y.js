BX.ready(function() {
    // Инициализация фильтров ресторанов
    initRestaurantFilters();
});

/**
 * Инициализация фильтров ресторанов
 */
function initRestaurantFilters() {
    var filterTabs = document.querySelectorAll('.filter-tab');
    var restaurantCards = document.querySelectorAll('.restaurant-card');

    if (!filterTabs.length || !restaurantCards.length) return;

    // Добавляем обработчики клика на табы фильтра
    filterTabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            // Убираем активный класс со всех табов
            filterTabs.forEach(function(t) {
                t.classList.remove('active');
            });

            // Добавляем активный класс текущему табу
            this.classList.add('active');

            // Получаем выбранную категорию
            var selectedCategory = this.getAttribute('data-filter');

            // Вызываем AJAX фильтрацию вместо обычной
            filterRestaurantsAjax(selectedCategory);
        });
    });

    // Обработчик для кнопки "Показать еще"
    var moreButton = document.querySelector('.pagination__more-btn');
    if (moreButton) {
        moreButton.addEventListener('click', function(e) {
            e.preventDefault();

            var url = this.getAttribute('href');
            if (!url) return;

            // Показываем индикатор загрузки
            this.textContent = 'Загрузка...';
            var button = this;

            // Получаем активную категорию фильтра
            var activeCategory = document.querySelector('.filter-tab.active').getAttribute('data-filter');

            // AJAX запрос
            BX.ajax({
                url: url,
                method: 'GET',
                dataType: 'html',
                onsuccess: function(data) {
                    // Создаем временный элемент для парсинга HTML
                    var div = document.createElement('div');
                    div.innerHTML = data;

                    // Получаем новые карточки
                    var newCards = div.querySelectorAll('.restaurant-card');
                    var grid = document.querySelector('.restaurants-grid');

                    // Добавляем новые карточки
                    newCards.forEach(function(card) {
                        // Если активен фильтр, применяем его к новым карточкам
                        if (activeCategory !== 'all' && card.getAttribute('data-category') !== activeCategory) {
                            card.style.display = 'none';
                        }
                        grid.appendChild(card);
                    });

                    // Получаем новую кнопку пагинации
                    var newMoreButton = div.querySelector('.pagination__more-btn');

                    // Если есть еще страницы, обновляем ссылку, иначе скрываем кнопку
                    if (newMoreButton) {
                        button.textContent = 'Показать еще';
                        button.setAttribute('href', newMoreButton.getAttribute('href'));
                    } else {
                        button.style.display = 'none';
                    }

                    // Обновляем обработчики для новых карточек
                    restaurantCards = document.querySelectorAll('.restaurant-card');
                },
                onfailure: function() {
                    button.textContent = 'Ошибка загрузки';
                }
            });
        });
    }
}

// AJAX фильтрация ресторанов
function filterRestaurantsAjax(category) {
    var grid = document.querySelector('.restaurants-grid');

    // Показываем индикатор загрузки
    grid.innerHTML = '<div class="loading">Загрузка...</div>';

    // AJAX запрос
    BX.ajax({
        url: window.location.pathname,
        method: 'GET',
        data: {
            cuisine: category,
            ajax: 'Y'
        },
        dataType: 'html',
        onsuccess: function(data) {
            // Создаем временный элемент для парсинга HTML
            var div = document.createElement('div');
            div.innerHTML = data;

            // Получаем новые карточки
            var newGrid = div.querySelector('.restaurants-grid');
            if (newGrid) {
                grid.innerHTML = newGrid.innerHTML;
            }

            // Обновляем обработчики для новых карточек
            restaurantCards = document.querySelectorAll('.restaurant-card');
        },
        onfailure: function() {
            grid.innerHTML = '<div class="error">Ошибка загрузки</div>';
        }
    });
}

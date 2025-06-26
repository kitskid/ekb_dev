// Объявляем переменную в глобальной области видимости
var restaurantCards;

BX.ready(function() {
    // Инициализация фильтров ресторанов
    initRestaurantFilters();
});

/**
 * Инициализация фильтров ресторанов
 */
function initRestaurantFilters() {
    var filterTabs = document.querySelectorAll('.filter-tab');
    restaurantCards = document.querySelectorAll('.restaurant-card');

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
        moreButton.addEventListener('click', handleMoreButtonClick);
    }
}

/**
 * Обработчик для кнопки "Показать еще"
 */
function handleMoreButtonClick(e) {
    e.preventDefault();

    var button = this;
    var url = button.getAttribute('href');
    if (!url) return;

    // Показываем индикатор загрузки
    button.textContent = 'Загрузка...';

    // Получаем активную категорию фильтра
    var activeCategory = document.querySelector('.filter-tab.active').getAttribute('data-filter');

    // Добавляем параметры к URL
    var requestUrl = new URL(url, window.location.origin);
    if (activeCategory !== 'all') {
        requestUrl.searchParams.set('cuisine', activeCategory);
    }
    requestUrl.searchParams.set('ajax', 'Y');

    // AJAX запрос
    BX.ajax({
        url: requestUrl.toString(),
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
}

/**
 * AJAX фильтрация ресторанов
 * @param {string} category - Категория для фильтрации (код XML_ID кухни)
 */
function filterRestaurantsAjax(category) {
    console.log("Фильтрация по категории:", category); // Отладочный вывод

    var grid = document.querySelector('.restaurants-grid');
    if (!grid) {
        console.error("Не найден контейнер для ресторанов!");
        return;
    }

    // Показываем индикатор загрузки
    grid.innerHTML = '<div class="loading">Загрузка...</div>';

    // Определяем текущий URL и добавляем к нему параметры
    var url = new URL(window.location.href);
    url.searchParams.set('cuisine', category);
    url.searchParams.set('ajax', 'Y');

    // AJAX запрос
    BX.ajax({
        url: url.toString(),
        method: 'GET',
        dataType: 'html',
        onsuccess: function(data) {
            console.log("Успешный ответ AJAX");

            // Создаем временный элемент для парсинга HTML
            var div = document.createElement('div');
            div.innerHTML = data;

            // Получаем новые карточки
            var newGrid = div.querySelector('.restaurants-grid');
            if (newGrid) {
                grid.innerHTML = newGrid.innerHTML;
                console.log("Обновлен контент грида");
            } else {
                console.error("В ответе не найден элемент .restaurants-grid");
                grid.innerHTML = '<div class="error">Ошибка обработки данных</div>';
            }

            // Обновляем обработчики для новых карточек
            restaurantCards = document.querySelectorAll('.restaurant-card');

            // Обновляем пагинацию, если она есть
            var oldPagination = document.querySelector('.pagination');
            var newPagination = div.querySelector('.pagination');

            if (oldPagination && newPagination) {
                oldPagination.innerHTML = newPagination.innerHTML;

                // Переинициализируем кнопку "Показать еще"
                var moreButton = oldPagination.querySelector('.pagination__more-btn');
                if (moreButton) {
                    moreButton.addEventListener('click', handleMoreButtonClick);
                }
            }
        },
        onfailure: function(error) {
            console.error("Ошибка AJAX запроса:", error);
            grid.innerHTML = '<div class="error">Ошибка загрузки</div>';
        }
    });
}

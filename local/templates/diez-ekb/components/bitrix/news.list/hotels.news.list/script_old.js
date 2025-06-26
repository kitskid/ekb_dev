BX.ready(function() {
    // Инициализация фильтров гостиниц
    initHotelFilters();
});

/**
 * Инициализация фильтров гостиниц
 */
function initHotelFilters() {
    var filterTabs = document.querySelectorAll('.filter-tab');
    var hotelCards = document.querySelectorAll('.hotel-card');

    if (!filterTabs.length || !hotelCards.length) return;

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
            filterHotelsAjax(selectedCategory);
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
                    var newCards = div.querySelectorAll('.hotel-card');
                    var grid = document.querySelector('.hotels-grid');

                    // Добавляем новые карточки
                    newCards.forEach(function(card) {
                        // Если активен фильтр, проверяем соответствие категории
                        if (activeCategory !== 'all') {
                            // Проверяем все категории элемента (для множественных свойств)
                            var allCategories = card.getAttribute('data-all-categories') || '';
                            var categoriesArray = allCategories.split(' ');
                            if (!categoriesArray.includes(activeCategory)) {
                                card.style.display = 'none';
                            }
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
                    hotelCards = document.querySelectorAll('.hotel-card');

                    // Обновляем карту
                    updateHotelMap(activeCategory);
                },
                onfailure: function() {
                    button.textContent = 'Ошибка загрузки';
                }
            });
        });
    }
}

// AJAX фильтрация гостиниц
function filterHotelsAjax(category) {
    var grid = document.querySelector('.hotels-grid');

    // Показываем индикатор загрузки
    grid.innerHTML = '<div class="loading">Загрузка...</div>';

    // AJAX запрос
    BX.ajax({
        url: window.location.pathname,
        method: 'GET',
        data: {
            type: category,
            ajax: 'Y'
        },
        dataType: 'html',
        onsuccess: function(data) {
            // Создаем временный элемент для парсинга HTML
            var div = document.createElement('div');
            div.innerHTML = data;

            // Получаем новые карточки
            var newGrid = div.querySelector('.hotels-grid');
            if (newGrid) {
                grid.innerHTML = newGrid.innerHTML;
            }

            // Обновляем обработчики для новых карточек
            hotelCards = document.querySelectorAll('.hotel-card');

            // Обновляем карту
            updateHotelMap(category);
        },
        onfailure: function() {
            grid.innerHTML = '<div class="error">Ошибка загрузки</div>';
        }
    });
}

// Функция обновления карты
function updateHotelMap(category) {
    // Если карта инициализирована
    if (window.myMap && window.hotelPlacemarks) {
        // Скрываем все метки
        for (var i = 0; i < window.hotelPlacemarks.length; i++) {
            var mark = window.hotelPlacemarks[i];

            // Если фильтр "все" или категория входит в список категорий метки
            if (category === 'all' || (mark.categories && mark.categories.includes(category))) {
                mark.placemark.options.set('visible', true);
            } else {
                mark.placemark.options.set('visible', false);
            }
        }
    }
}

// Инициализация карты гостиниц
function initHotelMap() {
    // Инициализируем массив меток
    window.hotelPlacemarks = [];

    // Создаем карту
    window.myMap = new ymaps.Map('hotel-map', {
        center: [55.76, 37.64], // центр Москвы
        zoom: 12,
        controls: ['zoomControl', 'geolocationControl']
    });

    // Получаем все карточки гостиниц
    var hotels = document.querySelectorAll('.hotel-card');

    // Массив для хранения координат меток
    var bounds = [];

    // Создаем метки для каждой гостиницы
    hotels.forEach(function(hotel) {
        // Получаем координаты из дата-атрибута
        var coords = hotel.getAttribute('data-coords');
        if (coords) {
            coords = coords.split(',').map(parseFloat);

            // Если координаты валидные
            if (coords.length === 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
                bounds.push(coords);

                // Получаем все категории элемента для множественной фильтрации
                var allCategories = hotel.getAttribute('data-all-categories') || '';
                var categoriesArray = allCategories.split(' ').filter(Boolean); // удаляем пустые строки

                // Создаем метку
                var placemark = new ymaps.Placemark(coords, {
                    hintContent: hotel.querySelector('.hotel-card__title').innerText,
                    balloonContent: hotel.querySelector('.hotel-card__title').innerText
                }, {
                    preset: 'islands#blueHotelIcon'
                });

                // Добавляем метку на карту
                window.myMap.geoObjects.add(placemark);

                // Сохраняем метку в массиве с указанием всех категорий
                window.hotelPlacemarks.push({
                    placemark: placemark,
                    categories: categoriesArray
                });
            }
        }
    });

    // Если есть метки, центрируем карту
    if (bounds.length > 0) {
        window.myMap.setBounds(bounds, {
            checkZoomRange: true,
            zoomMargin: 50
        });
    }
}

// Инициализация карты при загрузке API
ymaps.ready(initHotelMap);

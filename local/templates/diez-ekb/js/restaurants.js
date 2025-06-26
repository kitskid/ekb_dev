// restaurants.js

// Дождемся загрузки DOM
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация фильтрации ресторанов
    initRestaurantFilter();

    // Инициализация карты
    initRestaurantsMap();

    // Инициализация "Показать еще"
    initPagination();
});

/**
 * Инициализация фильтрации ресторанов
 * В Bitrix эта функция будет модифицирована для работы с AJAX
 */
function initRestaurantFilter() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const restaurantCards = document.querySelectorAll('.restaurant-card');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Убираем активный класс со всех табов
            filterTabs.forEach(t => t.classList.remove('active'));

            // Добавляем активный класс текущему табу
            this.classList.add('active');

            // Получаем выбранную категорию
            const selectedCategory = this.getAttribute('data-filter');

            // Фильтруем рестораны
            restaurantCards.forEach(card => {
                if (selectedCategory === 'all' || card.getAttribute('data-category') === selectedCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            // В Bitrix здесь будет AJAX-запрос для загрузки отфильтрованных элементов
            // При использовании компонента bitrix:news.list можно использовать его AJAX-возможности

            /*
            // Пример AJAX-запроса для Bitrix
            BX.ajax.runComponentAction('custom:restaurants.list', 'getFilteredList', {
                mode: 'class',
                data: {
                    category: selectedCategory
                }
            }).then(function(response) {
                if(response.status === 'success') {
                    document.querySelector('.restaurants-grid').innerHTML = response.data.html;

                    // Обновление карты после фильтрации
                    updateMapMarkers(response.data.mapData);
                }
            });
            */
        });
    });
}

/**
 * Инициализация Яндекс.Карты с ресторанами
 * В Bitrix данные будут загружаться из инфоблока
 */
function initRestaurantsMap() {
    // Проверяем, существует ли контейнер для карты
    const mapContainer = document.getElementById('restaurantsMap');
    if (!mapContainer) return;

    // Массив с тестовыми данными ресторанов
    // В Bitrix эти данные будут получены из инфоблока
    const restaurantsData = [
        {
            id: 1,
            name: "Ресторан Пряности Сад",
            address: "ул. Первомайская, 90",
            coordinates: [56.838011, 60.614273],
            cuisine: "russian",
            image: "/img/restaurants/restaurant-1.jpg"
        },
        {
            id: 2,
            name: "Ресторан Времена Года",
            address: "ул. Ленина, 25",
            coordinates: [56.836420, 60.617313],
            cuisine: "european",
            image: "/img/restaurants/restaurant-2.jpg"
        },
        {
            id: 3,
            name: "Ресторан Коммуна",
            address: "ул. Толедова, 18",
            coordinates: [56.833933, 60.621399],
            cuisine: "european",
            image: "/img/restaurants/restaurant-3.jpg"
        },
        {
            id: 4,
            name: "Ресторан Брюгге Клаб",
            address: "ул. Вайнера, 9",
            coordinates: [56.831274, 60.613974],
            cuisine: "asian",
            image: "/img/restaurants/restaurant-4.jpg"
        }
    ];

    // Инициализация Яндекс.Карты
    ymaps.ready(() => {
        // Создаем карту с центром в Екатеринбурге
        const map = new ymaps.Map('restaurantsMap', {
            center: [56.838011, 60.614273], // Координаты центра Екатеринбурга
            zoom: 12,
            controls: ['zoomControl', 'fullscreenControl']
        });

        // Кластеризатор для группировки меток
        const clusterer = new ymaps.Clusterer({
            preset: 'islands#greenClusterIcons',
            groupByCoordinates: false,
            clusterDisableClickZoom: false,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false
        });

        // Массив для меток
        const placemarks = [];

        // Создаем метки для ресторанов
        restaurantsData.forEach(restaurant => {
            const placemark = new ymaps.Placemark(restaurant.coordinates, {
                // Данные для балуна (всплывающей подсказки)
                balloonContentHeader: restaurant.name,
                balloonContentBody: `
                    <div style="display: flex; min-width: 240px;">
                        <div style="flex: 0 0 100px; margin-right: 10px;">
                            <img src="${restaurant.image}" style="width: 100px; height: 70px; object-fit: cover; border-radius: 4px;">
                        </div>
                        <div>
                            <div style="margin-bottom: 5px;">${restaurant.address}</div>
                            <a href="/guests/restaurants/restaurant-${restaurant.id}/" style="color: #2C9644; text-decoration: none;">Подробнее</a>
                        </div>
                    </div>
                `,
                balloonContentFooter: `Категория: ${getCuisineLabel(restaurant.cuisine)}`,
                // Данные для метки
                hintContent: restaurant.name
            }, {
                // Опции метки
                preset: 'islands#greenDotIcon', // Иконка метки
                // Другие опции (можно настроить иконки в зависимости от типа кухни)
                iconColor: getCuisineColor(restaurant.cuisine)
            });

            // Добавляем метку в массив
            placemarks.push(placemark);

            // Добавляем дополнительные данные для фильтрации
            placemark.properties.set('category', restaurant.cuisine);
        });

        // Добавляем метки в кластеризатор
        clusterer.add(placemarks);
        // Добавляем кластеризатор на карту
        map.geoObjects.add(clusterer);

        // Подгоняем карту под все метки
        map.setBounds(clusterer.getBounds(), {
            checkZoomRange: true,
            zoomMargin: 30
        });

        // Сохраняем объекты для последующей фильтрации
        window.restaurantsMap = {
            map: map,
            clusterer: clusterer,
            placemarks: placemarks
        };
    });
}

/**
 * Получение человекочитаемого названия кухни
 */
function getCuisineLabel(cuisine) {
    const labels = {
        'russian': 'Русская кухня',
        'european': 'Европейская кухня',
        'asian': 'Азиатская кухня',
        'fastfood': 'Фастфуд',
        'cafe': 'Кафе'
    };

    return labels[cuisine] || cuisine;
}

/**
 * Получение цвета для метки в зависимости от кухни
 */
function getCuisineColor(cuisine) {
    const colors = {
        'russian': '#2C9644',  // Зеленый
        'european': '#3B5998', // Синий
        'asian': '#D62976',    // Розовый
        'fastfood': '#FF9500', // Оранжевый
        'cafe': '#8A2BE2'      // Фиолетовый
    };

    return colors[cuisine] || '#2C9644'; // Зеленый по умолчанию
}

/**
 * Обновление маркеров на карте при фильтрации
 * Эта функция будет использоваться при AJAX-фильтрации
 */
function updateMapMarkers(category) {
    if (!window.restaurantsMap) return;

    const { clusterer, placemarks } = window.restaurantsMap;

    // Удаляем все метки с карты
    clusterer.removeAll();

    // Фильтруем метки
    const filteredPlacemarks = category === 'all'
        ? placemarks
        : placemarks.filter(placemark => {
            return placemark.properties.get('category') === category;
        });

    // Добавляем отфильтрованные метки обратно в кластеризатор
    clusterer.add(filteredPlacemarks);

    // Если есть метки, подгоняем карту под них
    if (filteredPlacemarks.length > 0) {
        window.restaurantsMap.map.setBounds(clusterer.getBounds(), {
            checkZoomRange: true,
            zoomMargin: 30
        });
    }
}

/**
 * Инициализация пагинации "Показать еще"
 * В Bitrix это будет реализовано через AJAX-загрузку
 */
function initPagination() {
    const moreButton = document.querySelector('.pagination__more-btn');
    if (!moreButton) return;

    moreButton.addEventListener('click', function(e) {
        e.preventDefault();

        // В реальном проекте здесь будет AJAX-запрос для загрузки следующей порции
        // В Bitrix можно использовать компонент bitrix:news.list с настройкой AJAX-пагинации

        // Демонстрационный код для наглядности
        const restaurantsGrid = document.querySelector('.restaurants-grid');

        // Имитация загрузки (в реальном проекте здесь будет AJAX)
        moreButton.textContent = 'Загрузка...';

        setTimeout(() => {
            // Добавляем новые элементы (в реальном проекте будут данные из AJAX-ответа)
            const newHtml = `
                <a href="/guests/restaurants/restaurant-5/" class="restaurant-card" data-category="russian">
                    <div class="restaurant-card__image">
                        <img src="/img/restaurants/restaurant-1.jpg" alt="Ресторан Урал">
                    </div>
                    <div class="restaurant-card__content">
                        <h3 class="restaurant-card__title">Ресторан Урал</h3>
                        <div class="restaurant-card__address">ул. Ленина, 64</div>
                    </div>
                </a>
                <a href="/guests/restaurants/restaurant-6/" class="restaurant-card" data-category="european">
                    <div class="restaurant-card__image">
                        <img src="/img/restaurants/restaurant-2.jpg" alt="Ресторан Особняк">
                    </div>
                    <div class="restaurant-card__content">
                        <h3 class="restaurant-card__title">Ресторан Особняк</h3>
                        <div class="restaurant-card__address">ул. Куйбышева, 42</div>
                    </div>
                </a>
                <a href="/guests/restaurants/restaurant-7/" class="restaurant-card" data-category="asian">
                    <div class="restaurant-card__image">
                        <img src="/img/restaurants/restaurant-3.jpg" alt="Ресторан Азия">
                    </div>
                    <div class="restaurant-card__content">
                        <h3 class="restaurant-card__title">Ресторан Азия</h3>
                        <div class="restaurant-card__address">ул. Малышева, 12</div>
                    </div>
                </a>
                <a href="/guests/restaurants/restaurant-8/" class="restaurant-card" data-category="cafe">
                    <div class="restaurant-card__image">
                        <img src="/img/restaurants/restaurant-4.jpg" alt="Кафе Счастье">
                    </div>
                    <div class="restaurant-card__content">
                        <h3 class="restaurant-card__title">Кафе Счастье</h3>
                        <div class="restaurant-card__address">ул. 8 Марта, 78</div>
                    </div>
                </a>
            `;

            restaurantsGrid.insertAdjacentHTML('beforeend', newHtml);

            // Восстанавливаем текст кнопки
            moreButton.textContent = 'Показать еще';

            // Проверка активного фильтра и применение к новым элементам
            const activeFilter = document.querySelector('.filter-tab.active');
            if (activeFilter && activeFilter.getAttribute('data-filter') !== 'all') {
                const category = activeFilter.getAttribute('data-filter');
                const newCards = restaurantsGrid.querySelectorAll('.restaurant-card:not([style*="display"])');

                newCards.forEach(card => {
                    if (card.getAttribute('data-category') !== category) {
                        card.style.display = 'none';
                    }
                });
            }

            // Скрываем кнопку после второй загрузки (для демонстрации)
            // В реальном проекте это будет зависеть от наличия следующих страниц
            moreButton.style.display = 'none';
        }, 800);
    });
}
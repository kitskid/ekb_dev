// Глобальная функция инициализации карты
function initYandexMap(mapId) {
    // Получаем элемент карты
    var mapElement = document.getElementById(mapId);
    if (!mapElement) return;

    // Получаем параметры из атрибутов данных
    var iblockId = mapElement.getAttribute('data-iblock-id');
    var mapItems = window['mapItems_' + mapId];

    // Инициализация карты ресторанов
    initRestaurantsMap(mapId, mapItems);
}

// Функция инициализации карты ресторанов
function initRestaurantsMap(mapId, mapItems) {
    var myMap = new ymaps.Map(mapId, {
        center: [56.838011, 60.614273], // Центр Екатеринбурга
        zoom: 12,
        controls: ['zoomControl', 'fullscreenControl']
    });

    // Кластеризатор для группировки меток
    var clusterer = new ymaps.Clusterer({
        preset: 'islands#greenClusterIcons',
        groupByCoordinates: false,
        clusterDisableClickZoom: false,
        clusterHideIconOnBalloonOpen: false,
        geoObjectHideIconOnBalloonOpen: false
    });

    var placemarks = [];

    // Создаем метки для всех ресторанов из массива
    if (mapItems && mapItems.length > 0) {
        mapItems.forEach(function(restaurant) {
            var placemark = new ymaps.Placemark(restaurant.coordinates, {
                balloonContentHeader: restaurant.name,
                balloonContentBody: getRestaurantBalloonContent(restaurant),
                balloonContentFooter: getCuisineLabel(restaurant.category),
                hintContent: restaurant.name
            }, {
                preset: 'islands#circleDotIcon',
                iconColor: getCuisineColor(restaurant.category)
            });

            placemark.properties.set('category', restaurant.category);
            placemarks.push(placemark);
        });

        // Добавляем метки в кластеризатор и на карту
        clusterer.add(placemarks);
        myMap.geoObjects.add(clusterer);

        // Автоматически подбираем зум, чтобы вместить все метки
        myMap.setBounds(clusterer.getBounds(), {
            checkZoomRange: true,
            zoomMargin: 30
        });
    }

    // Сохраняем объекты для внешней фильтрации в глобальной переменной с уникальным ID
    window['restaurantsMap_' + mapId] = {
        map: myMap,
        clusterer: clusterer,
        placemarks: placemarks,
        mapId: mapId,
        iblockId: document.getElementById(mapId).getAttribute('data-iblock-id')
    };

    // Привязываем обработчики к фильтрам после инициализации карты
    bindFilterHandlers(mapId);
}

// Привязка обработчиков к фильтрам
function bindFilterHandlers(mapId) {
    document.querySelectorAll('.filter-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            var category = this.getAttribute('data-filter');

            // Вызываем фильтрацию меток
            filterMapRestaurants(mapId, category);

            // Добавляем класс активности
            document.querySelectorAll('.filter-tab').forEach(function(t) {
                t.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
}

// Функция для фильтрации ресторанов на карте
function filterMapRestaurants(mapId, category) {
    var restaurantsMap = window['restaurantsMap_' + mapId];
    if (!restaurantsMap) return;

    var clusterer = restaurantsMap.clusterer;
    var placemarks = restaurantsMap.placemarks;

    // Удаляем все метки с карты
    clusterer.removeAll();

    // Фильтруем метки
    var filteredPlacemarks = category === 'all'
        ? placemarks
        : placemarks.filter(function(placemark) {
            return placemark.properties.get('category') === category;
        });

    // Добавляем отфильтрованные метки обратно в кластеризатор
    clusterer.add(filteredPlacemarks);

    // Если есть метки, подгоняем карту под них
    if (filteredPlacemarks.length > 0) {
        restaurantsMap.map.setBounds(clusterer.getBounds(), {
            checkZoomRange: true,
            zoomMargin: 30
        });
    }
}

// Функция для AJAX-фильтрации меток на карте (если нужно получать данные с сервера)
function filterMapMarkersAjax(mapId, category) {
    var restaurantsMap = window['restaurantsMap_' + mapId];
    if (!restaurantsMap) return;

    var iblockId = restaurantsMap.iblockId;

    // Выполняем AJAX-запрос
    BX.ajax({
        url: '/local/components/custom/map.yandex/ajax.php',
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'getFilteredItems',
            iblockId: iblockId,
            category: category
        },
        onsuccess: function(response) {
            if (response.success) {
                updateMapMarkers(mapId, response.items);
            }
        },
        onfailure: function() {
            console.error('Ошибка при загрузке данных');
        }
    });
}

// Функция обновления маркеров на карте из AJAX-ответа
function updateMapMarkers(mapId, items) {
    var restaurantsMap = window['restaurantsMap_' + mapId];
    if (!restaurantsMap) return;

    var clusterer = restaurantsMap.clusterer;
    clusterer.removeAll();

    var placemarks = [];

    // Создаем новые метки с отфильтрованными данными
    items.forEach(function(item) {
        var placemark = new ymaps.Placemark(item.coordinates, {
            balloonContentHeader: item.name,
            balloonContentBody: getRestaurantBalloonContent(item),
            balloonContentFooter: getCuisineLabel(item.category),
            hintContent: item.name
        }, {
            preset: 'islands#circleDotIcon',
            iconColor: getCuisineColor(item.category)
        });

        placemark.properties.set('category', item.category);
        placemarks.push(placemark);
    });

    // Добавляем отфильтрованные метки на карту
    clusterer.add(placemarks);

    // Если есть метки, подгоняем карту под них
    if (placemarks.length > 0) {
        restaurantsMap.map.setBounds(clusterer.getBounds(), {
            checkZoomRange: true,
            zoomMargin: 30
        });
    }

    // Обновляем массив меток для возможной дальнейшей фильтрации
    restaurantsMap.placemarks = placemarks;
}

// Формирование содержимого балуна для ресторана
function getRestaurantBalloonContent(restaurant) {
    var content = '<div style="display: flex; min-width: 240px;">';

    if (restaurant.image) {
        content += '<div style="flex: 0 0 100px; margin-right: 10px;">' +
            '<img src="' + restaurant.image + '" style="width: 100px; height: 70px; object-fit: cover; border-radius: 4px;">' +
            '</div>';
    }

    content += '<div>';

    if (restaurant.address) {
        content += '<div style="margin-bottom: 5px;">' + restaurant.address + '</div>';
    }

    if (restaurant.url) {
        content += '<a href="' + restaurant.url + '" style="color: #2C9644; text-decoration: none;">Подробнее</a>';
    }

    content += '</div></div>';

    return content;
}

// Получение человекочитаемого названия кухни
function getCuisineLabel(cuisine) {
    var labels = {
        'russian': 'Русская кухня',
        'european': 'Европейская кухня',
        'asian': 'Азиатская кухня',
        'fastfood': 'Фастфуд',
        'cafe': 'Кафе'
    };

    return labels[cuisine] || cuisine;
}

// Получение цвета для метки в зависимости от кухни
function getCuisineColor(cuisine) {
    var colors = {
        'russian': '#2C9644',  // Зеленый
        'european': '#3B5998', // Синий
        'asian': '#D62976',    // Розовый
        'fastfood': '#FF9500', // Оранжевый
        'cafe': '#8A2BE2'      // Фиолетовый
    };

    return colors[cuisine] || '#2C9644'; // Зеленый по умолчанию
}
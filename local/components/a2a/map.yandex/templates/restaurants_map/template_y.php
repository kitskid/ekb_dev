<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$mapId = 'yandexMap_'.rand(1, 100000);

// Установка значений по умолчанию
$mapWidth = isset($arParams["MAP_WIDTH"]) && !empty($arParams["MAP_WIDTH"]) ? $arParams["MAP_WIDTH"] : "100%";
$mapHeight = isset($arParams["MAP_HEIGHT"]) && !empty($arParams["MAP_HEIGHT"]) ? $arParams["MAP_HEIGHT"] : "400px";
$apiKey = isset($arParams["API_KEY"]) ? $arParams["API_KEY"] : "";
?>

<div class="map-container">
    <div id="<?=$mapId?>" class="map" style="width: <?=$mapWidth?>; height: <?=$mapHeight?>;"></div>
</div>

<!--<script src="https://api-maps.yandex.ru/2.1/?apikey=--><?//=$apiKey?><!--&lang=ru_RU"></script>-->
<script>
    // Массив с данными для карты
    var mapItems = <?=CUtil::PhpToJSObject($arResult["MAP_ITEMS"])?>;

    console.log('Map Items:', mapItems);

    ymaps.ready(function() {
        // Создаем карту
        var myMap = new ymaps.Map('<?=$mapId?>', {
            center: [56.838011, 60.614273],
            zoom: 12,
            controls: ['zoomControl', 'fullscreenControl']
        });

        // Создаем макет содержимого балуна
        var customBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div class="custom-balloon-content">' +
            '<div class="custom-balloon-header">$[properties.balloonContentHeader]</div>' +
            '<div class="custom-balloon-body">$[properties.balloonContentBody]</div>' +
            '$[if properties.balloonContentFooter]<div class="custom-balloon-footer">$[properties.balloonContentFooter]</div>$[endif]' +
            '<div class="custom-balloon-close"></div>' +
            '</div>'
        );

        // Кластеризатор для группировки меток
        var clusterer = new ymaps.Clusterer({
            preset: 'islands#greenClusterIcons',
            groupByCoordinates: false,
            clusterDisableClickZoom: false,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false
        });

        var placemarks = [];

        // Создаем метки для всех точек
        if (mapItems && mapItems.length > 0) {
            mapItems.forEach(function(item) {
                // Формируем содержимое балуна
                var balloonContent = getBalloonContent(item);

                // Создаем метку
                var placemark = new ymaps.Placemark(item.coordinates, {
                    // Данные для балуна
                    balloonContentHeader: item.name,
                    balloonContentBody: balloonContent,
                    balloonContentFooter: getCuisineLabel(item.category),
                    hintContent: item.name
                }, {
                    // Настройки метки
                    preset: 'islands#circleDotIcon',
                    iconColor: getCuisineColor(item.category),
                    // Настройки балуна
                    balloonContentLayout: customBalloonContentLayout,
                    balloonPanelMaxMapArea: 0,
                    hideIconOnBalloonOpen: false
                });

                // Сохраняем категорию для фильтрации
                placemark.properties.set('category', item.category);

                // Добавляем метку в массив
                placemarks.push(placemark);
            });

            // Добавляем метки в кластеризатор
            clusterer.add(placemarks);

            // Добавляем кластеризатор на карту
            myMap.geoObjects.add(clusterer);

            // Подгоняем карту под метки
            myMap.setBounds(clusterer.getBounds(), {
                checkZoomRange: true,
                zoomMargin: 30
            });
        }

        // Сохраняем объекты для внешней фильтрации
        window.restaurantsMap = {
            map: myMap,
            clusterer: clusterer,
            placemarks: placemarks
        };

        // Добавляем обработчики для закрытия балуна
        document.addEventListener('click', function(e) {
            if (e.target.closest('.custom-balloon-close')) {
                myMap.balloon.close();
            }
        });

        // Добавляем обработчики фильтров, если они есть на странице
        var filterTabs = document.querySelectorAll('.filter-tab');
        if (filterTabs.length > 0) {
            filterTabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    var category = this.getAttribute('data-filter');
                    filterMapRestaurants(category);

                    // Добавляем класс активности
                    filterTabs.forEach(function(t) {
                        t.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });
        }
    });

    // Форматирование содержимого балуна
    function getBalloonContent(restaurant) {
        var content = '<div class="balloon-content">';

        if (restaurant.image) {
            content += '<div class="balloon-image">' +
                '<img src="' + restaurant.image + '" alt="' + (restaurant.name || '') + '">' +
                '</div>';
        }

        content += '<div class="balloon-info">';

        if (restaurant.address) {
            content += '<div class="balloon-address"><strong>Адрес:</strong> ' + restaurant.address + '</div>';
        }

        if (restaurant.phone) {
            content += '<div class="balloon-phone"><strong>Телефон:</strong> ' + restaurant.phone + '</div>';
        }

        if (restaurant.schedule) {
            content += '<div class="balloon-schedule"><strong>Режим работы:</strong> ' + restaurant.schedule + '</div>';
        }

        // Особенности ресторана
        if (restaurant.features && restaurant.features.length > 0) {
            content += '<div class="balloon-features"><strong>Особенности:</strong> ' + restaurant.features.join(', ') + '</div>';
        }

        content += '<div class="balloon-actions">';
        if (restaurant.url) {
            content += '<a href="' + restaurant.url + '" class="balloon-link">Подробнее</a>';
        }
        content += '</div>';

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

    // Фильтрация ресторанов на карте
    function filterMapRestaurants(category) {
        if (!window.restaurantsMap) return;

        var clusterer = window.restaurantsMap.clusterer;
        var placemarks = window.restaurantsMap.placemarks;

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
            window.restaurantsMap.map.setBounds(clusterer.getBounds(), {
                checkZoomRange: true,
                zoomMargin: 30
            });
        }
    }
</script>

<style>
    /* Стили для карты */
    .map {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Скрываем стандартную кнопку закрытия Яндекс.Карт */
    .ymaps-2-1-79-balloon__close-button,
    [class^="ymaps-"][class$="-balloon__close-button"] {
        display: none !important;
    }

    /* Стили для кастомного содержимого балуна */
    .custom-balloon-content {
        position: relative;
        padding: 15px;
        background: #ffffff;
        border-radius: 8px;
        max-width: 350px;
    }

    .custom-balloon-header {
        font-weight: bold;
        font-size: 16px;
        color: #333;
        margin-bottom: 10px;
        padding-right: 20px; /* Место для крестика */
    }

    .custom-balloon-body {
        margin-bottom: 10px;
    }

    .custom-balloon-footer {
        font-size: 12px;
        color: #777;
        border-top: 1px solid #eee;
        padding-top: 8px;
        margin-top: 5px;
    }

    .custom-balloon-close {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .custom-balloon-close:before,
    .custom-balloon-close:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 2px;
        background: #999;
    }

    .custom-balloon-close:before {
        transform: translateY(-50%) rotate(45deg);
    }

    .custom-balloon-close:after {
        transform: translateY(-50%) rotate(-45deg);
    }

    /* Стили для содержимого балуна */
    .balloon-content {
        display: flex;
        flex-wrap: wrap;
        max-width: 300px;
    }

    .balloon-image {
        flex: 0 0 100px;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .balloon-image img {
        width: 100%;
        height: 70px;
        object-fit: cover;
        border-radius: 4px;
    }

    .balloon-info {
        flex: 1;
        min-width: 150px;
    }

    .balloon-address,
    .balloon-phone,
    .balloon-schedule,
    .balloon-features {
        margin-bottom: 5px;
        font-size: 13px;
        line-height: 1.4;
        word-break: break-word;
    }

    .balloon-actions {
        margin-top: 10px;
    }

    .balloon-link {
        display: inline-block;
        background: #2C9644;
        color: #fff !important;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 12px;
        transition: background 0.2s;
    }

    .balloon-link:hover {
        background: #228037;
        color: #fff !important;
        text-decoration: none;
    }

    /* Стили для балуна в мобильной версии */
    @media (max-width: 480px) {
        .balloon-content {
            flex-direction: column;
        }

        .balloon-image {
            flex: 0 0 auto;
            width: 100%;
            margin-right: 0;
            margin-bottom: 10px;
        }

        .balloon-image img {
            width: 100%;
            height: auto;
            max-height: 120px;
        }
    }

    /* Исправление стилей яндекс балуна */
    .ymaps-2-1-79-balloon,
    [class^="ymaps-"][class$="-balloon"] {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2) !important;
    }

    .ymaps-2-1-79-balloon__content,
    [class^="ymaps-"][class$="-balloon__content"] {
        padding: 0 !important;
        margin: 0 !important;
    }

    .ymaps-2-1-79-balloon__tail,
    [class^="ymaps-"][class$="-balloon__tail"] {
        display: block !important;
    }
</style>

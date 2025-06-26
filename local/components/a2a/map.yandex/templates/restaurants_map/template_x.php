<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$mapId = 'yandexMap_'.rand(1, 100000);

// Установка значений по умолчанию, если параметры не определены
$mapWidth = isset($arParams["MAP_WIDTH"]) && !empty($arParams["MAP_WIDTH"]) ? $arParams["MAP_WIDTH"] : "100%";
$mapHeight = isset($arParams["MAP_HEIGHT"]) && !empty($arParams["MAP_HEIGHT"]) ? $arParams["MAP_HEIGHT"] : "400px";

//echo "<pre>";
//var_dump($arResult["MAP_ITEMS"]);
//echo "</pre>";

//if (empty($arResult["MAP_ITEMS"])) {
//    $arResult["MAP_ITEMS"] = array(
//        array(
//            "name" => "Ресторан 'Прага'",
//            "coordinates" => array(56.838011, 60.614273),
//            "address" => "ул. Ленина, 1, Екатеринбург",
//            "phone" => "+7 (123) 456-78-90",
//            "category" => "russian",
//            "url" => "#"
//        ),
//        array(
//            "name" => "Кафе 'Венеция'",
//            "coordinates" => array(56.844103, 60.603667),
//            "address" => "ул. Пушкина, 10, Екатеринбург",
//            "phone" => "+7 (123) 456-78-91",
//            "category" => "european",
//            "url" => "#"
//        ),
//        array(
//            "name" => "Ресторан 'Токио'",
//            "coordinates" => array(56.830529, 60.621986),
//            "address" => "ул. Малышева, 15, Екатеринбург",
//            "phone" => "+7 (123) 456-78-92",
//            "category" => "asian",
//            "url" => "#"
//        )
//    );
//}

?>

<div class="map-container">
    <div id="<?=$mapId?>" class="map" style="width: <?=$mapWidth?>; height: <?=$mapHeight?>;"></div>
</div>

<script>
    // Массив с данными для карты
    var mapItems = <?=CUtil::PhpToJSObject($arResult["MAP_ITEMS"])?>;

    console.log('mapItems');
    console.log(mapItems);

    ymaps.ready(function() {
        // Создаем карту
        var myMap = new ymaps.Map('<?=$mapId?>', {
            center: [56.838011, 60.614273],
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

        // Создаем собственный макет балуна на основе шаблона
        var customBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div class="custom-balloon">' +
            '<div class="custom-balloon__header">$[properties.balloonContentHeader]</div>' +
            '<div class="custom-balloon__body">$[properties.balloonContentBody]</div>' +
            '$[if properties.balloonContentFooter]' +
            '<div class="custom-balloon__footer">$[properties.balloonContentFooter]</div>' +
            '$[endif]' +
            '<div class="custom-balloon__close" title="Закрыть"></div>' +
            '</div>', {
                // Переопределяем функцию build, чтобы добавить обработчик закрытия
                build: function() {
                    // Вызываем метод build родительского класса
                    customBalloonContentLayout.superclass.build.call(this);

                    // Сохраняем ссылку на DOM-элемент балуна
                    this._$element = this.getParentElement().querySelector('.custom-balloon');

                    // Находим и запоминаем кнопку закрытия
                    this._$closeButton = this._$element.querySelector('.custom-balloon__close');

                    // Добавляем обработчик на кнопку закрытия
                    this._$closeButton.addEventListener('click', this._onCloseClick.bind(this));
                },

                // Метод clear вызывается при разрушении макета
                clear: function() {
                    // Удаляем обработчик
                    this._$closeButton.removeEventListener('click', this._onCloseClick);

                    // Вызываем метод clear родительского класса
                    customBalloonContentLayout.superclass.clear.call(this);
                },

                // Обработчик клика по крестику закрытия
                _onCloseClick: function(e) {
                    e.preventDefault();
                    this.events.fire('userclose');
                }
            }
        );

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
                    hintContent: item.name // Подсказка при наведении
                }, {
                    // Настройки метки
                    preset: 'islands#circleDotIcon',
                    iconColor: getCuisineColor(item.category),
                    // Настройки балуна
                    balloonContentLayout: customBalloonContentLayout,
                    balloonPanelMaxMapArea: 0, // Всегда открывать балун в виде панели
                    balloonMaxWidth: 350,       // Максимальная ширина балуна
                    hideIconOnBalloonOpen: false // Не скрывать иконку при открытии балуна
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

        content += '<div class="balloon-actions">';
        if (restaurant.url) {
            content += '<a href="' + restaurant.url + '" class="balloon-link" target="_blank">Подробнее</a>';
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
    /* Стили для карты и балунов */
    .map {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Стили для балуна */
    .custom-balloon {
        padding: 15px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        position: relative;
        max-width: 350px;
    }

    .custom-balloon__header {
        color: #333;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        padding-right: 20px; /* Место для кнопки закрытия */
    }

    .custom-balloon__body {
        margin-bottom: 10px;
    }

    .custom-balloon__footer {
        color: #777;
        font-size: 12px;
        border-top: 1px solid #eee;
        padding-top: 8px;
        margin-top: 10px;
    }

    .custom-balloon__close {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .custom-balloon__close:before,
    .custom-balloon__close:after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        background: #999;
        top: 50%;
        left: 0;
    }

    .custom-balloon__close:before {
        transform: rotate(45deg);
    }

    .custom-balloon__close:after {
        transform: rotate(-45deg);
    }

    /* Стили для содержимого балуна */
    .balloon-content {
        display: flex;
    }

    .balloon-image {
        flex: 0 0 100px;
        margin-right: 10px;
    }

    .balloon-image img {
        width: 100%;
        height: 70px;
        object-fit: cover;
        border-radius: 4px;
    }

    .balloon-info {
        flex: 1;
    }

    .balloon-address,
    .balloon-phone,
    .balloon-schedule {
        margin-bottom: 5px;
        font-size: 13px;
        line-height: 1.4;
    }

    .balloon-actions {
        margin-top: 10px;
    }

    .balloon-link {
        display: inline-block;
        background: #2C9644;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 12px;
        transition: background 0.2s;
    }

    .balloon-link:hover {
        background: #228037;
    }
</style>


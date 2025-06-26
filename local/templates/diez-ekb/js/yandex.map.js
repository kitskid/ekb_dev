/**
 * Функция для инициализации Яндекс.Карты
 */
function initYandexMap() {
    if (typeof ymaps !== 'undefined' && document.getElementById('yandexMap')) {
        ymaps.ready(function() {
            var mapElement = document.getElementById('yandexMap');
            var iblockId = mapElement.dataset.iblock;
            var iblockType = mapElement.dataset.iblockType;

            // Создаем карту с центром в Екатеринбурге
            var attractionsMap = new ymaps.Map('yandexMap', {
                center: [56.838011, 60.597465],
                zoom: 12,
                controls: ['zoomControl', 'fullscreenControl', 'typeSelector']
            });

            // Если есть данные о достопримечательностях
            if (window.attractionsData && window.attractionsData.length) {
                // Создаем коллекцию меток
                var objectManager = new ymaps.ObjectManager({
                    clusterize: true,
                    gridSize: 32
                });

                // Настройка кластеризации
                objectManager.clusters.options.set({
                    preset: 'islands#blueClusterIcons'
                });

                // Подготавливаем данные для objectManager
                var features = [];
                window.attractionsData.forEach(function(item, index) {
                    if (item.COORDINATES) {
                        var coords = item.COORDINATES.split(',').map(function(coord) {
                            return parseFloat(coord.trim());
                        });

                        if (coords.length === 2) {
                            features.push({
                                type: 'Feature',
                                id: index,
                                geometry: {
                                    type: 'Point',
                                    coordinates: coords
                                },
                                properties: {
                                    hintContent: item.NAME,
                                    balloonContentHeader: item.NAME,
                                    balloonContentBody: (item.ADDRESS ? '<p>Адрес: ' + item.ADDRESS + '</p>' : '') +
                                        '<p><a href="' + item.DETAIL_URL + '">Подробнее</a></p>'
                                }
                            });
                        }
                    }
                });

                objectManager.add({
                    type: 'FeatureCollection',
                    features: features
                });

                attractionsMap.geoObjects.add(objectManager);

                // Устанавливаем оптимальную область показа карты
                if (features.length > 0) {
                    attractionsMap.setBounds(attractionsMap.geoObjects.getBounds(), {
                        checkZoomRange: true,
                        zoomMargin: 30
                    });
                }
            }

            // Сохраняем объект карты в глобальном объекте
            window.attractionsMapObject = attractionsMap;
        });
    }
}

/**
 * Функция для добавления новых точек на карту
 * @param {Array} newPoints - массив новых точек для добавления на карту
 */
function addPointsToYandexMap(newPoints) {
    if (typeof ymaps !== 'undefined' && window.attractionsMapObject && newPoints && newPoints.length) {
        // Получаем существующий ObjectManager
        var objectManager = null;
        window.attractionsMapObject.geoObjects.each(function(obj) {
            if (obj instanceof ymaps.ObjectManager) {
                objectManager = obj;
                return false;
            }
        });

        // Если ObjectManager не найден, создаем новый
        if (!objectManager) {
            objectManager = new ymaps.ObjectManager({
                clusterize: true,
                gridSize: 32
            });

            objectManager.clusters.options.set({
                preset: 'islands#blueClusterIcons'
            });

            window.attractionsMapObject.geoObjects.add(objectManager);
        }

        // Подготавливаем новые точки для добавления
        var features = [];
        var startId = objectManager.objects.getLength();

        newPoints.forEach(function(item, index) {
            if (item.COORDINATES) {
                var coords = item.COORDINATES.split(',').map(function(coord) {
                    return parseFloat(coord.trim());
                });

                if (coords.length === 2) {
                    features.push({
                        type: 'Feature',
                        id: startId + index,
                        geometry: {
                            type: 'Point',
                            coordinates: coords
                        },
                        properties: {
                            hintContent: item.NAME,
                            balloonContentHeader: item.NAME,
                            balloonContentBody: (item.ADDRESS ? '<p>Адрес: ' + item.ADDRESS + '</p>' : '') +
                                '<p><a href="' + item.DETAIL_URL + '">Подробнее</a></p>'
                        }
                    });
                }
            }
        });

        // Добавляем новые точки на карту
        if (features.length > 0) {
            objectManager.add({
                type: 'FeatureCollection',
                features: features
            });
        }
    }
}

// Инициализация карты при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    initYandexMap();

    // Глобальная функция для добавления точек из AJAX-запросов
    window.addPointsToMap = function(newItems) {
        if (newItems && newItems.length) {
            addPointsToYandexMap(newItems);
        }
    };
});

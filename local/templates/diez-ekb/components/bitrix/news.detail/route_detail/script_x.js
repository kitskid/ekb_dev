/**
 * Скрипт для работы с Яндекс Картами на детальной странице маршрута
 */
class RouteMap {
    constructor(options) {
        this.mapContainer = options.mapContainer || 'route-map';
        this.pointsSelector = options.pointsSelector || '.route-point';
        this.isCircular = options.isCircular || false;
        this.routeType = options.routeType || 'pedestrian';
        this.apiKey = options.apiKey || '';

        this.map = null;
        this.routePoints = [];
        this.routeLine = null;

        this.init();
    }

    init() {
        // Проверяем, загружен ли уже API Яндекс Карт
        if (typeof ymaps !== 'undefined') {
            this.initMap();
        } else {
            this.loadYandexMapsAPI();
        }
    }

    loadYandexMapsAPI() {
        const script = document.createElement('script');
        script.src = `https://api-maps.yandex.ru/2.1/?apikey=${this.apiKey}&lang=ru_RU`;
        script.async = true;
        script.onload = () => {
            ymaps.ready(() => this.initMap());
        };
        document.head.appendChild(script);
    }

    initMap() {
        // Создаем карту
        this.map = new ymaps.Map(this.mapContainer, {
            center: [55.76, 37.64], // Начальные координаты
            zoom: 10,
            controls: ['zoomControl', 'fullscreenControl', 'rulerControl']
        });

        // Получаем точки маршрута из HTML
        this.collectPoints();

        // Строим маршрут
        this.buildRoute();

        // Добавляем интерактивность
        this.setupInteractivity();
    }

    collectPoints() {
        const pointElements = document.querySelectorAll(this.pointsSelector);

        pointElements.forEach((point, index) => {
            const lat = parseFloat(point.dataset.lat);
            const lng = parseFloat(point.dataset.lng);

            if (!isNaN(lat) && !isNaN(lng)) {
                const pointData = {
                    element: point,
                    coordinates: [lat, lng],
                    title: point.querySelector('.route-point-title')?.textContent || `Точка ${index + 1}`,
                    number: index + 1
                };

                this.routePoints.push(pointData);

                // Создаем маркер
                this.createMarker(pointData);
            }
        });
    }

    createMarker(pointData) {
        const marker = new ymaps.Placemark(pointData.coordinates, {
            iconContent: pointData.number.toString(),
            balloonContent: pointData.title
        }, {
            preset: 'islands#blueCircleIcon'
        });

        this.map.geoObjects.add(marker);

        // При клике на маркер прокручиваем к соответствующему блоку
        marker.events.add('click', () => {
            pointData.element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        return marker;
    }

    buildRoute() {
        // Если есть точки для построения маршрута
        if (this.routePoints.length > 0) {
            const coordinates = this.routePoints.map(point => point.coordinates);

            // Проверяем, нужно ли замкнуть маршрут
            if (this.isCircular && coordinates.length > 2) {
                // Добавляем первую точку в конец для замкнутого маршрута
                coordinates.push(coordinates[0]);
            }

            // Определяем тип маршрута
            if (this.routeType === "auto" && coordinates.length >= 2) {
                // Для авто-маршрута используем роутинг
                const multiRoute = new ymaps.multiRouter.MultiRoute({
                    referencePoints: coordinates,
                    params: {
                        routingMode: 'auto'
                    }
                }, {
                    boundsAutoApply: true,
                    wayPointStartIconLayout: "default#image",
                    wayPointStartIconImageHref: "/local/templates/.default/images/map-start.png",
                    wayPointFinishIconLayout: "default#image",
                    wayPointFinishIconImageHref: "/local/templates/.default/images/map-finish.png"
                });

                this.map.geoObjects.add(multiRoute);
            } else {
                // Для пешеходных маршрутов просто соединяем точки линиями
                this.routeLine = new ymaps.Polyline(coordinates, {}, {
                    strokeColor: "#1E98FF",
                    strokeWidth: 4,
                    strokeOpacity: 0.7
                });

                this.map.geoObjects.add(this.routeLine);
            }

            // Устанавливаем границы карты, чтобы были видны все точки
            this.map.setBounds(this.map.geoObjects.getBounds(), {
                checkZoomRange: true,
                zoomMargin: 30
            });
        }
    }

    setupInteractivity() {
        // При клике на блок с точкой центрируем карту на этой точке
        this.routePoints.forEach(point => {
            point.element.addEventListener('click', () => {
                this.map.setCenter(point.coordinates, 15);
            });
        });
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация карты
    const mapContainer = document.getElementById('route-map');
    if (mapContainer) {
        const isCircular = mapContainer.dataset.circular === 'true';
        const routeType = mapContainer.dataset.routeType || 'pedestrian';
        const apiKey = mapContainer.dataset.apiKey || '';

        new RouteMap({
            mapContainer: 'route-map',
            pointsSelector: '.route-point',
            isCircular: isCircular,
            routeType: routeType,
            apiKey: apiKey
        });
    }

    // Инициализация галереи, если подключена библиотека Fancybox
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox="gallery"]', {
            // Настройки для фотогалереи
            loop: true,
            buttons: [
                "zoom",
                "slideShow",
                "fullScreen",
                "close"
            ],
            caption: function(instance, item) {
                return item.opts.caption || '';
            }
        });
    }

    // Плавная прокрутка при клике на ссылки внутри страницы
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Анимация появления блоков при прокрутке
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Добавляем наблюдение за секциями
    document.querySelectorAll('.route-description, .route-map-section, .route-points-section, .route-gallery-section, .other-routes-section').forEach(section => {
        section.classList.add('animate-section');
        observer.observe(section);
    });
});

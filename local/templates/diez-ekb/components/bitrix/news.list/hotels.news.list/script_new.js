document.addEventListener('DOMContentLoaded', function() {
    // Инициализация Яндекс.Карты
    initHotelsMap();

    // Обработчик для фильтрации по типам гостиниц
    const filterItems = document.querySelectorAll('.tag--filter');
    filterItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Получаем выбранный тип
            const selectedType = this.getAttribute('data-type');
            const filterContainer = this.closest('.filter');
            const containerId = filterContainer.nextElementSibling.id;

            // Обновляем активный класс у фильтров
            filterItems.forEach(function(filter) {
                filter.classList.remove('active');
            });
            this.classList.add('active');

            // Отправляем AJAX запрос для получения отфильтрованных данных
            loadFilteredHotels(selectedType, containerId);
        });
    });

    // Обработчик для кнопки "Показать больше"
    const loadMoreBtn = document.querySelector('.js-load-more');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const page = parseInt(this.getAttribute('data-page'));
            const maxPage = parseInt(this.getAttribute('data-max-page'));
            const containerId = this.getAttribute('data-container');

            if (page < maxPage) {
                loadMoreHotels(page, containerId);
            }
        });
    }
});

// Функция для загрузки отфильтрованных гостиниц
function loadFilteredHotels(type, containerId) {
    const container = document.getElementById(containerId);

    // Показываем индикатор загрузки
    container.classList.add('loading');

    // Получаем текущий URL и добавляем параметр фильтрации
    const url = new URL(window.location);
    if (type === 'all') {
        url.searchParams.delete('type');
    } else {
        url.searchParams.set('type', type);
    }
    url.searchParams.set('ajax', 'Y');

    // Отправляем AJAX запрос
    fetch(url.toString())
        .then(response => response.text())
        .then(html => {
            // Обновляем содержимое контейнера
            container.innerHTML = html;

            // Обновляем URL без перезагрузки страницы
            const newUrl = new URL(window.location);
            if (type === 'all') {
                newUrl.searchParams.delete('type');
            } else {
                newUrl.searchParams.set('type', type);
            }
            newUrl.searchParams.delete('ajax');

            history.pushState({}, '', newUrl.toString());

            // Удаляем индикатор загрузки
            container.classList.remove('loading');
        })
        .catch(error => {
            console.error('Error loading filtered hotels:', error);
            container.classList.remove('loading');
        });
}

// Функция для подгрузки дополнительных гостиниц
function loadMoreHotels(page, containerId) {
    const container = document.getElementById(containerId);
    const loadMoreBtn = document.querySelector('.js-load-more');

    // Блокируем кнопку на время загрузки
    loadMoreBtn.disabled = true;
    loadMoreBtn.classList.add('loading');

    // Получаем текущий URL и добавляем параметр страницы
    const url = new URL(window.location);
    url.searchParams.set('page', page + 1);
    url.searchParams.set('ajax', 'Y');

    // Отправляем AJAX запрос
    fetch(url.toString())
        .then(response => response.text())
        .then(html => {
            // Добавляем новые элементы в конец списка
            container.insertAdjacentHTML('beforeend', html);

            // Разблокируем кнопку
            loadMoreBtn.disabled = false;
            loadMoreBtn.classList.remove('loading');
        })
        .catch(error => {
            console.error('Error loading more hotels:', error);
            loadMoreBtn.disabled = false;
            loadMoreBtn.classList.remove('loading');
        });
}

// Инициализация карты Яндекс
function initHotelsMap() {
    if (typeof ymaps !== 'undefined' && document.getElementById('hotels-map') && typeof hotelsMapData !== 'undefined') {
        ymaps.ready(function() {
            const map = new ymaps.Map('hotels-map', {
                center: [56.8519, 60.6122], // Центр Екатеринбурга
                zoom: 12,
                controls: ['zoomControl', 'fullscreenControl']
            });

            // Добавляем метки на карту
            hotelsMapData.forEach(function(hotel) {
                const placemark = new ymaps.Placemark(
                    [parseFloat(hotel.LAT), parseFloat(hotel.LON)],
                    {
                        hintContent: hotel.NAME,
                        balloonContent: `<strong>${hotel.NAME}</strong><br>${hotel.ADDRESS || ''}<br><a href="${hotel.DETAIL_URL}">Подробнее</a>`
                    },
                    {
                        preset: 'islands#redDotIcon'
                    }
                );

                map.geoObjects.add(placemark);
            });

            // Устанавливаем границы карты по меткам
            if (hotelsMapData.length > 0) {
                map.setBounds(map.geoObjects.getBounds(), {
                    checkZoomRange: true,
                    zoomMargin: 30
                });
            }
        });
    }
}
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация Яндекс.Карты
    initHotelsMap();

    // Обработчик для фильтрации по типам гостиниц
    const filterItems = document.querySelectorAll('.tag--filter:not(.tag--reset)');
    // filterItems.forEach(function(item) {
    //     item.addEventListener('click', function(e) {
    //         e.preventDefault();
    //
    //         const selectedType = this.getAttribute('data-type');
    //         const filterContainer = this.closest('.filter');
    //         const containerId = filterContainer.nextElementSibling.id;
    //
    //         // Если выбран пункт "Все", сбрасываем все фильтры
    //         if (selectedType === 'all') {
    //             filterItems.forEach(function(filter) {
    //                 if (filter.getAttribute('data-type') !== 'all') {
    //                     filter.classList.remove('active');
    //                 } else {
    //                     filter.classList.add('active');
    //                 }
    //             });
    //
    //             // Отправляем AJAX запрос без фильтров
    //             loadFilteredHotels([], containerId);
    //             return;
    //         }
    //
    //         // Если уже активен - снимаем активность, иначе добавляем
    //         this.classList.toggle('active');
    //
    //         // Снимаем активность с "Все", если выбран другой фильтр
    //         const allFilter = filterContainer.querySelector('.tag--filter[data-type="all"]');
    //         if (allFilter) {
    //             allFilter.classList.remove('active');
    //         }
    //
    //         // Собираем все активные фильтры
    //         const activeFilters = [];
    //         filterContainer.querySelectorAll('.tag--filter.active').forEach(function(activeFilter) {
    //             const type = activeFilter.getAttribute('data-type');
    //             if (type !== 'all') {
    //                 activeFilters.push(type);
    //             }
    //         });
    //
    //         // Если нет активных фильтров, активируем "Все"
    //         if (activeFilters.length === 0 && allFilter) {
    //             allFilter.classList.add('active');
    //         }
    //
    //         // Отправляем AJAX запрос с активными фильтрами
    //         loadFilteredHotels(activeFilters, containerId);
    //
    //         // Показываем или скрываем кнопку сброса фильтров
    //         const resetButton = filterContainer.querySelector('.tag--reset');
    //         if (resetButton) {
    //             resetButton.style.display = activeFilters.length > 0 ? 'inline-flex' : 'none';
    //         } else if (activeFilters.length > 0) {
    //             // Создаем кнопку сброса, если её нет
    //             const newResetButton = document.createElement('a');
    //             newResetButton.className = 'tag tag--filter tag--reset';
    //             newResetButton.setAttribute('href', 'javascript:void(0);');
    //             newResetButton.setAttribute('data-action', 'reset');
    //             newResetButton.innerHTML = '<span>Сбросить фильтры</span>';
    //
    //             newResetButton.addEventListener('click', function() {
    //                 resetFilters(filterContainer, containerId);
    //             });
    //
    //             filterContainer.appendChild(newResetButton);
    //         }
    //     });
    // });
    // Функция для фильтрации по типам гостиниц (упрощенная)
    filterItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            const selectedType = this.getAttribute('data-type');
            const filterContainer = this.closest('.filter');
            const containerId = filterContainer.nextElementSibling.id;

            // Если выбран пункт "Все", сбрасываем все фильтры
            if (selectedType === 'all') {
                filterItems.forEach(function(filter) {
                    if (filter.getAttribute('data-type') !== 'all') {
                        filter.classList.remove('active');
                    } else {
                        filter.classList.add('active');
                    }
                });

                loadFilteredHotels([], containerId);
                return;
            }

            // Переключаем активность текущего фильтра
            this.classList.toggle('active');

            // Снимаем активность с "Все"
            const allFilter = filterContainer.querySelector('.tag--filter[data-type="all"]');
            if (allFilter) {
                allFilter.classList.remove('active');
            }

            // Собираем все активные фильтры
            const activeFilters = [];
            filterContainer.querySelectorAll('.tag--filter.active').forEach(function(activeFilter) {
                const type = activeFilter.getAttribute('data-type');
                if (type !== 'all') {
                    activeFilters.push(type);
                }
            });

            // Если нет активных фильтров, активируем "Все"
            if (activeFilters.length === 0) {
                if (allFilter) {
                    allFilter.classList.add('active');
                }
            }

            // Отправляем AJAX запрос
            loadFilteredHotels(activeFilters, containerId);

            // Управление кнопкой сброса
            const resetButton = filterContainer.querySelector('.tag--reset');
            if (resetButton) {
                resetButton.style.display = activeFilters.length > 0 ? 'inline-flex' : 'none';
            }
        });
    });


    // Обработчик для кнопки сброса фильтров
    const resetButton = document.querySelector('.tag--reset');
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            const filterContainer = this.closest('.filter');
            const containerId = filterContainer.nextElementSibling.id;
            resetFilters(filterContainer, containerId);
        });
    }

    // Обработчик для кнопки "Показать больше"
    const loadMoreBtn = document.querySelector('.js-load-more');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const page = parseInt(this.getAttribute('data-page'));
            const maxPage = parseInt(this.getAttribute('data-max-page'));
            const containerId = this.getAttribute('data-container');

            if (page < maxPage) {
                // Собираем активные фильтры
                const activeFilters = [];
                const filterContainer = document.getElementById(containerId).previousElementSibling;

                filterContainer.querySelectorAll('.tag--filter.active').forEach(function(activeFilter) {
                    const type = activeFilter.getAttribute('data-type');
                    if (type !== 'all') {
                        activeFilters.push(type);
                    }
                });

                loadMoreHotels(page, containerId, activeFilters);
            }
        });
    }
});

// Функция сброса всех фильтров
function resetFilters(filterContainer, containerId) {
    // Снимаем активность со всех фильтров
    filterContainer.querySelectorAll('.tag--filter').forEach(function(filter) {
        if (filter.getAttribute('data-type') === 'all') {
            filter.classList.add('active');
        } else {
            filter.classList.remove('active');
        }
    });

    // Скрываем кнопку сброса
    const resetButton = filterContainer.querySelector('.tag--reset');
    if (resetButton) {
        resetButton.style.display = 'none';
    }

    // Загружаем все элементы без фильтров
    loadFilteredHotels([], containerId);
}

// Функция для загрузки отфильтрованных гостиниц
// Функция для загрузки отфильтрованных гостиниц
function loadFilteredHotels(types, containerId) {
    const container = document.getElementById(containerId);

    // Отладочная информация
    console.log('=== ОТЛАДКА AJAX ЗАПРОСА ===');
    console.log('Выбранные типы:', types);
    console.log('ID контейнера:', containerId);

    // Показываем индикатор загрузки
    container.classList.add('loading');

    // Формируем URL с правильными параметрами для множественных значений
    const url = new URL(window.location);

    // Удаляем существующие параметры фильтрации
    url.searchParams.delete('type');

    // Формируем query string вручную для поддержки множественных параметров type
    let queryParams = [];

    // Сохраняем существующие параметры (кроме type и ajax)
    for (let [key, value] of url.searchParams) {
        if (key !== 'type' && key !== 'ajax') {
            queryParams.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
        }
    }

    // Добавляем множественные параметры type
    if (types && types.length > 0) {
        types.forEach(function(type) {
            queryParams.push('type=' + encodeURIComponent(type));
            console.log('Добавлен параметр type:', type);
        });
    }

    // Добавляем ajax и debug параметры
    queryParams.push('ajax=Y');
    queryParams.push('debug=Y'); // ДОБАВЛЯЕМ DEBUG!

    // Формируем финальный URL
    const finalUrl = url.origin + url.pathname + '?' + queryParams.join('&');

    console.log('Итоговый URL для запроса:', finalUrl);

    // Отправляем AJAX запрос
    fetch(finalUrl)
        .then(response => {
            console.log('Ответ получен, статус:', response.status);
            return response.text();
        })
        .then(html => {
            console.log('HTML получен, длина:', html.length);

            // Ищем отладочную информацию в ответе
            const debugMatch = html.match(/<script>console\.log\("Отладка AJAX запроса:", (.*?)\);<\/script>/);
            if (debugMatch) {
                const debugData = JSON.parse(debugMatch[1]);
                console.log('=== ОТЛАДКА С СЕРВЕРА ===');
                console.log('Данные фильтрации:', debugData);
                console.log('Показывать кнопку "Показать еще":', debugData.showMoreButton);
                console.log('Всего страниц:', debugData.totalPages);
                console.log('Текущая страница:', debugData.currentPage);
            }

            // Обновляем содержимое контейнера
            container.innerHTML = html;

            // Обновляем URL без перезагрузки страницы (без ajax и debug параметров)
            let newQueryParams = [];

            // Сохраняем существующие параметры (кроме type, ajax и debug)
            for (let [key, value] of url.searchParams) {
                if (key !== 'type' && key !== 'ajax' && key !== 'debug') {
                    newQueryParams.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
                }
            }

            // Добавляем множественные параметры type
            if (types && types.length > 0) {
                types.forEach(function(type) {
                    newQueryParams.push('type=' + encodeURIComponent(type));
                });
            }

            const newUrl = url.origin + url.pathname + (newQueryParams.length > 0 ? '?' + newQueryParams.join('&') : '');

            history.pushState({}, '', newUrl);

            // Удаляем индикатор загрузки
            container.classList.remove('loading');
        })
        .catch(error => {
            console.error('Ошибка при загрузке отфильтрованных гостиниц:', error);
            container.classList.remove('loading');
        });
}

// Функция для подгрузки дополнительных гостиниц
function loadMoreHotels(page, containerId, types) {
    const container = document.getElementById(containerId);
    const loadMoreBtn = document.querySelector('.js-load-more');

    // Блокируем кнопку на время загрузки
    loadMoreBtn.disabled = true;
    loadMoreBtn.classList.add('loading');

    // Сохраняем исходный текст кнопки
    const originalButtonText = loadMoreBtn.querySelector('span').textContent;
    loadMoreBtn.querySelector('span').textContent = 'Загрузка...';

    // Формируем URL аналогично loadFilteredHotels
    const url = new URL(window.location);

    let queryParams = [];

    // Сохраняем существующие параметры (кроме type, ajax и page)
    for (let [key, value] of url.searchParams) {
        if (key !== 'type' && key !== 'ajax' && key !== 'page') {
            queryParams.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
        }
    }

    // Добавляем параметр страницы
    queryParams.push('page=' + (page + 1));

    // Добавляем множественные параметры type
    if (types && types.length > 0) {
        types.forEach(function(type) {
            queryParams.push('type=' + encodeURIComponent(type));
        });
    }

    // Добавляем ajax параметр
    queryParams.push('ajax=Y');

    const finalUrl = url.origin + url.pathname + '?' + queryParams.join('&');

    console.log('Загрузка страницы', page + 1, 'URL:', finalUrl);

    // Отправляем AJAX запрос
    fetch(finalUrl)
        .then(response => response.text())
        .then(html => {
            console.log('Получен HTML, длина:', html.length);

            // Добавляем новые элементы в конец списка
            container.insertAdjacentHTML('beforeend', html);

            // Обновляем данные кнопки
            const newPage = page + 1;
            loadMoreBtn.dataset.page = newPage;

            // Проверяем, есть ли еще страницы
            const maxPage = parseInt(loadMoreBtn.dataset.maxPage);
            if (newPage >= maxPage) {
                // Скрываем кнопку, если больше нет страниц
                loadMoreBtn.style.display = 'none';
            } else {
                // Обновляем текст кнопки с количеством оставшихся элементов
                const nextCount = parseInt(loadMoreBtn.dataset.nextCount);
                const remainingText = nextCount > 0 ? ` (${nextCount})` : '';
                loadMoreBtn.querySelector('span').textContent = 'Показать больше' + remainingText;
            }

            // Разблокируем кнопку
            loadMoreBtn.disabled = false;
            loadMoreBtn.classList.remove('loading');
        })
        .catch(error => {
            console.error('Error loading more hotels:', error);
            loadMoreBtn.disabled = false;
            loadMoreBtn.classList.remove('loading');
            loadMoreBtn.querySelector('span').textContent = originalButtonText;
        });
}

// // Инициализация карты Яндекс
// function initHotelsMap() {
//     if (typeof ymaps !== 'undefined' && document.getElementById('hotels-map') && typeof hotelsMapData !== 'undefined') {
//         ymaps.ready(function() {
//             const map = new ymaps.Map('hotels-map', {
//                 center: [56.8519, 60.6122], // Центр Екатеринбурга
//                 zoom: 12,
//                 controls: ['zoomControl', 'fullscreenControl']
//             });
//
//             // Добавляем метки на карту
//             hotelsMapData.forEach(function(hotel) {
//                 const placemark = new ymaps.Placemark(
//                     [parseFloat(hotel.LAT), parseFloat(hotel.LON)],
//                     {
//                         hintContent: hotel.NAME,
//                         balloonContent: `<strong>${hotel.NAME}</strong><br>${hotel.ADDRESS || ''}<br><a href="${hotel.DETAIL_URL}">Подробнее</a>`
//                     },
//                     {
//                         preset: 'islands#redDotIcon'
//                     }
//                 );
//
//                 map.geoObjects.add(placemark);
//             });
//
//             // Устанавливаем границы карты по меткам
//             if (hotelsMapData.length > 0) {
//                 map.setBounds(map.geoObjects.getBounds(), {
//                     checkZoomRange: true,
//                     zoomMargin: 30
//                 });
//             }
//         });
//     }
// }
// Инициализация карты Яндекс
function initHotelsMap() {
    if (typeof ymaps !== 'undefined' && document.getElementById('hotels-map') && typeof hotelsMapData !== 'undefined') {
        ymaps.ready(function() {
            // Дополнительная проверка и сброс стилей контейнера карты
            const mapElement = document.getElementById('hotels-map');
            if (mapElement) {
                // Установка размеров для контейнера карты
                mapElement.style.width = '100%';
                mapElement.style.height = '100%';
            }

            const map = new ymaps.Map('hotels-map', {
                center: [56.8519, 60.6122], // Центр Екатеринбурга
                zoom: 12,
                controls: ['zoomControl', 'fullscreenControl']
            }, {
                // Дополнительные опции для предотвращения смещения
                suppressMapOpenBlock: true,
                yandexMapDisablePoiInteractivity: true
            });

            // Добавляем метки на карту
            hotelsMapData.forEach(function(hotel) {
                if (hotel.LAT && hotel.LON) {
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
                }
            });

            // Устанавливаем границы карты по меткам
            if (hotelsMapData.length > 0) {
                map.setBounds(map.geoObjects.getBounds(), {
                    checkZoomRange: true,
                    zoomMargin: 30
                }).then(function() {
                    // Исправляем проблему смещения контейнера карты после загрузки
                    // Принудительно обновляем размер карты
                    map.container.fitToViewport();
                });
            }

            // Обработчик изменения размера окна
            window.addEventListener('resize', function() {
                // Обновляем размер карты при изменении размера окна
                if (map) {
                    map.container.fitToViewport();
                }
            });
        });
    }
}


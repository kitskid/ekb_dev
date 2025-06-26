document.addEventListener('DOMContentLoaded', function() {
    let currentFilters = {
        city: '',
        month: '',
        tags: ['all']
    };

    // Устанавливаем активные теги из GET параметров при загрузке страницы
    setActiveTagsFromURL();

    // Обработчик для фильтрации по тегам
    const filterItems = document.querySelectorAll('.tags .tag:not(.tag--reset)');

    filterItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            const selectedType = this.getAttribute('data-type');
            const filterContainer = this.closest('.tags');
            const containerId = document.querySelector('.grid[id]').id;

            // Если выбран пункт "Все", сбрасываем все фильтры
            if (selectedType === 'all') {
                filterItems.forEach(function(filter) {
                    if (filter.getAttribute('data-type') !== 'all') {
                        filter.classList.remove('active');
                    } else {
                        filter.classList.add('active');
                    }
                });

                currentFilters.tags = ['all'];
                loadFilteredEvents([], containerId);
                updateResetButton(filterContainer, []);
                return;
            }

            // Переключаем активность текущего фильтра
            this.classList.toggle('active');

            // Снимаем активность с "Все"
            const allFilter = filterContainer.querySelector('.tag[data-type="all"]');
            if (allFilter) {
                allFilter.classList.remove('active');
            }

            // Собираем все активные фильтры
            const activeFilters = [];
            filterContainer.querySelectorAll('.tag.active').forEach(function(activeFilter) {
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
                currentFilters.tags = ['all'];
            } else {
                currentFilters.tags = activeFilters;
            }

            // Отправляем AJAX запрос
            loadFilteredEvents(activeFilters, containerId);

            // Обновляем кнопку сброса
            updateResetButton(filterContainer, activeFilters);
        });
    });

    // Обработчик для выпадающих списков (город и месяц)
    initDropdowns();

    // Обработчик для кнопки сброса фильтров
    const resetButton = document.querySelector('.tag--reset');
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            const filterContainer = this.closest('.tags');
            const containerId = document.querySelector('.grid[id]').id;
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
                const activeFilters = getActiveFilters();
                const selectedCity = getSelectedCity();
                const selectedMonth = getSelectedMonth();

                loadMoreEvents(page, containerId, activeFilters, selectedCity, selectedMonth);
            }
        });
    }

    // Функция для установки активных тегов из URL
    function setActiveTagsFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const tagParams = urlParams.getAll('tag');

        if (tagParams.length > 0) {
            console.log('Найдены теги в URL:', tagParams);

            // Убираем активность с "Все события"
            const allTag = document.querySelector('.tag[data-type="all"]');
            if (allTag) {
                allTag.classList.remove('active');
            }

            // Устанавливаем активные теги
            let foundTags = [];
            tagParams.forEach(tagParam => {
                const tag = document.querySelector(`.tag[data-type="${tagParam}"]`);
                if (tag) {
                    tag.classList.add('active');
                    foundTags.push(tagParam);
                    console.log('Активирован тег:', tagParam);
                }
            });

            // Обновляем currentFilters
            if (foundTags.length > 0) {
                currentFilters.tags = foundTags;

                // Обновляем кнопку сброса
                const filterContainer = document.querySelector('.tags');
                updateResetButton(filterContainer, foundTags);
            }
        }
    }

    // Функция для инициализации выпадающих списков
    function initDropdowns() {
        const dropdowns = document.querySelectorAll('.filter-dropdown');

        dropdowns.forEach(dropdown => {
            const btn = dropdown.querySelector('.filter-btn');
            const content = dropdown.querySelector('.filter-dropdown-content');
            const options = dropdown.querySelectorAll('.filter-option');
            const textElement = dropdown.querySelector('.filter-text');

            btn.addEventListener('click', function(e) {
                e.stopPropagation();

                // Закрываем другие выпадающие списки
                dropdowns.forEach(otherDropdown => {
                    if (otherDropdown !== dropdown) {
                        otherDropdown.classList.remove('open');
                    }
                });

                dropdown.classList.toggle('open');
            });

            options.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.dataset.value;
                    const text = this.textContent;
                    const filterType = btn.dataset.filter;

                    // Обновляем выбранный элемент
                    options.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');

                    // Обновляем текст кнопки
                    textElement.textContent = text;

                    // Обновляем фильтр
                    currentFilters[filterType] = value;

                    // Закрываем выпадающий список
                    dropdown.classList.remove('open');

                    // Применяем фильтрацию
                    const containerId = document.querySelector('.grid[id]').id;
                    const activeFilters = getActiveFilters();
                    const selectedCity = getSelectedCity();
                    const selectedMonth = getSelectedMonth();

                    loadFilteredEvents(activeFilters, containerId, selectedCity, selectedMonth);
                });
            });
        });

        // Закрываем выпадающие списки при клике вне их
        document.addEventListener('click', function() {
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('open');
            });
        });
    }

    // Функция для получения активных фильтров по тегам
    function getActiveFilters() {
        return currentFilters.tags.includes('all') ? [] : currentFilters.tags;
    }

    // Функция для получения выбранного города
    function getSelectedCity() {
        return currentFilters.city;
    }

    // Функция для получения выбранного месяца
    function getSelectedMonth() {
        return currentFilters.month;
    }

    // Функция для обновления кнопки сброса фильтров
    function updateResetButton(filterContainer, activeFilters) {
        let resetButton = filterContainer.querySelector('.tag--reset');

        const hasActiveFilters = activeFilters.length > 0 || currentFilters.city || currentFilters.month;

        if (hasActiveFilters) {
            // Показываем кнопку сброса или создаем её
            if (resetButton) {
                resetButton.style.display = 'inline-flex';
            } else {
                // Создаем кнопку сброса, если её нет
                resetButton = document.createElement('a');
                resetButton.className = 'tag tag--reset';
                resetButton.setAttribute('href', 'javascript:void(0);');
                resetButton.setAttribute('data-action', 'reset');
                resetButton.textContent = 'Сбросить фильтры';

                resetButton.addEventListener('click', function() {
                    const containerId = document.querySelector('.grid[id]').id;
                    resetFilters(filterContainer, containerId);
                });

                filterContainer.appendChild(resetButton);
            }
        } else {
            // Скрываем кнопку сброса
            if (resetButton) {
                resetButton.style.display = 'none';
            }
        }
    }

    // Функция сброса всех фильтров
    function resetFilters(filterContainer, containerId) {
        // Снимаем активность со всех фильтров тегов
        filterContainer.querySelectorAll('.tag').forEach(function(filter) {
            if (filter.getAttribute('data-type') === 'all') {
                filter.classList.add('active');
            } else {
                filter.classList.remove('active');
            }
        });

        // Сбрасываем выпадающие списки
        const dropdowns = document.querySelectorAll('.filter-dropdown');
        dropdowns.forEach(dropdown => {
            const options = dropdown.querySelectorAll('.filter-option');
            const textElement = dropdown.querySelector('.filter-text');
            const filterType = dropdown.querySelector('.filter-btn').dataset.filter;

            options.forEach(opt => opt.classList.remove('selected'));
            options[0].classList.add('selected'); // Выбираем первый элемент ("Все")

            // Обновляем текст кнопки
            if (filterType === 'city') {
                textElement.textContent = 'город проведения';
            } else if (filterType === 'month') {
                textElement.textContent = 'Выбрать месяц';
            }
        });

        // Скрываем кнопку сброса
        const resetButton = filterContainer.querySelector('.tag--reset');
        if (resetButton) {
            resetButton.style.display = 'none';
        }

        // Сбрасываем currentFilters
        currentFilters = {
            city: '',
            month: '',
            tags: ['all']
        };

        // Загружаем все элементы без фильтров
        loadFilteredEvents([], containerId, '', '');

        // Обновляем URL (убираем GET параметры)
        const url = new URL(window.location);
        url.search = '';
        history.pushState({}, '', url.toString());
    }

    // Функция для загрузки отфильтрованных событий
    function loadFilteredEvents(tags, containerId, city = '', month = '') {
        const container = document.getElementById(containerId);

        // Если параметры не переданы, получаем их из currentFilters
        if (!city) city = currentFilters.city;
        if (!month) month = currentFilters.month;

        // Отладочная информация
        console.log('=== ОТЛАДКА AJAX ЗАПРОСА ===');
        console.log('Выбранные теги:', tags);
        console.log('Выбранный город:', city);
        console.log('Выбранный месяц:', month);
        console.log('ID контейнера:', containerId);

        // Показываем индикатор загрузки
        container.classList.add('loading');

        // Формируем URL с правильными параметрами для множественных значений
        const url = new URL(window.location);

        // Удаляем существующие параметры фильтрации
        url.searchParams.delete('tag');
        url.searchParams.delete('city');
        url.searchParams.delete('month');

        // Формируем query string вручную для поддержки множественных параметров tag
        let queryParams = [];

        // Сохраняем существующие параметры (кроме tag, city, month и ajax)
        for (let [key, value] of url.searchParams) {
            if (key !== 'tag' && key !== 'city' && key !== 'month' && key !== 'ajax') {
                queryParams.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
            }
        }

        // Добавляем множественные параметры tag
        if (tags && tags.length > 0) {
            tags.forEach(function(tag) {
                queryParams.push('tag=' + encodeURIComponent(tag));
                console.log('Добавлен параметр tag:', tag);
            });
        }

        // Добавляем параметры города и месяца
        if (city) {
            queryParams.push('city=' + encodeURIComponent(city));
            console.log('Добавлен параметр city:', city);
        }

        if (month) {
            queryParams.push('month=' + encodeURIComponent(month));
            console.log('Добавлен параметр month:', month);
        }

        // Добавляем ajax параметр
        queryParams.push('ajax=Y');

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

                // Обновляем содержимое контейнера
                container.innerHTML = html;

                // Ищем данные пагинации и обновляем кнопку
                const paginationData = container.querySelector('.pagination-data');
                if (paginationData) {
                    updateLoadMoreButton(paginationData);
                }

                // Обновляем URL без перезагрузки страницы (без ajax параметров)
                let newQueryParams = [];

                // Сохраняем существующие параметры (кроме tag, city, month и ajax)
                for (let [key, value] of url.searchParams) {
                    if (key !== 'tag' && key !== 'city' && key !== 'month' && key !== 'ajax') {
                        newQueryParams.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
                    }
                }

                // Добавляем множественные параметры tag
                if (tags && tags.length > 0) {
                    tags.forEach(function(tag) {
                        newQueryParams.push('tag=' + encodeURIComponent(tag));
                    });
                }

                // Добавляем параметры города и месяца
                if (city) {
                    newQueryParams.push('city=' + encodeURIComponent(city));
                }

                if (month) {
                    newQueryParams.push('month=' + encodeURIComponent(month));
                }

                const newUrl = url.origin + url.pathname + (newQueryParams.length > 0 ? '?' + newQueryParams.join('&') : '');

                history.pushState({}, '', newUrl);

                // Удаляем индикатор загрузки
                container.classList.remove('loading');
            })
            .catch(error => {
                console.error('Ошибка при загрузке отфильтрованных событий:', error);
                container.classList.remove('loading');
            });
    }

    // Функция для обновления кнопки "Показать еще"
    function updateLoadMoreButton(dataElement) {
        console.log('Обновляем кнопку "Показать еще"');

        let btn = document.querySelector('.js-load-more');

        if (!btn) {
            console.log('Кнопка не найдена, ищем в родительском контейнере...');
            const eventsContainer = document.querySelector('.blockPosterFilter');
            if (eventsContainer) {
                btn = eventsContainer.querySelector('.js-load-more');
            }
        }

        console.log('Итоговая найденная кнопка:', btn);

        if (btn) {
            const showButton = JSON.parse(dataElement.dataset.showButton);
            console.log('Показать кнопку:', showButton);
            console.log('Данные пагинации:', {
                showButton: showButton,
                currentPage: dataElement.dataset.currentPage,
                maxPage: dataElement.dataset.maxPage,
                nextCount: dataElement.dataset.nextCount,
                remaining: dataElement.dataset.remaining
            });

            if (showButton) {
                btn.style.display = '';
                btn.dataset.page = dataElement.dataset.currentPage;
                btn.dataset.maxPage = dataElement.dataset.maxPage;
                btn.dataset.nextCount = dataElement.dataset.nextCount;

                const nextCount = parseInt(dataElement.dataset.nextCount);
                const remaining = parseInt(dataElement.dataset.remaining);

                // Обновляем текст кнопки
                let newText = 'больше мероприятий';
                if (nextCount > 0) {
                    newText = `больше мероприятий (${nextCount} из ${remaining})`;
                }

                // Полностью пересоздаем содержимое кнопки
                btn.innerHTML = `
                    <span>${newText}</span>
                    <span class="button__icon">
                        <svg>
                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                        </svg>
                    </span>
                `;
            } else {
                console.log('Скрываем кнопку');
                btn.style.display = 'none';
            }
        }
    }

    // Функция для подгрузки дополнительных событий
    function loadMoreEvents(page, containerId, tags, city, month) {
        const container = document.getElementById(containerId);
        const loadMoreBtn = document.querySelector('.js-load-more');

        // Блокируем кнопку на время загрузки
        loadMoreBtn.disabled = true;
        loadMoreBtn.classList.add('loading');

        // Сохраняем исходный текст кнопки
        const originalButtonText = loadMoreBtn.querySelector('span').textContent;
        loadMoreBtn.querySelector('span').textContent = 'Загрузка...';

        // Формируем URL аналогично loadFilteredEvents
        const url = new URL(window.location);

        let queryParams = [];

        // Сохраняем существующие параметры (кроме tag, city, month, ajax и page)
        for (let [key, value] of url.searchParams) {
            if (key !== 'tag' && key !== 'city' && key !== 'month' && key !== 'ajax' && key !== 'page') {
                queryParams.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
            }
        }

        // Добавляем параметр страницы
        queryParams.push('page=' + (page + 1));

        // Добавляем множественные параметры tag
        if (tags && tags.length > 0) {
            tags.forEach(function(tag) {
                queryParams.push('tag=' + encodeURIComponent(tag));
            });
        }

        // Добавляем параметры города и месяца
        if (city) {
            queryParams.push('city=' + encodeURIComponent(city));
        }

        if (month) {
            queryParams.push('month=' + encodeURIComponent(month));
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
                    loadMoreBtn.querySelector('span').textContent = 'больше мероприятий' + remainingText;
                }

                // Разблокируем кнопку
                loadMoreBtn.disabled = false;
                loadMoreBtn.classList.remove('loading');
            })
            .catch(error => {
                console.error('Error loading more events:', error);
                loadMoreBtn.disabled = false;
                loadMoreBtn.classList.remove('loading');
                loadMoreBtn.querySelector('span').textContent = originalButtonText;
            });
    }
});

<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
$this->setFrameMode(true);

if (empty($arResult["ITEMS"])) {
    return;
}

// Подключаем модуль инфоблоков
if (!CModule::IncludeModule("iblock")) return;

// Получаем все города из элементов
$cities = array();
$allTags = array();
$sections = array();

// Получаем разделы
$rsSections = CIBlockSection::GetList(
    array('SORT' => 'ASC'),
    array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ACTIVE' => 'Y'),
    false,
    array('ID', 'NAME')
);

while ($arSection = $rsSections->GetNext()) {
    $sections[$arSection['ID']] = $arSection['NAME'];
    $allTags[] = $arSection['NAME'];
}

// Получаем все элементы для формирования списков городов и тегов
$rsAllItems = CIBlockElement::GetList(
    array(),
    array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ACTIVE' => 'Y'),
    false,
    false,
    array('ID', 'IBLOCK_SECTION_ID')
);

while ($arAllItem = $rsAllItems->GetNext()) {
    // Получаем города
    $rsLocation = CIBlockElement::GetProperty(
        $arParams["IBLOCK_ID"],
        $arAllItem["ID"],
        array(),
        array("CODE" => "LOCATION")
    );
    if ($propLocation = $rsLocation->Fetch()) {
        if (!empty($propLocation["VALUE"])) {
            $cities[] = $propLocation["VALUE"];
        }
    }

    // Получаем теги из свойства
    $rsTags = CIBlockElement::GetProperty(
        $arParams["IBLOCK_ID"],
        $arAllItem["ID"],
        array(),
        array("CODE" => "TAGS")
    );
    while ($propTag = $rsTags->Fetch()) {
        if (!empty($propTag["VALUE_ENUM"])) {
            $allTags[] = $propTag["VALUE_ENUM"];
        }
    }
}

// Убираем дубликаты и сортируем
$cities = array_unique($cities);
sort($cities);
$allTags = array_unique($allTags);
sort($allTags);

// Генерируем список месяцев (+12 месяцев от текущего)
$months = array();
$currentMonth = date('n');
$currentYear = date('Y');

for ($i = 0; $i < 12; $i++) {
    $month = $currentMonth + $i;
    $year = $currentYear;

    if ($month > 12) {
        $month -= 12;
        $year++;
    }

    $monthNames = array(
        1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
        5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
        9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
    );

    $months[] = array(
        'value' => sprintf('%04d-%02d', $year, $month),
        'name' => $monthNames[$month] . ' ' . $year
    );
}

// Уникальный идентификатор для контейнеров
$containerId = "events-list-" . randString(6);
$paginationContainerId = "events-pagination-" . randString(6);
?>

<div class="events-program">
    <div class="container">
        <div class="header-block">
            <h2 class="title">Программа событий</h2>
        </div>

        <!-- Фильтры -->
        <div class="events-filters">
            <!-- Выбор города -->
            <div class="filter-dropdown">
                <button class="filter-btn" data-filter="city">
                    <span class="filter-text">Выберите город</span>
                    <svg class="filter-arrow">
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                    </svg>
                </button>
                <div class="filter-dropdown-content">
                    <div class="filter-option" data-value="">Все города</div>
                    <?php foreach ($cities as $city): ?>
                        <div class="filter-option" data-value="<?=htmlspecialchars($city)?>"><?=htmlspecialchars($city)?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Выбор месяца -->
            <div class="filter-dropdown">
                <button class="filter-btn" data-filter="month">
                    <span class="filter-text">Выберите месяц</span>
                    <svg class="filter-arrow">
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                    </svg>
                </button>
                <div class="filter-dropdown-content">
                    <div class="filter-option" data-value="">Все месяцы</div>
                    <?php foreach ($months as $month): ?>
                        <div class="filter-option" data-value="<?=$month['value']?>"><?=$month['name']?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Теги -->
        <div class="events-tags">
            <button class="tag tag--filter active" data-type="all">Все события</button>
            <?php foreach ($allTags as $tag): ?>
                <button class="tag tag--filter" data-type="<?=htmlspecialchars($tag)?>"><?=htmlspecialchars($tag)?></button>
            <?php endforeach; ?>
        </div>

        <!-- Список событий -->
        <div class="events-list" id="<?=$containerId?>">
            <?php foreach($arResult["ITEMS"] as $arItem): ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                $title = $arItem["~NAME"];
                $detailUrl = !empty($arItem["DETAIL_PAGE_URL"]) ? $arItem["DETAIL_PAGE_URL"] : "#";

                // Получаем картинку
                $imgSrc = "/local/templates/diez-ekb/assets/images/no-image.jpg";
                if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
                    $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
                }

                // Получаем дату события
                $eventDate = "";
                if (!empty($arItem["PROPERTIES"]["DATETIME"]["VALUE"])) {
                    $eventDate = FormatDate("d.m.Y", MakeTimeStamp($arItem["PROPERTIES"]["DATETIME"]["VALUE"]));
                }

                // Получаем город
                $eventCity = "";
                if (!empty($arItem["PROPERTIES"]["LOCATION"]["VALUE"])) {
                    $eventCity = $arItem["PROPERTIES"]["LOCATION"]["VALUE"];
                }

                // Получаем теги элемента
                $itemTags = array();
                if (!empty($arItem["IBLOCK_SECTION_ID"]) && isset($sections[$arItem["IBLOCK_SECTION_ID"]])) {
                    $itemTags[] = $sections[$arItem["IBLOCK_SECTION_ID"]];
                }
                if (!empty($arItem["PROPERTIES"]["TAGS"]["VALUE"])) {
                    if (is_array($arItem["PROPERTIES"]["TAGS"]["VALUE"])) {
                        $itemTags = array_merge($itemTags, $arItem["PROPERTIES"]["TAGS"]["VALUE"]);
                    } else {
                        $itemTags[] = $arItem["PROPERTIES"]["TAGS"]["VALUE"];
                    }
                }

                // Формируем строку с тегами для фильтрации
                $tagsString = implode(',', $itemTags);

                // Формируем месяц для фильтрации
                $eventMonth = "";
                if (!empty($arItem["PROPERTIES"]["DATETIME"]["VALUE"])) {
                    $eventMonth = date('Y-m', MakeTimeStamp($arItem["PROPERTIES"]["DATETIME"]["VALUE"]));
                }
                ?>
                <div class="event-item"
                     data-city="<?=htmlspecialchars($eventCity)?>"
                     data-month="<?=$eventMonth?>"
                     data-tags="<?=htmlspecialchars($tagsString)?>"
                     id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <a href="<?=$detailUrl?>" class="event-card">
                        <div class="event-image">
                            <img src="<?=$imgSrc?>" alt="<?=htmlspecialchars($title)?>">
                        </div>
                        <div class="event-info">
                            <div class="event-meta">
                                <?php if (!empty($eventDate)): ?>
                                    <span class="event-date"><?=$eventDate?></span>
                                <?php endif; ?>
                                <?php if (!empty($eventCity)): ?>
                                    <span class="event-city"><?=htmlspecialchars($eventCity)?></span>
                                <?php endif; ?>
                            </div>
                            <h3 class="event-title"><?=htmlspecialchars($title)?></h3>
                            <?php if (!empty($arItem["~PREVIEW_TEXT"])): ?>
                                <p class="event-description"><?=$arItem["~PREVIEW_TEXT"]?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Кнопка "Показать больше" -->
        <div class="events-pagination" id="<?=$paginationContainerId?>">
            <?php if (count($arResult["ITEMS"]) >= intval($arParams["NEWS_COUNT"])): ?>
                <button class="button js-load-more"
                        data-page="1"
                        data-container="<?=$containerId?>"
                        data-pagination-container="<?=$paginationContainerId?>">
                    <span>Показать больше мероприятий</span>
                    <span class="button__icon">
                        <svg>
                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                        </svg>
                    </span>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .events-program {
        padding: 50px 0;
    }

    .events-filters {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .filter-dropdown {
        position: relative;
        min-width: 200px;
    }

    .filter-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 12px 16px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        border-color: #008cd2;
    }

    .filter-btn.active {
        border-color: #008cd2;
        background: #f0f8ff;
    }

    .filter-arrow {
        width: 12px;
        height: 12px;
        transition: transform 0.3s ease;
    }

    .filter-dropdown.open .filter-arrow {
        transform: rotate(180deg);
    }

    .filter-dropdown-content {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 10;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }

    .filter-dropdown.open .filter-dropdown-content {
        display: block;
    }

    .filter-option {
        padding: 12px 16px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s ease;
    }

    .filter-option:hover {
        background: #f5f5f5;
    }

    .filter-option.selected {
        background: #008cd2;
        color: #fff;
    }

    .events-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 40px;
    }

    .tag {
        padding: 8px 16px;
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .tag:hover {
        border-color: #008cd2;
    }

    .tag.active {
        background: #008cd2;
        color: #fff;
        border-color: #008cd2;
    }

    .events-list {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    .event-item {
        transition: opacity 0.3s ease;
    }

    .event-item.hidden {
        display: none;
    }

    .event-card {
        display: block;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .event-card:hover {
        transform: translateY(-5px);
    }

    .event-image {
        height: 200px;
        overflow: hidden;
    }

    .event-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .event-info {
        padding: 20px;
    }

    .event-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
        font-size: 12px;
        color: #666;
    }

    .event-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .event-description {
        font-size: 14px;
        color: #666;
        line-height: 1.4;
    }

    .events-pagination {
        text-align: center;
    }

    @media (max-width: 768px) {
        .events-list {
            grid-template-columns: 1fr;
        }

        .events-filters {
            flex-direction: column;
        }

        .filter-dropdown {
            min-width: auto;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentFilters = {
            city: '',
            month: '',
            tags: ['all']
        };

        // Инициализация выпадающих списков
        initDropdowns();

        // Инициализация тегов
        initTags();

        // Инициализация кнопки "Показать больше"
        initLoadMore();

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
                        applyFilters();
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

        function initTags() {
            const tags = document.querySelectorAll('.tag--filter');

            tags.forEach(tag => {
                tag.addEventListener('click', function() {
                    const tagType = this.dataset.type;

                    if (tagType === 'all') {
                        // Сброс всех тегов
                        tags.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        currentFilters.tags = ['all'];
                    } else {
                        // Убираем "Все события"
                        const allTag = document.querySelector('.tag--filter[data-type="all"]');
                        if (allTag) allTag.classList.remove('active');

                        // Переключаем текущий тег
                        this.classList.toggle('active');

                        // Собираем активные теги
                        const activeTags = [];
                        document.querySelectorAll('.tag--filter.active').forEach(activeTag => {
                            const type = activeTag.dataset.type;
                            if (type !== 'all') {
                                activeTags.push(type);
                            }
                        });

                        // Если нет активных тегов, активируем "Все"
                        if (activeTags.length === 0 && allTag) {
                            allTag.classList.add('active');
                            currentFilters.tags = ['all'];
                        } else {
                            currentFilters.tags = activeTags;
                        }
                    }

                    applyFilters();
                });
            });
        }

        function applyFilters() {
            const events = document.querySelectorAll('.event-item');

            events.forEach(event => {
                let shouldShow = true;

                // Фильтр по городу
                if (currentFilters.city && event.dataset.city !== currentFilters.city) {
                    shouldShow = false;
                }

                // Фильтр по месяцу
                if (currentFilters.month && event.dataset.month !== currentFilters.month) {
                    shouldShow = false;
                }

                // Фильтр по тегам
                if (!currentFilters.tags.includes('all')) {
                    const eventTags = event.dataset.tags.split(',');
                    const hasMatchingTag = currentFilters.tags.some(tag =>
                        eventTags.some(eventTag => eventTag.trim() === tag)
                    );
                    if (!hasMatchingTag) {
                        shouldShow = false;
                    }
                }

                // Показываем/скрываем событие
                if (shouldShow) {
                    event.classList.remove('hidden');
                } else {
                    event.classList.add('hidden');
                }
            });

            // Обновляем кнопку "Показать больше"
            updateLoadMoreButton();
        }

        function initLoadMore() {
            const loadMoreBtn = document.querySelector('.js-load-more');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    loadMoreEvents();
                });
            }
        }

        function loadMoreEvents() {
            const loadMoreBtn = document.querySelector('.js-load-more');
            if (!loadMoreBtn) return;

            const page = parseInt(loadMoreBtn.dataset.page) + 1;
            const containerId = loadMoreBtn.dataset.container;

            // Здесь должен быть AJAX-запрос для загрузки дополнительных событий
            // Аналогично реализации для гостиниц

            loadMoreBtn.disabled = true;
            loadMoreBtn.querySelector('span').textContent = 'Загрузка...';

            // Пример AJAX-запроса (нужно адаптировать под ваши нужды)
            const url = new URL(window.location);
            url.searchParams.set('page', page);
            url.searchParams.set('ajax', 'Y');

            // Добавляем текущие фильтры в запрос
            if (currentFilters.city) url.searchParams.set('city', currentFilters.city);
            if (currentFilters.month) url.searchParams.set('month', currentFilters.month);
            if (!currentFilters.tags.includes('all')) {
                currentFilters.tags.forEach(tag => url.searchParams.append('tag', tag));
            }

            fetch(url.toString())
                .then(response => response.text())
                .then(html => {
                    const container = document.getElementById(containerId);
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;

                    // Удаляем script теги
                    tempDiv.querySelectorAll('script').forEach(s => s.remove());

                    // Добавляем новые элементы
                    container.insertAdjacentHTML('beforeend', tempDiv.innerHTML);

                    // Обновляем кнопку
                    loadMoreBtn.dataset.page = page;
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.querySelector('span').textContent = 'Показать больше мероприятий';

                    // Применяем текущие фильтры к новым элементам
                    applyFilters();
                })
                .catch(error => {
                    console.error('Ошибка загрузки:', error);
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.querySelector('span').textContent = 'Показать больше мероприятий';
                });
        }

        function updateLoadMoreButton() {
            const loadMoreBtn = document.querySelector('.js-load-more');
            const visibleEvents = document.querySelectorAll('.event-item:not(.hidden)');
            const totalEvents = document.querySelectorAll('.event-item');

            if (loadMoreBtn) {
                // Показываем кнопку только если есть скрытые события
                if (visibleEvents.length < totalEvents.length) {
                    loadMoreBtn.style.display = 'block';
                } else {
                    loadMoreBtn.style.display = 'none';
                }
            }
        }
    });
</script>
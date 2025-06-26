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

<main class="main">
    <section class="section section--intro" style="--background: url('/local/templates/diez-ekb/assets/images/main-bg-5.png')">
        <div class="container">
            <div class="intro">
                <h1 class="title title--light">
                    афиша актуальных событий екатеринбурга
                </h1>
                <p class="subtitle">
                    Юбилейный год будет наполнен событиями. Все мероприятия 300-летия любимого города— в нашей Афише.
                </p>
                <a href="#" class="button js-suggest-event">предложить событие</a>
            </div>
        </div>
    </section>

    <section class="section section--gray pt-87 ptm-66 pb-94 pbm-120 blockPosterFilter">
        <div class="container">
            <div class="grid mb-50 mbm-40">
                <h2 class="title grid__item--5 grid__item-mob--4">Программа событий</h2>
                <div class="grid__item--7 blockPosterFilter__btns">
                    <!-- Выбор города -->
                    <div class="filter-dropdown">
                        <button class="button button--invert filter-btn" data-filter="city">
                            <span class="filter-text">город проведения</span>
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
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
                        <button class="button filter-btn" data-filter="month">
                            <span class="filter-text">Выбрать месяц</span>
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date-2"></use>
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
                <div class="tags tags--purple grid__item--12 grid__item-mob--4">
                    <a href="#" class="tag active" data-type="all">Все события</a>
                    <?php foreach ($allTags as $tag): ?>
                        <a href="#" class="tag" data-type="<?=htmlspecialchars($tag)?>"><?=htmlspecialchars($tag)?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Сетка событий -->
            <div class="grid" id="<?=$containerId?>">
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
                    $eventDateTime = "";
                    if (!empty($arItem["PROPERTIES"]["DATETIME"]["VALUE"])) {
                        $eventDate = FormatDate("d.m.Y", MakeTimeStamp($arItem["PROPERTIES"]["DATETIME"]["VALUE"]));
                        $eventDateTime = date("Y.m.d", MakeTimeStamp($arItem["PROPERTIES"]["DATETIME"]["VALUE"]));
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

                    // Определяем тип события и цветовую схему
                    $eventType = "";
                    $colorClass = "article-news--yellow"; // по умолчанию

                    // Берем тип из раздела
                    if (!empty($arItem["IBLOCK_SECTION_ID"]) && isset($sections[$arItem["IBLOCK_SECTION_ID"]])) {
                        $eventType = $sections[$arItem["IBLOCK_SECTION_ID"]];
                    }

                    // Или из первого тега
                    if (!$eventType && !empty($itemTags)) {
                        $eventType = $itemTags[0];
                    }

                    // Цветовые схемы по типам
                    $colorSchemes = array(
                        "Концерт" => "article-news--yellow",
                        "Фестиваль" => "article-news--green",
                        "Выставка" => "article-news--blue",
                        "Спектакль" => "article-news--purple",
                        "Спорт" => "article-news--red",
                        "Концерты" => "article-news--yellow",
                        "Фестивали" => "article-news--green",
                        "Выставки" => "article-news--blue",
                        "Спектакли" => "article-news--purple",
                    );

                    if (isset($colorSchemes[$eventType])) {
                        $colorClass = $colorSchemes[$eventType];
                    }

                    // Проверяем, есть ли в названии или тегах слова "топ", "популярный" и т.д.
                    $isTop = false;
                    $checkTopWords = array("топ", "популярный", "рекомендуем", "хит");
                    $searchText = mb_strtolower($title . " " . implode(" ", $itemTags));
                    foreach ($checkTopWords as $word) {
                        if (strpos($searchText, $word) !== false) {
                            $isTop = true;
                            break;
                        }
                    }
                    ?>
                    <a href="<?=$detailUrl?>"
                       class="article-news grid__item--4 grid__item-mob--4 <?=$colorClass?> event-item"
                       data-city="<?=htmlspecialchars($eventCity)?>"
                       data-month="<?=$eventMonth?>"
                       data-tags="<?=htmlspecialchars($tagsString)?>"
                       id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <span class="article-news__badges">
                            <?php if ($isTop): ?>
                                <span class="badge">топ!</span>
                            <?php endif; ?>
                        </span>
                        <picture class="article-news__picture">
                            <img src="<?=$imgSrc?>" alt="<?=htmlspecialchars($title)?>">
                        </picture>
                        <div class="article-news__info">
                            <div class="article-news__header">
                                <?php if ($eventType): ?>
                                    <p class="article-news__tag"><?=htmlspecialchars($eventType)?></p>
                                <?php endif; ?>
                                <?php if ($eventDate): ?>
                                    <time class="article-news__time" datetime="<?=$eventDateTime?>"><?=$eventDate?></time>
                                <?php endif; ?>
                            </div>
                            <h2 class="article-news__title">
                                <?=htmlspecialchars($title)?>
                            </h2>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Кнопка "Показать больше" -->
            <button class="button button--down blockPosterFilter__more-btn button--mob-wide js-load-more"
                    data-page="1"
                    data-container="<?=$containerId?>"
                    data-pagination-container="<?=$paginationContainerId?>"
                    style="<?=count($arResult["ITEMS"]) < intval($arParams["NEWS_COUNT"]) ? 'display:none;' : ''?>">
                <span>больше мероприятий</span>
                <span class="button__icon">
                    <svg>
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                    </svg>
                </span>
            </button>
        </div>
<!--        <div class="decor">-->
<!--            <img style="--top: 7%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/circle-3.svg" alt="">-->
<!--            <img style="--top: 94%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/line-1.svg" alt="">-->
<!--            <img style="--top: 86%; --left: 94.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-4.svg" alt="">-->
<!--        </div>-->
    </section>
</main>

<!-- Вся логика фильтрации и подгрузки из старого template.php -->
<style>
    .filter-dropdown {
        position: relative;
        display: inline-block;
    }

    .filter-dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        top: 100%;
        left: 0;
        border-radius: 8px;
        overflow: hidden;
    }

    .filter-dropdown.open .filter-dropdown-content {
        display: block;
    }

    .filter-option {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        cursor: pointer;
    }

    .filter-option:hover {
        background-color: #f1f1f1;
    }

    .filter-option.selected {
        background-color: #008cd2;
        color: white;
    }

    .event-item.hidden {
        display: none !important;
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
            const tags = document.querySelectorAll('.tags .tag');

            tags.forEach(tag => {
                tag.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tagType = this.dataset.type;

                    if (tagType === 'all') {
                        // Сброс всех тегов
                        tags.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        currentFilters.tags = ['all'];
                    } else {
                        // Убираем "Все события"
                        const allTag = document.querySelector('.tag[data-type="all"]');
                        if (allTag) allTag.classList.remove('active');

                        // Переключаем текущий тег
                        this.classList.toggle('active');

                        // Собираем активные теги
                        const activeTags = [];
                        document.querySelectorAll('.tag.active').forEach(activeTag => {
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

            loadMoreBtn.disabled = true;
            loadMoreBtn.querySelector('span').textContent = 'Загрузка...';

            // AJAX-запрос для загрузки дополнительных событий
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
                    const newEvents = tempDiv.querySelectorAll('.event-item');
                    newEvents.forEach(event => {
                        container.appendChild(event);
                    });

                    // Обновляем кнопку
                    loadMoreBtn.dataset.page = page;
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.querySelector('span').textContent = 'больше мероприятий';

                    // Применяем текущие фильтры к новым элементам
                    applyFilters();
                })
                .catch(error => {
                    console.error('Ошибка загрузки:', error);
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.querySelector('span').textContent = 'больше мероприятий';
                });
        }

        function updateLoadMoreButton() {
            const loadMoreBtn = document.querySelector('.js-load-more');
            const visibleEvents = document.querySelectorAll('.event-item:not(.hidden)');
            const totalEvents = document.querySelectorAll('.event-item');

            if (loadMoreBtn) {
                // Показываем кнопку только если есть скрытые события
                if (visibleEvents.length < totalEvents.length) {
                    loadMoreBtn.style.display = 'inline-flex';
                } else {
                    loadMoreBtn.style.display = 'none';
                }
            }
        }
    });
</script>
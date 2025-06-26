<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

// Подключаем модуль инфоблоков, если еще не подключен
if(!CModule::IncludeModule("iblock"))
    return;

// Получаем список разделов инфоблока с ID=21
$activeSections = array();
$sectionsById = array();
$sectionsWithElements = array();

// Получаем разделы инфоблока
$arFilter = array('IBLOCK_ID' => 23, 'ACTIVE' => 'Y');
$rsSections = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilter, true, array('ID', 'NAME', 'CODE'));

while($arSection = $rsSections->GetNext()) {

    $activeElements = CIBlockSection::GetSectionElementsCount($arSection['ID'], Array("CNT_ACTIVE"=>"Y"));
    echo $activeElements;
    // Проверяем наличие элементов в разделе
    if($activeElements > 0) {
        $sectionsWithElements[] = $arSection['ID'];
    }
}

// Проверяем, есть ли в элементах компонента разделы из нашего списка
$usedSections = array();

foreach($arResult["ITEMS"] as $arItem) {
    if(isset($arItem["IBLOCK_SECTION_ID"]) && in_array($arItem["IBLOCK_SECTION_ID"], $sectionsWithElements)) {
        $usedSections[$arItem["IBLOCK_SECTION_ID"]] = $arItem["IBLOCK_SECTION_ID"];
    }
}

// Фильтруем разделы, оставляя только те, которые используются в текущей выборке элементов
foreach($activeSections as $sectionId => $sectionName) {
    if(!isset($usedSections[$sectionId])) {
        unset($activeSections[$sectionId]);
        unset($sectionsById[$sectionId]);
    }
}
?>

<style>
    .top-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #4CAF50; /* Зеленый цвет */
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: bold;
        border-radius: 8px; /* Закругленные края */
        z-index: 1;
    }

    .event-card {
        position: relative;
    }

    /* Стили для блока "Афиша" с фильтрами */
    .events-container {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        margin-bottom: 30px;
    }

    .events-filter-block {
        width: 28%;
        padding-right: 2%;
    }

    .events-filter-title {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .events-filter-description {
        margin-bottom: 25px;
        line-height: 1.5;
        color: #333;
    }

    .events-filter-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-button {
        padding: 10px 20px;
        background-color: #fff;
        color: #008cd2;
        border: 1px solid #e0e0e0;
        border-radius: 100px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .filter-button.active {
        background-color: #008cd2;
        color: #fff;
    }

    .filter-button:hover:not(.active) {
        border-color: #008cd2;
    }

    .events-slider-block {
        width: 70%;
    }

    /* Адаптивность для мобильных устройств */
    @media (max-width: 768px) {
        .events-filter-block, .events-slider-block {
            width: 100%;
        }

        .events-filter-block {
            margin-bottom: 20px;
        }
    }

    .events-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .event-card {
        transition: opacity 0.3s ease;
    }

    .event-card.hidden {
        display: none;
    }

    /* Стили для мобильного слайдера */
    .mobile-swiper {
        display: none;
    }

    @media (max-width: 768px) {
        .events-grid {
            display: none;
        }

        .mobile-swiper {
            display: block;
        }

        .swiper-slide.hidden {
            display: none;
        }
    }
</style>

<div class="events-container">
    <!-- Блок с описанием и фильтрами -->
    <div class="events-filter-block">
        <h2 class="events-filter-title">АФИША</h2>
        <div class="events-filter-description">
            В год 300-летия Екатеринбург с особым размахом проведёт полюбившиеся многим и известные на весь мир флагманские мероприятия города, а также новые уникальные события.
        </div>
        <div class="events-filter-buttons">
            <button class="filter-button active" data-filter="all">ВСЕ СОБЫТИЯ</button>
            <?php if(!empty($activeSections)): ?>
                <?php foreach($activeSections as $sectionId => $sectionName): ?>
                    <button class="filter-button" data-filter="<?=$sectionsById[$sectionId]?>"><?=$sectionName?></button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Блок со слайдером/сеткой событий -->
    <div class="events-slider-block">
        <div class="events-grid">
            <?php foreach($arResult["ITEMS"] as $arItem): ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                // Получаем изображение
                $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/event-placeholder.jpg";

                // Получаем дату и время мероприятия из свойства DATETIME
                $eventDateTime = !empty($arItem["PROPERTIES"]["DATETIME"]["VALUE"])
                    ? $arItem["PROPERTIES"]["DATETIME"]["VALUE"]
                    : $arItem["ACTIVE_FROM"];

                // Проверяем наличие свойства TOP со значением yes_top_posters
                $isTopItem = false;
                if (isset($arItem["PROPERTIES"]["TOP"]) &&
                    $arItem["PROPERTIES"]["TOP"]["VALUE_XML_ID"] == "yes_top_posters") {
                    $isTopItem = true;
                }

                // Получаем ID раздела элемента для фильтрации
                $sectionId = $arItem["IBLOCK_SECTION_ID"];
                $sectionCode = isset($sectionsById[$sectionId]) ? $sectionsById[$sectionId] : "other";
                ?>

                <div class="event-card" id="<?=$this->GetEditAreaId($arItem['ID']);?>" data-section="<?=$sectionCode?>">
                    <?php if($isTopItem): ?>
                        <div class="top-badge">ТОП!</div>
                    <?php endif; ?>
                    <img src="<?=$imgSrc?>" alt="<?=$arItem["NAME"]?>" class="event-img">
                    <div class="event-content">
                        <div class="event-date"><?=$eventDateTime?></div>
                        <h3 class="event-title"><?=$arItem["NAME"]?></h3>
                        <?php if(!empty($arItem["PREVIEW_TEXT"])): ?>
                            <p><?=$arItem["PREVIEW_TEXT"]?></p>
                        <?php endif; ?>
                        <?php if(!empty($arItem["PROPERTIES"]["EVENT_PLACE"]["VALUE"])): ?>
                            <p class="event-place"><strong>Место:</strong> <?=$arItem["PROPERTIES"]["EVENT_PLACE"]["VALUE"]?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Версия для мобильных устройств -->
        <div class="mobile-swiper events-mobile-swiper">
            <div class="swiper-wrapper">
                <?php foreach($arResult["ITEMS"] as $arItem): ?>
                    <?php
                    // Получаем изображение
                    $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/event-placeholder.jpg";

                    // Получаем дату и время мероприятия из свойства DATETIME
                    $eventDateTime = !empty($arItem["PROPERTIES"]["DATETIME"]["VALUE"])
                        ? $arItem["PROPERTIES"]["DATETIME"]["VALUE"]
                        : $arItem["ACTIVE_FROM"];

                    // Проверяем наличие свойства TOP со значением yes_top_posters
                    $isTopItem = false;
                    if (isset($arItem["PROPERTIES"]["TOP"]) &&
                        $arItem["PROPERTIES"]["TOP"]["VALUE_XML_ID"] == "yes_top_posters") {
                        $isTopItem = true;
                    }

                    // Получаем ID раздела элемента для фильтрации
                    $sectionId = $arItem["IBLOCK_SECTION_ID"];
                    $sectionCode = isset($sectionsById[$sectionId]) ? $sectionsById[$sectionId] : "other";
                    ?>

                    <div class="swiper-slide" data-section="<?=$sectionCode?>">
                        <div class="event-card">
                            <?php if($isTopItem): ?>
                                <div class="top-badge">ТОП!</div>
                            <?php endif; ?>
                            <img src="<?=$imgSrc?>" alt="<?=$arItem["NAME"]?>" class="event-img">
                            <div class="event-content">
                                <div class="event-date"><?=$eventDateTime?></div>
                                <h3 class="event-title"><?=$arItem["NAME"]?></h3>
                                <?php if(!empty($arItem["PREVIEW_TEXT"])): ?>
                                    <p><?=$arItem["PREVIEW_TEXT"]?></p>
                                <?php endif; ?>
                                <?php if(!empty($arItem["PROPERTIES"]["EVENT_PLACE"]["VALUE"])): ?>
                                    <p class="event-place"><strong>Место:</strong> <?=$arItem["PROPERTIES"]["EVENT_PLACE"]["VALUE"]?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация Swiper для мобильной версии (если используется)
        if (document.querySelector('.events-mobile-swiper')) {
            var swiper = new Swiper('.events-mobile-swiper', {
                slidesPerView: 1,
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            });
        }

        // Функция фильтрации элементов
        function filterItems(filter) {
            var desktopItems = document.querySelectorAll('.events-grid .event-card');
            var mobileItems = document.querySelectorAll('.mobile-swiper .swiper-slide');

            // Фильтрация для десктопной версии
            desktopItems.forEach(function(item) {
                if (filter === 'all' || item.getAttribute('data-section') === filter) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });

            // Фильтрация для мобильной версии
            mobileItems.forEach(function(item) {
                if (filter === 'all' || item.getAttribute('data-section') === filter) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });

            // Обновление Swiper после фильтрации
            if (typeof swiper !== 'undefined') {
                swiper.update();
            }
        }

        // Обработчики кликов по кнопкам фильтра
        var filterButtons = document.querySelectorAll('.filter-button');
        filterButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Убираем активный класс со всех кнопок
                filterButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                });

                // Добавляем активный класс к нажатой кнопке
                this.classList.add('active');

                // Фильтруем элементы
                filterItems(this.getAttribute('data-filter'));
            });
        });
    });
</script>

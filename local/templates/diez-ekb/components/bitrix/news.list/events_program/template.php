<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
$this->setFrameMode(true);

// Если AJAX запрос - не выводим обрамляющую разметку
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') {
    $APPLICATION->RestartBuffer();
    $this->setFrameMode(false);
}

// Идентификатор для AJAX
$containerId = "events-list-" . $arResult["AJAX_ID"];
$filterContainerId = "events-filter-" . $arResult["AJAX_ID"];
?>

<?php if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 'Y'): ?>
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
                    <span class="filter-text"><?= !empty($arResult["SELECTED_CITY"]) ? $arResult["SELECTED_CITY"] : 'город проведения' ?></span>
                    <svg>
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                    </svg>
                </button>
                <div class="filter-dropdown-content">
                    <div class="filter-option" data-value="">Все города</div>
                    <?php foreach ($arResult["CITIES"] as $city): ?>
                        <div class="filter-option<?= $arResult["SELECTED_CITY"] == $city ? ' selected' : '' ?>" data-value="<?=htmlspecialchars($city)?>"><?=htmlspecialchars($city)?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Выбор месяца -->
            <div class="filter-dropdown">
                <button class="button filter-btn" data-filter="month">
                    <span class="filter-text"><?= !empty($arResult["SELECTED_MONTH_NAME"]) ? $arResult["SELECTED_MONTH_NAME"] : 'Выбрать месяц' ?></span>
                    <svg>
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date-2"></use>
                    </svg>
                </button>
                <div class="filter-dropdown-content">
                    <div class="filter-option" data-value="">Все месяцы</div>
                    <?php foreach ($arResult["MONTHS"] as $month): ?>
                        <div class="filter-option<?= $arResult["SELECTED_MONTH"] == $month['value'] ? ' selected' : '' ?>" data-value="<?=$month['value']?>"><?=$month['name']?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Теги -->
        <div class="tags tags--purple grid__item--12 grid__item-mob--4" id="<?=$filterContainerId?>">
            <?php foreach ($arResult["CATEGORIES"] as $type => $category): ?>
                <a href="javascript:void(0);"
                   class="tag<?=$category['ACTIVE'] ? ' active' : ''?>"
                   data-type="<?=$type?>">
                    <?=$category['NAME']?>
                </a>
            <?php endforeach; ?>

            <!-- Кнопка для сброса фильтров, видима только при активных фильтрах -->
            <?php if (!empty($arResult["SELECTED_TAGS"])): ?>
                <a href="javascript:void(0);" class="tag tag--reset" data-action="reset">
                    Сбросить фильтры
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Сетка событий -->
    <div class="grid" id="<?=$containerId?>">
<?php endif; ?>

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

    // Определяем тип события и цветовую схему
    $eventType = "";
    $colorClass = "article-news--yellow"; // по умолчанию

    // Берем тип из тегов
    if (!empty($arItem["PROPERTIES"]["TAGS"]["VALUE"])) {
        if (is_array($arItem["PROPERTIES"]["TAGS"]["VALUE"])) {
            $eventType = $arItem["PROPERTIES"]["TAGS"]["VALUE"][0];
        } else {
            $eventType = $arItem["PROPERTIES"]["TAGS"]["VALUE"];
        }
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
    $searchText = mb_strtolower($title . " " . ($eventType ? $eventType : ""));
    foreach ($checkTopWords as $word) {
        if (strpos($searchText, $word) !== false) {
            $isTop = true;
            break;
        }
    }
    ?>
    <a href="<?=$detailUrl?>"
       class="article-news grid__item--4 grid__item-mob--4 <?=$colorClass?>"
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

<?php if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 'Y'): ?>
    </div>

    <!-- КНОПКА ВЫНЕСЕНА ИЗ AJAX-КОНТЕЙНЕРА -->
    <?php if ($arResult["SHOW_MORE_BUTTON"]): ?>
        <button class="button button--down blockPosterFilter__more-btn button--mob-wide js-load-more"
                data-page="<?=$arResult['NAV_RESULT']->NavPageNomer?>"
                data-container="<?=$containerId?>"
                data-max-page="<?=$arResult['NAV_RESULT']->NavPageCount?>"
                data-next-count="<?=$arResult['NEXT_LOAD_COUNT']?>">
            <span>больше мероприятий (<?=$arResult['NEXT_LOAD_COUNT']?> из <?=$arResult['REMAINING_ITEMS']?>)</span>
            <span class="button__icon">
                        <svg>
                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                        </svg>
                    </span>
        </button>
    <?php endif; ?>
    </div>
<!--    <div class="decor">-->
<!--        <img style="--top: 7%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/circle-3.svg" alt="">-->
<!--        <img style="--top: 94%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/line-1.svg" alt="">-->
<!--        <img style="--top: 86%; --left: 94.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-4.svg" alt="">-->
<!--    </div>-->
    </section>
    </main>
<?php else: ?>
    <!-- Передаем данные через data-атрибуты для AJAX -->
    <div style="display: none;"
         data-show-button="<?=json_encode($arResult["SHOW_MORE_BUTTON"])?>"
         data-current-page="<?=$arResult['NAV_RESULT']->NavPageNomer?>"
         data-max-page="<?=$arResult['NAV_RESULT']->NavPageCount?>"
         data-next-count="<?=$arResult['NEXT_LOAD_COUNT']?>"
         data-remaining="<?=$arResult['REMAINING_ITEMS']?>"
         class="pagination-data"></div>

    <?php die(); // Прерываем выполнение для AJAX-запросов ?>
<?php endif; ?>
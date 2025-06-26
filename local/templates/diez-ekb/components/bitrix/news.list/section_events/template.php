<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Если AJAX запрос - не выводим обрамляющую разметку
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') {
    $APPLICATION->RestartBuffer();
    $this->setFrameMode(false);
}

// Идентификатор для AJAX
$containerId = "section-events-" . $arResult["AJAX_ID"];
?>

<?php if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 'Y'): ?>
    <!-- Сетка событий -->
<div class="grid" id="<?=$containerId?>">
    <?php endif; ?>

    <?php if (!empty($arResult["ITEMS"])): ?>
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

            // Получаем тип события
            $eventType = "";
            $colorClass = "article-news--yellow"; // по умолчанию

            // Получаем раздел
            if (!empty($arItem["IBLOCK_SECTION_ID"])) {
                $rsSection = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"]);
                if ($arSection = $rsSection->GetNext()) {
                    $eventType = $arSection["NAME"];
                }
            }

            // Цветовые схемы по типам
            $colorSchemes = array(
                "Концерты" => "article-news--yellow",
                "Фестивали" => "article-news--green",
                "Выставки" => "article-news--blue",
                "Спектакли" => "article-news--purple",
                "Спорт" => "article-news--red",
                "Концерт" => "article-news--yellow",
                "Фестиваль" => "article-news--green",
                "Выставка" => "article-news--blue",
                "Спектакль" => "article-news--purple",
            );

            if (isset($colorSchemes[$eventType])) {
                $colorClass = $colorSchemes[$eventType];
            }

            // Проверяем топовость
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
    <?php else: ?>
        <div class="grid__item--12">
            <div class="empty-state">
                <h3>В этой категории пока нет событий</h3>
                <p>Но мы постоянно добавляем новые мероприятия. Загляните позже или посмотрите <a href="/afisha/">все события</a>.</p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 'Y'): ?>
</div>

<!-- Кнопка "Показать больше" если есть еще события -->
<?php if ($arResult["SHOW_MORE_BUTTON"]): ?>
    <button class="button button--down blockPosterFilter__more-btn button--mob-wide js-load-more"
            data-page="<?=$arResult['NAV_RESULT']->NavPageNomer?>"
            data-container="<?=$containerId?>"
            data-max-page="<?=$arResult['NAV_RESULT']->NavPageCount?>"
            data-next-count="<?=$arResult['NEXT_LOAD_COUNT']?>">
        <span>больше событий (<?=$arResult['NEXT_LOAD_COUNT']?> из <?=$arResult['REMAINING_ITEMS']?>)</span>
        <span class="button__icon">
                <svg>
                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                </svg>
            </span>
    </button>
<?php endif; ?>
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

<style>
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #f9f9f9;
        border-radius: 12px;
    }

    .empty-state h3 {
        font-size: 24px;
        margin-bottom: 16px;
        color: #333;
    }

    .empty-state p {
        font-size: 16px;
        color: #666;
        line-height: 1.5;
    }

    .empty-state a {
        color: #008cd2;
        text-decoration: none;
    }

    .empty-state a:hover {
        text-decoration: underline;
    }
</style>
<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/* @var array $arParams */
/* @var array $arResult */
/* @global CMain $APPLICATION */
/* @global CUser $USER */
/* @global CDatabase $DB */
/* @var CBitrixComponentTemplate $this */
/* @var string $templateName */
/* @var string $templateFile */
/* @var string $templateFolder */
/* @var string $componentPath */
/* @var CBitrixComponent $component */
$this->setFrameMode(true);

// Если AJAX запрос - не выводим обрамляющую разметку
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') {
    $APPLICATION->RestartBuffer();
    $this->setFrameMode(false);
}

// Идентификатор для AJAX
$containerId = "hotels-list-" . $arResult["AJAX_ID"];
$filterContainerId = "hotels-filter-" . $arResult["AJAX_ID"];
?>

<?php if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 'Y'): ?>
<section class="section section--gradient pt-130 ptm-64 pb-125 pbm-30">
    <div class="container">
        <div class="header-block">
            <h2 class="title">Где остановиться</h2>
        </div>
        <div class="hotels">
            <div class="filter tags" id="<?=$filterContainerId?>">
                <?php foreach ($arResult["CATEGORIES"] as $type => $category): ?>
                    <a href="javascript:void(0);"
                       class="tag tag--filter<?=$category['ACTIVE'] ? ' active' : ''?>"
                       data-type="<?=$type?>">
                        <span><?=$category['NAME']?></span>
                        <?php if (strpos($category['NAME'], 'гостиниц') !== false): ?>
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-star"></use>
                            </svg>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>

                <!-- Кнопка для сброса фильтров, видима только при активных фильтрах -->
                <?php if (!empty($arResult["SELECTED_TYPES"])): ?>
                    <a href="javascript:void(0);" class="tag tag--filter tag--reset" data-action="reset">
                        <span>Сбросить фильтры</span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="hotels__list" id="<?=$containerId?>">
                <?php endif; ?>

                <?php foreach($arResult["ITEMS"] as $arItem): ?>
                    <?php
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                    $isTop = !empty($arItem["PROPERTIES"]["TOP"]["VALUE"]);
                    $itemUrl = !empty($arItem["DETAIL_PAGE_URL"]) ? $arItem["DETAIL_PAGE_URL"] : "#";
                    $pictureSrc = !empty($arItem["PREVIEW_PICTURE"]["SRC"]) ? $arItem["PREVIEW_PICTURE"]["SRC"] : "/local/templates/diez-ekb/assets/images/no-image.jpg";
                    $address = !empty($arItem["PROPERTIES"]["ADDRESS"]["VALUE"]) ? $arItem["PROPERTIES"]["ADDRESS"]["VALUE"] : "";
                    ?>
                    <a href="<?=$itemUrl?>" class="article-news article-news--max-size article-news--attraction article-news--light" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                        <?php if ($isTop): ?>
                            <span class="article-news__badges">
            <span class="badge">топ!</span>
        </span>
                        <?php endif; ?>
                        <picture class="article-news__picture">
                            <img src="<?=$pictureSrc?>" alt="<?=$arItem['NAME']?>">
                        </picture>
                        <div class="article-news__info">
                            <h2 class="article-news__title">
                                <?=$arItem["NAME"]?>
                            </h2>
                            <?php if (!empty($address)): ?>
                                <p class="article-news__place">
                                    <svg>
                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                    </svg>
                                    <span><?=$address?></span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>

                <?php if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 'Y'): ?>
            </div>

            <!-- КНОПКА ВЫНЕСЕНА ИЗ AJAX-КОНТЕЙНЕРА -->
            <?php if ($arResult["SHOW_MORE_BUTTON"]): ?>
                <button class="button button--down js-load-more"
                        data-page="<?=$arResult['NAV_RESULT']->NavPageNomer?>"
                        data-container="<?=$containerId?>"
                        data-max-page="<?=$arResult['NAV_RESULT']->NavPageCount?>"
                        data-next-count="<?=$arResult['NEXT_LOAD_COUNT']?>">
                    <span>Показать больше (<?=$arResult['NEXT_LOAD_COUNT']?> из <?=$arResult['REMAINING_ITEMS']?>)</span>
                    <span class="button__icon">
                        <svg>
                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                        </svg>
                    </span>
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>

    <section class="section section--logo-bg section--logo-bg-top pt-130 ptm-55 pb-130 pbm-80">
        <div class="container">
            <div class="header-block">
                <h2 class="title">Карта гостиниц</h2>
            </div>
            <div class="map-container">
                <div id="hotels-map" class="map-element"></div>
            </div>
        </div>
    </section>

    <script>
        // Передаем данные для карты в JavaScript
        var hotelsMapData = <?=CUtil::PhpToJSObject($arResult["MAP_ITEMS"])?>;
    </script>
<?php else: ?>
    <!-- Передаем данные через data-атрибуты -->
    <div style="display: none;"
         data-show-button="<?=json_encode($arResult["SHOW_MORE_BUTTON"])?>"
         data-current-page="<?=$arResult['NAV_RESULT']->NavPageNomer?>"
         data-max-page="<?=$arResult['NAV_RESULT']->NavPageCount?>"
         data-next-count="<?=$arResult['NEXT_LOAD_COUNT']?>"
         data-remaining="<?=$arResult['REMAINING_ITEMS']?>"
         class="pagination-data"></div>

    <?php die(); // Прерываем выполнение для AJAX-запросов ?>
<?php endif; ?>

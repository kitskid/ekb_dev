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
$containerId = "restaurants-list-" . $arResult["AJAX_ID"];
$filterContainerId = "restaurants-filter-" . $arResult["AJAX_ID"];
?>

<?php if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 'Y'): ?>
<main class="main">
    <section class="section section--intro" style="--background: url('../assets/images/main-bg-3.jpg')">
        <div class="container">
            <div class="intro">
                <div class="breadcrumbs breadcrumbs--intro">
                    <a href="/" class="breadcrumbs__link">Главная</a>
                    <p class="breadcrumbs__link">Рестораны города</p>
                </div>
                <h1 class="title title--light">
                    Рестораны города
                </h1>
                <p class="subtitle">
                    В 2023 году Екатеринбург отпразднует свое 300-летие. Свою историю город отсчитывает с 18 ноября 1723 года, когда были запущены цеха крупнейшего в России железоделательного Екатерининского завода.
                </p>
            </div>
        </div>
    </section>
    <section class="section section--gradient pt-130 ptm-64 pb-125 pbm-30">
        <div class="container">
            <div class="header-block">
                <h2 class="title">Где поесть</h2>
            </div>
            <div class="hotels">
                <div class="filter tags" id="<?=$filterContainerId?>">
                    <?php foreach ($arResult["CATEGORIES"] as $type => $category): ?>
                        <a href="javascript:void(0);"
                           class="tag tag--filter<?=$category['ACTIVE'] ? ' active' : ''?>"
                           data-type="<?=$type?>">
                            <span><?=$category['NAME']?></span>
                        </a>
                    <?php endforeach; ?>
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
    if (isset($arItem["PROPERTIES"]["GALLERY"]["VALUE"][0])) {
        $galleryImg = CFile::GetPath($arItem["PROPERTIES"]["GALLERY"]["VALUE"][0]);
        if ($galleryImg) $pictureSrc = $galleryImg;
    }
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
                <h2 class="title">Карта ресторанов</h2>
            </div>
            <div class="map-container">
                <div id="restaurants-map" class="map-element"></div>
            </div>
        </div>
    </section>
    <script>
        var restaurantsMapData = <?=CUtil::PhpToJSObject($arResult["MAP_ITEMS"])?>;
    </script>
</main>
<?php else: ?>
    <div style="display: none;"
         data-show-button="<?=json_encode($arResult["SHOW_MORE_BUTTON"])?>"
         data-current-page="<?=$arResult['NAV_RESULT']->NavPageNomer?>"
         data-max-page="<?=$arResult['NAV_RESULT']->NavPageCount?>"
         data-next-count="<?=$arResult['NEXT_LOAD_COUNT']?>"
         data-remaining="<?=$arResult['REMAINING_ITEMS']?>"
         class="pagination-data"></div>
    <?php die(); ?>
<?php endif; ?>

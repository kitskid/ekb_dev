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

if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') {
    $APPLICATION->RestartBuffer();
    $this->setFrameMode(false);
}

// Получаем уникальные категории (кухни) из элементов для фильтров
$categories = array();
$categories['all'] = 'Все';

if (!empty($arResult["ITEMS"])) {
    foreach ($arResult["ITEMS"] as $arItem) {
        if (isset($arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"]) && !empty($arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"])) {
            $categories[$arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"]] = $arItem["PROPERTIES"]["CUISINE"]["VALUE"];
        }
    }
}
?>

<section class="restaurants-section">
    <div class="container">
        <div class="section-heading">
            <h2 class="section-title">Где поесть</h2>

            <!-- Filter tabs -->
            <div class="filter-tabs">
                <?php
                $i = 0;
                foreach ($categories as $xmlId => $name) {
                    $activeClass = ($i == 0) ? 'active' : '';
                    ?>
                    <button class="filter-tab <?=$activeClass?>" data-filter="<?=$xmlId?>"><?=$name?></button>
                    <?php
                    $i++;
                }
                ?>
            </div>
        </div>

        <?php if ($arResult["ITEMS"]): ?>
            <div class="restaurants-grid">
                <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                    $category = $arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"] ?: strtolower($arItem["PROPERTIES"]["CUISINE"]["VALUE"]);
                    $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"] ?: $arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"][0]["SRC"];
                    $detailPageUrl = $arItem["DETAIL_PAGE_URL"];
                    ?>

                    <a href="<?=$detailPageUrl?>" class="restaurant-card" data-category="<?=$category?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="restaurant-card__image">
                            <?php if ($previewPicture): ?>
                                <img src="<?=$previewPicture?>" alt="<?=$arItem["NAME"]?>">
                            <?php else: ?>
                                <div class="restaurant-card__no-image"></div>
                            <?php endif; ?>

                            <?php if (!empty($arItem["PROPERTIES"]["TOP"]["VALUE"])): ?>
                                <div class="restaurant-card__badge">ТОП</div>
                            <?php endif; ?>
                        </div>
                        <div class="restaurant-card__content">
                            <h3 class="restaurant-card__title"><?=$arItem["NAME"]?></h3>
                            <?php if (!empty($arItem["PROPERTIES"]["ADDRESS"]["VALUE"])): ?>
                                <div class="restaurant-card__address"><?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?></div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
                <div class="pagination">
                    <?=$arResult["NAV_STRING"]?>
                    <?php if ($arResult["NAV_RESULT"]->nEndPage > 1 && $arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->nEndPage): ?>
                        <a href="<?=$arResult["NAV_RESULT"]->GetUrlNewPage($arResult["NAV_RESULT"]->NavPageNomer + 1)?>" class="pagination__more-btn">Показать еще</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>В данный момент нет доступных ресторанов.</p>
        <?php endif; ?>
    </div>
</section>

<?php
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') {
    die();
}
?>
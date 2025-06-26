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

// Добавляем данные для карты
$mapData = array();
foreach($arResult["ITEMS"] as $arItem) {
    if(!empty($arItem["PROPERTIES"]["COORDINATES"]["VALUE"])) {
        $mapData[] = array(
            "ID" => $arItem["ID"],
            "NAME" => $arItem["NAME"],
            "COORDINATES" => $arItem["PROPERTIES"]["COORDINATES"]["VALUE"],
            "ADDRESS" => $arItem["PROPERTIES"]["ADDRESS"]["VALUE"],
            "DETAIL_URL" => $arItem["DETAIL_PAGE_URL"]
        );
    }
}

// Передаем данные в JS для использования в карте
$this->addExternalJS($templateFolder.'/script.js');
?>
<script>
    window.attractionsData = <?=CUtil::PhpToJSObject($mapData)?>;
</script>

<div class="attractions-grid" id="attractions-container">
    <div class="row">
        <?php foreach($arResult["ITEMS"] as $arItem): ?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

            $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"] ? $arItem["PREVIEW_PICTURE"]["SRC"] : SITE_TEMPLATE_PATH . "/images/no-image.jpg";
            ?>
            <div class="col-md-4 col-sm-6 mb-4 attraction-item">
                <div class="attraction-card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="attraction-card__link">
                        <div class="attraction-card__image">
                            <img src="<?=$previewPicture?>" alt="<?=$arItem["NAME"]?>" class="img-fluid">
                            <?php if($arItem["PROPERTIES"]["NEW"]["VALUE"] == "Y"): ?>
                                <div class="attraction-card__label new">NEW</div>
                            <?php endif; ?>
                        </div>
                        <div class="attraction-card__content">
                            <h3 class="attraction-card__title"><?=$arItem["NAME"]?></h3>
                            <?php if($arItem["PROPERTIES"]["ADDRESS"]["VALUE"]): ?>
                                <div class="attraction-card__address">
                                    <i class="fa fa-map-marker"></i> <?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <?=$arResult["NAV_STRING"]?>
    <?php endif; ?>

    <?php if($arResult["NAV_RESULT"]->NavPageCount > $arResult["NAV_RESULT"]->NavPageNomer): ?>
        <div class="attractions-list__more text-center">
            <button class="btn btn-primary load-more-btn"
                    data-page="<?=$arResult["NAV_RESULT"]->NavPageNomer?>"
                    data-total-pages="<?=$arResult["NAV_RESULT"]->NavPageCount?>"
                    data-path="<?=$templateFolder?>/ajax.php"
                    data-params="<?=base64_encode(serialize($arParams))?>">
                Показать больше достопримечательностей
            </button>
        </div>
    <?php endif; ?>
</div>

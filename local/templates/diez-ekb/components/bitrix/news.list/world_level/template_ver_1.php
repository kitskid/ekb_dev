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
?>

<div class="world-level-grid">
    <?php foreach($arResult["ITEMS"] as $arItem): ?>
        <?php
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        // Получаем изображение
        $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/achievement-placeholder.jpg";
        ?>

        <div class="world-level-card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <img src="<?=$imgSrc?>" alt="<?=$arItem["NAME"]?>" class="event-img">
            <div class="event-content">
                <h3 class="event-title"><?=$arItem["NAME"]?></h3>
                <?php if(!empty($arItem["PREVIEW_TEXT"])): ?>
                    <p><?=$arItem["PREVIEW_TEXT"]?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Версия для мобильных устройств -->
<div class="mobile-swiper world-level-mobile-swiper">
    <div class="swiper-wrapper">
        <?php foreach($arResult["ITEMS"] as $arItem): ?>
            <?php
            // Получаем изображение
            $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/achievement-placeholder.jpg";
            ?>

            <div class="swiper-slide">
                <div class="world-level-card">
                    <img src="<?=$imgSrc?>" alt="<?=$arItem["NAME"]?>" class="event-img">
                    <div class="event-content">
                        <h3 class="event-title"><?=$arItem["NAME"]?></h3>
                        <?php if(!empty($arItem["PREVIEW_TEXT"])): ?>
                            <p><?=TruncateText($arItem["PREVIEW_TEXT"], 100)?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
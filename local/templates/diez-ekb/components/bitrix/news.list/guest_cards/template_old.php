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

<div class="guests-grid" id="guest-cards-container">
    <?php foreach($arResult["ITEMS"] as $arItem): ?>
        <?php
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        // Получаем цвет из свойства, если оно задано
        $cardColor = !empty($arItem["PROPERTIES"]["COLOR"]["VALUE"])
            ? $arItem["PROPERTIES"]["COLOR"]["VALUE"]
            : "rgba(0, 123, 255, 0.7)";

        // Получаем изображение
        $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/placeholder.jpg";
        ?>

        <div class="guest-card" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="background-image: url('<?=$imgSrc?>')">
            <div class="guest-card-overlay" style="background-color: <?=$cardColor?>;">
                <h3 class="guest-card-title"><?=$arItem["NAME"]?></h3>
                <?php if(!empty($arItem["PREVIEW_TEXT"])): ?>
                    <p><?=$arItem["PREVIEW_TEXT"]?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Версия для мобильных устройств -->
<div class="mobile-swiper guests-mobile-swiper">
    <div class="swiper-wrapper">
        <?php foreach($arResult["ITEMS"] as $arItem): ?>
            <?php
            // Получаем цвет из свойства, если оно задано
            $cardColor = !empty($arItem["PROPERTIES"]["COLOR"]["VALUE"])
                ? $arItem["PROPERTIES"]["COLOR"]["VALUE"]
                : "rgba(0, 123, 255, 0.7)";

            // Получаем изображение
            $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/placeholder.jpg";
            ?>

            <div class="swiper-slide">
                <div class="guest-card" style="background-image: url('<?=$imgSrc?>')">
                    <div class="guest-card-overlay" style="background-color: <?=$cardColor?>;">
                        <h3 class="guest-card-title"><?=$arItem["NAME"]?></h3>
                        <?php if(!empty($arItem["PREVIEW_TEXT"])): ?>
                            <p><?=$arItem["PREVIEW_TEXT"]?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
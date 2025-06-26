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

<div class="digest-grid">
    <?php foreach($arResult["ITEMS"] as $arItem): ?>
        <?php
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        // Получаем изображение
        $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/news-placeholder.jpg";

        // Форматируем дату
        $date = FormatDate("j F Y", MakeTimeStamp($arItem["ACTIVE_FROM"]));
        ?>

        <div class="digest-card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <img src="<?=$imgSrc?>" alt="<?=$arItem["NAME"]?>" class="digest-img">
            <div class="digest-content">
                <div class="digest-date"><?=$date?></div>
                <h3 class="digest-title"><?=$arItem["NAME"]?></h3>
                <?php if(!empty($arItem["PREVIEW_TEXT"])): ?>
                    <p><?=$arItem["PREVIEW_TEXT"]?></p>
                <?php endif; ?>
                <?php if(!empty($arItem["DETAIL_PAGE_URL"])): ?>
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="digest-link">Подробнее</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Версия для мобильных устройств -->
<div class="mobile-swiper digest-mobile-swiper">
    <div class="swiper-wrapper">
        <?php foreach($arResult["ITEMS"] as $arItem): ?>
            <?php
            // Получаем изображение
            $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/news-placeholder.jpg";

            // Форматируем дату
            $date = FormatDate("j F Y", MakeTimeStamp($arItem["ACTIVE_FROM"]));
            ?>

            <div class="swiper-slide">
                <div class="digest-card">
                    <img src="<?=$imgSrc?>" alt="<?=$arItem["NAME"]?>" class="digest-img">
                    <div class="digest-content">
                        <div class="digest-date"><?=$date?></div>
                        <h3 class="digest-title"><?=$arItem["NAME"]?></h3>
                        <?php if(!empty($arItem["PREVIEW_TEXT"])): ?>
                            <p><?=TruncateText($arItem["PREVIEW_TEXT"], 100)?></p>
                        <?php endif; ?>
                        <?php if(!empty($arItem["DETAIL_PAGE_URL"])): ?>
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="digest-link">Подробнее</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
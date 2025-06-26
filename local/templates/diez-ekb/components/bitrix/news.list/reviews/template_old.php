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

<div class="reviews-grid">
    <?php foreach($arResult["ITEMS"] as $arItem): ?>
        <?php
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        // Генерируем звёзды рейтинга из свойства
        $rating = intval($arItem["PROPERTIES"]["RATING"]["VALUE"] ?? 5);
        $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);

        // Получаем автора отзыва
        $author = $arItem["PROPERTIES"]["AUTHOR"]["VALUE"] ?? "";
        ?>

        <div class="review-card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="review-stars"><?=$stars?></div>
            <p class="review-text">"<?=$arItem["PREVIEW_TEXT"]?>"</p>
            <?php if(!empty($author)): ?>
                <div class="review-author"><?=$author?></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
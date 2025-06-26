<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

// Получаем URL фонового изображения
$bgImageUrl = '';
if(!empty($arResult["DETAIL_PICTURE"]["SRC"])) {
    $bgImageUrl = $arResult["DETAIL_PICTURE"]["SRC"];
} elseif(!empty($arResult["PROPERTIES"]["HERO_BACKGROUND"]["VALUE"])) {
    $bgImageUrl = CFile::GetPath($arResult["PROPERTIES"]["HERO_BACKGROUND"]["VALUE"]);
}
?>

<div class="container">
    <div class="hero-content" <?if(!empty($bgImageUrl)):?>style="background-image:url('<?=$bgImageUrl?>');"<?endif;?>>
        <h1 class="hero-title">О ЕКАТЕРИНБУРГЕ <br>И ГОРОДАХ СПУТНИКАХ</h1>
        <div class="hero-description">
            <?if(!empty($arResult["PREVIEW_TEXT"])):?>
                <?=$arResult["PREVIEW_TEXT"]?>
            <?elseif(!empty($arResult["DETAIL_TEXT"])):?>
                <?=$arResult["DETAIL_TEXT"]?>
            <?endif;?>
        </div>
    </div>
</div>
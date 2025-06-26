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

if (empty($arResult["ITEMS"])) {
    return;
}

// Берем первый (и единственный) элемент
$arItem = $arResult["ITEMS"][0];

// Добавляем возможность редактирования
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

// Получаем данные из свойств
$bannerTitle = !empty($arItem["PROPERTIES"]["BANNER_TITLE"]["~VALUE"]["TEXT"]) ? $arItem["PROPERTIES"]["BANNER_TITLE"]["~VALUE"]["TEXT"] : $arItem["NAME"];
$articleTitle = !empty($arItem["PROPERTIES"]["ARTICLE_TITLE"]["~VALUE"]["TEXT"]) ? $arItem["PROPERTIES"]["ARTICLE_TITLE"]["~VALUE"]["TEXT"] : "";

// Получаем фоновое изображение из превью элемента
$backgroundImage = "/local/templates/diez-ekb/assets/images/promo.png"; // Fallback
if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
    $backgroundImage = $arItem["PREVIEW_PICTURE"]["SRC"];
}

$articleText = !empty($arItem["PREVIEW_TEXT"]) ? $arItem["PREVIEW_TEXT"] : $arItem["DETAIL_TEXT"];
?>

<div id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <section class="section section--intro" style="--background: url('<?=$backgroundImage?>')">
        <div class="container">
            <div class="intro">
                <h1 class="title title--light">
                    <?=$bannerTitle?>
                </h1>
            </div>
        </div>
    </section>

    <section class="section section--logo-bg section--logo-bg-center pt-190 ptm-65 pb-190 pbm-75">
        <div class="container">
            <?php if (!empty($articleTitle)): ?>
                <div class="header-block">
                    <h2 class="title"><?=$articleTitle?></h2>
                </div>
            <?php endif; ?>

            <?php if (!empty($articleText)): ?>
                <div class="editor">
                    <?=$articleText?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

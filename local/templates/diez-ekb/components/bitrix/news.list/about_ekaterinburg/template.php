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

// Берем первый элемент
$arItem = $arResult["ITEMS"][0];

// Добавляем возможность редактирования
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

// Получаем данные
$bannerTitle = !empty($arItem["PROPERTIES"]["BANNER_TITLE"]["~VALUE"]["TEXT"]) ? $arItem["PROPERTIES"]["BANNER_TITLE"]["~VALUE"]["TEXT"] : $arItem["NAME"];
$articleTitle = !empty($arItem["PROPERTIES"]["ARTICLE_TITLE"]["~VALUE"]["TEXT"]) ? $arItem["PROPERTIES"]["ARTICLE_TITLE"]["~VALUE"]["TEXT"] : "";
$bannerText = !empty($arItem["~DETAIL_TEXT"]) ? $arItem["~DETAIL_TEXT"] : "";
$articleText = !empty($arItem["~PREVIEW_TEXT"]) ? $arItem["~PREVIEW_TEXT"] : "";

// Получаем фоновое изображение из детальной картинки
$backgroundImage = "/local/templates/diez-ekb/assets/images/main-bg-2.jpg"; // Fallback
if (!empty($arItem["DETAIL_PICTURE"]["SRC"])) {
    $backgroundImage = $arItem["DETAIL_PICTURE"]["SRC"];
}

// Получаем картинку для статьи из превью
$articleImage = "/local/templates/diez-ekb/assets/images/photo-1.png"; // Fallback
if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
    $articleImage = $arItem["PREVIEW_PICTURE"]["SRC"];
}
?>

<div id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <section class="section section--intro" style="--background: url('<?=$backgroundImage?>')">
        <div class="container">
            <div class="intro">
                <h1 class="title title--light">
                    <?=$bannerTitle?>
                </h1>
                <?php if (!empty($bannerText)): ?>
                    <p class="subtitle">
                        <?=$bannerText?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section section--logo-bg section--logo-bg-center pt-130 ptm-70 pb-100 pbm-25">
        <div class="container">
            <div class="block-info">
                <div class="grid">
                    <div class="grid__item grid__item--6 mob-hidden"></div>
                    <div class="grid__item grid__item--6 grid__item-mob--4">
                        <?php if (!empty($articleTitle)): ?>
                            <h2 class="block-info__title">
                                <?=$articleTitle?>
                            </h2>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="grid">
                    <div class="grid__item grid__item--6 grid__item-mob--4">
                        <picture class="block-info__picture">
                            <img src="<?=$articleImage?>" alt="<?=htmlspecialchars($arItem["NAME"])?>">
                        </picture>
                    </div>
                    <div class="grid__item grid__item--6 grid__item-mob--4">
                        <?php if (!empty($articleText)): ?>
                            <div class="block-info__text text">
                                <?=$articleText?>
                            </div>
                            <p class="block-info__more text">
                                <span>Развернуть</span>
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-chevrone"></use>
                                </svg>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



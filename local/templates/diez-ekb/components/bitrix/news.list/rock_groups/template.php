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
?>

<div class="header-block">
    <h2 class="title title--medium">
        Славу Свердловскому рок-клубу принесли такие <b>группы</b>, как:
    </h2>
    <div class="swiper-control mob-hidden">
        <button class="swiper-btn swiper-btn--prev">
            <svg>
                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
            </svg>
        </button>
        <button class="swiper-btn swiper-btn--next">
            <svg>
                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
            </svg>
        </button>
    </div>
</div>
<div class="slider slider--auto slider--visible" data-slider="enhanced">
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php foreach($arResult["ITEMS"] as $arItem): ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                // Получаем данные элемента
                $title = $arItem["NAME"];
                $detailUrl = !empty($arItem["DETAIL_PAGE_URL"]) ? $arItem["DETAIL_PAGE_URL"] : "#";

                // Получаем картинку
                $imgSrc = "/local/templates/diez-ekb/assets/images/no-image.jpg"; // Fallback
                if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
                    $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
                }

                // Получаем описание группы
                $description = "";
                if (!empty($arItem["~PREVIEW_TEXT"])) {
                    $description = $arItem["~PREVIEW_TEXT"];
                }
                ?>
                <div class="swiper-slide">
                    <a href="<?=$detailUrl?>" class="article-news article-news--promo" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <span class="article-news__badges"></span>
                        <picture class="article-news__picture">
                            <img src="<?=$imgSrc?>" alt="<?=htmlspecialchars($title)?>">
                        </picture>
                        <div class="article-news__info">
                            <h2 class="article-news__title">
                                <?=htmlspecialchars($title)?>
                            </h2>
                            <?php if (!empty($description)): ?>
                                <p class="article-news__text text">
                                    <?=$description?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-control swiper-control--static desktop-hidden">
            <button class="swiper-btn swiper-btn--prev">
                <svg>
                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                </svg>
            </button>
            <button class="swiper-btn swiper-btn--next">
                <svg>
                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                </svg>
            </button>
        </div>
    </div>
</div>

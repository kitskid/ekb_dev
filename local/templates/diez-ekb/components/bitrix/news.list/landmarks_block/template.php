<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
$this->setFrameMode(true);

// Цвета для карточек достопримечательностей
$colors = ['red', 'blue', 'purple', 'yellow', 'green', 'red'];
?>

<div class="container">
    <div class="blockAttractionsDirections">
        <div class="header-block">
            <h2 class="title">
                Достопримечательности
            </h2>
            <div class="swiper-control noselect mob-hidden">
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
                    <?php foreach($arResult["ITEMS"] as $key => $arItem): ?>
                        <?php
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                        $itemUrl = !empty($arItem["DETAIL_PAGE_URL"]) ? $arItem["DETAIL_PAGE_URL"] : "#";
                        $pictureSrc = !empty($arItem["PREVIEW_PICTURE"]["SRC"]) ? $arItem["PREVIEW_PICTURE"]["SRC"] : "/local/templates/diez-ekb/assets/images/pic-15.jpg";
                        $address = !empty($arItem["PROPERTIES"]["ADDRESS"]["VALUE"]) ? $arItem["PROPERTIES"]["ADDRESS"]["VALUE"] : "";
                        $isTop = !empty($arItem["PROPERTIES"]["TOP"]["VALUE_ENUM"]) && $arItem["PROPERTIES"]["TOP"]["VALUE_ENUM"] == "Да";
                        $colorClass = $colors[$key % count($colors)];
                        ?>
                        <div class="swiper-slide">
                            <a href="<?=$itemUrl?>" class="article-news article-news--attraction article-news--direction article-news--<?=$colorClass?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                                <div class="article-news__intro">
                                    <?php if($isTop): ?>
                                        <span class="article-news__badges">
                                            <span class="badge">топ!</span>
                                        </span>
                                    <?php else: ?>
                                        <span class="article-news__badges"></span>
                                    <?php endif; ?>
                                    <picture class="article-news__picture">
                                        <img src="<?=$pictureSrc?>" alt="<?=$arItem['NAME']?>">
                                    </picture>
                                    <div class="article-news__more">
                                        <span>подробнее</span>
                                        <svg>
                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="article-news__info">
                                    <h2 class="article-news__title">
                                        <?=$arItem["NAME"]?>
                                    </h2>
                                    <?php if($address): ?>
                                        <p class="article-news__place">
                                            <svg>
                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                            </svg>
                                            <span><?=$address?></span>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-control noselect desktop-hidden">
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
    </div>
</div>

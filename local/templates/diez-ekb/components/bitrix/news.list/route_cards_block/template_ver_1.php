<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
$this->setFrameMode(true);

// Цвета для карточек маршрутов
$colors = ['green', 'orange', 'purple'];
?>

<div class="container">
    <div class="blockPickYourRoute">
        <div class="header-block">
            <h2 class="title">
                <span>Выбери</span> свой маршрут
            </h2>
        </div>

        <div class="grid">
            <div class="grid__item grid__item--5 grid__item-mob--4">
                <div class="block-text">
                    <p class="text">
                        Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света,
                        соединивший в себе Европу и Азию. Поможем спланировать путешествие в Екатеринбург — город на
                        пересечении двух частей света, соединивший в себе Европу и Азию.
                    </p>
                    <img class="mob-hidden" src="/local/templates/diez-ekb/assets/images/icon-route.svg" alt="">
                    <img class="block-text__icon desktop-hidden" src="/local/templates/diez-ekb/assets/images/icon-route-mob.svg" alt="">
                    <div class="block-text__icon swiper-control noselect mob-hidden">
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
            <div class="grid__item grid__item--7 grid__item-mob--4">
                <div class="slider slider--auto slider--visible" data-slider="enhanced">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php foreach($arResult["ITEMS"] as $key => $arItem): ?>
                                <?php
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                                // Получаем изображение карточки (как в исходном шаблоне)
                                $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"] ?: "";
                                if (!$previewPicture && isset($arItem["DETAIL_PICTURE"]["SRC"])) {
                                    $previewPicture = $arItem["DETAIL_PICTURE"]["SRC"];
                                }
                                if (!$previewPicture) {
                                    $previewPicture = "/local/templates/diez-ekb/assets/images/pic-1.png";
                                }
                                var_dump($arItem["PROPERTIES"]["TYPE"]);
                                // Определяем тип маршрута и другие свойства (как в исходном шаблоне)
                                $routeType = $arItem["PROPERTIES"]["TYPE"]["VALUE"];
                                $routeDuration = $arItem["PROPERTIES"]["DURATION"]["VALUE"];
                                $routeDistance = $arItem["PROPERTIES"]["DISTANCE"]["VALUE"];

                                // Определяем цветовую схему карточки (адаптированная логика)
                                $colorClass = $colors[$key % count($colors)];
                                ?>
                                <div class="swiper-slide">
                                    <article class="article-intro-card article-intro-card--narrow article-intro-card--<?=$colorClass?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                                        <?php if($routeType && $arParams["DISPLAY_ROUTE_TYPE"] !== "N"): ?>
                                            <div class="article-intro-card__tags">
                                                <a href="#" class="article-intro-card__tag"><?=$routeType?></a>
                                                <?php if($routeDuration && $arParams["DISPLAY_ROUTE_DURATION"] !== "N"): ?>
                                                    <a href="#" class="article-intro-card__tag"><?=$routeDuration?></a>
                                                <?php endif; ?>
                                                <?php if($routeDistance && $arParams["DISPLAY_ROUTE_DISTANCE"] !== "N"): ?>
                                                    <a href="#" class="article-intro-card__tag"><?=$routeDistance?> км</a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <picture class="article-intro-card__picture">
                                            <img src="<?=$previewPicture?>" alt="<?=$arItem['NAME']?>">
                                        </picture>
                                        <div class="article-intro-card__info">
                                            <h2 class="article-intro-card__title">
                                                <?=$arItem["NAME"]?>
                                            </h2>
                                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="article-intro-card__link">
                                                <span>Узнать подробности</span>
                                                <svg class="article-intro-card__icon">
                                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-control swiper-control--static noselect desktop-hidden">
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
    </div>
</div>

<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
$this->setFrameMode(true);

// Цвета для карточек маршрутов
$colors = ['green', 'orange', 'purple'];
$blockTitle = !empty($arParams["BLOCK_TITLE"]) ? $arParams["BLOCK_TITLE"] : "топ маршрутов";
?>

<div class="container">
    <div class="blockTopRoutes">
        <div class="header-block">
            <h2 class="title">
                <?=$blockTitle?>
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
            </div>
            <div class="grid__item grid__item--7 grid__item-mob--4">
                <div class="slider slider--auto slider--visible" data-slider="enhanced">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php foreach($arResult["ITEMS"] as $key => $arItem): ?>
                                <?php
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                                // Получаем изображение карточки
                                $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"] ?: "";
                                if (!$previewPicture && isset($arItem["DETAIL_PICTURE"]["SRC"])) {
                                    $previewPicture = $arItem["DETAIL_PICTURE"]["SRC"];
                                }
                                if (!$previewPicture) {
                                    $previewPicture = "/local/templates/diez-ekb/assets/images/pic-1.png";
                                }

                                // Кешированная версия для оптимизации
                                static $sectionsWithElements = null;

                                if ($sectionsWithElements === null) {
                                    $sectionsWithElements = array();

                                    if (CModule::IncludeModule("iblock")) {
                                        // Загружаем все разделы
                                        $rsSections = CIBlockSection::GetList(
                                            array("SORT" => "ASC"),
                                            array("IBLOCK_ID" => 24, "ACTIVE" => "Y"),
                                            false,
                                            array("ID", "NAME")
                                        );

                                        $allSectionIds = array();
                                        $sectionsData = array();

                                        while ($arSection = $rsSections->GetNext()) {
                                            $allSectionIds[] = $arSection["ID"];
                                            $sectionsData[$arSection["ID"]] = $arSection["NAME"];
                                        }

                                        // Загружаем первые элементы для всех разделов одним запросом
                                        if (!empty($allSectionIds)) {
                                            $rsElements = CIBlockElement::GetList(
                                                array("SECTION_ID" => "ASC", "SORT" => "ASC"),
                                                array(
                                                    "IBLOCK_ID" => 24,
                                                    "SECTION_ID" => $allSectionIds,
                                                    "ACTIVE" => "Y"
                                                ),
                                                false,
                                                false,
                                                array("ID", "CODE", "IBLOCK_SECTION_ID")
                                            );

                                            $usedSections = array();
                                            while ($arElement = $rsElements->GetNext()) {
                                                $sectionId = $arElement["IBLOCK_SECTION_ID"];

                                                // Берем только первый элемент для каждого раздела
                                                if (!isset($usedSections[$sectionId])) {
                                                    $sectionsWithElements[$sectionId] = array(
                                                        "NAME" => $sectionsData[$sectionId],
                                                        "URL" => "/tourism/" . $arElement["CODE"]
                                                    );
                                                    $usedSections[$sectionId] = true;
                                                }
                                            }
                                        }
                                    }
                                }

                                // Обрабатываем множественное свойство TYPE_TOURISM
                                $routeTypes = array();
                                if (!empty($arItem["PROPERTIES"]["TYPE_TOURISM"]["VALUE"])) {
                                    $sectionIds = array();

                                    if (is_array($arItem["PROPERTIES"]["TYPE_TOURISM"]["VALUE"])) {
                                        $sectionIds = array_filter($arItem["PROPERTIES"]["TYPE_TOURISM"]["VALUE"]);
                                    } else {
                                        $sectionIds = array($arItem["PROPERTIES"]["TYPE_TOURISM"]["VALUE"]);
                                    }

                                    foreach ($sectionIds as $sectionId) {
                                        if (!empty($sectionId) && isset($sectionsWithElements[$sectionId])) {
                                            $routeTypes[] = $sectionsWithElements[$sectionId];
                                        }
                                    }
                                }

                                // Обрабатываем множественный список TYPE
//                                $routeTypes = array();
//                                if (!empty($arItem["PROPERTIES"]["TYPE"]["VALUE_ENUM"])) {
//                                    if (is_array($arItem["PROPERTIES"]["TYPE"]["VALUE_ENUM"])) {
//                                        $routeTypes = $arItem["PROPERTIES"]["TYPE"]["VALUE_ENUM"];
//                                    } else {
//                                        $routeTypes = array($arItem["PROPERTIES"]["TYPE"]["VALUE_ENUM"]);
//                                    }
//                                }

                                // Другие свойства
//                                $routeDuration = $arItem["PROPERTIES"]["DURATION"]["VALUE"];
//                                $routeDistance = $arItem["PROPERTIES"]["DISTANCE"]["VALUE"];

                                // Определяем цветовую схему карточки
                                $colorClass = $colors[$key % count($colors)];
                                ?>
                                <div class="swiper-slide">
                                    <article class="article-intro-card article-intro-card--narrow article-intro-card--<?=$colorClass?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                                        <?php if(!empty($routeTypes) && $arParams["DISPLAY_ROUTE_TYPE"] !== "N"): ?>
                                            <div class="article-intro-card__tags">
                                                <?php foreach($routeTypes as $routeType): ?>
                                                    <a href="<?=$routeType["URL"]?>" class="article-intro-card__tag"><?=$routeType["NAME"]?></a>
                                                <?php endforeach; ?>

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
                        <div class="swiper-control desktop-hidden noselect">
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

<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
$this->setFrameMode(true);
// Получаем фоновое изображение
$backgroundImage = "/local/templates/diez-ekb/assets/images/direction-bg.png"; // по умолчанию

if ($arResult["DETAIL_PICTURE"]) {
    $backgroundImage = $arResult["DETAIL_PICTURE"]["SRC"];
} elseif ($arResult["PREVIEW_PICTURE"]) {
    $backgroundImage = $arResult["PREVIEW_PICTURE"]["SRC"];
}

// Получаем subtitle
$subtitle = !empty($arResult["PREVIEW_TEXT"]) ? $arResult["PREVIEW_TEXT"] :
    "Поможем спланировать путешествие в Екатеринбург — город на пересечении двух частей света, соединивший в себе Европу и Азию.";

// Получаем галерею
$gallery = array();
if (!empty($arResult["PROPERTIES"]["GALLERY"]["VALUE"])) {
    if (is_array($arResult["PROPERTIES"]["GALLERY"]["VALUE"])) {
        $gallery = $arResult["PROPERTIES"]["GALLERY"]["VALUE"];
    } else {
        $gallery = array($arResult["PROPERTIES"]["GALLERY"]["VALUE"]);
    }
}

// Получаем точки маршрута из связанного инфоблока
$routePoints = array();
if (CModule::IncludeModule("iblock")) {
    $arFilter = array(
        "IBLOCK_ID" => 32, // ID инфоблока точек маршрутов
        "PROPERTY_BINDING" => $arResult["ID"],
        "ACTIVE" => "Y"
    );
    $arSort = array("PROPERTY_SORT" => "ASC", "SORT" => "ASC");
    $arSelect = array(
        "ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "PREVIEW_PICTURE", "DETAIL_PICTURE"
    );

    $rsPoints = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
    while($arPoint = $rsPoints->GetNext()) {
        $routePoints[] = array(
            "ID" => $arPoint["ID"],
            "NAME" => $arPoint["NAME"],
            "TEXT" => !empty($arPoint["DETAIL_TEXT"]) ? $arPoint["DETAIL_TEXT"] : $arPoint["PREVIEW_TEXT"],
            "PICTURE" => !empty($arPoint["DETAIL_PICTURE"]) ? CFile::GetPath($arPoint["DETAIL_PICTURE"]) : CFile::GetPath($arPoint["PREVIEW_PICTURE"])
        );
    }
}
?>

<main class="main">
    <section class="section section--intro" style="--background: url('<?=$backgroundImage?>')">
        <div class="container">
            <div class="intro">
                <div class="breadcrumbs breadcrumbs--intro">
                    <a href="/" class="breadcrumbs__link">Главная</a>
                    <a href="/routes/" class="breadcrumbs__link">Маршруты</a>
                    <p class="breadcrumbs__link"><?=$arResult["NAME"]?></p>
                </div>
                <h1 class="title title--light">
                    <?=$arResult["NAME"]?>
                </h1>
                <p class="subtitle">
                    <?=$subtitle?>
                </p>
            </div>
        </div>
    </section>

    <section class="section pt-115 ptm-60 pb-115 pbm-80">
        <div class="container">
            <div class="media-block">
                <?php if(!empty($routePoints)): ?>
                    <?php foreach($routePoints as $index => $point): ?>
                        <div class="media-block__item">
                            <div class="media-block__info">
                                <h2 class="media-block__title">
                                    Маршрут <span><?=$point["NAME"]?></span>

<!--                                    --><?php //if($index == 0): ?>
<!--                                        Маршрут <span>--><?//=mb_strtolower($arResult["NAME"], 'UTF-8')?><!--</span>-->
<!--                                    --><?php //else: ?>
<!--                                        <span>--><?//=$point["NAME"]?><!--</span>-->
<!--                                    --><?php //endif; ?>
                                </h2>
                                <p class="text">
                                    <?=$point["TEXT"]?>
                                </p>
                            </div>
                            <?php if($point["PICTURE"]): ?>
                                <picture class="media-block__picture">
                                    <img src="<?=$point["PICTURE"]?>" alt="<?=$point["NAME"]?>">
                                </picture>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if(!empty($gallery)): ?>
                    <div class="media-block__item">
                        <div class="media-block__info">
                            <h2 class="media-block__title"><span>Общая галерея</span> маршрута</h2>
                        </div>
                        <div class="slider slider--auto slider--visible" data-slider="enhanced">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <?php foreach($gallery as $imageId): ?>
                                        <?php
                                        $image = CFile::GetFileArray($imageId);
                                        if($image):
                                            ?>
                                            <div class="swiper-slide">
                                                <article class="article-gallery" data-fancybox="gallery" data-src="<?=$image['SRC']?>">
                                                    <picture class="article-gallery__picture">
                                                        <img src="<?=$image['SRC']?>" alt="<?=$arResult['NAME']?>">
                                                    </picture>
                                                </article>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-45">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "route_cards_block",
            Array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "IBLOCK_ID" => "31",
                "IBLOCK_TYPE" => "routes",
                "NEWS_COUNT" => "3",
                "SORT_BY1" => "RAND",
                "SORT_ORDER1" => "ASC",
                "FILTER_NAME" => "otherRoutesFilter",
                "PROPERTY_CODE" => array("TYPE", "DURATION", "DISTANCE"),
                "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"),
                "DETAIL_URL" => "/routes/#ELEMENT_CODE#/",
                "SET_TITLE" => "N",
                "DISPLAY_ROUTE_TYPE" => "Y",
            )
        );
        ?>
    </section>
</main>

<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
$this->setFrameMode(true);
?>

<section class="choose-route-section" id="choose-route">
    <div class="container">
        <h2 class="section-title"><?=$arParams["TITLE"] ?: "ВЫБЕРИ СВОЙ МАРШРУТ"?></h2>

        <div class="route-cards-grid">
            <?php foreach($arResult["ITEMS"] as $arItem): ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                // Получаем изображение карточки
                $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"] ?: "";
                if (!$previewPicture && isset($arItem["DETAIL_PICTURE"]["SRC"])) {
                    $previewPicture = $arItem["DETAIL_PICTURE"]["SRC"];
                }

                // Определяем тип маршрута и другие свойства
                $routeType = $arItem["PROPERTIES"]["TYPE"]["VALUE"];
                $routeDuration = $arItem["PROPERTIES"]["DURATION"]["VALUE"];
                $routeDistance = $arItem["PROPERTIES"]["DISTANCE"]["VALUE"];

                // Определяем цветовую схему карточки
                $cardColors = array('green', 'orange', 'purple', 'blue', 'red');
                $colorIndex = $arItem["ID"] % count($cardColors);
                $cardColor = $cardColors[$colorIndex];
                ?>
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="route-card route-card-<?=$cardColor?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                    <div class="route-card-image" <?if($previewPicture):?>style="background-image: url('<?=$previewPicture?>')"<?endif;?>>
                        <?if($routeType && $arParams["DISPLAY_ROUTE_TYPE"] !== "N"):?>
                            <div class="route-type-badge"><?=$routeType?></div>
                        <?endif;?>
                    </div>

                    <div class="route-card-content">
                        <h3 class="route-card-title"><?=$arItem["NAME"]?></h3>

                        <div class="route-card-info">
                            <?if($routeDuration && $arParams["DISPLAY_ROUTE_DURATION"] !== "N"):?>
                                <div class="route-info-item">
                                    <span class="info-icon duration-icon"></span>
                                    <span class="info-text"><?=$routeDuration?></span>
                                </div>
                            <?endif;?>

                            <?if($routeDistance && $arParams["DISPLAY_ROUTE_DISTANCE"] !== "N"):?>
                                <div class="route-info-item">
                                    <span class="info-icon distance-icon"></span>
                                    <span class="info-text"><?=$routeDistance?> км</span>
                                </div>
                            <?endif;?>
                        </div>

                        <div class="route-card-more">
                            <span>Подробнее</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 0L6.59 1.41L12.17 7H0V9H12.17L6.59 14.59L8 16L16 8L8 0Z" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
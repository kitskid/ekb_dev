<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
$this->setFrameMode(true);
?>

<section class="top-routes-section" id="top-routes">
    <div class="container">
        <h2 class="section-title"><?=$arParams["TITLE"] ?: "ТОП МАРШРУТОВ"?></h2>

        <div class="top-routes-grid">
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
                ?>
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="top-route-card" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                    <div class="top-route-image" <?if($previewPicture):?>style="background-image: url('<?=$previewPicture?>')"<?endif;?>>
                        <?if($routeType && $arParams["DISPLAY_ROUTE_TYPE"] !== "N"):?>
                            <div class="route-type-badge"><?=$routeType?></div>
                        <?endif;?>
                        <div class="top-route-overlay">
                            <div class="top-route-overlay-content">
                                <div class="route-info">
                                    <?if($routeDuration && $arParams["DISPLAY_ROUTE_DURATION"] !== "N"):?>
                                        <div class="route-info-item">
                                            <svg class="info-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.99 2C6.47 2 2 6.48 2 12C2 17.52 6.47 22 11.99 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 11.99 2ZM12 20C7.58 20 4 16.42 4 12C4 7.58 7.58 4 12 4C16.42 4 20 7.58 20 12C20 16.42 16.42 20 12 20ZM12.5 7H11V13L16.25 16.15L17 14.92L12.5 12.25V7Z" fill="currentColor"/>
                                            </svg>
                                            <span><?=$routeDuration?></span>
                                        </div>
                                    <?endif;?>

                                    <?if($routeDistance && $arParams["DISPLAY_ROUTE_DISTANCE"] !== "N"):?>
                                        <div class="route-info-item">
                                            <svg class="info-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21.92 11.6C19.9 6.91 16.1 4 12 4C7.9 4 4.1 6.91 2.08 11.6C2.03 11.72 2 11.86 2 12C2 12.14 2.03 12.28 2.08 12.4C4.1 17.09 7.9 20 12 20C16.1 20 19.9 17.09 21.92 12.4C21.97 12.28 22 12.14 22 12C22 11.86 21.97 11.72 21.92 11.6ZM12 18C8.83 18 5.83 15.71 4.05 12C5.83 8.29 8.83 6 12 6C15.17 6 18.17 8.29 19.95 12C18.17 15.71 15.17 18 12 18ZM12 8C9.79 8 8 9.79 8 12C8 14.21 9.79 16 12 16C14.21 16 16 14.21 16 12C16 9.79 14.21 8 12 8ZM12 14C10.9 14 10 13.1 10 12C10 10.9 10.9 10 12 10C13.1 10 14 10.9 14 12C14 13.1 13.1 14 12 14Z" fill="currentColor"/>
                                            </svg>
                                            <span><?=$routeDistance?> км</span>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="top-route-content">
                        <h3 class="top-route-title"><?=$arItem["NAME"]?></h3>

                        <?if($arItem["PREVIEW_TEXT"]):?>
                            <div class="top-route-description"><?=$arItem["PREVIEW_TEXT"]?></div>
                        <?endif;?>

                        <div class="top-route-more">
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

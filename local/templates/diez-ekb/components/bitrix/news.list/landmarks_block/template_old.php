<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
$this->setFrameMode(true);
?>

<section class="landmarks-section" id="landmarks">
    <div class="container">
        <h2 class="section-title"><?=$arParams["TITLE"] ?: "ДОСТОПРИМЕЧАТЕЛЬНОСТИ"?></h2>

        <div class="landmarks-grid">
            <?php foreach($arResult["ITEMS"] as $arItem): ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                // Получаем изображение
                $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"] ?: "";
                if (!$previewPicture && isset($arItem["DETAIL_PICTURE"]["SRC"])) {
                    $previewPicture = $arItem["DETAIL_PICTURE"]["SRC"];
                }

                // Получаем случайный рейтинг для демонстрации (в реальном проекте это может быть свойство)
                $rating = rand(40, 50) / 10; // Генерируем рейтинг от 4.0 до 5.0
                ?>
                <div class="landmark-card" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="landmark-image-wrapper">
                        <?if($previewPicture):?>
                            <img src="<?=$previewPicture?>" alt="<?=$arItem["NAME"]?>" class="landmark-image">
                        <?endif;?>

                        <?if($arParams["DISPLAY_RATING"] !== "N"):?>
                            <div class="landmark-rating">
                                <span class="rating-value"><?=$rating?></span>
                                <svg class="rating-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" fill="currentColor"/>
                                </svg>
                            </div>
                        <?endif;?>
                    </a>

                    <div class="landmark-content">
                        <h3 class="landmark-title">
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
                        </h3>
                        <?if($arItem["PREVIEW_TEXT"]):?>
                            <div class="landmark-description"><?=$arItem["PREVIEW_TEXT"]?></div>
                        <?endif;?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
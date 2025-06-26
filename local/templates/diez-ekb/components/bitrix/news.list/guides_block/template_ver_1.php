<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
$this->setFrameMode(true);
?>

<section class="guides-section" id="guides">
    <div class="container">
        <div class="guides-header">
            <h2 class="section-title"><?=$arParams["TITLE"] ?: "ВАШ ГИД ПО ЕКАТЕРИНБУРГУ"?></h2>
            <div class="guides-description">
                <p>Профессиональные экскурсоводы и знатоки города покажут вам самые интересные места и поделятся уникальными историями об Екатеринбурге</p>
            </div>
        </div>

        <div class="guides-grid">
            <?php foreach($arResult["ITEMS"] as $arItem): ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                // Получаем изображение (фото гида)
                $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"] ?: "";
                if (!$previewPicture && isset($arItem["DETAIL_PICTURE"]["SRC"])) {
                    $previewPicture = $arItem["DETAIL_PICTURE"]["SRC"];
                }

                // Получаем контакты
                $phone = $arItem["PROPERTIES"]["PHONE"]["VALUE"];
                $email = $arItem["PROPERTIES"]["EMAIL"]["VALUE"];
                $socialMedia = $arItem["PROPERTIES"]["SOCIAL_MEDIA"]["VALUE"];

                // Получаем маршруты гида
                $routeIds = array();
                if (is_array($arItem["PROPERTIES"]["BINDING_ROUTES"]["VALUE"])) {
                    $routeIds = $arItem["PROPERTIES"]["BINDING_ROUTES"]["VALUE"];
                } elseif (!empty($arItem["PROPERTIES"]["BINDING_ROUTES"]["VALUE"])) {
                    $routeIds = array($arItem["PROPERTIES"]["BINDING_ROUTES"]["VALUE"]);
                }
                ?>
                <div class="guide-card" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                    <div class="guide-image">
                        <?if($previewPicture):?>
                            <img src="<?=$previewPicture?>" alt="<?=$arItem["NAME"]?>">
                        <?else:?>
                            <div class="guide-no-image">
                                <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" fill="currentColor"/>
                                    <path d="M12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" fill="currentColor"/>
                                </svg>
                            </div>
                        <?endif;?>
                    </div>

                    <div class="guide-content">
                        <h3 class="guide-name"><?=$arItem["NAME"]?></h3>

                        <?if($arItem["PREVIEW_TEXT"]):?>
                            <div class="guide-bio"><?=$arItem["PREVIEW_TEXT"]?></div>
                        <?endif;?>

                        <?if($arParams["DISPLAY_CONTACTS"] !== "N" && ($phone || $email || $socialMedia)):?>
                            <div class="guide-contacts">
                                <?if($phone):?>
                                    <div class="guide-contact">
                                        <svg class="contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20.01 15.38C18.78 15.38 17.59 15.18 16.48 14.82C16.13 14.7 15.74 14.79 15.47 15.06L13.9 17.03C11.07 15.68 8.42 13.13 7.01 10.2L8.96 8.54C9.23 8.26 9.31 7.87 9.2 7.52C8.83 6.41 8.64 5.22 8.64 3.99C8.64 3.45 8.19 3 7.65 3H4.19C3.65 3 3 3.24 3 3.99C3 13.28 10.73 21 20.01 21C20.72 21 21 20.37 21 19.82V16.37C21 15.83 20.55 15.38 20.01 15.38Z" fill="currentColor"/>
                                        </svg>
                                        <a href="tel:<?=preg_replace('/[^0-9+]/', '', $phone)?>" class="contact-link"><?=$phone?></a>
                                    </div>
                                <?endif;?>

                                <?if($email):?>
                                    <div class="guide-contact">
                                        <svg class="contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20 4H4C2.9 4 2.01 4.9 2.01 6L2 18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 8L12 13L4 8V6L12 11L20 6V8Z" fill="currentColor"/>
                                        </svg>
                                        <a href="mailto:<?=$email?>" class="contact-link"><?=$email?></a>
                                    </div>
                                <?endif;?>

                                <?if($socialMedia):?>
                                    <div class="guide-contact">
                                        <svg class="contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22.675 0H1.325C0.593 0 0 0.593 0 1.325V22.676C0 23.407 0.593 24 1.325 24H12.82V14.706H9.692V11.084H12.82V8.413C12.82 5.313 14.713 3.625 17.479 3.625C18.804 3.625 19.942 3.724 20.274 3.768V7.008L18.356 7.009C16.852 7.009 16.561 7.724 16.561 8.772V11.085H20.148L19.681 14.707H16.561V24H22.677C23.407 24 24 23.407 24 22.675V1.325C24 0.593 23.407 0 22.675 0Z" fill="currentColor"/>
                                        </svg>
                                        <a href="<?=$socialMedia?>" target="_blank" class="contact-link">Профиль в соцсетях</a>
                                    </div>
                                <?endif;?>
                            </div>
                        <?endif;?>

                        <?if(!empty($routeIds)):?>
                            <div class="guide-routes">
                                <div class="guide-routes-title">Проводит маршруты:</div>
                                <div class="guide-routes-list">
                                    <?php
                                    // Получаем информацию о маршрутах
                                    $arRoutes = array();
                                    $rsRoutes = CIBlockElement::GetList(
                                        array("SORT" => "ASC"),
                                        array("IBLOCK_ID" => 31, "ID" => $routeIds, "ACTIVE" => "Y"),
                                        false,
                                        false,
                                        array("ID", "NAME", "DETAIL_PAGE_URL")
                                    );

                                    while ($arRoute = $rsRoutes->GetNext()) {
                                        echo '<a href="'.$arRoute["DETAIL_PAGE_URL"].'" class="guide-route-link">'.$arRoute["NAME"].'</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?endif;?>

                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="guide-more-link">Подробнее</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
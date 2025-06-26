<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
$this->setFrameMode(true);
?>

<div class="container">
    <div class="header-block header-block--offset">
        <h2 class="title">
            Ваш гид по Екатеринбургу
        </h2>
        <div class="text">
            Каждый уголок Екатеринбурга скрывает свою уникальную историю.<br>
            Наши экскурсоводы помогут вам увидеть все самые интересные места города.<br>
            Выберите экскурсовода, чтобы узнать подробности о туре и контакты для записи.
        </div>
    </div>
    <div class="guides">
        <?php foreach($arResult["ITEMS"] as $arItem): ?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

            // Получаем изображение (фото гида)
            $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"] ?: "";
            if (!$previewPicture && isset($arItem["DETAIL_PICTURE"]["SRC"])) {
                $previewPicture = $arItem["DETAIL_PICTURE"]["SRC"];
            }
            if (!$previewPicture) {
                $previewPicture = "/local/templates/diez-ekb/assets/images/guide-1.png"; // fallback изображение
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

            // Формируем текст из PREVIEW_TEXT или берем название маршрутов
            $guideText = "";
            if (!empty($arItem["PREVIEW_TEXT"])) {
                $guideText = $arItem["PREVIEW_TEXT"];
            } elseif (!empty($routeIds)) {
                // Получаем названия маршрутов для отображения
                $arRoutes = array();
                $rsRoutes = CIBlockElement::GetList(
                    array("SORT" => "ASC"),
                    array("IBLOCK_ID" => 31, "ID" => $routeIds, "ACTIVE" => "Y"),
                    false,
                    array("nTopCount" => 1), // Берем только первый маршрут для краткого описания
                    array("ID", "NAME")
                );
                if ($arRoute = $rsRoutes->GetNext()) {
                    $guideText = '"Покажу<br>' . $arRoute["NAME"] . '!"';
                }
            }

            if (empty($guideText)) {
                $guideText = '"Покажу вам<br>Екатеринбург!"';
            }
            ?>
            <article class="article-guide" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                    <picture class="article-guide__picture">
                        <img src="<?=$previewPicture?>" alt="<?=$arItem['NAME']?>">
                    </picture>
                    <p class="article-guide__text"><?=$guideText?></p>
                </a>
            </article>
        <?php endforeach; ?>
    </div>
</div>

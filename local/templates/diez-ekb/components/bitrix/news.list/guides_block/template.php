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
        <?php foreach($arResult["ITEMS"] as $key => $arItem): ?>
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
            $phone = !empty($arItem["PROPERTIES"]["PHONE"]["VALUE"]) ? $arItem["PROPERTIES"]["PHONE"]["VALUE"] : "";
            $email = !empty($arItem["PROPERTIES"]["EMAIL"]["VALUE"]) ? $arItem["PROPERTIES"]["EMAIL"]["VALUE"] : "";
            $socialMedia = !empty($arItem["PROPERTIES"]["SOCIAL_MEDIA"]["VALUE"]) ? $arItem["PROPERTIES"]["SOCIAL_MEDIA"]["VALUE"] : "";

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

            // Цвета для модальных окон
            $modalColors = ['blue', 'green', 'orange'];
            $modalColor = $modalColors[$key % count($modalColors)];

            // Формируем ID для модального окна
            $modalId = "guide-" . $arItem["ID"];
            ?>
            <article class="article-guide" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                <picture class="article-guide__picture">
                    <img src="<?=$previewPicture?>" alt="<?=$arItem['NAME']?>">
                </picture>
                <p class="article-guide__text"><?=$guideText?></p>
                <button class="button" data-fancybox data-src="#<?=$modalId?>">Подробнее</button>
            </article>

            <!-- Модальное окно для гида -->
            <div class="hidden">
                <div class="article-guide__modal article-guide__modal--<?=$modalColor?>" id="<?=$modalId?>">
                    <div class="article-guide__wrapper">
                        <div class="article-guide__content">
                            <div class="article-guide__picture">
                                <img src="<?=$previewPicture?>" alt="<?=$arItem['NAME']?>">
                            </div>
                            <div class="article-guide__info">
                                <h2 class="article-guide__title">
                                    Привет! Меня зовут <span><?=$arItem["NAME"]?></span>
                                </h2>
                                <p class="article-guide__text">
                                    <?=!empty($arItem["DETAIL_TEXT"]) ? $arItem["DETAIL_TEXT"] :
                                        "На экскурсиях со мной вы разглядите неочевидное в привычных местах и объектах, погрузитесь в локальные смыслы и влюбитесь в город."?>
                                </p>
                                <ul class="article-guide__list">
                                    <?php if($phone): ?>
                                        <li class="article-guide__item">
                                            <p class="mob-hidden">Телефон:
                                                <a href="tel:<?=preg_replace('/[^0-9+]/', '', $phone)?>"><?=$phone?></a>
                                            </p>
                                            <a href="tel:<?=preg_replace('/[^0-9+]/', '', $phone)?>" class="article-guide__icon">
                                                <img src="/local/templates/diez-ekb/assets/images/phone.svg" alt="">
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if($email): ?>
                                        <li class="article-guide__item mob-hidden">
                                            <p>Email:
                                                <a href="mailto:<?=$email?>"><?=$email?></a>
                                            </p>
                                        </li>
                                    <?php endif; ?>

                                    <?php if($socialMedia): ?>
                                        <li class="article-guide__item">
                                            <p class="mob-hidden">Telegram:
                                                <a href="<?=$socialMedia?>" target="_blank">
                                                    <?php
                                                    // Извлекаем username из ссылки для отображения
                                                    $telegramHandle = $socialMedia;
                                                    if (strpos($socialMedia, 't.me/') !== false) {
                                                        $telegramHandle = '@' . basename($socialMedia);
                                                    } elseif (strpos($socialMedia, '@') === false) {
                                                        $telegramHandle = '@' . $socialMedia;
                                                    }
                                                    echo $telegramHandle;
                                                    ?>
                                                </a>
                                            </p>
                                            <a href="<?=$socialMedia?>" target="_blank" class="article-guide__icon">
                                                <img src="/local/templates/diez-ekb/assets/images/telegram.svg" alt="">
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <a href="#" class="button mob-hidden">Записаться</a>
                            </div>
                        </div>
                        <a href="#" class="button desktop-hidden">Записаться</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

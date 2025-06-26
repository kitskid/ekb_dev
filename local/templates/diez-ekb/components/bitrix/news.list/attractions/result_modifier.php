<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Дополнительная обработка элементов
foreach($arResult["ITEMS"] as &$arItem) {
    // Проверяем наличие символьного кода
    if(empty($arItem["CODE"])) {        // Если код элемента не задан, генерируем его из названия
        $code = \CUtil::translit($arItem["NAME"], "ru", array(
            "replace_space" => "-",
            "replace_other" => "-"
        ));

        // Проверяем, что код уникальный
        $existElement = \CIBlockElement::GetList(
            array(),
            array("IBLOCK_ID" => $arItem["IBLOCK_ID"], "CODE" => $code, "!ID" => $arItem["ID"]),
            false,
            array("nTopCount" => 1),
            array("ID")
        )->Fetch();

        if($existElement) {
            // Если такой код уже существует, добавляем к нему ID элемента для уникальности
            $code .= "-" . $arItem["ID"];
        }

        // Обновляем символьный код элемента
        $el = new \CIBlockElement;
        $el->Update($arItem["ID"], array("CODE" => $code));

        // Обновляем код в текущем массиве
        $arItem["CODE"] = $code;

        // Обновляем URL детальной страницы
        $arItem["DETAIL_PAGE_URL"] = str_replace(
            array("#ELEMENT_CODE#", "#ELEMENT_ID#"),
            array($code, $arItem["ID"]),
            $arParams["DETAIL_URL"]
        );
    }

    // Преобразование координат в нужный формат, если они указаны не в формате "широта,долгота"
    if(!empty($arItem["PROPERTIES"]["COORDINATES"]["VALUE"])) {
        $coordinates = $arItem["PROPERTIES"]["COORDINATES"]["VALUE"];

        // Проверяем формат и корректируем при необходимости
        if(strpos($coordinates, ',') === false) {
            // Если координаты записаны в другом формате, преобразуем их
            // Например, если они в формате "широта долгота"
            $coordinates = str_replace(' ', ',', trim($coordinates));
            $arItem["PROPERTIES"]["COORDINATES"]["VALUE"] = $coordinates;
        }
    }

    // Дополнительная обработка свойства BINDING (привязка к маршрутам)
    if(!empty($arItem["PROPERTIES"]["BINDING"]["VALUE"])) {
        // Получаем информацию о связанных маршрутах
        $arItem["ROUTES"] = array();

        if(is_array($arItem["PROPERTIES"]["BINDING"]["VALUE"])) {
            $routeIds = $arItem["PROPERTIES"]["BINDING"]["VALUE"];

            $rsRoutes = \CIBlockElement::GetList(
                array("SORT" => "ASC"),
                array(
                    "IBLOCK_TYPE" => "routes",
                    "ID" => $routeIds,
                    "ACTIVE" => "Y"
                ),
                false,
                false,
                array("ID", "NAME", "DETAIL_PAGE_URL", "CODE")
            );

            while($arRoute = $rsRoutes->GetNext()) {
                // Формируем ЧПУ URL для маршрута
                if(!empty($arRoute["CODE"])) {
                    $arRoute["DETAIL_PAGE_URL"] = "/routes/" . $arRoute["CODE"] . "/";
                }
                $arItem["ROUTES"][] = $arRoute;
            }
        }
    }
}

// Если это AJAX-запрос для подгрузки элементов
if($arParams["LOAD_ON_SCROLL"] === "Y") {
    // Убираем лишние элементы шаблона для AJAX-вывода
    $arResult["ITEMS_HTML"] = array();

    foreach($arResult["ITEMS"] as $arItem) {
        ob_start();
        ?>
        <div class="col-md-4 col-sm-6 mb-4 attraction-item">
            <div class="attraction-card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="attraction-card__link">
                    <div class="attraction-card__image">
                        <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"] ? $arItem["PREVIEW_PICTURE"]["SRC"] : SITE_TEMPLATE_PATH . "/images/no-image.jpg"?>" alt="<?=$arItem["NAME"]?>" class="img-fluid">
                        <?php if($arItem["PROPERTIES"]["NEW"]["VALUE"] == "Y"): ?>
                            <div class="attraction-card__label new">NEW</div>
                        <?php endif; ?>
                    </div>
                    <div class="attraction-card__content">
                        <h3 class="attraction-card__title"><?=$arItem["NAME"]?></h3>
                        <?php if($arItem["PROPERTIES"]["ADDRESS"]["VALUE"]): ?>
                            <div class="attraction-card__address">
                                <i class="fa fa-map-marker"></i> <?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        </div>
        <?php
        $arResult["ITEMS_HTML"][] = ob_get_clean();
    }
}

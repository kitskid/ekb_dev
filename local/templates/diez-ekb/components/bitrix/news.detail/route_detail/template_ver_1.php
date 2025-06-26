<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

// Получаем информацию о маршруте
$routeID = $arResult["ID"];
$routeName = $arResult["NAME"];
$routeDetailText = $arResult["DETAIL_TEXT"];
$routeDetailPicture = $arResult["DETAIL_PICTURE"]["SRC"] ?? "";
$routePreviewPicture = $arResult["PREVIEW_PICTURE"]["SRC"] ?? "";

// Получаем значения свойств маршрута
$isCircular = $arResult["PROPERTIES"]["CIRCULAR"]["VALUE_ENUM"] == "Да" ? true : false;
$routeType = $arResult["PROPERTIES"]["TYPE"]["VALUE"];
$routeDifficulty = $arResult["PROPERTIES"]["DIFFICULTY"]["VALUE"];
$routeDuration = $arResult["PROPERTIES"]["DURATION"]["VALUE"];
$routeDistance = $arResult["PROPERTIES"]["DISTANCE"]["VALUE"];

// Определяем тип линии маршрута на карте
$routeLineType = "";
if ($routeType == "Автомобильный") {
    $routeLineType = "auto";
} else {
    $routeLineType = "pedestrian"; // По умолчанию пешеходный
}

// Получаем точки маршрута
$arFilter = array(
    "IBLOCK_ID" => 32, // ID инфоблока точек маршрутов
    "PROPERTY_BINDING" => $routeID,
    "ACTIVE" => "Y"
);
$arSort = array("PROPERTY_SORT" => "ASC");
$arSelect = array(
    "ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_TEXT", "DETAIL_PICTURE",
    "PROPERTY_COORDINATES", "PROPERTY_SORT"
);

$rsPoints = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
$arPoints = array();
while($arPoint = $rsPoints->GetNext()) {
    // Парсим координаты из строки в формате "широта,долгота"
    $coordinates = explode(",", $arPoint["PROPERTY_COORDINATES_VALUE"]);
    $lat = isset($coordinates[0]) ? trim($coordinates[0]) : 0;
    $lng = isset($coordinates[1]) ? trim($coordinates[1]) : 0;

    $arPoints[] = array(
        "ID" => $arPoint["ID"],
        "NAME" => $arPoint["NAME"],
        "PREVIEW_TEXT" => $arPoint["PREVIEW_TEXT"],
        "DETAIL_TEXT" => $arPoint["DETAIL_TEXT"],
        "PREVIEW_PICTURE" => CFile::GetPath($arPoint["PREVIEW_PICTURE"]),
        "DETAIL_PICTURE" => CFile::GetPath($arPoint["DETAIL_PICTURE"]),
        "SORT" => $arPoint["PROPERTY_SORT_VALUE"],
        "LAT" => $lat,
        "LNG" => $lng
    );
}
?>

<div class="route-detail-container">
    <!-- Главный баннер -->
    <div class="route-hero" style="background-image: url('<?=$routeDetailPicture ?: $routePreviewPicture?>')">
        <div class="route-hero-content">
            <h1><?=$routeName?></h1>
            <div class="route-stats">
                <?if($routeType):?>
                    <div class="route-stat">
                        <span class="route-stat-label">Тип:</span>
                        <span class="route-stat-value"><?=$routeType?></span>
                    </div>
                <?endif;?>
                <?if($routeDifficulty):?>
                    <div class="route-stat">
                        <span class="route-stat-label">Сложность:</span>
                        <span class="route-stat-value"><?=$routeDifficulty?></span>
                    </div>
                <?endif;?>
                <?if($routeDuration):?>
                    <div class="route-stat">
                        <span class="route-stat-label">Продолжительность:</span>
                        <span class="route-stat-value"><?=$routeDuration?></span>
                    </div>
                <?endif;?>
                <?if($routeDistance):?>
                    <div class="route-stat">
                        <span class="route-stat-label">Расстояние:</span>
                        <span class="route-stat-value"><?=$routeDistance?> км</span>
                    </div>
                <?endif;?>
                <div class="route-stat">
                    <span class="route-stat-label">Тип маршрута:</span>
                    <span class="route-stat-value"><?=$isCircular ? "Замкнутый" : "Линейный"?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Описание маршрута -->
    <?if($routeDetailText):?>
        <div class="route-description">
            <div class="container">
                <h2>О маршруте</h2>
                <div class="route-description-content">
                    <?=$routeDetailText?>
                </div>
            </div>
        </div>
    <?endif;?>

    <!-- Интерактивная карта маршрута -->
    <?if($arParams["DISPLAY_MAP"] !== "N" && !empty($arPoints)):?>
        <div class="route-map-section">
            <div class="container">
                <h2>Карта маршрута</h2>
                <div id="route-map"
                     style="width: 100%; height: <?=$arParams["MAP_HEIGHT"] ? $arParams["MAP_HEIGHT"] : 500?>px;"
                     data-circular="<?=$isCircular ? 'true' : 'false'?>"
                     data-route-type="<?=$routeLineType?>"
                     data-api-key="<?=$arParams["YANDEX_MAP_API_KEY"]?>"></div>
            </div>
        </div>
    <?endif;?>

    <!-- Точки маршрута -->
    <?if($arParams["DISPLAY_POINTS"] !== "N" && !empty($arPoints)):?>
        <div class="route-points-section">
            <div class="container">
                <h2>Точки маршрута</h2>
                <div class="route-points">
                    <?php foreach($arPoints as $index => $arPoint): ?>
                        <div class="route-point" id="point-<?=$arPoint["ID"]?>" data-lat="<?=$arPoint["LAT"]?>" data-lng="<?=$arPoint["LNG"]?>">
                            <div class="route-point-header">
                                <div class="route-point-number"><?=$index + 1?></div>
                                <h3 class="route-point-title"><?=$arPoint["NAME"]?></h3>
                            </div>

                            <div class="route-point-content">
                                <?php if($arPoint["PREVIEW_PICTURE"]): ?>
                                    <div class="route-point-image">
                                        <img src="<?=$arPoint["PREVIEW_PICTURE"]?>" alt="<?=$arPoint["NAME"]?>">
                                    </div>
                                <?php endif; ?>

                                <div class="route-point-text">
                                    <?=$arPoint["PREVIEW_TEXT"] ? $arPoint["PREVIEW_TEXT"] : $arPoint["DETAIL_TEXT"]?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?endif;?>

    <!-- Галерея маршрута -->
    <?if($arParams["DISPLAY_GALLERY"] !== "N" && !empty($arPoints)):?>
        <div class="route-gallery-section">
            <div class="container">
                <h2>Общая галерея маршрута</h2>
                <div class="route-gallery">
                    <?php foreach($arPoints as $arPoint): ?>
                        <?php if($arPoint["PREVIEW_PICTURE"]): ?>
                            <div class="gallery-item">
                                <a href="<?=$arPoint["PREVIEW_PICTURE"]?>" data-fancybox="gallery" data-caption="<?=htmlspecialchars($arPoint["NAME"])?>">
                                    <img src="<?=$arPoint["PREVIEW_PICTURE"]?>" alt="<?=htmlspecialchars($arPoint["NAME"])?>">
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?endif;?>

    <!-- Другие маршруты -->
    <?if($arParams["DISPLAY_RELATED"] !== "N"):?>
        <div class="other-routes-section">
            <div class="container">
                <h2>Другие маршруты</h2>
                <?php
                // Компонент для вывода других маршрутов
                $relatedCount = intval($arParams["RELATED_ROUTES_COUNT"]) > 0 ? intval($arParams["RELATED_ROUTES_COUNT"]) : 3;

                $GLOBALS["arrFilter"] = array(
                    "!ID" => $routeID, // Исключаем текущий маршрут
                );

                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "routes_list",
                    array(
                        "IBLOCK_TYPE" => "routes",
                        "IBLOCK_ID" => "31",
                        "SECTION_ID" => "",
                        "SECTION_CODE" => "",
                        "ELEMENT_SORT_FIELD" => "rand",
                        "ELEMENT_SORT_ORDER" => "asc",
                        "FILTER_NAME" => "arrFilter",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "SHOW_ALL_WO_SECTION" => "Y",
                        "HIDE_NOT_AVAILABLE" => "Y",
                        "PAGE_ELEMENT_COUNT" => $relatedCount,
                        "LINE_ELEMENT_COUNT" => $relatedCount,
                        "PROPERTY_CODE" => array("TYPE", "DIFFICULTY", "DURATION", "DISTANCE"),
                        "OFFERS_LIMIT" => "0",
                        "SECTION_URL" => "/routes/#SECTION_CODE#/", // если нужно
                        "DETAIL_URL" => "/routes/#ELEMENT_CODE#/",
                        "BASKET_URL" => "/personal/basket.php",
                        "ACTION_VARIABLE" => "action",
                        "PRODUCT_ID_VARIABLE" => "id",
                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_GROUPS" => "Y",
                        "DISPLAY_COMPARE" => "N",
                        "PRICE_CODE" => array(),
                        "USE_PRICE_COUNT" => "N",
                        "SHOW_PRICE_COUNT" => "1",
                        "PRICE_VAT_INCLUDE" => "Y",
                        "CONVERT_CURRENCY" => "N",
                        "PAGER_TEMPLATE" => "",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "PAGER_TITLE" => "Маршруты",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N"
                    ),
                    false
                );
                ?>
            </div>
        </div>
    <?endif;?>
</div>

<!-- Подключаем скрипты для работы с картой -->
<script src="https://api-maps.yandex.ru/2.1/?apikey=<?=$arParams["YANDEX_MAP_API_KEY"]?>&lang=ru_RU" type="text/javascript"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ymaps.ready(function() {
            var map = new ymaps.Map('route-map', {
                center: [55.76, 37.64], // Начальные координаты
                zoom: 10,
                controls: ['zoomControl', 'fullscreenControl']
            });

            // Получаем точки маршрута из HTML
            var pointElements = document.querySelectorAll('.route-point');
            var routePoints = [];

            // Создаем массив точек для построения маршрута
            pointElements.forEach(function(point, index) {
                var lat = parseFloat(point.dataset.lat);
                var lng = parseFloat(point.dataset.lng);

                if (!isNaN(lat) && !isNaN(lng)) {
                    routePoints.push([lat, lng]);

                    // Создаем маркер с номером точки
                    var marker = new ymaps.Placemark([lat, lng], {
                        iconContent: (index + 1).toString(),
                        balloonContent: point.querySelector('.route-point-title').textContent
                    }, {
                        preset: 'islands#blueCircleIcon'
                    });

                    map.geoObjects.add(marker);

                    // При клике на маркер прокручиваем к соответствующему блоку
                    marker.events.add('click', function() {
                        point.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                }
            });

            // Если есть точки для построения маршрута
            if (routePoints.length > 0) {
                // Проверяем, нужно ли замкнуть маршрут
                var isCircular = document.getElementById('route-map').dataset.circular === 'true';

                if (isCircular && routePoints.length > 2) {
                    // Добавляем первую точку в конец для замкнутого маршрута
                    routePoints.push(routePoints[0]);
                }

                // Определяем тип маршрута
                var routeType = document.getElementById('route-map').dataset.routeType;

                // Если у нас авто-маршрут, строим его через маршрутизатор
                if (routeType === "auto" && routePoints.length >= 2) {
                    var multiRoute = new ymaps.multiRouter.MultiRoute({
                        referencePoints: routePoints,
                        params: {
                            routingMode: 'auto'
                        }
                    }, {
                        boundsAutoApply: true
                    });

                    map.geoObjects.add(multiRoute);
                } else {
                    // Иначе просто соединяем точки линиями (для пешеходных маршрутов)
                    var routeLine = new ymaps.Polyline(routePoints, {}, {
                        strokeColor: "#1E98FF",
                        strokeWidth: 4,
                        strokeOpacity: 0.7
                    });

                    map.geoObjects.add(routeLine);

                    // Устанавливаем границы карты, чтобы были видны все точки
                    map.setBounds(map.geoObjects.getBounds(), {
                        checkZoomRange: true,
                        zoomMargin: 30
                    });
                }
            }

            // При клике на блок с точкой центрируем карту на этой точке
            pointElements.forEach(function(point) {
                point.addEventListener('click', function() {
                    var lat = parseFloat(this.dataset.lat);
                    var lng = parseFloat(this.dataset.lng);

                    if (!isNaN(lat) && !isNaN(lng)) {
                        map.setCenter([lat, lng], 15);
                    }
                });
            });
        });

        // Инициализируем фотогалерею, если подключена библиотека Fancybox
        if (typeof Fancybox !== 'undefined') {
            Fancybox.bind("[data-fancybox]", {
                // Опции Fancybox
            });
        }
    });
</script>
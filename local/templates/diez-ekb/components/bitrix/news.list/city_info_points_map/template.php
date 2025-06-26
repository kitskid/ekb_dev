<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

// Собираем данные для карты
$mapPoints = array();
foreach($arResult["ITEMS"] as $arItem) {
    if(!empty($arItem["PROPERTIES"]["COORDINATES"]["VALUE"])) {
        $coordinates = explode(',', $arItem["PROPERTIES"]["COORDINATES"]["VALUE"]);
        if(count($coordinates) == 2) {
            $mapPoints[] = array(
                'ID' => $arItem['ID'],
                'NAME' => $arItem['NAME'],
                'LAT' => trim($coordinates[0]),
                'LON' => trim($coordinates[1]),
                'ADDRESS' => $arItem["PROPERTIES"]["ADDRESS"]["VALUE"],
                'DESCRIPTION' => $arItem['PREVIEW_TEXT']
            );
        }
    }
}
// Кодируем данные для передачи в JavaScript
$mapPointsJson = json_encode($mapPoints);
// Уникальный ID для карты
$mapId = 'info_points_map_' . $this->randString();
?>

<div class="city-map-container">
    <div class="city-map-wrapper">
        <div id="<?=$mapId?>" class="city-map-canvas"></div>
    </div>

    <div class="info-points-container">
        <?php foreach($arResult["ITEMS"] as $arItem): ?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

            // Получаем координаты для маркера
            $markerCoords = '';
            if(!empty($arItem["PROPERTIES"]["COORDINATES"]["VALUE"])) {
                $markerCoords = $arItem["PROPERTIES"]["COORDINATES"]["VALUE"];
            }
            ?>

            <div class="info-point-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" data-coords="<?=$markerCoords?>">
                <h3 class="info-point-title"><?=$arItem["NAME"]?></h3>

                <?php if(!empty($arItem["PROPERTIES"]["ADDRESS"]["VALUE"])): ?>
                    <div class="info-point-address">
                        <i class="info-icon location-icon"></i>
                        <span><?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?></span>
                    </div>
                <?php endif; ?>

                <?php if(!empty($arItem["PROPERTIES"]["PHONE"]["VALUE"])): ?>
                    <div class="info-point-phone">
                        <i class="info-icon phone-icon"></i>
                        <a href="tel:<?=preg_replace('/[^0-9+]/', '', $arItem["PROPERTIES"]["PHONE"]["VALUE"])?>"><?=$arItem["PROPERTIES"]["PHONE"]["VALUE"]?></a>
                    </div>
                <?php endif; ?>

                <?php if(!empty($arItem["PROPERTIES"]["WORKING_HOURS"]["VALUE"])): ?>
                    <div class="info-point-hours">
                        <i class="info-icon clock-icon"></i>
                        <span><?=$arItem["PROPERTIES"]["WORKING_HOURS"]["VALUE"]?></span>
                    </div>
                <?php endif; ?>

                <?php if(!empty($arItem["PROPERTIES"]["EMAIL"]["VALUE"])): ?>
                    <div class="info-point-email">
                        <i class="info-icon email-icon"></i>
                        <a href="mailto:<?=$arItem["PROPERTIES"]["EMAIL"]["VALUE"]?>"><?=$arItem["PROPERTIES"]["EMAIL"]["VALUE"]?></a>
                    </div>
                <?php endif; ?>

                <?php if(!empty($arItem["PROPERTIES"]["WEBSITE"]["VALUE"])): ?>
                    <div class="info-point-website">
                        <i class="info-icon website-icon"></i>
                        <a href="<?=$arItem["PROPERTIES"]["WEBSITE"]["VALUE"]?>" target="_blank"><?=$arItem["PROPERTIES"]["WEBSITE"]["VALUE"]?></a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* Стили для блока карты и информационных пунктов */
    .city-map-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin-top: 30px;
    }

    .city-map-wrapper {
        flex: 1;
        min-width: 60%;
    }

    .city-map-canvas {
        width: 100%;
        height: 500px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .info-points-container {
        flex: 1;
        min-width: 300px;
        max-height: 500px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .info-point-item {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .info-point-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .info-point-item.active {
        border-left: 4px solid #008CD2;
    }

    .info-point-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }

    .info-point-address,
    .info-point-phone,
    .info-point-hours,
    .info-point-email,
    .info-point-website {
        display: flex;
        align-items: flex-start;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .info-icon {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 10px;
        position: relative;
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        flex-shrink: 0;
    }

    .location-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23FF5722"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>');
    }

    .phone-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%234CAF50"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>');
    }

    .clock-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%232196F3"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>');
    }

    .email-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23673AB7"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>');
    }

    .website-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23009688"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95c-.32-1.25-.78-2.45-1.38-3.56 1.84.63 3.37 1.91 4.33 3.56zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56-1.84-.63-3.37-1.9-4.33-3.56zm2.95-8H5.08c.96-1.66 2.49-2.93 4.33-3.56C8.81 5.55 8.35 6.75 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95c-.96 1.65-2.49 2.93-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z"/></svg>');
    }

    .info-point-phone a,
    .info-point-email a,
    .info-point-website a {
        color: #008CD2;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .info-point-phone a:hover,
    .info-point-email a:hover,
    .info-point-website a:hover {
        color: #006699;
        text-decoration: underline;
    }

    /* Адаптивные стили */
    @media (max-width: 992px) {
        .city-map-container {
            flex-direction: column;
        }

        .city-map-wrapper,
        .info-points-container {
            width: 100%;
        }

        .city-map-canvas {
            height: 400px;
        }

        .info-points-container {
            max-height: none;
            padding-right: 0;
        }
    }

    @media (max-width: 576px) {
        .city-map-canvas {
            height: 300px;
        }

        .info-point-item {
            padding: 15px;
        }

        .info-point-title {
            font-size: 16px;
        }
    }
</style>

<script>
    // Функция инициализации после загрузки API Яндекс.Карт
    function initPointsMap() {
        // Получаем данные о точках
        var mapPoints = <?=$mapPointsJson?>;

        // Если нет точек, выходим
        if (mapPoints.length === 0) {
            return;
        }

        // Создаем карту
        var myMap = new ymaps.Map('<?=$mapId?>', {
            center: [mapPoints[0].LAT, mapPoints[0].LON], // Центр по первой точке
            zoom: 12,
            controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
        });

        // Добавляем элементы управления для мобильных устройств
        if (window.innerWidth <= 768) {
            myMap.controls.add('geolocationControl');
        }

        // Коллекция меток
        var objectManager = new ymaps.ObjectManager({
            clusterize: true,
            gridSize: 64,
            clusterDisableClickZoom: false
        });

        // Создаем массив объектов для карты
        var objects = [];

        // Добавляем метки на карту
        mapPoints.forEach(function(point, index) {
            objects.push({
                type: 'Feature',
                id: point.ID,
                geometry: {
                    type: 'Point',
                    coordinates: [point.LAT, point.LON]
                },
                properties: {
                    balloonContentHeader: point.NAME,
                    balloonContentBody: point.ADDRESS,
                    balloonContentFooter: point.DESCRIPTION,
                    clusterCaption: point.NAME,
                    hintContent: point.NAME
                },
                options: {
                    preset: 'islands#blueInfoIcon',
                    iconColor: '#008CD2'
                }
            });
        });

        objectManager.add({
            type: 'FeatureCollection',
            features: objects
        });

        myMap.geoObjects.add(objectManager);

        // Устанавливаем границы карты по всем точкам
        if (mapPoints.length > 1) {
            var bounds = [];
            mapPoints.forEach(function(point) {
                bounds.push([point.LAT, point.LON]);
            });
            myMap.setBounds(bounds, { checkZoomRange: true });
        }

        // Обработчики событий для точек в списке
        var infoPoints = document.querySelectorAll('.info-point-item');

        infoPoints.forEach(function(point) {
            point.addEventListener('click', function() {
                // Убираем активный класс со всех точек
                infoPoints.forEach(function(p) {
                    p.classList.remove('active');
                });

                // Добавляем активный класс к текущей точке
                this.classList.add('active');

                // Получаем координаты
                var coordsStr = this.getAttribute('data-coords');
                if (coordsStr) {
                    var coords = coordsStr.split(',');
                    if (coords.length === 2) {
                        // Центрируем карту на выбранной точке
                        myMap.setCenter([parseFloat(coords[0]), parseFloat(coords[1])], 15, {
                            duration: 500
                        });

                        // Открываем балун с информацией
                        objectManager.objects.each(function(object) {
                            if (object.geometry.coordinates[0] == parseFloat(coords[0]) &&
                                object.geometry.coordinates[1] == parseFloat(coords[1])) {
                                objectManager.objects.setObjectOptions(object.id, {
                                    preset: 'islands#redInfoIcon',
                                    iconColor: '#FF5722'
                                });
                            } else {
                                objectManager.objects.setObjectOptions(object.id, {
                                    preset: 'islands#blueInfoIcon',
                                    iconColor: '#008CD2'
                                });
                            }
                        });
                    }
                }
            });
        });

        // Активируем первую точку по умолчанию
        if (infoPoints.length > 0) {
            infoPoints[0].click();
        }
    }

    // Загружаем Яндекс.Карты
    // document.addEventListener('DOMContentLoaded', function() {
    //     var script = document.createElement('script');
    //     // script.src = 'https://api-maps.yandex.ru/2.1/?apikey=ваш_API_ключ&lang=ru_RU&onload=initPointsMap';
    //     script.async = true;
    //     document.head.appendChild(script);
    // });
</script>

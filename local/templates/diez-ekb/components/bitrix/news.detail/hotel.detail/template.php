<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

$isTop = !empty($arResult["PROPERTIES"]["TOP"]["VALUE"]);
$rating = !empty($arResult["PROPERTIES"]["RATING"]["VALUE"]) ? $arResult["PROPERTIES"]["RATING"]["VALUE"] : "0";
$stars = !empty($arResult["PROPERTIES"]["STARS"]["VALUE"]) ? intval($arResult["PROPERTIES"]["STARS"]["VALUE"]) : 0;
$price = !empty($arResult["PROPERTIES"]["PRICE"]["VALUE"]) ? $arResult["PROPERTIES"]["PRICE"]["VALUE"] : "";
$address = !empty($arResult["PROPERTIES"]["ADDRESS"]["VALUE"]) ? $arResult["PROPERTIES"]["ADDRESS"]["VALUE"] : "";
$phone = !empty($arResult["PROPERTIES"]["PHONE"]["VALUE"]) ? $arResult["PROPERTIES"]["PHONE"]["VALUE"] : "";
$email = !empty($arResult["PROPERTIES"]["EMAIL"]["VALUE"]) ? $arResult["PROPERTIES"]["EMAIL"]["VALUE"] : "";
$openHours = !empty($arResult["PROPERTIES"]["OPEN_HOURS"]["~VALUE"]["TEXT"]) ? $arResult["PROPERTIES"]["OPEN_HOURS"]["~VALUE"]["TEXT"] : "";
$features = !empty($arResult["PROPERTIES"]["FEATURES"]["VALUE"]) ? $arResult["PROPERTIES"]["FEATURES"]["VALUE"] : array();
$gallery = !empty($arResult["PROPERTIES"]["GALLERY"]["VALUE"]) ? $arResult["PROPERTIES"]["GALLERY"]["VALUE"] : array();
$coordinates = !empty($arResult["PROPERTIES"]["COORDINATES"]["VALUE"]) ? $arResult["PROPERTIES"]["COORDINATES"]["VALUE"] : "";
?>

<main class="main main--offset">
    <section class="section">
        <div class="container">
            <div class="breadcrumbs">
                <a href="/" class="breadcrumbs__link">Главная</a>
                <a href="/hotels/" class="breadcrumbs__link">Гостиницы города</a>
                <p class="breadcrumbs__link"><?=$arResult["NAME"]?></p>
            </div>
        </div>
    </section>
    <section class="section section--hotels pt-70 ptm-50 pb-140 pbm-40">
        <div class="container">
            <div class="hotel-page">
                <div class="hotel-page__info">
                    <div class="hotel-page__meta">
                        <div class="meta-info">
                            <p class="meta-info__text">
                                <?
                                if (!empty($arResult["PROPERTIES"]["TYPE"]["VALUE_ENUM"]) && is_array($arResult["PROPERTIES"]["TYPE"]["VALUE_ENUM"])) {
                                    foreach ($arResult["PROPERTIES"]["TYPE"]["VALUE_ENUM"] as $str) {
                                        echo mb_convert_case(mb_substr($str, 0, 1), MB_CASE_UPPER, "UTF-8").mb_convert_case(mb_substr($str, 1, mb_strlen($str) -1 ), MB_CASE_LOWER, "UTF-8") . ' ';
                                    }
                                } else {
                                    echo "Отель-гостиница";
                                } ?>
                            </p>
                            <div class="rating">
                                <div class="rating__list">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <svg class="rating__icon<?=($i <= $stars) ? ' active' : ''?>">
                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-star"></use>
                                        </svg>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <div class="meta-info">
                            <p class="meta-info__text">Рейтинг</p>
                            <div class="rating">
                                <p class="rating__text"><?=$rating?></p>
                            </div>
                        </div>
                        <?php if($isTop): ?>
                            <div class="hotel-page__tag hotel-page__tag--green">Топ</div>
                        <?php endif; ?>
                    </div>
                    <div class="hotel-page__detail">
                        <div class="hotel-page__about">
                            <h1 class="title title--small"><?=$arResult["NAME"]?></h1>
                            <?php if($address): ?>
                                <p class="hotel-page__place">
                                    <svg>
                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                    </svg>
                                    <span><?=$address?></span>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="hotel-page__side">
                            <?php if($price): ?>
                                <p class="price"><?=$price?></p>
                            <?php endif; ?>
                            <a class="hotel-page__link" href="#hotel-page-map">Посмотреть на карте</a>
                        </div>
                    </div>
                    <?php if(!empty($features)): ?>

                        <div class="hotel-page__features">
                            <?php foreach($features as $feature): ?>
                                <div class="hotel-page__feature">
                                    <?php
                                    $iconMap = array(
                                        'Есть Wi-Fi' => 'icon-wifi.svg',
                                        'Есть парковка' => 'icon-parking.svg',
                                        'Кондиционер в номерах' => 'icon-fridge.svg',
                                        'Есть трансфер ' => 'icon-fridge.svg'
                                    );
                                    $icon = isset($iconMap[$feature]) ? $iconMap[$feature] : 'icon-wifi.svg';
                                    ?>
                                    <img src="/local/templates/diez-ekb/assets/images/icons/<?=$icon?>" alt="">
                                    <span><?=$feature?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="hotel-page__content">
                    <?php if(!empty($gallery)): ?>
                        <div class="hotel-page__pictures mob-hidden">
                            <?php foreach($gallery as $key => $imageId):
                                $image = CFile::GetFileArray($imageId);
                                if($image):
                                    ?>
                                    <picture class="hotel-page__picture<?=($key == 0) ? ' hotel-page__picture--main' : ''?>"
                                             data-fancybox="pictures" data-src="<?=$image['SRC']?>">
                                        <img src="<?=$image['SRC']?>" alt="<?=$arResult['NAME']?>">
                                    </picture>
                                <?php endif; endforeach; ?>
                        </div>
                        <div class="slider desktop-hidden" data-slider="default">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <?php foreach($gallery as $imageId):
                                        $image = CFile::GetFileArray($imageId);
                                        if($image):
                                            ?>
                                            <div class="swiper-slide">
                                                <picture class="hotel-page__picture" data-fancybox="pictures-mob"
                                                         data-src="<?=$image['SRC']?>">
                                                    <img src="<?=$image['SRC']?>" alt="<?=$arResult['NAME']?>">
                                                </picture>
                                            </div>
                                        <?php endif; endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="hotel-page__body">
                        <div class="hotel-page__editor">
                            <div class="editor editor--longrid">
                                <?=$arResult["DETAIL_TEXT"]?>
                            </div>
                        </div>
                        <aside class="sidebar sidebar--center">
                            <?php if($openHours): ?>
                                <p class="sidebar__head">время работы:</p>
                                <p class="sidebar__text">
                                    <?=$openHours?>
                                </p>
                            <?php endif; ?>
                            <?php if($phone || $email): ?>
                                <p class="sidebar__head">Контакты</p>
                                <p class="sidebar__text">
                                    <?php if($phone): ?>
                                        <a href="tel:<?=preg_replace('/[^0-9+]/', '', $phone)?>"><?=$phone?></a>
                                    <?php endif; ?>
                                    <?php if($email): ?>
                                        <a href="mailto:<?=$email?>"><?=$email?></a>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                            <button class="button button--mob-wide">Забронировать</button>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if($coordinates): ?>
        <section class="section section--logo-bg section--logo-bg-top pt-55 ptm-55 pb-130 pbm-80" id="hotel-page-map">
            <div class="container">
                <div class="header-block">
                    <h2 class="title title--small">Расположение</h2>
                </div>
                <div class="map">
                    <div id="hotelMap" class="yandex-map" data-coordinates="<?=$coordinates?>"></div>
                </div>
            </div>
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof ymaps !== 'undefined') {
                    ymaps.ready(function() {
                        var mapElement = document.getElementById('hotelMap');
                        var coordinates = mapElement.dataset.coordinates.split(',').map(function(coord) {
                            return parseFloat(coord.trim());
                        });

                        if (coordinates.length === 2) {
                            var map = new ymaps.Map('hotelMap', {
                                center: coordinates,
                                zoom: 16,
                                controls: ['zoomControl', 'fullscreenControl']
                            });

                            var placemark = new ymaps.Placemark(coordinates, {
                                hintContent: '<?=CUtil::JSEscape($arResult["NAME"])?>',
                                balloonContent: '<strong><?=CUtil::JSEscape($arResult["NAME"])?></strong>' +
                                    '<?=!empty($arResult["PROPERTIES"]["ADDRESS"]["VALUE"]) ? "<br>Адрес: " . CUtil::JSEscape($arResult["PROPERTIES"]["ADDRESS"]["VALUE"]) : ""?>' +
                                    '<?=!empty($arResult["PROPERTIES"]["PHONE"]["VALUE"]) ? "<br>Телефон: " . CUtil::JSEscape($arResult["PROPERTIES"]["PHONE"]["VALUE"]) : ""?>'
                            }, {
                                preset: 'islands#redDotIcon'
                            });

                            map.geoObjects.add(placemark);
                        }
                    });
                }
            });
        </script>
    <?php endif; ?>
    <style>
        .yandex-map {
            width: 100%;
            height: 100%;
            border: 1px solid #ddd;
            position: relative;
        }

        @media (max-width: 768px) {
            .yandex-map {
                height: 300px;
            }
        }
    </style>
<!--    --><?php //if($coordinates): ?>
<!--        <section class="section section--logo-bg section--logo-bg-top pt-55 ptm-55 pb-130 pbm-80" id="hotel-page-map">-->
<!--            <div class="container">-->
<!--                <div class="header-block">-->
<!--                    <h2 class="title title--small">Расположение</h2>-->
<!--                </div>-->
<!--                <div class="map">-->
<!--                    <iframe src="https://yandex.ru/map-widget/v1/?ll=--><?//=$coordinates?><!--&z=13.62" width="560" height="400"-->
<!--                            frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
<!--    --><?php //endif; ?>
</main>

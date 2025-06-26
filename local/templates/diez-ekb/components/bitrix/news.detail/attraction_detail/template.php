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

// Устанавливаем заголовок страницы
$APPLICATION->SetTitle($arResult["NAME"]);
?>

<div class="attraction-detail">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1><?=$arResult["NAME"]?></h1>

                <?php if(!empty($arResult["DISPLAY_PROPERTIES"]["ADDRESS"]["VALUE"])): ?>
                    <div class="attraction-detail__address">
                        <i class="fa fa-map-marker"></i> <?=$arResult["DISPLAY_PROPERTIES"]["ADDRESS"]["VALUE"]?>
                    </div>
                <?php endif; ?>

                <?php if(!empty($arResult["DETAIL_PICTURE"])): ?>
                    <div class="attraction-detail__image">
                        <img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>" class="img-fluid">
                    </div>
                <?php elseif(!empty($arResult["PREVIEW_PICTURE"])): ?>
                    <div class="attraction-detail__image">
                        <img src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>" class="img-fluid">
                    </div>
                <?php endif; ?>

                <?php if(!empty($arResult["DETAIL_TEXT"])): ?>
                    <div class="attraction-detail__description">
                        <?=$arResult["DETAIL_TEXT"]?>
                    </div>
                <?php elseif(!empty($arResult["PREVIEW_TEXT"])): ?>
                    <div class="attraction-detail__description">
                        <?=$arResult["PREVIEW_TEXT"]?>
                    </div>
                <?php endif; ?>

                <?php
                // Если есть связанные маршруты
                if(!empty($arResult["PROPERTIES"]["BINDING"]["VALUE"]) && is_array($arResult["PROPERTIES"]["BINDING"]["VALUE"])):
                    $routeIds = $arResult["PROPERTIES"]["BINDING"]["VALUE"];
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

                    if($rsRoutes->SelectedRowsCount() > 0):
                        ?>
                        <div class="attraction-detail__routes">
                            <h3>Входит в маршруты:</h3>
                            <ul>
                                <?php while($arRoute = $rsRoutes->GetNext()): ?>
                                    <li><a href="<?=$arRoute["DETAIL_PAGE_URL"]?>"><?=$arRoute["NAME"]?></a></li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php
                    endif;
                endif;
                ?>

                <div class="attraction-detail__back">
                    <a href="/attractions/" class="btn btn-primary">Вернуться к списку достопримечательностей</a>
                </div>
            </div>

            <div class="col-md-4">
                <?php if(!empty($arResult["PROPERTIES"]["COORDINATES"]["VALUE"])): ?>
                    <div class="attraction-detail__map">
                        <div id="attractionMap" class="yandex-map" data-coordinates="<?=$arResult["PROPERTIES"]["COORDINATES"]["VALUE"]?>"></div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            if (typeof ymaps !== 'undefined') {
                                ymaps.ready(function() {
                                    var mapElement = document.getElementById('attractionMap');
                                    var coordinates = mapElement.dataset.coordinates.split(',').map(function(coord) {
                                        return parseFloat(coord.trim());
                                    });

                                    if (coordinates.length === 2) {
                                        var map = new ymaps.Map('attractionMap', {
                                            center: coordinates,
                                            zoom: 16,
                                            controls: ['zoomControl', 'fullscreenControl']
                                        });

                                        var placemark = new ymaps.Placemark(coordinates, {
                                            hintContent: '<?=CUtil::JSEscape($arResult["NAME"])?>',
                                            balloonContent: '<strong><?=CUtil::JSEscape($arResult["NAME"])?></strong>' +
                                                '<?=!empty($arResult["DISPLAY_PROPERTIES"]["ADDRESS"]["VALUE"]) ? "<br>Адрес: " . CUtil::JSEscape($arResult["DISPLAY_PROPERTIES"]["ADDRESS"]["VALUE"]) : ""?>'
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

                <!-- Дополнительная информация в сайдбаре (можно добавить блок related info, теги и т.д.) -->
                <div class="attraction-detail__sidebar-block">
                    <h3>Другие достопримечательности</h3>
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "attractions_sidebar",
                        Array(
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "/attractions/#ELEMENT_CODE#/",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "DISPLAY_DATE" => "N",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "Y",
                            "DISPLAY_PREVIEW_TEXT" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "CODE"),
                            "FILTER_NAME" => "",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "IBLOCK_ID" => $arResult["IBLOCK_ID"],
                            "IBLOCK_TYPE" => $arResult["IBLOCK_TYPE_ID"],
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "MESSAGE_404" => "",
                            "NEWS_COUNT" => "3",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => "Достопримечательности",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "PROPERTY_CODE" => array("ADDRESS"),
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SORT_BY1" => "RAND",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER1" => "DESC",
                            "SORT_ORDER2" => "ASC",
                            "STRICT_SECTION_CHECK" => "N",
                            "ELEMENT_ID" => $arResult["ID"]
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

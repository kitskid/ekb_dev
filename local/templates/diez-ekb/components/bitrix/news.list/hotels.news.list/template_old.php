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

if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') {
    $APPLICATION->RestartBuffer();
    $this->setFrameMode(false);
}

// Получаем уникальные категории (типы) из элементов для фильтров
$categories = array();
$categories['all'] = 'Все';

if (!empty($arResult["ITEMS"])) {
    foreach ($arResult["ITEMS"] as $arItem) {
        // Проверяем, является ли свойство TYPE множественным
        if (isset($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
            // Если это массив (множественное свойство)
            if (is_array($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
                // Обрабатываем каждое значение массива
                foreach ($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] as $key => $xml_id) {
                    if (!empty($xml_id) && is_scalar($xml_id)) {
                        $xmlId = (string)$xml_id;
                        // Соответствующее значение VALUE также должно быть массивом
                        $value = isset($arItem["PROPERTIES"]["TYPE"]["VALUE"][$key]) ?
                            $arItem["PROPERTIES"]["TYPE"]["VALUE"][$key] : $xmlId;
                        $categories[$xmlId] = mb_strtoupper($value, "UTF-8");
                    }
                }
            }
            // Если это строка или скалярное значение (обычное свойство)
            elseif (!empty($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"]) &&
                is_scalar($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
                $xmlId = (string)$arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"];
                $categories[$xmlId] = $arItem["PROPERTIES"]["TYPE"]["VALUE"];
            }
        }
    }
}

?>

<section class="hotels-section">
    <div class="container">
        <div class="section-heading">
            <h2 class="section-title">Где остановиться</h2>

            <!-- Filter tabs -->
            <div class="filter-tabs">
                <?php
                $i = 0;
                foreach ($categories as $xmlId => $name) {
                    $activeClass = ($i == 0) ? 'active' : '';
                    ?>
                    <button class="filter-tab <?=$activeClass?>" data-filter="<?=$xmlId?>"><?=$name?></button>
                    <?php
                    $i++;
                }
                ?>
            </div>
        </div>

        <?php if ($arResult["ITEMS"]): ?>
            <div class="hotels-grid">
                <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                    // Определяем категорию с учетом возможности множественного свойства
                    $category = '';
                    if (isset($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
                        if (is_array($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
                            // Берем первое значение для отображения в data-category
                            if (!empty($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"][0])) {
                                $category = (string)$arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"][0];
                            }
                            // Для фильтрации мы используем все категории, добавляя их как data-атрибуты
                            $allCategories = array_map(function($val) {
                                return (string)$val;
                            }, $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"]);
                            $allCategoriesString = implode(' ', $allCategories);
                        } else {
                            $category = (string)$arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"];
                            $allCategoriesString = $category;
                        }
                    }

                    // Определяем картинку
                    $previewPicture = '';
                    if (isset($arItem["PREVIEW_PICTURE"]["SRC"]) && !empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
                        $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"];
                    } elseif (isset($arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"])) {
                        // Проверяем, является ли FILE_VALUE массивом или одиночным значением
                        if (is_array($arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"])) {
                            if (isset($arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"][0]["SRC"])) {
                                $previewPicture = $arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"][0]["SRC"];
                            } elseif (isset($arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"]["SRC"])) {
                                $previewPicture = $arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"]["SRC"];
                            }
                        } elseif (isset($arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"]["SRC"])) {
                            $previewPicture = $arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"]["SRC"];
                        }
                    }

                    $detailPageUrl = $arItem["DETAIL_PAGE_URL"];
                    ?>

                    <a href="<?=$detailPageUrl?>" class="hotel-card" data-category="<?=$category?>" data-all-categories="<?=$allCategoriesString?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="hotel-card__image">
                            <?php if ($previewPicture): ?>
                                <img src="<?=$previewPicture?>" alt="<?=$arItem["NAME"]?>">
                            <?php else: ?>
                                <div class="hotel-card__no-image"></div>
                            <?php endif; ?>

                            <?php if (!empty($arItem["PROPERTIES"]["TOP"]["VALUE"])): ?>
                                <div class="hotel-card__badge">ТОП</div>
                            <?php endif; ?>
                        </div>
                        <div class="hotel-card__content">
                            <h3 class="hotel-card__title"><?=$arItem["NAME"]?></h3>
                            <?php if (!empty($arItem["PROPERTIES"]["ADDRESS"]["VALUE"])): ?>
                                <div class="hotel-card__address"><?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?></div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
                <div class="pagination">
                    <?=$arResult["NAV_STRING"]?>
                    <?php if ($arResult["NAV_RESULT"]->nEndPage > 1 && $arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->nEndPage): ?>
                        <a href="<?=$arResult["NAV_RESULT"]->GetUrlNewPage($arResult["NAV_RESULT"]->NavPageNomer + 1)?>" class="pagination__more-btn">Показать еще</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>В данный момент нет доступных гостиниц.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Карта гостиниц -->
<section class="map-section">
    <div class="container">
        <h2 class="section-title">Карта гостиниц</h2>
        <div id="hotel-map" style="width:100%; height:500px;"></div>
    </div>
</section>

<?php
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') {
    die();
}
?>

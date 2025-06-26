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

// Проверяем, является ли это AJAX-запросом
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') {
    $APPLICATION->RestartBuffer();
    $this->setFrameMode(false);

    // Обработка фильтрации по кухне
    $filterCategory = isset($_REQUEST['cuisine']) ? $_REQUEST['cuisine'] : 'all';

    // Если указан фильтр не "all", отфильтруем элементы
    if ($filterCategory !== 'all') {
        $filteredItems = array();
        foreach ($arResult["ITEMS"] as $arItem) {
            if (isset($arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"]) &&
                $arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"] === $filterCategory) {
                $filteredItems[] = $arItem;
            }
        }
        $arResult["ITEMS"] = $filteredItems;
    }
}

// Получаем уникальные категории (кухни) из элементов для фильтров
$cuisineCategories = array();
$cuisineCategories['all'] = 'Все';

// Получаем уникальные особенности
$featureCategories = array();

if (!empty($arResult["ITEMS"])) {
    foreach ($arResult["ITEMS"] as $arItem) {
        // Кухни
        if (isset($arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"]) && !empty($arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"])) {
            $cuisineCategories[$arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"]] = $arItem["PROPERTIES"]["CUISINE"]["VALUE"];
        }

        // Особенности (множественное свойство)
        if (isset($arItem["PROPERTIES"]["FEATURES"]["VALUE"]) && is_array($arItem["PROPERTIES"]["FEATURES"]["VALUE"])) {
            foreach ($arItem["PROPERTIES"]["FEATURES"]["VALUE"] as $key => $featureValue) {
                $featureXmlId = $arItem["PROPERTIES"]["FEATURES"]["VALUE_XML_ID"][$key];
                if (!empty($featureXmlId) && !isset($featureCategories[$featureXmlId])) {
                    $featureCategories[$featureXmlId] = $featureValue;
                }
            }
        }
    }
}

// Формируем уникальный идентификатор для компонента
$containerId = 'restaurant_list_' . $this->randString();
?>

<section class="restaurants-section" id="<?=$containerId?>">
    <div class="container">
        <div class="section-heading">
            <h2 class="section-title">Где поесть</h2>

            <!-- Filter tabs for cuisines -->
            <div class="filter-tabs cuisine-filter" data-filter-type="cuisine">
                <?php
                $i = 0;
                foreach ($cuisineCategories as $xmlId => $name) {
                    $activeClass = ($i == 0) ? 'active' : '';
                    ?>
                    <button class="filter-tab <?=$activeClass?>" data-filter="<?=$xmlId?>"><?=$name?></button>
                    <?php
                    $i++;
                }
                ?>
            </div>

            <?php if (!empty($featureCategories)): ?>
                <!-- Filter tags for features -->
                <div class="filter-tags feature-filter" data-filter-type="feature">
                    <div class="filter-tags__label">Особенности:</div>
                    <div class="filter-tags__list">
                        <?php foreach ($featureCategories as $xmlId => $name): ?>
                            <div class="filter-tag" data-filter="<?=$xmlId?>"><?=$name?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="restaurants-wrapper">
            <?php if (!empty($arResult["ITEMS"])): ?>
                <div class="restaurants-grid">
                    <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                        <?
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                        $category = $arItem["PROPERTIES"]["CUISINE"]["VALUE_XML_ID"] ?: strtolower($arItem["PROPERTIES"]["CUISINE"]["VALUE"]);

                        // Получаем особенности в формате для data-атрибута
                        $features = array();
                        if (isset($arItem["PROPERTIES"]["FEATURES"]["VALUE_XML_ID"]) && is_array($arItem["PROPERTIES"]["FEATURES"]["VALUE_XML_ID"])) {
                            $features = $arItem["PROPERTIES"]["FEATURES"]["VALUE_XML_ID"];
                        }
                        $featuresAttr = htmlspecialcharsbx(json_encode($features));

                        $previewPicture = $arItem["PREVIEW_PICTURE"]["SRC"] ?: $arItem["DISPLAY_PROPERTIES"]["GALLERY"]["FILE_VALUE"][0]["SRC"];
                        $detailPageUrl = $arItem["DETAIL_PAGE_URL"];
                        ?>

                        <a href="<?=$detailPageUrl?>" class="restaurant-card"
                           data-category="<?=$category?>"
                           data-features='<?=$featuresAttr?>'
                           data-id="<?=$arItem['ID']?>"
                           id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <div class="restaurant-card__image">
                                <?php if ($previewPicture): ?>
                                    <img src="<?=$previewPicture?>" alt="<?=$arItem["NAME"]?>">
                                <?php else: ?>
                                    <div class="restaurant-card__no-image"></div>
                                <?php endif; ?>

                                <?php if (!empty($arItem["PROPERTIES"]["TOP"]["VALUE"])): ?>
                                    <div class="restaurant-card__badge">ТОП</div>
                                <?php endif; ?>
                            </div>
                            <div class="restaurant-card__content">
                                <h3 class="restaurant-card__title"><?=$arItem["NAME"]?></h3>
                                <?php if (!empty($arItem["PROPERTIES"]["ADDRESS"]["VALUE"])): ?>
                                    <div class="restaurant-card__address"><?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?></div>
                                <?php endif; ?>

                                <?php if (!empty($features)): ?>
                                    <div class="restaurant-card__features">
                                        <?php foreach ($features as $key => $featureXmlId): ?>
                                            <span class="restaurant-card__feature"><?=$arItem["PROPERTIES"]["FEATURES"]["VALUE"][$key]?></span>
                                        <?php endforeach; ?>
                                    </div>
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
                <div class="restaurants-empty">В данный момент нет доступных ресторанов.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    // Передаем идентификатор секции для JavaScript
    BX.ready(function() {
        window.restaurantsContainerId = '<?=$containerId?>';
    });
</script>

<?php
// Если это AJAX-запрос, завершаем выполнение
if (isset($_REQUEST['ajax_filter']) && $_REQUEST['ajax_filter'] == 'Y') {
    die();
}
?>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Рестораны города | Екатеринбург");
?>

<body class="page">
<!-- 
MAIN CONTENT
В Bitrix будет обернуто в:
<div id="workarea"> 
<?//$APPLICATION->IncludeComponent("bitrix:breadcrumb", "", []);?>
-->
<main class="main">
    <!-- Hero section with main title -->
    <section class="hero" style="background-image: url('/img/restaurants-bg.jpg');">
        <div class="container">
            <h1 class="hero__title">Рестораны города</h1>
            <p class="hero__text">
                В 2023 году Екатеринбург отпразднует свое 300-летие. Свою историю город отсчитывает с 18 ноября 1723 года, когда были запущены цеха крупнейшего в России железоделательного Екатеринбургского завода.
            </p>
        </div>
    </section>

    <?php
    // Создайте файл /local/templates/.default/components/bitrix/news.list/restaurants_list/filter.php

    // Инициализация фильтра
    $restaurantsFilter = array(
        "ACTIVE" => "Y",
    );

    // Обработка фильтрации по типу кухни
    if (isset($_REQUEST['cuisine']) && $_REQUEST['cuisine'] != 'all') {
        $cuisine = htmlspecialcharsbx($_REQUEST['cuisine']);
        $restaurantsFilter["PROPERTY_CUISINE_VALUE_XML_ID"] = $cuisine;
    }

    // Обработка фильтрации по особенностям (множественное свойство)
    if (isset($_REQUEST['features']) && !empty($_REQUEST['features'])) {
        $features = is_array($_REQUEST['features']) ? $_REQUEST['features'] : [$_REQUEST['features']];

        if (count($features) == 1) {
            $restaurantsFilter["PROPERTY_FEATURES_VALUE_XML_ID"] = $features[0];
        } else {
            $featureFilter = array(
                "LOGIC" => "OR"
            );

            foreach ($features as $feature) {
                $featureFilter[] = array("PROPERTY_FEATURES_VALUE_XML_ID" => htmlspecialcharsbx($feature));
            }

            $restaurantsFilter[] = $featureFilter;
        }
    }

    // Задаем глобальную переменную для использования в компоненте
    $GLOBALS["restaurantsFilter"] = $restaurantsFilter;
    ?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "restaurants.news.list",
        Array(
            "DISPLAY_DATE" => "N",
            "SET_TITLE" => "N",
            "IBLOCK_TYPE" => "infrastructure",
            "IBLOCK_ID" => "21",
            "NEWS_COUNT" => "12",
            "SORT_BY1" => "SORT",
            "SORT_ORDER1" => "ASC",
            "FILTER_NAME" => "restaurantsFilter",
            "FIELD_CODE" => Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_TEXT"),
            "PROPERTY_CODE" => Array("ADDRESS", "PHONE", "CUISINE", "PRICE_CATEGORY", "COORDINATES"),
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "/guests/restaurants/#ELEMENT_CODE#/",
            "PREVIEW_TRUNCATE_LEN" => "150",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "SET_STATUS_404" => "Y",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_FILTER" => "Y",
            "PAGER_TEMPLATE" => "modern",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Рестораны",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
        )
    );?>

    <!-- Restaurants map section -->
    <section class="map-section">
        <div class="container">
            <h2 class="section-title">Карта ресторанов</h2>

            <?$APPLICATION->IncludeComponent(
                "a2a:map.yandex",
                "restaurants_map",
                Array(
                    "IBLOCK_TYPE" => "infrastructure",
                    "IBLOCK_ID" => "21",
                    "MAP_HEIGHT" => "500px",
                    "MAP_WIDTH" => "100%",
                    "INIT_MAP_TYPE" => "MAP",
                    "MAP_DATA" => "COORDINATES",
                    "FILTER_NAME" => "restaurantsMapFilter",
                    "PROPERTY_CODE" => Array("COORDINATES", "ADDRESS", "NAME", "PREVIEW_PICTURE"),
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                )
            );?>
        </div>
    </section>
</main>
</body>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
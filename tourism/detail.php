<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

// Получаем ELEMENT_CODE из разных источников
$elementCode = '';
if (!empty($_REQUEST["ELEMENT_CODE"])) {
    $elementCode = $_REQUEST["ELEMENT_CODE"];
} elseif (!empty($_GET["ELEMENT_CODE"])) {
    $elementCode = $_GET["ELEMENT_CODE"];
} else {
    // Парсим из REQUEST_URI
    if (preg_match('#^/tourism/([^/]+)/?$#', $_SERVER['REQUEST_URI'], $matches)) {
        $elementCode = $matches[1];
    }
}

if (empty($elementCode)) {
    CHTTP::SetStatus("404 Not Found");
    include($_SERVER["DOCUMENT_ROOT"]."/404.php");
    die();
}

// Получаем информацию об элементе
CModule::IncludeModule("iblock");
$arElement = CIBlockElement::GetList(
    array(),
    array("IBLOCK_ID" => 24, "CODE" => $elementCode, "ACTIVE" => "Y"),
    false,
    false,
    array("ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "PREVIEW_PICTURE", "DETAIL_PICTURE", "IBLOCK_SECTION_ID")
)->GetNext();

if (!$arElement) {
    CHTTP::SetStatus("404 Not Found");
    include($_SERVER["DOCUMENT_ROOT"]."/404.php");
    die();
}

// Устанавливаем заголовок
$APPLICATION->SetTitle($arElement["NAME"]);

// Получаем фоновое изображение
$backgroundImage = "/local/templates/diez-ekb/assets/images/tourism.jpg"; // по умолчанию
if ($arElement["PREVIEW_PICTURE"]) {
    $arPicture = CFile::GetFileArray($arElement["PREVIEW_PICTURE"]);
    if ($arPicture) {
        $backgroundImage = $arPicture["SRC"];
    }
}

// Получаем subtitle
$subtitle = !empty($arElement["PREVIEW_TEXT"]) ? $arElement["PREVIEW_TEXT"] :
    "В 2023 году Екатеринбург отпразднует свое 300-летие. Свою историю город отсчитывает с 18 ноября 1723 года, когда были запущены цеха крупнейшего в России железоделательного Екатерининского завода.";

// Получаем detail text
$detailText = !empty($arElement["DETAIL_TEXT"]) ? $arElement["DETAIL_TEXT"] :
    "<p>Описание данного вида туризма...</p>";
?>

<main class="main">
    <section class="section section--intro" style="--background: url('<?=$backgroundImage?>')">
        <div class="container">
            <div class="intro">
                <div class="breadcrumbs breadcrumbs--intro">
                    <a href="/" class="breadcrumbs__link">Главная</a>
                    <a href="/tourism/" class="breadcrumbs__link">Виды туризма</a>
                    <p class="breadcrumbs__link"><?=$arElement["NAME"]?></p>
                </div>
                <h1 class="title title--light">
                    <?=$arElement["NAME"]?>
                </h1>
                <p class="subtitle">
                    <?=$subtitle?>
                </p>
            </div>
        </div>
    </section>

    <section class="section section--tourism pt-130 ptm-84 pb-140 pbm-45">
        <div class="container">
            <div class="editor editor--longrid">
                <? echo "<h2><b>" . $arElement["NAME"] . "</b><br>подзаголовок?</h2><p>". $detailText . "<p>"?>
            </div>
        </div>
    </section>

    <section class="section section--gray pt-87 ptm-66 pb-94 pbm-120">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "events_list",
            Array(
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "IBLOCK_TYPE" => "bill",
                "IBLOCK_ID" => "23",
                "NEWS_COUNT" => "6",
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_ORDER1" => "DESC",
                "SORT_BY2" => "SORT",
                "SORT_ORDER2" => "ASC",
                "FIELD_CODE" => array(
                    "ID",
                    "NAME",
                    "PREVIEW_PICTURE",
                    "PREVIEW_TEXT",
                    "ACTIVE_FROM",
                    "DETAIL_PAGE_URL",
                    "IBLOCK_SECTION_ID"
                ),
                "PROPERTY_CODE" => array(
                    "EVENT_DATE",
                    "EVENT_PLACE",
                    "TOP"
                ),
                "SET_TITLE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
            ),
            false
        );
        ?>
        <div class="decor">
            <img style="--top: 7%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/circle-3.svg" alt="">
            <img style="--top: 94%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/line-1.svg" alt="">
            <img style="--top: 86%; --left: 94.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-4.svg" alt="">
        </div>
    </section>

    <section class="section section--pick-route pt-130 ptm-70 pb-130 pbm-45">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "route_cards_block",
            Array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "IBLOCK_ID" => "31",
                "IBLOCK_TYPE" => "routes",
                "NEWS_COUNT" => "4",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "PROPERTY_CODE" => array("TYPE", "DURATION", "DISTANCE"),
                "SET_TITLE" => "N",
                "DISPLAY_ROUTE_TYPE" => "Y",
            )
        );
        ?>
    </section>

    <section class="section section--attraction pt-130 ptm-70 pb-130 pbm-45">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "landmarks_block",
            Array(
                "IBLOCK_TYPE" => "routes",
                "IBLOCK_ID" => "32",
                "NEWS_COUNT" => "8",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "NAME",
                "SORT_ORDER2" => "ASC",
                "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"),
                "PROPERTY_CODE" => array("ADDRESS", "TOP"),
                "SET_TITLE" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_META_DESCRIPTION" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "Y",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            )
        );
        ?>
    </section>

    <section class="section section--where-stop pt-130 ptm-38 pb-130 pbm-70">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "hotels_block",
            Array(
                "IBLOCK_TYPE" => "infrastructure",
                "IBLOCK_ID" => "26",
                "NEWS_COUNT" => "5",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "NAME",
                "SORT_ORDER2" => "ASC",
                "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"),
                "PROPERTY_CODE" => array(
                    "ADDRESS",
                    "PHONE",
                    "TYPE",
                    "FEATURES",
                    "TOP",
                    "RATING",
                    "STARS",
                    "PRICE"
                ),
                "SET_TITLE" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_META_DESCRIPTION" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "Y",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            )
        );
        ?>
    </section>

    <section class="section section--eat pt-130 ptm-38 pb-130 pbm-70">
        <section class="section section--eat pt-130 ptm-38 pb-130 pbm-70">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "restaurants_block",
                Array(
                    "IBLOCK_TYPE" => "infrastructure",
                    "IBLOCK_ID" => "21",
                    "NEWS_COUNT" => "5",
                    "SORT_BY1" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "SORT_BY2" => "NAME",
                    "SORT_ORDER2" => "ASC",
                    "FIELD_CODE" => array("NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"),
                    "PROPERTY_CODE" => array(
                        "ADDRESS",
                        "PHONE",
                        "CUISINE",
                        "PRICE_LEVEL",
                        "FEATURES",
                        "TOP"
                    ),
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "Y",
                    "DISPLAY_DATE" => "N",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                )
            );
            ?>
        </section>

    </section>
</main>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>

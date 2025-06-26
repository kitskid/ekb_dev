<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

// Получаем параметры из ЧПУ
$sectionCode = $_REQUEST["SECTION_CODE"] ?? '';
$elementCode = $_REQUEST["ELEMENT_CODE"] ?? '';

if (empty($sectionCode) || empty($elementCode)) {
    // Редирект на 404 если параметры отсутствуют
    CHTTP::SetStatus("404 Not Found");
    require($_SERVER["DOCUMENT_ROOT"]."/404.php");
    die();
}

// Находим элемент по коду
CModule::IncludeModule("iblock");

$arElement = false;
$rsElement = CIBlockElement::GetList(
    array(),
    array(
        "IBLOCK_ID" => 23,
        "CODE" => $elementCode,
        "ACTIVE" => "Y"
    ),
    false,
    false,
    array("ID", "NAME", "DETAIL_TEXT", "PREVIEW_TEXT", "DETAIL_PICTURE", "PREVIEW_PICTURE", "IBLOCK_SECTION_ID")
);

if ($arElementData = $rsElement->GetNext()) {
    // Проверяем, что элемент принадлежит правильному разделу
    $sectionMatch = false;
    if (!empty($arElementData["IBLOCK_SECTION_ID"])) {
        $rsSection = CIBlockSection::GetByID($arElementData["IBLOCK_SECTION_ID"]);
        if ($arSection = $rsSection->GetNext()) {
            if ($arSection["CODE"] == $sectionCode) {
                $sectionMatch = true;
                $arElementData["SECTION"] = $arSection;
            }
        }
    }

    if (!$sectionMatch) {
        // Раздел не совпадает
        CHTTP::SetStatus("404 Not Found");
        require($_SERVER["DOCUMENT_ROOT"]."/404.php");
        die();
    }

    // Получаем свойства элемента
    $arElement = $arElementData;
    $arElement["PROPERTIES"] = array();

    $rsProps = CIBlockElement::GetProperty(23, $arElement["ID"]);
    while ($arProp = $rsProps->Fetch()) {
        if (!empty($arProp["VALUE"])) {
            if ($arProp["CODE"] == "TAGS" && !empty($arProp["VALUE_ENUM"])) {
                $arElement["PROPERTIES"][$arProp["CODE"]]["VALUE"][] = $arProp["VALUE_ENUM"];
            } else {
                $arElement["PROPERTIES"][$arProp["CODE"]]["VALUE"] = $arProp["VALUE"];
            }
        }
    }

    // Получаем картинки
    if (!empty($arElement["DETAIL_PICTURE"])) {
        $arElement["DETAIL_PICTURE"] = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);
    }
    if (!empty($arElement["PREVIEW_PICTURE"])) {
        $arElement["PREVIEW_PICTURE"] = CFile::GetFileArray($arElement["PREVIEW_PICTURE"]);
    }
} else {
    // Элемент не найден
    CHTTP::SetStatus("404 Not Found");
    require($_SERVER["DOCUMENT_ROOT"]."/404.php");
    die();
}

// Устанавливаем заголовок страницы
$APPLICATION->SetTitle($arElement["NAME"]);
$APPLICATION->SetPageProperty("description", strip_tags($arElement["PREVIEW_TEXT"]));

// Хлебные крошки
$APPLICATION->AddChainItem("Афиша", "/afisha/");
if (!empty($arElement["SECTION"])) {
    $APPLICATION->AddChainItem($arElement["SECTION"]["NAME"], "/afisha/" . $arElement["SECTION"]["CODE"] . "/");
}
$APPLICATION->AddChainItem($arElement["NAME"]);
?>

<main class="main">
    <!-- Детальная информация о событии -->
    <section class="section pt-30 ptm-20 pb-60 pbm-40">
        <div class="container">
            <!-- Хлебные крошки -->
            <nav class="breadcrumbs mb-30 mbm-20">
                <?php $APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default"); ?>
            </nav>

            <!-- Тег события -->
            <?php if (!empty($arElement["SECTION"]["NAME"])): ?>
                <div class="event-category mb-20 mbm-15">
                    <span class="badge badge--large badge--<?= getEventColorClass($arElement["SECTION"]["NAME"]) ?>">
                        <?= htmlspecialchars($arElement["SECTION"]["NAME"]) ?>
                    </span>
                </div>
            <?php endif; ?>

            <!-- Заголовок -->
            <h1 class="title title--large mb-30 mbm-20">
                <?= htmlspecialchars($arElement["NAME"]) ?>
            </h1>

            <div class="grid">
                <!-- Левая колонка - изображение -->
                <div class="grid__item--8 grid__item-mob--4">
                    <?php
                    $mainImage = $arElement["DETAIL_PICTURE"] ?: $arElement["PREVIEW_PICTURE"];
                    if ($mainImage):
                        ?>
                        <div class="event-image mb-40 mbm-30">
                            <img src="<?= $mainImage["SRC"] ?>"
                                 alt="<?= htmlspecialchars($arElement["NAME"]) ?>"
                                 class="event-image__img">
                        </div>
                    <?php endif; ?>

                    <!-- Описание события -->
                    <div class="event-content">
                        <?php if (!empty($arElement["DETAIL_TEXT"])): ?>
                            <div class="event-description">
                                <?= $arElement["DETAIL_TEXT"] ?>
                            </div>
                        <?php elseif (!empty($arElement["PREVIEW_TEXT"])): ?>
                            <div class="event-description">
                                <?= $arElement["PREVIEW_TEXT"] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Правая колонка - информация -->
                <div class="grid__item--4 grid__item-mob--4">
                    <div class="event-sidebar">
                        <div class="event-info-card">
                            <h3 class="event-info-card__title">Информация о событии</h3>

                            <!-- Дата и время -->
                            <?php if (!empty($arElement["PROPERTIES"]["DATETIME"]["VALUE"])): ?>
                                <?php
                                $datetime = MakeTimeStamp($arElement["PROPERTIES"]["DATETIME"]["VALUE"]);
                                $date = FormatDate("d.m.Y", $datetime);
                                $time = date("H:i", $datetime);
                                ?>
                                <div class="event-info-item">
                                    <div class="event-info-item__label">Дата и время:</div>
                                    <div class="event-info-item__value">
                                        <strong><?= $date ?></strong>
                                        <?php if ($time != "00:00"): ?>
                                            <br>с <?= $time ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Место проведения -->
                            <?php if (!empty($arElement["PROPERTIES"]["LOCATION"]["VALUE"])): ?>
                                <div class="event-info-item">
                                    <div class="event-info-item__label">Место проведения:</div>
                                    <div class="event-info-item__value">
                                        <svg class="event-info-item__icon">
                                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                        </svg>
                                        <?= htmlspecialchars($arElement["PROPERTIES"]["LOCATION"]["VALUE"]) ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Теги -->
                            <?php if (!empty($arElement["PROPERTIES"]["TAGS"]["VALUE"])): ?>
                                <div class="event-info-item">
                                    <div class="event-info-item__label">Категории:</div>
                                    <div class="event-tags">
                                        <?php foreach ($arElement["PROPERTIES"]["TAGS"]["VALUE"] as $tag): ?>
                                            <a href="/afisha/?tag=<?= urlencode($tag) ?>" class="tag tag--small">
                                                <?= htmlspecialchars($tag) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Кнопка возврата к афише -->
                            <div class="event-actions mt-30 mtm-20">
                                <a href="/afisha/" class="button button--secondary button--full">
                                    <span>Вернуться к афише</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Блок "Другие события" -->
    <section class="section section--gray pt-60 ptm-40 pb-80 pbm-60">
        <div class="container">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "other_events",
                Array(
                    "IBLOCK_TYPE" => "bill",
                    "IBLOCK_ID" => "23",
                    "NEWS_COUNT" => "3",
                    "SORT_BY1" => "PROPERTY_DATETIME",
                    "SORT_ORDER1" => "ASC",
                    "SORT_BY2" => "ID",
                    "SORT_ORDER2" => "DESC",
                    "FIELD_CODE" => array(
                        "ID",
                        "NAME",
                        "PREVIEW_PICTURE",
                        "PREVIEW_TEXT",
                        "DETAIL_PAGE_URL",
                        "IBLOCK_SECTION_ID"
                    ),
                    "PROPERTY_CODE" => array(
                        "LOCATION",
                        "DATETIME",
                        "TAGS"
                    ),
                    "FILTER_NAME" => "arOtherEventsFilter",
                    "SET_TITLE" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CHECK_DATES" => "Y",
                    "CURRENT_EVENT_ID" => $arElement["ID"] // Исключаем текущее событие
                ),
                false
            );
            ?>
        </div>
    </section>
</main>

<?php
// Фильтр для исключения текущего события
$GLOBALS["arOtherEventsFilter"] = array(
    "!ID" => $arElement["ID"]
);

// Функция для определения цветового класса
function getEventColorClass($sectionName) {
    $colorSchemes = array(
        "Концерт" => "yellow",
        "Фестиваль" => "green",
        "Выставка" => "blue",
        "Спектакль" => "purple",
        "Спорт" => "red",
        "Концерты" => "yellow",
        "Фестивали" => "green",
        "Выставки" => "blue",
        "Спектакли" => "purple",
    );

    return $colorSchemes[$sectionName] ?? "yellow";
}
?>

<!-- Стили остаются те же -->
<style>
    /* Стили для детальной страницы события */
    .event-category {
        margin-bottom: 20px;
    }

    .badge--large {
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 20px;
        display: inline-block;
    }

    .badge--yellow { background: #ffd54f; color: #333; }
    .badge--green { background: #66bb6a; color: #fff; }
    .badge--blue { background: #42a5f5; color: #fff; }
    .badge--purple { background: #ab47bc; color: #fff; }
    .badge--red { background: #ef5350; color: #fff; }

    .title--large {
        font-size: 32px;
        line-height: 1.2;
    }

    .event-image {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .event-image__img {
        width: 100%;
        height: auto;
        min-height: 300px;
        object-fit: cover;
    }

    .event-sidebar {
        position: sticky;
        top: 20px;
    }

    .event-info-card {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .event-info-card__title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }

    .event-info-item {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .event-info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .event-info-item__label {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .event-info-item__value {
        font-size: 16px;
        color: #333;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .event-info-item__icon {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .event-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tag--small {
        padding: 4px 12px;
        font-size: 12px;
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
        border-radius: 16px;
        text-decoration: none;
        color: #666;
        transition: all 0.3s ease;
    }

    .tag--small:hover {
        background: #008cd2;
        color: #fff;
        border-color: #008cd2;
    }

    .button--secondary {
        background: #f5f5f5;
        color: #333;
        border: 1px solid #e0e0e0;
    }

    .button--secondary:hover {
        background: #e0e0e0;
    }

    .button--full {
        width: 100%;
        text-align: center;
    }

    .event-description {
        font-size: 16px;
        line-height: 1.6;
        color: #333;
    }

    .event-description p {
        margin-bottom: 16px;
    }

    .event-description p:last-child {
        margin-bottom: 0;
    }

    /* Мобильные стили */
    @media (max-width: 768px) {
        .title--large {
            font-size: 24px;
        }

        .event-sidebar {
            position: static;
            margin-top: 30px;
        }

        .event-info-card {
            padding: 20px;
        }

        .event-image {
            margin-bottom: 20px;
        }
    }

    .breadcrumbs {
        font-size: 14px;
    }

    .breadcrumbs a {
        color: #666;
        text-decoration: none;
    }

    .breadcrumbs a:hover {
        color: #008cd2;
    }
</style>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>

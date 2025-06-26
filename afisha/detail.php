<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

// Получаем параметры из ЧПУ
$sectionCode = $_REQUEST["SECTION_CODE"] ?? '';
$elementCode = $_REQUEST["ELEMENT_CODE"] ?? '';

if (empty($sectionCode) || empty($elementCode)) {
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
    // Ресайз логотипа организатора
    if (!empty($arElement["PROPERTIES"]["ORGANIZER_LOGO"]["VALUE"])) {
        $arElement["ORGANIZER_LOGO_RESIZED"] = CFile::ResizeImageGet(
            $arElement["PROPERTIES"]["ORGANIZER_LOGO"]["VALUE"],
            array("width" => 200, "height" => 254), // Размер аватара организатора
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true,
            array(),
            false,
            false
        );
    }

//    // Для десктопа
//    $arElement["ORGANIZER_LOGO_DESKTOP"] = CFile::ResizeImageGet(
//        $arElement["PROPERTIES"]["ORGANIZER_LOGO"]["VALUE"],
//        array("width" => 80, "height" => 80),
//        BX_RESIZE_IMAGE_PROPORTIONAL,
//        true
//    );
//
//    // Для мобильных (больше размер)
//    $arElement["ORGANIZER_LOGO_MOBILE"] = CFile::ResizeImageGet(
//        $arElement["PROPERTIES"]["ORGANIZER_LOGO"]["VALUE"],
//        array("width" => 100, "height" => 100),
//        BX_RESIZE_IMAGE_PROPORTIONAL,
//        true
//    );

} else {
    CHTTP::SetStatus("404 Not Found");
    require($_SERVER["DOCUMENT_ROOT"]."/404.php");
    die();
}

// Устанавливаем заголовок страницы
$APPLICATION->SetTitle($arElement["NAME"]);
$APPLICATION->SetPageProperty("description", strip_tags($arElement["PREVIEW_TEXT"]));

// Хлебные крошки
$APPLICATION->AddChainItem("Главная", "/");
$APPLICATION->AddChainItem("Афиша", "/afisha/");
if (!empty($arElement["SECTION"])) {
    $APPLICATION->AddChainItem($arElement["SECTION"]["NAME"], "/afisha/" . $arElement["SECTION"]["CODE"] . "/");
}
$APPLICATION->AddChainItem($arElement["NAME"]);

// Определяем цветовую схему блока
$blockColorClass = getEventBlockColorClass($arElement["SECTION"]["NAME"]);
?>

<main class="main main--offset">
    <section class="section">
        <div class="container">
            <div class="breadcrumbs">
                <?php $APPLICATION->IncludeComponent("bitrix:breadcrumb", "detail_event"); ?>
            </div>
        </div>
    </section>

    <section class="section pt-70 ptm-50 pb-140 pbm-40">
        <div class="container">
            <div class="block-poster <?= $blockColorClass ?>">
                <div class="grid">
                    <div class="grid__item grid__item--9 grid__item-mob--4">
                        <div class="block-poster__intro">
                            <div class="block-poster__top">
                                <?php if (!empty($arElement["SECTION"]["NAME"])): ?>
                                    <div class="block-poster__tag"><?= htmlspecialchars($arElement["SECTION"]["NAME"]) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($arElement["PROPERTIES"]["DATETIME"]["VALUE"])): ?>
                                    <?php
                                    $datetime = MakeTimeStamp($arElement["PROPERTIES"]["DATETIME"]["VALUE"]);
                                    $date = FormatDate("d.m.Y", $datetime);
                                    $dateAttr = date("Y.m.d", $datetime);
                                    ?>
                                    <time class="text text--small text--gray" datetime="<?= $dateAttr ?>"><?= $date ?></time>
                                <?php endif; ?>
                            </div>
                            <h1 class="title title--small"><?= htmlspecialchars($arElement["~NAME"]) ?></h1>
                            <?php if (!empty($arElement["PROPERTIES"]["LOCATION"]["VALUE"])): ?>
                                <div class="block-poster__place">
                                    <svg>
                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                    </svg>
                                    <span><?= htmlspecialchars($arElement["PROPERTIES"]["LOCATION"]["VALUE"]) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <div class="grid__item grid__item--9 grid__item-mob--4 order-mob-1">
                        <div class="block-poster__content">
                            <?php
                            $mainImage = $arElement["DETAIL_PICTURE"] ?: $arElement["PREVIEW_PICTURE"];
                            if ($mainImage):
                                ?>
                                <picture class="block-poster__picture">
                                    <img src="<?= $mainImage["SRC"] ?>" alt="<?= htmlspecialchars($arElement["NAME"]) ?>">
                                </picture>
                            <?php endif; ?>

                            <div class="block-poster__info" data-tabs>
                                <div class="block-poster__header">
                                    <button class="block-poster__head block-poster__head--orange active" data-tabs-head>
                                        О событии
                                    </button>
                                    <?php if (!empty($arElement["PROPERTIES"]["ORGANIZER"]["VALUE"])): ?>
                                        <button class="block-poster__head block-poster__head--green" data-tabs-head>
                                            Организатор события
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="block-poster__detail">
                                    <!-- Вкладка "О событии" -->
                                    <div class="block-poster__item active" data-tabs-item>
                                        <div class="editor editor--text">
                                            <?php if (!empty($arElement["DETAIL_TEXT"])): ?>
                                                <?= $arElement["DETAIL_TEXT"] ?>
                                            <?php elseif (!empty($arElement["PREVIEW_TEXT"])): ?>
                                                <p><?= $arElement["PREVIEW_TEXT"] ?></p>
                                            <?php else: ?>
                                                <p>Подробная информация о событии будет доступна позже.</p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="block-poster__footer">
                                            <?php if (!empty($arElement["PROPERTIES"]["TICKET_LINK"]["VALUE"])): ?>
                                                <a class="button" href="<?= $arElement["PROPERTIES"]["TICKET_LINK"]["VALUE"] ?>" target="_blank">купить билет</a>
                                                <picture class="block-poster__img">
                                                    <img src="/local/templates/diez-ekb/assets/images/kassir.png" alt="">
                                                </picture>
                                            <?php else: ?>
                                                <a class="button" href="/afisha/" target="_blank">Все события</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Вкладка "Организатор" -->
                                    <?php if (!empty($arElement["PROPERTIES"]["ORGANIZER"]["VALUE"])): ?>
                                        <div class="block-poster__item" data-tabs-item>
                                            <article class="article-organizer">
                                                <picture class="article-organizer__avatar">
                                                    <?php if (!empty($arElement["ORGANIZER_LOGO_RESIZED"])): ?>
                                                        <img src="<?= $arElement["ORGANIZER_LOGO_RESIZED"]["src"] ?>"
                                                             alt="<?= htmlspecialchars($arElement["PROPERTIES"]["ORGANIZER"]["VALUE"]) ?>"
                                                             width="<?= $arElement["ORGANIZER_LOGO_RESIZED"]["width"] ?>"
                                                             height="<?= $arElement["ORGANIZER_LOGO_RESIZED"]["height"] ?>">
                                                    <?php elseif (!empty($arElement["PROPERTIES"]["ORGANIZER_LOGO"]["VALUE"])): ?>
                                                        <img src="<?= CFile::GetPath($arElement["PROPERTIES"]["ORGANIZER_LOGO"]["VALUE"]) ?>" alt="">
                                                    <?php else: ?>
                                                        <img src="/local/templates/diez-ekb/assets/images/user-avatar.jpg" alt="">
                                                    <?php endif; ?>
                                                </picture>
                                                <div class="article-organizer__info">
                                                    <h2 class="article-organizer__title">
                                                        <?= htmlspecialchars($arElement["PROPERTIES"]["ORGANIZER"]["VALUE"]) ?>
                                                    </h2>
                                                    <p class="article-organizer__text">
                                                        <?= $arElement["PROPERTIES"]["ORGANIZER_DESCRIPTION"]["VALUE"]["TEXT"] ?: "Информация об организаторе будет добавлена позже." ?>
                                                    </p>
                                                    <?php if (!empty($arElement["PROPERTIES"]["TICKET_LINK"]["VALUE"])): ?>
                                                        <a class="button button--mob-wide" href="<?= $arElement["PROPERTIES"]["TICKET_LINK"]["VALUE"] ?>" target="_blank">купить билет</a>
                                                    <?php endif; ?>
                                                </div>
                                            </article>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Сайдбар с дополнительной информацией -->
                    <div class="grid__item grid__item--3 grid__item-mob--4 order-mob-0">
                        <aside class="sidebar">
                            <?php if (!empty($arElement["PROPERTIES"]["WORK_SCHEDULE"]["VALUE"])): ?>
                                <p class="sidebar__head">время работы:</p>
                                <p class="sidebar__text">
                                    <?= $arElement["PROPERTIES"]["WORK_SCHEDULE"]["VALUE"]["TEXT"]?>
                                </p>
                            <?php elseif (!empty($arElement["PROPERTIES"]["DATETIME"]["VALUE"])): ?>
                                <?php
                                $datetime = MakeTimeStamp($arElement["PROPERTIES"]["DATETIME"]["VALUE"]);
                                $time = date("H:i", $datetime);
                                ?>
                                <p class="sidebar__head">время события:</p>
                                <p class="sidebar__text">
                                    <?= FormatDate("d.m.Y", $datetime) ?><br>
                                    <?php if ($time != "00:00"): ?>
                                        с <?= $time ?>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($arElement["PROPERTIES"]["PRICE"]["VALUE"])): ?>
                                <p class="sidebar__head">стоимость:</p>
                                <p class="sidebar__text">
                                    <?= htmlspecialchars($arElement["PROPERTIES"]["PRICE"]["VALUE"]) ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($arElement["PROPERTIES"]["AGE_LIMIT"]["VALUE"])): ?>
                                <p class="sidebar__head">возрастное ограничение:</p>
                                <p class="sidebar__text">
                                    <?= htmlspecialchars($arElement["PROPERTIES"]["AGE_LIMIT"]["VALUE"]) ?>
                                </p>
                            <?php endif; ?>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Блок "Другие события" в виде слайдера -->
    <section class="section section--gray pt-87 ptm-66 pb-94 pbm-120">
        <div class="container">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "other_events",
                Array(
                    "IBLOCK_TYPE" => "bill",
                    "IBLOCK_ID" => "23",
                    "NEWS_COUNT" => "6",
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
                    "CURRENT_EVENT_ID" => $arElement["ID"]
                ),
                false
            );
            ?>
        </div>
        <div class="decor">
            <img style="--top: 7%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/circle-3.svg" alt="">
            <img style="--top: 94%; --left: 0%;" src="/local/templates/diez-ekb/assets/images/decor/line-1.svg" alt="">
            <img style="--top: 86%; --left: 94.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-4.svg" alt="">
        </div>
    </section>
</main>

<?php
// Фильтр для исключения текущего события
$GLOBALS["arOtherEventsFilter"] = array(
    "!ID" => $arElement["ID"]
);

// Функция для определения цветового класса блока
function getEventBlockColorClass($sectionName) {
    $colorSchemes = array(
        "Концерт" => "block-poster--yellow",
        "Фестиваль" => "block-poster--green",
        "Выставка" => "block-poster--blue",
        "Спектакль" => "block-poster--purple",
        "Спорт" => "block-poster--red",
        "Концерты" => "block-poster--yellow",
        "Фестивали" => "block-poster--green",
        "Выставки" => "block-poster--blue",
        "Спектакли" => "block-poster--purple",
    );

    return $colorSchemes[$sectionName] ?? "block-poster--green";
}
?>

<!--<script>-->
<!--    // Скрипт для работы табов-->
<!--    document.addEventListener('DOMContentLoaded', function() {-->
<!--        const tabsContainers = document.querySelectorAll('[data-tabs]');-->
<!---->
<!--        tabsContainers.forEach(container => {-->
<!--            const heads = container.querySelectorAll('[data-tabs-head]');-->
<!--            const items = container.querySelectorAll('[data-tabs-item]');-->
<!---->
<!--            heads.forEach((head, index) => {-->
<!--                head.addEventListener('click', () => {-->
<!--                    // Убираем активные классы-->
<!--                    heads.forEach(h => h.classList.remove('active'));-->
<!--                    items.forEach(i => i.classList.remove('active'));-->
<!---->
<!--                    // Добавляем активные классы-->
<!--                    head.classList.add('active');-->
<!--                    if (items[index]) {-->
<!--                        items[index].classList.add('active');-->
<!--                    }-->
<!--                });-->
<!--            });-->
<!--        });-->
<!--    });-->
<!--</script>-->

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>

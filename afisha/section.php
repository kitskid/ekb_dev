<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

// Получаем код раздела из ЧПУ
$sectionCode = $_REQUEST["SECTION_CODE"] ?? '';

if (empty($sectionCode)) {
    // Редирект на главную афишу если нет кода раздела
    LocalRedirect("/afisha/");
    die();
}

// Находим раздел по коду
CModule::IncludeModule("iblock");

$arSection = false;
$rsSection = CIBlockSection::GetList(
    array(),
    array(
        "IBLOCK_ID" => 23,
        "CODE" => $sectionCode,
        "ACTIVE" => "Y"
    ),
    false,
    array("ID", "NAME", "CODE", "DESCRIPTION", "PICTURE")
);

if ($arSectionData = $rsSection->GetNext()) {
    $arSection = $arSectionData;

    // Получаем картинку раздела
    if (!empty($arSection["PICTURE"])) {
        $arSection["PICTURE"] = CFile::GetFileArray($arSection["PICTURE"]);
    }
} else {
    // Раздел не найден
    CHTTP::SetStatus("404 Not Found");
    require($_SERVER["DOCUMENT_ROOT"]."/404.php");
    die();
}

// Устанавливаем заголовок страницы
$APPLICATION->SetTitle($arSection["NAME"] . " - Афиша Екатеринбурга");
$APPLICATION->SetPageProperty("description", strip_tags($arSection["DESCRIPTION"]));

// Хлебные крошки
$APPLICATION->AddChainItem("Афиша", "/afisha/");
$APPLICATION->AddChainItem($arSection["NAME"]);
?>

    <main class="main">
        <!-- Баннер раздела -->
        <section class="section section--intro" style="--background: url('<?= $arSection["PICTURE"]["SRC"] ?? "/local/templates/diez-ekb/assets/images/main-bg-5.png" ?>')">
            <div class="container">
                <div class="intro">
                    <h1 class="title title--light">
                        <?= htmlspecialchars($arSection["NAME"]) ?><br>
                        в Екатеринбурге
                    </h1>
                    <?php if (!empty($arSection["DESCRIPTION"])): ?>
                        <p class="subtitle">
                            <?= $arSection["DESCRIPTION"] ?>
                        </p>
                    <?php else: ?>
                        <p class="subtitle">
                            Все события в категории "<?= htmlspecialchars($arSection["NAME"]) ?>" в год 300-летия Екатеринбурга.<br>
                            Найдите интересные мероприятия и не пропустите ничего важного.
                        </p>
                    <?php endif; ?>
                    <a href="#events" class="button js-scroll-to-events">смотреть события</a>
                </div>
            </div>
        </section>

        <!-- События раздела -->
        <section class="section section--gray pt-87 ptm-66 pb-94 pbm-120 blockPosterFilter" id="events">
            <div class="container">
                <div class="grid mb-50 mbm-40">
                    <h2 class="title grid__item--5 grid__item-mob--4">
                        <?= htmlspecialchars($arSection["NAME"]) ?>
                    </h2>
                    <div class="grid__item--7 blockPosterFilter__btns">
                        <!-- Кнопка возврата к полной афише -->
                        <a href="/afisha/" class="button button--invert">
                            <span>Вся афиша</span>
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-left"></use>
                            </svg>
                        </a>

                        <!-- Выбор месяца -->
                        <div class="filter-dropdown">
                            <button class="button filter-btn" data-filter="month">
                                <span class="filter-text">Выбрать месяц</span>
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date-2"></use>
                                </svg>
                            </button>
                            <div class="filter-dropdown-content">
                                <div class="filter-option" data-value="">Все месяцы</div>
                                <!-- Месяцы будут добавлены через JS из основного компонента -->
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                // Устанавливаем фильтр для компонента
                $GLOBALS["arSectionFilter"] = array(
                    "IBLOCK_SECTION_ID" => $arSection["ID"]
                );

                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "section_events",
                    Array(
                        "IBLOCK_TYPE" => "bill",
                        "IBLOCK_ID" => "23",
                        "NEWS_COUNT" => "9", // Больше событий для раздела
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
                        "FILTER_NAME" => "arSectionFilter",
                        "SET_TITLE" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "CHECK_DATES" => "Y",
                        "SECTION_INFO" => $arSection // Передаем информацию о разделе
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Плавная прокрутка к событиям
            const scrollButton = document.querySelector('.js-scroll-to-events');
            if (scrollButton) {
                scrollButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector('#events');
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            }
        });
    </script>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
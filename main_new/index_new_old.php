<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Екатеринбург - Город Контрастов');

// Устанавливаем мета-теги для SEO
$APPLICATION->SetPageProperty("title", "Екатеринбург - Город Контрастов | Официальный туристический портал");
$APPLICATION->SetPageProperty("description", "Откройте для себя Екатеринбург - столицу Урала. Информация для туристов, афиша событий, достопримечательности и многое другое.");
$APPLICATION->SetPageProperty("keywords", "Екатеринбург, туризм, город контрастов, Урал, достопримечательности");
?>

    <!-- Основное содержимое страницы -->
    <main>
    <!-- Секция "Заголовок сайта" -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">ЕКАТЕРИНБУРГ<br>ГОРОД КОНТРАСТОВ</h1>
                <p class="hero-subtitle">Откройте для себя столицу Урала</p>
            </div>
        </div>
    </section>

        <!-- Секция "Гостям Города" -->
        <section class="section">
            <div class="container">
                <!-- Компонент битрикса для вывода разделов инфоблока "Гостям Города" -->
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "guest_cards",
                    array(
                        "IBLOCK_TYPE" => "guests",
                        "IBLOCK_ID" => "24",
                        "COUNT_ELEMENTS" => "Y",
                        "TOP_DEPTH" => "1",
                        "SECTION_FIELDS" => array(
                            0 => "ID",
                            1 => "NAME",
                            2 => "DESCRIPTION",
                            3 => "PICTURE",
                        ),
                        "SECTION_URL" => "",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_GROUPS" => "Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "SHOW_PARENT_NAME" => "N",
                        "HIDE_SECTION_NAME" => "N",
                        "SORT_BY" => "SORT",
                        "SORT_ORDER" => "ASC",
                    )
                );
                ?>
            </div>
        </section>

    <!-- Секция "Афиша" -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">АФИША</h2>

            <!-- Компонент битрикса для вывода афиши событий -->
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
                    "NEWS_COUNT" => "3",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "ACTIVE_FROM"),
                    "PROPERTY_CODE" => array("EVENT_DATE", "EVENT_PLACE"),
                    "SET_TITLE" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                )
            );
            ?>

            <div class="section-more">
                <a href="/afisha/" class="btn-more">Подробнее</a>
            </div>
        </div>
    </section>

        <!-- Секция "Год Уральского Юга 2024" -->
        <section class="ural-year">
            <div class="ural-overlay"></div>
            <div class="container">
                <div class="ural-content">
                    <h2 class="section-title">ГОД УРАЛЬСКОГО ЮГА 2024</h2>

                    <!-- Компонент битрикса для вывода информации о проекте "Год Уральского Юга" -->
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/index/ural_year.php"
                        )
                    );
                    ?>

                    <a href="/ural-year-2024/" class="btn-more">Подробнее</a>
                </div>
            </div>
        </section>

        <!-- Секция "Городской Дайджест" -->
        <section class="section">
            <div class="container">
                <h2 class="section-title">ГОРОДСКОЙ ДАЙДЖЕСТ</h2>

                <!-- Компонент битрикса для вывода городских новостей -->
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "city_digest",
                    Array(
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "IBLOCK_TYPE" => "content",
                        "IBLOCK_ID" => "3",
                        "NEWS_COUNT" => "6",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "DESC",
                        "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "ACTIVE_FROM"),
                        "PROPERTY_CODE" => array("NEWS_TYPE"),
                        "SET_TITLE" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                    )
                );
                ?>

                <div class="section-more">
                    <a href="/news/" class="btn-more">Подробнее</a>
                </div>
            </div>
        </section>

        <!-- Секция "Мировой Уровень" -->
        <section class="section">
            <div class="container">
                <h2 class="section-title">МИРОВОЙ УРОВЕНЬ</h2>

                <!-- Компонент битрикса для вывода достижений города -->
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "world_level",
                    Array(
                        "DISPLAY_DATE" => "N",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "IBLOCK_TYPE" => "content",
                        "IBLOCK_ID" => "22",
                        "NEWS_COUNT" => "4",
                        "SORT_BY1" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT"),
                        "PROPERTY_CODE" => array(),
                        "SET_TITLE" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                    )
                );
                ?>

                <div class="section-more">
                    <a href="/achievements/" class="btn-more">Подробнее</a>
                </div>
            </div>
        </section>

        <!-- Секция "Отзывы" -->
        <section class="section">
            <div class="container">
                <h2 class="section-title">ОТЗЫВЫ</h2>

                <!-- Компонент битрикса для вывода отзывов -->
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "reviews",
                    Array(
                        "DISPLAY_DATE" => "N",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "N",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "IBLOCK_TYPE" => "reviews",
                        "IBLOCK_ID" => "25",
                        "NEWS_COUNT" => "4",
                        "SORT_BY1" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "FIELD_CODE" => array("NAME", "PREVIEW_TEXT"),
                        "PROPERTY_CODE" => array("RATING", "AUTHOR"),
                        "SET_TITLE" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                    )
                );
                ?>
            </div>
        </section>
    </main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php'); ?>
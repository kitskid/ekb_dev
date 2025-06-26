<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("О Екатеринбурге");
?>
<main class="main">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "about_ekaterinburg",
            Array(
                "IBLOCK_TYPE" => "o_ekaterinburge",
                "IBLOCK_ID" => "28",
                "NEWS_COUNT" => "1", // Берем только первый элемент
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "ID",
                "SORT_ORDER2" => "ASC",
                "FIELD_CODE" => array(
                    "ID",
                    "NAME",
                    "PREVIEW_PICTURE",   // Картинка для статьи
                    "DETAIL_PICTURE",    // Фоновое изображение для баннера
                    "PREVIEW_TEXT",      // Текст статьи
                    "DETAIL_TEXT"        // Текст для баннера
                ),
                "PROPERTY_CODE" => array(
                    "BANNER_TITLE",      // Заголовок на баннере
                    "ARTICLE_TITLE"      // Заголовок для H2
                ),
                "PARENT_SECTION_CODE" => "glavnoe-o-ekaterinburge", // Код раздела
                "INCLUDE_SUBSECTIONS" => "Y",
                "SET_TITLE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "CHECK_DATES" => "Y"
            ),
            false
        );
        ?>

        <section class="section section--gray pt-130 ptm-30 pb-145 pbm-65">
            <div class="container">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "history_sections",
                    Array(
                        "IBLOCK_TYPE" => "history_new",
                        "IBLOCK_ID" => "27",
                        "SECTION_ID" => "",
                        "SECTION_CODE" => "",
                        "SECTION_URL" => "",
                        "COUNT_ELEMENTS" => "Y",
                        "TOP_DEPTH" => "1",
                        "SECTION_FIELDS" => array(
                            "ID",
                            "NAME",
                            "PICTURE",
                            "SECTION_PAGE_URL"
                        ),
                        "SECTION_USER_FIELDS" => array(),
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_FILTER" => "N"
                    ),
                    false
                );
                ?>
            </div>
        </section>

        <section class="section section--study pt-195 ptm-30 pb-195 pbm-248">
            <div class="container">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "education",
                    Array(
                        "IBLOCK_TYPE" => "o_ekaterinburge",
                        "IBLOCK_ID" => "28",
                        "SECTION_ID" => "215",
                        "SECTION_CODE" => "",
                        "SECTION_URL" => "",
                        "COUNT_ELEMENTS" => "N",
                        "TOP_DEPTH" => "1",
                        "SECTION_FIELDS" => array(
                            "ID",
                            "NAME",
                            "PICTURE",
                            "DESCRIPTION",
                            "SECTION_PAGE_URL"
                        ),
                        "SECTION_USER_FIELDS" => array(),
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_FILTER" => "N"
                    ),
                    false
                );
                ?>
            </div>
        </section>

        <section class="section section--gradient pt-130 ptm-35 pb-100 pbm-30">
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "city_faq",
                [
                    "ACTIVE_DATE_FORMAT"              => "d.m.Y",
                    "ADD_SECTIONS_CHAIN"              => "Y",
                    "AJAX_MODE"                       => "N",
                    "AJAX_OPTION_ADDITIONAL"          => "",
                    "AJAX_OPTION_HISTORY"             => "N",
                    "AJAX_OPTION_JUMP"                => "N",
                    "AJAX_OPTION_STYLE"               => "Y",
                    "CACHE_FILTER"                    => "N",
                    "CACHE_GROUPS"                    => "Y",
                    "CACHE_TIME"                      => "36000000",
                    "CACHE_TYPE"                      => "A",
                    "CHECK_DATES"                     => "Y",
                    "COMPONENT_TEMPLATE"              => "city_faq",
                    "DETAIL_URL"                      => "",
                    "DISPLAY_BOTTOM_PAGER"            => "Y",
                    "DISPLAY_DATE"                    => "Y",
                    "DISPLAY_NAME"                    => "Y",
                    "DISPLAY_PICTURE"                 => "Y",
                    "DISPLAY_PREVIEW_TEXT"            => "Y",
                    "DISPLAY_TOP_PAGER"               => "N",
                    "FIELD_CODE"                      => [
                        0 => "",
                        1 => "",
                    ],
                    "FILTER_NAME"                     => "",
                    "HIDE_LINK_WHEN_NO_DETAIL"        => "N",
                    "IBLOCK_ID"                       => "6",
                    "IBLOCK_TYPE"                     => "Faq",
                    "INCLUDE_IBLOCK_INTO_CHAIN"       => "N",
                    "INCLUDE_SUBSECTIONS"             => "Y",
                    "MESSAGE_404"                     => "",
                    "NEWS_COUNT"                      => "20",
                    "PAGER_BASE_LINK_ENABLE"          => "N",
                    "PAGER_DESC_NUMBERING"            => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL"                  => "N",
                    "PAGER_SHOW_ALWAYS"               => "N",
                    "PAGER_TEMPLATE"                  => ".default",
                    "PAGER_TITLE"                     => "Афиша",
                    "PARENT_SECTION"                  => "",
                    "PARENT_SECTION_CODE"             => "",
                    "PREVIEW_TRUNCATE_LEN"            => "",
                    "PROPERTY_CODE"                   => [
                        0 => "DATE",
                        1 => "",
                    ],
                    "SET_BROWSER_TITLE"               => "N",
                    "SET_LAST_MODIFIED"               => "N",
                    "SET_META_DESCRIPTION"            => "N",
                    "SET_META_KEYWORDS"               => "N",
                    "SET_STATUS_404"                  => "Y",
                    "SET_TITLE"                       => "N",
                    "SHOW_404"                        => "N",
                    "SORT_BY1"                        => "ACTIVE_FROM",
                    "SORT_BY2"                        => "SORT",
                    "SORT_ORDER1"                     => "DESC",
                    "SORT_ORDER2"                     => "ASC",
                    "STRICT_SECTION_CHECK"            => "N",
                ],
                false,
            );
            ?>
        </section>

        <section class="section">
            <div class="map-info">
                <div class="container">
                    <div class="map-info__detail">
                        <h2 class="map-info__title">
                            Информационно-туристическая
                            служба города Екатеринбурга
                        </h2>
                        <ul class="map-info__list">
                            <li class="map-info__item">
                                <p class="map-info__head">Телефон:</p>
                                <a href="#" class="map-info__text">+7 (922) 038-19-40</a>
                            </li>
                            <li class="map-info__item">
                                <p class="map-info__head">Адрес:</p>
                                <a href="#" class="map-info__text">Екатеринбург, ул. Вайнера, 16 (креативный кластер ДОМНА)</a>
                            </li>
                            <li class="map-info__item">
                                <p class="map-info__head">Время работы:</p>
                                <a href="#" class="map-info__text">пн. – пт. 10:00–19:00, сб.-вс. 10:00-17:00</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="map-info__map" style="position:relative;overflow:hidden;">
                    <iframe
                            src="https://yandex.ru/map-widget/v1/?ll=60.581270%2C56.834542&mode=search&oid=156924630373&ol=biz&sctx=ZAAAAAgBEAAaKAoSCZpd91YkTE5AEQeXjjnPakxAEhIJMpOoF3yagz8Rh086kWCqaT8iBgABAgMEBSgKOABA3ZwGSAFqAnJ1nQHNzMw9oAEAqAEAvQGjoe2ewgEG5aq%2Fy8gEggJq0JjQvdGE0L7RgNC80LDRhtC40L7QvdC90L4t0YLRg9GA0LjRgdGC0LjRh9C10YHQutCw0Y8g0YHQu9GD0LbQsdCwINCz0L7RgNC%2B0LTQsCDQldC60LDRgtC10YDQuNC90LHRg9GA0LPQsIoCAJICAjU0mgIMZGVza3RvcC1tYXBz&sll=60.594130%2C56.834542&sspn=0.085559%2C0.028006&text=%D0%98%D0%BD%D1%84%D0%BE%D1%80%D0%BC%D0%B0%D1%86%D0%B8%D0%BE%D0%BD%D0%BD%D0%BE-%D1%82%D1%83%D1%80%D0%B8%D1%81%D1%82%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B0%D1%8F%20%D1%81%D0%BB%D1%83%D0%B6%D0%B1%D0%B0%20%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0%20%D0%95%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3%D0%B0&z=14.49&no-balloon=1&scrollwheel=false"
                            width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
                </div>
            </div>
        </section>

    </main>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
<?
require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle ("Символика 300-летия для бизнеса");
?>

    <section
        class="section section--bg relative invert"
        style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/bg-single-special-symbol.jpg')"
    >
        <div class="section__content section__content--overlay-80 section__content--flex section__content--full-650 pt-100 ptm-80 pb-120 pbm-40">
            <div class="container container--flex-between">
                <? $APPLICATION->IncludeComponent (
                    "bitrix:breadcrumb",
                    "breadcrumbs",
                    [
                        "START_FROM" => "0",
                        "PATH"       => "",
                        "SITE_ID"    => "s1",
                    ],
                ); ?>
                <div class="columns">
                    <div class="columns__col columns__col--8">
                        <h2 class="title mb-30 mbm-20">
                            <? $APPLICATION->IncludeComponent (
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "EDIT_TEMPLATE"  => "",
                                    "PATH"           => "/include/special/symbol/symbol_title_text.php",
                                ],
                            );
                            ?>
                        </h2>
                        <div class="editor editor--24 mb-40 mbm-30">
                            <p>
                                <? $APPLICATION->IncludeComponent (
                                    "bitrix:main.include",
                                    "",
                                    [
                                        "AREA_FILE_SHOW" => "file",
                                        "EDIT_TEMPLATE"  => "",
                                        "PATH"           => "/include/special/symbol/symbol_subtitle_text.php",
                                    ],
                                );
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section bg-light pt-100 pb-100 ptm-30 pbm-30">
        <div class="container">
            <div class="editor editor--20 regular mb-50 mbm-30">
                <p>
                    <? $APPLICATION->IncludeComponent (
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "EDIT_TEMPLATE"  => "",
                            "PATH"           => "/include/special/symbol/symbol_info_text.php",
                        ],
                    );
                    ?>
                </p>
            </div>
            <? $APPLICATION->IncludeComponent (
                "bitrix:news.list",
                "docks.news.list",
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
                    "COMPONENT_TEMPLATE"              => "docks.news.list",
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
                    "IBLOCK_ID"                       => "11",
                    "IBLOCK_TYPE"                     => "Special",
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
                    "PAGER_TITLE"                     => "Документы",
                    "PARENT_SECTION"                  => "23",
                    "PARENT_SECTION_CODE"             => "",
                    "PREVIEW_TRUNCATE_LEN"            => "",
                    "PROPERTY_CODE"                   => [
                        0 => "COLOR",
                        1 => "DOCKS",
                        2 => "",
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
            ); ?>
            <article class="article-direction article-direction--yellow">
                <svg class="article-direction__icon">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-circle-mail"></use>
                </svg>
                <div class="article-direction__content">
                    <h3 class="article-direction__title">
                        Получите подтверждение на почте
                    </h3>
                    <div class="article-direction__text editor">
                        <p>
                            Вам на почту придёт письмо-подтверждение со ссылкой на скачивание логотипа и дополнительных
                            элементов в
                            удобном формате.
                        </p>
                    </div>
                </div>
            </article>
        </div>
    </section>
    <section class="section bg-white pt-100 pb-80 ptm-40 pbm-40">
        <div class="container">
            <div class="columns">
                <div class="columns__col columns__col--7">
                    <div class="editor mb-40">
                        <? $APPLICATION->IncludeComponent (
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "EDIT_TEMPLATE"  => "",
                                "PATH"           => "/include/special/symbol/symbol_section_text.php",
                            ],
                        );
                        ?>
                        <figure class="figure centered max-220 desktop-hidden">
                            <picture class="figure__picture">
                                <? $APPLICATION->IncludeComponent (
                                    "bitrix:main.include",
                                    "",
                                    [
                                        "AREA_FILE_SHOW" => "file",
                                        "EDIT_TEMPLATE"  => "",
                                        "PATH"           => "/include/special/symbol/symbol_section_logo.php",
                                    ],
                                );
                                ?>
                            </picture>
                        </figure>
                        <? $APPLICATION->IncludeComponent (
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "EDIT_TEMPLATE"  => "",
                                "PATH"           => "/include/special/symbol/symbol_section_second_text.php",
                            ],
                        );
                        ?>
                    </div>
                    <div class="wrapper wrapper--green-light editor">
                        <p>
                            <? $APPLICATION->IncludeComponent (
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "EDIT_TEMPLATE"  => "",
                                    "PATH"           => "/include/special/symbol/symbol_section_description_text.php",
                                ],
                            );
                            ?>
                        </p>
                    </div>
                </div>
                <div class="columns__col columns__col--1 mob-hidden"></div>
                <div class="columns__col columns__col--4 mob-hidden">
                    <figure class="figure mob-centered max-mob-220">
                        <picture class="figure__picture">
                            <? $APPLICATION->IncludeComponent (
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "EDIT_TEMPLATE"  => "",
                                    "PATH"           => "/include/special/symbol/symbol_section_logo.php",
                                ],
                            );
                            ?>
                        </picture>
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <section class="section bg-grey pt-85 pb-90 ptm-30 pbm-30">
        <div class="container">
            <div class="editor editor--20 mb-40 mbm-20">
                <p>
                    <? $APPLICATION->IncludeComponent (
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "EDIT_TEMPLATE"  => "",
                            "PATH"           => "/include/special/symbol/symbol_brand_text.php",
                        ],
                    );
                    ?>
                </p>
            </div>
            <div class="columns columns--articles mb-40 mbm-20">
                <? $APPLICATION->IncludeComponent (
                    "bitrix:news.list",
                    "symbol.news.list",
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
                        "COMPONENT_TEMPLATE"              => "symbol.news.list",
                        "DETAIL_URL"                      => "",
                        "DISPLAY_BOTTOM_PAGER"            => "Y",
                        "DISPLAY_DATE"                    => "Y",
                        "DISPLAY_NAME"                    => "Y",
                        "DISPLAY_PICTURE"                 => "Y",
                        "DISPLAY_PREVIEW_TEXT"            => "Y",
                        "DISPLAY_TOP_PAGER"               => "N",
                        "FIELD_CODE"                      => [
                            0 => "",
                        ],
                        "FILTER_NAME"                     => "",
                        "HIDE_LINK_WHEN_NO_DETAIL"        => "N",
                        "IBLOCK_ID"                       => "10",
                        "IBLOCK_TYPE"                     => "Symbol",
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
                        "PAGER_TITLE"                     => "Символы",
                        "PARENT_SECTION"                  => "",
                        "PARENT_SECTION_CODE"             => "",
                        "PREVIEW_TRUNCATE_LEN"            => "",
                        "PROPERTY_CODE"                   => [
                            0 => "SYMBOL_ICON",
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
                ); ?>
            </div>
            <div class="editor editor--20 editor--accent mb-20">
                <? $APPLICATION->IncludeComponent (
                    "bitrix:main.include",
                    "",
                    [
                        "AREA_FILE_SHOW" => "file",
                        "EDIT_TEMPLATE"  => "",
                        "PATH"           => "/include/special/symbol/symbol_brand_bold_text.php",
                    ],
                );
                ?>
            </div>
            <? $APPLICATION->IncludeComponent (
                "bitrix:news.list",
                "symbol.page.list",
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
                    "COMPONENT_TEMPLATE"              => "symbol.page.list",
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
                    "IBLOCK_ID"                       => "18",
                    "IBLOCK_TYPE"                     => "Symbol-gallery",
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
                    "PAGER_TITLE"                     => "Символы",
                    "PARENT_SECTION"                  => "",
                    "PARENT_SECTION_CODE"             => "",
                    "PREVIEW_TRUNCATE_LEN"            => "",
                    "PROPERTY_CODE"                   => [
                        0 => "",
                        1 => "SLIDER",
                        2 => "",
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
            ); ?>
        </div>
    </section>

<? require ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
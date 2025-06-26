<? include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена, ошибка - 404");
?>

    <section class="section bg-grey bg-4">
        <div class="section__content section__content--full-640 pt-100 pb-100 ptm-80 pbm-40">
            <div class="container container--flex-between">
                <div class="mb-40 mbm-15">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:breadcrumb",
                        "breadcrumbs",
                        array(
                            "START_FROM" => "0",
                            "PATH" => "",
                            "SITE_ID" => "s1"
                        )
                    ); ?>
                </div>
                <div class="columns columns--align">
                    <div class="columns__col columns__col--6 mbm-30">
                        <figure class="figure max-430 centered">
                            <picture class="figure__picture">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => "/include/404/404_logo.php"
                                    )
                                );
                                ?>
                            </picture>
                        </figure>
                    </div>
                    <div class="columns__col columns__col--6">
                        <div class="editor mb-30 mob-center">
                            <h3>
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => "/include/404/404_title_text.php"
                                    )
                                );
                                ?>
                            </h3>
                        </div>
                        <a class="button button--green button--fit-m mob-centered" href="/">
                                <span class="button__text">
                                    На главную
                                </span>
                            <svg class="button__icon">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite/sprite.svg#icon-arrow-next-green"></use>
                            </svg>
                        </a>
                    </div>
                </div>
                <div></div>
            </div>
        </div>
    </section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
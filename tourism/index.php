<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Виды туризма");
?>
<main class="main">
    <section class="section section--intro" style="--background: url('/local/templates/diez-ekb/assets/images/tourism.jpg')">
        <div class="container">
            <div class="intro">
                <div class="breadcrumbs breadcrumbs--intro">
                    <a href="/" class="breadcrumbs__link">Главная</a>
                    <p class="breadcrumbs__link">Виды туризма</p>
                </div>
                <h1 class="title title--light">
                    виды туризма
                </h1>
                <p class="subtitle">
                    В 2023 году Екатеринбург отпразднует свое 300-летие. Свою историю город отсчитывает с 18 ноября 1723
                    года, когда были запущены цеха крупнейшего в России железоделательного Екатерининского завода.
                </p>
            </div>
        </div>
    </section>

    <section class="section section--gradient pt-130 ptm-70 pb-130 pbm-45">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "tourism_cards",
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
                    4 => "CODE",
                ),
                "SECTION_URL" => "/tourism/#SECTION_CODE#/",
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

        <div class="decor">
            <img style="--top: 15.7%; --left: 87.3%;" src="/local/templates/diez-ekb/assets/images/decor/circle-1.svg" alt="">
            <img style="--top: 7.94%; --left: 53.8%;" src="/local/templates/diez-ekb/assets/images/decor/circle-2.svg" alt="">
            <img style="--top: 26%; --left: 7%;" src="/local/templates/diez-ekb/assets/images/decor/triangle-1.svg" alt="">
        </div>
    </section>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Справочная информация");
$APPLICATION->SetPageProperty("title", "Справочная информация | Екатеринбург");
$APPLICATION->SetPageProperty("description", "Полезная справочная информация для гостей и жителей города Екатеринбурга");

if (!CModule::IncludeModule("iblock")) {
    ShowError("Модуль Информационных блоков не установлен");
    return;
}

// Получаем данные раздела для верхнего блока
$sectionInfo = [];
$obSection = CIBlockSection::GetList(
    [],
    ['IBLOCK_ID' => 30, 'ID' => 220],
    false,
    ['ID', 'NAME', 'DESCRIPTION', 'PICTURE', 'UF_*']
);

if ($arSection = $obSection->GetNext()) {
    $sectionInfo = $arSection;

    if ($sectionInfo['PICTURE']) {
        $sectionInfo['PICTURE'] = CFile::GetFileArray($sectionInfo['PICTURE']);
    }
}
?>

<!-- Секция с основной справочной информацией -->
<section class="reference-hero-section" style="background-image: url('<?= $sectionInfo['PICTURE']['SRC'] ?>');">
    <div class="container">
        <div class="reference-hero-content">
            <h1 class="reference-title">СПРАВОЧНАЯ ИНФОРМАЦИЯ</h1>
            <div class="reference-description">
                <?= $sectionInfo['DESCRIPTION'] ?>
            </div>
        </div>
    </div>
</section>

<!-- Секция с карточками справочной информации -->
<section class="reference-cards-section">
    <div class="container">
        <div class="reference-cards">
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "reference_info_cards",
                Array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "FIELD_CODE" => array("ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL"),
                    "FILTER_NAME" => "",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => "30",
                    "IBLOCK_TYPE" => "articles",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "12",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "round_buttons",
                    "PAGER_TITLE" => "Справочная информация",
                    "PARENT_SECTION" => "220",
                    "PARENT_SECTION_CODE" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "PROPERTY_CODE" => array("LINK_TYPE"),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "SORT",
                    "SORT_BY2" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "ASC",
                    "SORT_ORDER2" => "DESC",
                    "STRICT_SECTION_CHECK" => "N"
                )
            );?>
        </div>

        <!-- Кнопка "Показать больше" -->
        <div class="reference-load-more">
            <button class="btn btn-primary load-more-btn">ПОКАЗАТЬ БОЛЬШЕ</button>
        </div>
    </div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

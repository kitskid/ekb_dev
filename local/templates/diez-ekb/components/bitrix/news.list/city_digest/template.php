<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if (empty($arResult["ITEMS"])) {
    return;
}

// Получаем разделы для формирования тегов
$sections = array();
if (!CModule::IncludeModule("iblock")) return;

$rsSections = CIBlockSection::GetList(
    array('SORT' => 'ASC'),
    array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ACTIVE' => 'Y'),
    false,
    array('ID', 'NAME')
);

while ($arSection = $rsSections->GetNext()) {
    $sections[$arSection['ID']] = $arSection['NAME'];
}

// Массив цветов для карточек
$cardColors = array('orange', 'blue', 'green', 'red', 'purple');
?>

<div class="header-block">
    <h2 class="title">Городской дайджест</h2>
    <button class="button mob-hidden" onclick="window.location.href='/news/'">
        <span>больше текстов</span>
        <span class="button__icon">
            <svg>
                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
            </svg>
        </span>
    </button>
</div>
<div class="grid">
    <?php foreach($arResult["ITEMS"] as $index => $arItem): ?>
        <?php
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        // Получаем данные элемента
        $title = $arItem["~NAME"];
        $detailUrl = !empty($arItem["DETAIL_PAGE_URL"]) ? $arItem["DETAIL_PAGE_URL"] : "#";

        // Получаем картинку
        $imgSrc = "/local/templates/diez-ekb/assets/images/no-image.jpg"; // Fallback
        if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
            $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
        }

        // Получаем дату публикации
        $publicationDate = "";
        if (!empty($arItem["PROPERTIES"]["PUBLICATION_DATE"]["VALUE"])) {
            $publicationDate = FormatDate("d.m.Y", MakeTimeStamp($arItem["PROPERTIES"]["PUBLICATION_DATE"]["VALUE"]));
        }

        // Получаем название раздела для тега
        $sectionName = "";
        if (!empty($arItem["IBLOCK_SECTION_ID"]) && isset($sections[$arItem["IBLOCK_SECTION_ID"]])) {
            $sectionName = $sections[$arItem["IBLOCK_SECTION_ID"]];
        }

        // Выбираем цвет карточки
        $cardColor = $cardColors[$index % count($cardColors)];

        // Определяем дополнительные классы для мобильной верстки
        $mobileClass = ($index >= 3) ? ' mob-hidden' : '';
        ?>
        <div class="grid__item grid__item--4 grid__item-mob--4<?=$mobileClass?>">
            <a href="<?=$detailUrl?>" class="article-news article-news--full article-news--<?=$cardColor?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <span class="article-news__badges"></span>
                <picture class="article-news__picture">
                    <img src="<?=$imgSrc?>" alt="<?=htmlspecialchars($title)?>">
                </picture>
                <div class="article-news__info">
                    <div class="article-news__header">
                        <?php if (!empty($sectionName)): ?>
                            <p class="article-news__tag"><?=htmlspecialchars(strtolower($sectionName))?></p>
                        <?php endif; ?>
                        <?php if (!empty($publicationDate)): ?>
                            <time class="article-news__time" datetime="<?=$publicationDate?>"><?=$publicationDate?></time>
                        <?php endif; ?>
                    </div>
                    <h2 class="article-news__title">
                        <?=htmlspecialchars($title)?>
                    </h2>
                    <div class="show-more">
                        <span>Узнать подробности</span>
                        <svg>
                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

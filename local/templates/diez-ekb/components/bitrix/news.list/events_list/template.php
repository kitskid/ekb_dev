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

// Получаем список разделов инфоблока для тегов
$activeSections = array();

// Подключаем модуль инфоблоков
if(!CModule::IncludeModule("iblock")) return;

// Получаем разделы инфоблока с их URL
$arFilter = array('IBLOCK_ID' => 23, 'ACTIVE' => 'Y');
$rsSections = CIBlockSection::GetList(
    array('SORT' => 'ASC'),
    $arFilter,
    false,
    array('ID', 'NAME', 'CODE', 'SECTION_PAGE_URL')
);

while($arSection = $rsSections->GetNext()) {
    $activeElements = CIBlockSection::GetSectionElementsCount($arSection['ID'], Array("CNT_ACTIVE"=>"Y"));
    if ($activeElements > 0) {
        $activeSections[$arSection['ID']] = array(
            'NAME' => $arSection['NAME'],
            'URL' => $arSection['SECTION_PAGE_URL']
        );
    }
}

// Массив цветов для карточек событий
$cardColors = array('yellow', 'green', 'blue', 'red', 'purple');
?>

<div class="container">
    <div class="grid">
        <div class="grid__item grid__item--5 grid__item-mob--4">
            <div class="poster">
                <div class="poster__info">
                    <h2 class="title">Афиша</h2>
                    <p class="text">
                        В год 300-летия Екатеринбург с особым размахом проведёт полюбившиеся многим и известные на
                        весь мир флагманские мероприятия города, а также новые уникальные события.
                    </p>
                    <button class="button mob-hidden" onclick="window.location.href='/afisha/'">
                        <span>Все события</span>
                        <span class="button__icon">
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                            </svg>
                        </span>
                    </button>
                </div>
                <div class="tags">
                    <?php foreach($activeSections as $sectionId => $sectionData): ?>
                        <a href="<?=$sectionData['URL']?>" class="tag"><?=$sectionData['NAME']?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="grid__item grid__item--7 grid__item-mob--4">
            <div class="slider slider--auto slider--visible" data-slider="poster">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php foreach($arResult["ITEMS"] as $index => $arItem): ?>
                            <?php
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                            // Получаем изображение
                            $imgSrc = "/local/templates/diez-ekb/assets/images/no-image.jpg";
                            if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
                                $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
                            }

                            // Получаем дату события
                            $eventDate = "";
                            if (!empty($arItem["PROPERTIES"]["EVENT_DATE"]["VALUE"])) {
                                $eventDate = FormatDate("d.m.Y", MakeTimeStamp($arItem["PROPERTIES"]["EVENT_DATE"]["VALUE"]));
                            } elseif (!empty($arItem["ACTIVE_FROM"])) {
                                $eventDate = FormatDate("d.m.Y", MakeTimeStamp($arItem["ACTIVE_FROM"]));
                            }

                            // Получаем название раздела для тега
                            $sectionName = "";
                            if (!empty($arItem["IBLOCK_SECTION_ID"]) && isset($activeSections[$arItem["IBLOCK_SECTION_ID"]])) {
                                $sectionName = $activeSections[$arItem["IBLOCK_SECTION_ID"]]['NAME'];
                            }

                            // Проверяем, является ли событие топовым
                            $isTop = false;
                            if (!empty($arItem["PROPERTIES"]["TOP"]["VALUE_XML_ID"]) &&
                                $arItem["PROPERTIES"]["TOP"]["VALUE_XML_ID"] == "yes_top_posters") {
                                $isTop = true;
                            }

                            // Выбираем цвет карточки
                            $cardColor = $cardColors[$index % count($cardColors)];

                            // URL детальной страницы
                            $detailUrl = !empty($arItem["DETAIL_PAGE_URL"]) ? $arItem["DETAIL_PAGE_URL"] : "#";
                            ?>
                            <div class="swiper-slide">
                                <a href="<?=$detailUrl?>" class="article-news article-news--<?=$cardColor?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                    <span class="article-news__badges">
                                        <?php if ($isTop): ?>
                                            <span class="badge">топ!</span>
                                        <?php endif; ?>
                                    </span>
                                    <picture class="article-news__picture">
                                        <img src="<?=$imgSrc?>" alt="<?=htmlspecialchars($arItem["NAME"])?>">
                                    </picture>
                                    <div class="article-news__info">
                                        <div class="article-news__header">
                                            <?php if (!empty($sectionName)): ?>
                                                <p class="article-news__tag"><?=$sectionName?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($eventDate)): ?>
                                                <time class="article-news__time" datetime="<?=$eventDate?>"><?=$eventDate?></time>
                                            <?php endif; ?>
                                        </div>
                                        <h2 class="article-news__title">
                                            <?=$arItem["NAME"]?>
                                        </h2>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-control swiper-control--end">
                        <button class="swiper-btn swiper-btn--prev">
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                            </svg>
                        </button>
                        <button class="swiper-btn swiper-btn--next">
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid__item grid__item-mob--4 desktop-hidden">
            <button class="button button--mob-wide" onclick="window.location.href='/events/'">
                <span>Все события</span>
                <span class="button__icon">
                    <svg>
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>
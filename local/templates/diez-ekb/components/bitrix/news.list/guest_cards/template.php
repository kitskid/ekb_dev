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

// Подключаем модуль инфоблоков, если еще не подключен
if(!CModule::IncludeModule("iblock"))
    return;

// Получаем разделы инфоблока с ID=24
$activeSections = array();
$arFilter = array('IBLOCK_ID' => 24, 'ACTIVE' => 'Y');
$rsSections = CIBlockSection::GetList(
    array('SORT' => 'ASC'),
    $arFilter,
    true, // Считаем количество элементов
    array('ID', 'NAME', 'DESCRIPTION', 'PICTURE', 'ELEMENT_CNT', 'UF_COLOR')
);

// Получаем цвета для карточек, можно настроить под свои требования или определять из свойств разделов
$cardColors = array(
    'rgba(194, 84, 165, 0.8)', // Фиолетовый
    'rgba(255, 120, 85, 0.8)',  // Оранжевый
    'rgba(133, 80, 255, 0.8)',  // Фиолетовый 2
    'rgba(125, 79, 168, 0.8)',  // Темно-фиолетовый
    'rgba(66, 189, 85, 0.8)',   // Зеленый
    'rgba(250, 171, 33, 0.8)',  // Желтый
    'rgba(25, 156, 224, 0.8)',  // Синий
    'rgba(236, 65, 70, 0.8)',   // Красный
    'rgba(50, 175, 94, 0.8)',   // Зеленый 2
);

// Получаем разделы с элементами
$colorIndex = 0;
while($arSection = $rsSections->GetNext()) {
    // Проверяем наличие элементов в разделе
    if($arSection['ELEMENT_CNT'] > 0) {
        // Определяем цвет для раздела
        $cardColor = !empty($arSection["UF_COLOR"])
            ? $arSection["UF_COLOR"]
            : $cardColors[$colorIndex % count($cardColors)];

        $colorIndex++;

        // Получаем изображение раздела
        $imgSrc = '';
        if(!empty($arSection["PICTURE"])) {
            $arFile = CFile::GetFileArray($arSection["PICTURE"]);
            if($arFile) {
                $imgSrc = $arFile["SRC"];
            }
        }

        if(empty($imgSrc)) {
            $imgSrc = "/local/templates/.default/images/placeholder.jpg";
        }

        // Добавляем раздел в результирующий массив
        $activeSections[] = array(
            'ID' => $arSection['ID'],
            'NAME' => $arSection['NAME'],
            'DESCRIPTION' => $arSection['DESCRIPTION'],
            'IMAGE_SRC' => $imgSrc,
            'COLOR' => $cardColor
        );
    }
}
?>

<style>
    /* Стили для карточек гостям города */
    .guests-section {
        margin-bottom: 40px;
    }

    .guests-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .guests-title {
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .guests-more {
        display: inline-block;
        padding: 8px 15px;
        background-color: #008cd2;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
    }

    .guests-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-auto-rows: 250px;
        gap: 20px;
    }

    @media (max-width: 992px) {
        .guests-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .guests-grid {
            display: none;
        }

        .mobile-swiper {
            display: block;
        }
    }

    .guest-card {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        background-size: cover;
        background-position: center;
    }

    .guest-card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        color: white;
        min-height: 40%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .guest-card-title {
        margin: 0 0 5px 0;
        font-size: 16px;
        font-weight: bold;
    }

    .guest-card p {
        margin: 0;
        font-size: 13px;
        opacity: 0.9;
    }

    /* Стили для мобильного слайдера */
    .mobile-swiper {
        display: none;
        height: 400px;
    }

    .mobile-swiper .swiper-slide {
        height: 350px;
    }

    .mobile-swiper .guest-card {
        width: 100%;
        height: 100%;
    }

    .mobile-swiper .swiper-pagination {
        bottom: 0;
    }

    .mobile-swiper .swiper-pagination-bullet-active {
        background: #008cd2;
    }
</style>

<div class="guests-section">
    <div class="guests-header">
        <h2 class="guests-title">Гостям города</h2>
        <a href="/guests/" class="guests-more">Еще туры</a>
    </div>

    <!-- Десктопная версия -->
    <div class="guests-grid" id="guest-cards-container">
        <?php foreach($activeSections as $index => $section): ?>
            <div class="guest-card" id="section_<?=$section['ID']?>" style="background-image: url('<?=$section['IMAGE_SRC']?>')">
                <div class="guest-card-overlay" style="background-color: <?=$section['COLOR']?>;">
                    <h3 class="guest-card-title"><?=$section['NAME']?></h3>
                    <?php if(!empty($section["DESCRIPTION"])): ?>
                        <p><?=$section["DESCRIPTION"]?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Версия для мобильных устройств -->
    <div class="mobile-swiper guests-mobile-swiper">
        <div class="swiper-wrapper">
            <?php foreach($activeSections as $index => $section): ?>
                <div class="swiper-slide">
                    <div class="guest-card" style="background-image: url('<?=$section['IMAGE_SRC']?>')">
                        <div class="guest-card-overlay" style="background-color: <?=$section['COLOR']?>;">
                            <h3 class="guest-card-title"><?=$section['NAME']?></h3>
                            <?php if(!empty($section["DESCRIPTION"])): ?>
                                <p><?=$section["DESCRIPTION"]?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация Swiper для мобильной версии
        if (document.querySelector('.guests-mobile-swiper')) {
            new Swiper('.guests-mobile-swiper', {
                slidesPerView: 1.2,
                spaceBetween: 10,
                centeredSlides: false,
                loop: false,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            });
        }
    });
</script>

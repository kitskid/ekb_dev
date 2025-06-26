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

// Массив для хранения разделов с элементами
$sectionsWithElements = array();
//var_dump($arResult['SECTIONS']);
// Проверяем наличие элементов в каждом разделе
foreach($arResult['SECTIONS'] as $section) {
//    $activeElements = CIBlockSection::GetSectionElementsCount($section['ID'], Array("CNT_ACTIVE" => "Y"));

    // Получаем изображение раздела
    $imgSrc = '';
    if(!empty($section['PICTURE'])) {
        $imgSrc = CFile::GetPath($section['PICTURE']);
    }

//    if(empty($imgSrc)) {
//        $imgSrc = "/local/templates/.default/images/placeholder.jpg";
//    }

    // Добавляем раздел с непустым количеством элементов
    $section['IMAGE_SRC'] = $imgSrc;
    $sectionsWithElements[] = $section;

//    if($activeElements > 0) {
//        // Получаем изображение раздела
//        $imgSrc = '';
//        if(!empty($section['PICTURE'])) {
//            $imgSrc = CFile::GetPath($section['PICTURE']);
//        }
//        var_dump($imgSrc);
//        if(empty($imgSrc)) {
//            $imgSrc = "/local/templates/.default/images/placeholder.jpg";
//        }
//
//        // Добавляем раздел с непустым количеством элементов
//        $section['IMAGE_SRC'] = $imgSrc;
//        $sectionsWithElements[] = $section;
//    }
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
        background-color: rgba(0, 0, 0, 0.5); /* Единый цвет оверлея для всех карточек */
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
        <?php foreach($sectionsWithElements as $section): ?>
            <?php
            // Получаем изображение раздела
            $imgSrc = '';
            if(!empty($section['PICTURE'])) {
                if(is_array($section['PICTURE'])) {
                    $imgSrc = $section['PICTURE']['SRC'];
                } else {
                    $imgSrc = CFile::GetPath($section['PICTURE']);
                }
            }

            if(empty($imgSrc)) {
                $imgSrc = "/local/templates/.default/images/placeholder.jpg";
            }
            ?>
            <div class="guest-card" id="section_<?=$section['ID']?>" style="background-image: url('<?=$imgSrc?>')">
                <div class="guest-card-overlay">
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
            <?php foreach($sectionsWithElements as $section): ?>
                <?php
                // Получаем изображение раздела
                $imgSrc = '';
                if(!empty($section['PICTURE'])) {
                    if(is_array($section['PICTURE'])) {
                        $imgSrc = $section['PICTURE']['SRC'];
                    } else {
                        $imgSrc = CFile::GetPath($section['PICTURE']);
                    }
                }

                if(empty($imgSrc)) {
                    $imgSrc = "/local/templates/.default/images/placeholder.jpg";
                }
                ?>
                <div class="swiper-slide">
                    <div class="guest-card" style="background-image: url('<?=$imgSrc?>')">
                        <div class="guest-card-overlay">
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

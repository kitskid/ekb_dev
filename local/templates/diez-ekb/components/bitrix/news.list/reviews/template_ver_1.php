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

// Функция для форматирования даты в формат DD.MM.YYYY
function formatReviewDate($date) {
    if (empty($date)) return '';
    return FormatDate("d.m.Y", MakeTimeStamp($date));
}
?>

<style>
    /* Общие стили для отзывов */
    .reviews-section {
        margin-bottom: 40px;
    }
    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .reviews-title {
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
        margin: 0;
    }
    /* Сетка отзывов для десктопа */
    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }
    /* Стили для карточки отзыва */
    .review-card {
        background-color: #F5F5F5;
        border-radius: 10px;
        padding: 20px;
        position: relative;
    }
    .review-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .review-author-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
        background-color: #ddd; /* Цвет по умолчанию, если изображение не загрузится */
    }
    .review-author {
        font-weight: 600;
        color: #333;
    }
    .review-date {
        margin-left: auto;
        color: #888;
        font-size: 14px;
        display: flex;
        align-items: center;
    }
    .review-text {
        font-size: 14px;
        line-height: 1.5;
        color: #555;
        margin: 0;
    }
    .review-likes {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        margin-top: 15px;
    }
    .review-like-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #FF5252;
        font-size: 16px;
        display: flex;
        align-items: center;
        padding: 0;
    }
    .review-like-btn .heart-icon {
        margin-right: 5px;
    }
    .review-like-btn.active .heart-icon {
        fill: #FF5252;
    }
    /* Мобильная версия со слайдером */
    .reviews-mobile {
        display: none;
    }
    .mobile-swiper {
        overflow: hidden;
        position: relative;
        padding-bottom: 30px;
    }
    .mobile-swiper .swiper-pagination {
        bottom: 0;
    }
    .mobile-swiper .swiper-pagination-bullet-active {
        background-color: #4CAF50;
    }
    .show-all-btn {
        display: inline-flex;
        align-items: center;
        color: #4CAF50;
        text-decoration: none;
        font-weight: 500;
        margin-top: 15px;
    }
    .show-all-btn svg {
        margin-right: 8px;
    }
    @media (max-width: 992px) {
        .reviews-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 576px) {
        .reviews-grid {
            display: none;
        }
        .reviews-mobile {
            display: block;
        }
    }
</style>

<div class="reviews-section">
    <div class="reviews-header">
        <h2 class="reviews-title">Отзывы</h2>
    </div>

    <!-- Десктопная версия -->
    <div class="reviews-grid">
        <?php foreach($arResult["ITEMS"] as $arItem): ?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

            // Получаем автора отзыва
            $author = $arItem["PROPERTIES"]["AUTHOR"]["VALUE"] ?? "Пользователь";

            // Получаем дату отзыва из свойства DATE
            $reviewDate = '';
            if(!empty($arItem["PROPERTIES"]["DATE"]["VALUE"])) {
                $reviewDate = formatReviewDate($arItem["PROPERTIES"]["DATE"]["VALUE"]);
            }

            // Получаем аватар автора из картинки анонса
            $avatarSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/user-placeholder.jpg";

            // Получаем рейтинг для обработки в JS
            $rating = intval($arItem["PROPERTIES"]["RATING"]["VALUE"] ?? 5);
            ?>

            <div class="review-card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="review-header">
                    <img src="<?=$avatarSrc?>" alt="<?=$author?>" class="review-author-avatar">
                    <span class="review-author"><?=$author?></span>
                    <?php if(!empty($reviewDate)): ?>
                        <span class="review-date"><?=$reviewDate?> <?php if($rating > 0): ?><svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" fill="#FFC107"/></svg><?php endif; ?></span>
                    <?php endif; ?>
                </div>
                <p class="review-text"><?=$arItem["PREVIEW_TEXT"]?></p>
                <div class="review-likes">
                    <button class="review-like-btn" data-review-id="<?=$arItem['ID']?>">
                        <svg class="heart-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.03L12 21.35Z" stroke="#FF5252" stroke-width="2"/>
                        </svg>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Мобильная версия со слайдером -->
    <div class="reviews-mobile">
        <div class="mobile-swiper reviews-mobile-swiper">
            <div class="swiper-wrapper">
                <?php foreach($arResult["ITEMS"] as $arItem): ?>
                    <div class="swiper-slide">
                        <?php
                        // Получаем автора отзыва
                        $author = $arItem["PROPERTIES"]["AUTHOR"]["VALUE"] ?? "Пользователь";

                        // Получаем дату отзыва из свойства DATE
                        $reviewDate = '';
                        if(!empty($arItem["PROPERTIES"]["DATE"]["VALUE"])) {
                            $reviewDate = formatReviewDate($arItem["PROPERTIES"]["DATE"]["VALUE"]);
                        }

                        // Получаем аватар автора из картинки анонса
                        $avatarSrc = $arItem["PREVIEW_PICTURE"]["SRC"] ?? "/local/templates/.default/images/user-placeholder.jpg";

                        // Получаем рейтинг для обработки в JS
                        $rating = intval($arItem["PROPERTIES"]["RATING"]["VALUE"] ?? 5);
                        ?>

                        <div class="review-card">
                            <div class="review-header">
                                <img src="<?=$avatarSrc?>" alt="<?=$author?>" class="review-author-avatar">
                                <span class="review-author"><?=$author?></span>
                                <?php if(!empty($reviewDate)): ?>
                                    <span class="review-date"><?=$reviewDate?> <?php if($rating > 0): ?><svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" fill="#FFC107"/></svg><?php endif; ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="review-text"><?=$arItem["PREVIEW_TEXT"]?></p>
                            <div class="review-likes">
                                <button class="review-like-btn" data-review-id="<?=$arItem['ID']?>">
                                    <svg class="heart-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.03L12 21.35Z" stroke="#FF5252" stroke-width="2"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <!-- Кнопка "Показать все" в мобильной версии -->
        <div style="text-align: center;">
            <a href="/reviews/" class="show-all-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM13 7H11V13H17V11H13V7Z" fill="#4CAF50"/>
                </svg>
                Показать все
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация слайдера для мобильной версии
        if (document.querySelector('.reviews-mobile-swiper')) {
            new Swiper('.reviews-mobile-swiper', {
                slidesPerView: 1,
                spaceBetween: 15,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            });
        }

        // Обработчик клика по кнопке "Нравится"
        var likeButtons = document.querySelectorAll('.review-like-btn');
        likeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                this.classList.toggle('active');
                var heartIcon = this.querySelector('.heart-icon');
                if (this.classList.contains('active')) {
                    heartIcon.setAttribute('fill', '#FF5252');
                } else {
                    heartIcon.setAttribute('fill', 'none');
                }
            });
        });
    });
</script>
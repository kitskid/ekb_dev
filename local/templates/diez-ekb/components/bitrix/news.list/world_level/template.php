<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (!empty($arResult["ITEMS"])): ?>
    <div class="container">
        <div class="header-block">
            <h2 class="title">Мировой уровень</h2>
            <p class="text">
                В год 300-летия Екатеринбург с особым размахом<br>
                проведёт полюбившиеся многим и известные на<br>
                весь мир флагманские мероприятия города, а также<br>
                новые уникальные события.
            </p>
        </div>
        <div class="slider slider--auto slider--visible" data-slider="poster">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                        <div class="swiper-slide">
                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="article-news article-news--attraction article-news--green">
                        <span class="article-news__badges">
                            <?php if ($arItem["PROPERTIES"]["TOP"]["VALUE"] == "да" || $arItem["PROPERTIES"]["TOP"]["VALUE"] == "1"): ?>
                                <span class="badge">топ!</span>
                            <?php endif; ?>
                        </span>
                                <picture class="article-news__picture">
                                    <?php
                                    $imageSrc = '';
                                    if ($arItem["PREVIEW_PICTURE_RESIZED"]) {
                                        $imageSrc = $arItem["PREVIEW_PICTURE_RESIZED"]["src"];
                                    } elseif ($arItem["PREVIEW_PICTURE"] && is_array($arItem["PREVIEW_PICTURE"])) {
                                        $imageSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
                                    } elseif ($arItem["DETAIL_PICTURE_RESIZED"]) {
                                        $imageSrc = $arItem["DETAIL_PICTURE_RESIZED"]["src"];
                                    } elseif ($arItem["DETAIL_PICTURE"] && is_array($arItem["DETAIL_PICTURE"])) {
                                        $imageSrc = $arItem["DETAIL_PICTURE"]["SRC"];
                                    }
                                    ?>
                                    <?php if ($imageSrc): ?>
                                        <img src="<?= $imageSrc ?>" alt="<?= htmlspecialchars($arItem["NAME"]) ?>">
                                    <?php else: ?>
                                        <img src="/local/templates/diez-ekb/assets/images/no-image.jpg" alt="<?= htmlspecialchars($arItem["NAME"]) ?>">
                                    <?php endif; ?>
                                </picture>
                                <div class="article-news__info">
                                    <h2 class="article-news__title">
                                        <?= htmlspecialchars($arItem["NAME"]) ?>
                                    </h2>
                                    <?php if ($arItem["PROPERTIES"]["ADDRESS"]["VALUE"]): ?>
                                        <p class="article-news__place">
                                            <svg>
                                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-location"></use>
                                            </svg>
                                            <span><?= htmlspecialchars($arItem["PROPERTIES"]["ADDRESS"]["VALUE"]) ?></span>
                                        </p>
                                    <?php endif; ?>
                                    <img class="article-news__decor" src="/local/templates/diez-ekb/assets/images/attraction-bg.svg" alt="">
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-footer">
                    <div class="swiper-control">
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
                    <button class="button button--mob-wide">
                        <span>больше объектов</span>
                        <span class="button__icon">
                        <svg>
                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                        </svg>
                    </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
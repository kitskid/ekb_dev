<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (!empty($arResult["ITEMS"])): ?>
    <div class="container">
        <div class="header-block">
            <h2 class="title">Отзывы</h2>
        </div>
        <div class="slider slider--auto-overflow slider--visible" data-slider="enhanced" data-slides="4">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                        <div class="swiper-slide">
                            <article class="article-review">
                                <div class="article-review__header">
                                    <picture class="article-review__avatar">
                                        <?php if ($arItem["PROPERTIES"]["AVATAR"]["VALUE"]): ?>
                                            <img src="<?= CFile::GetPath($arItem["PROPERTIES"]["AVATAR"]["VALUE"]) ?>" alt="<?= htmlspecialchars($arItem["PROPERTIES"]["AUTHOR"]["VALUE"]) ?>">
                                        <?php else: ?>
                                            <img src="/local/templates/diez-ekb/assets/images/user-1.png" alt="<?= htmlspecialchars($arItem["PROPERTIES"]["AUTHOR"]["VALUE"]) ?>">
                                        <?php endif; ?>
                                    </picture>
                                    <h3 class="article-review__author">
                                        <?= htmlspecialchars($arItem["PROPERTIES"]["AUTHOR"]["VALUE"] ?: $arItem["NAME"]) ?>
                                    </h3>
                                </div>
                                <p class="article-review__text">
                                    <?= $arItem["PREVIEW_TEXT"] ?>
                                </p>
                                <div class="article-review__footer">
                                    <?php if ($arItem["ACTIVE_FROM"]): ?>
                                        <time class="article-review__time" datetime="<?= date('Y.m.d', strtotime($arItem["ACTIVE_FROM"])) ?>">
                                            <?= date('d.m.Y', strtotime($arItem["ACTIVE_FROM"])) ?>
                                        </time>
                                    <?php elseif ($arItem["DATE_CREATE"]): ?>
                                        <time class="article-review__time" datetime="<?= date('Y.m.d', strtotime($arItem["DATE_CREATE"])) ?>">
                                            <?= date('d.m.Y', strtotime($arItem["DATE_CREATE"])) ?>
                                        </time>
                                    <?php endif; ?>
                                    <svg class="article-review__icon">
                                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-date"></use>
                                    </svg>
                                </div>
                                <?php if ($arItem["PROPERTIES"]["RATING"]["VALUE"]): ?>
<!--                                    <div class="article-review__rating">-->
<!--                                        --><?php //for ($i = 1; $i <= 5; $i++): ?>
<!--                                            <span class="star --><?//= $i <= intval($arItem["PROPERTIES"]["RATING"]["VALUE"]) ? 'active' : '' ?><!--">★</span>-->
<!--                                        --><?php //endfor; ?>
<!--                                    </div>-->
                                <?php endif; ?>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-control mob-hidden">
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
<?php endif; ?>

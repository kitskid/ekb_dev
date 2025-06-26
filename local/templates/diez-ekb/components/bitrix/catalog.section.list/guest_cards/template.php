<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
?>

<div class="container">
    <div class="header-block">
        <h2 class="title">
            <span><?=$arResult["SECTION_TITLE"]?></span>
        </h2>
        <button class="button mob-hidden">
            <span><?=$arResult["BUTTON_TEXT"]?></span>
            <span class="button__icon">
                <svg>
                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                </svg>
            </span>
        </button>
    </div>

    <?php if (!empty($arResult['SECTIONS'])): ?>
        <div class="intro-cards">
            <?php foreach ($arResult['SECTIONS'] as $section): ?>
                <article class="article-intro-card article-intro-card--<?=$section["COLOR"]?>">
                    <?php if (!empty($section["TAGS"])): ?>
                        <div class="article-intro-card__tags">
                            <?php foreach ($section["TAGS"] as $tag): ?>
                                <a href="<?=$tag["URL"]?>" class="article-intro-card__tag"><?=$tag["NAME"]?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <picture class="article-intro-card__picture">
                        <?php if ($section["PICTURE"]): ?>
                            <img src="<?=$section["PICTURE"]["src"]?>" alt="<?=$section["NAME"]?>">
                        <?php else: ?>
                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/no-image.jpg" alt="<?=$section["NAME"]?>">
                        <?php endif; ?>
                    </picture>

                    <div class="article-intro-card__info">
                        <h2 class="article-intro-card__title">
                            <?=$section["NAME"]?>
                        </h2>
                        <a href="<?=$section["SECTION_PAGE_URL"]?>" class="article-intro-card__link">
                            <span>Узнать подробности</span>
                            <svg class="article-intro-card__icon">
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                            </svg>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <button class="button button--mob-wide desktop-hidden">
        <span><?=$arResult["BUTTON_TEXT"]?></span>
        <span class="button__icon">
            <svg>
                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
            </svg>
        </span>
    </button>
</div>

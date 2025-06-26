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
var_dump($arResult);
if (empty($arResult)) {
    return;
}

// Добавляем возможность редактирования
$this->AddEditAction($arResult['ID'], $arResult['EDIT_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arResult['ID'], $arResult['DELETE_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

// Получаем данные
$bannerTitle = !empty($arResult["PROPERTIES"]["BANNER_TITLE"]["~VALUE"]) ? $arResult["PROPERTIES"]["BANNER_TITLE"]["~VALUE"] : $arResult["NAME"];
$articleTitle = !empty($arResult["PROPERTIES"]["ARTICLE_TITLE"]["~VALUE"]) ? $arResult["PROPERTIES"]["ARTICLE_TITLE"]["~VALUE"] : "";
$bannerText = !empty($arResult["~DETAIL_TEXT"]) ? $arResult["~DETAIL_TEXT"] : "";
$articleText = !empty($arResult["~PREVIEW_TEXT"]) ? $arResult["~PREVIEW_TEXT"] : "";

// Получаем фоновое изображение из детальной картинки
$backgroundImage = "/local/templates/diez-ekb/assets/images/main-bg-2.jpg"; // Fallback
if (!empty($arResult["DETAIL_PICTURE"]["SRC"])) {
    $backgroundImage = $arResult["DETAIL_PICTURE"]["SRC"];
}

// Получаем картинку для статьи из превью
$articleImage = "/local/templates/diez-ekb/assets/images/photo-1.png"; // Fallback
if (!empty($arResult["PREVIEW_PICTURE"]["SRC"])) {
    $articleImage = $arResult["PREVIEW_PICTURE"]["SRC"];
}
?>

<div id="<?=$this->GetEditAreaId($arResult['ID']);?>">
    <section class="section section--intro" style="--background: url('<?=$backgroundImage?>')">
        <div class="container">
            <div class="intro">
                <h1 class="title title--light">
                    <?=$bannerTitle?>
                </h1>
                <?php if (!empty($bannerText)): ?>
                    <p class="subtitle">
                        <?=$bannerText?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section section--logo-bg section--logo-bg-center pt-130 ptm-70 pb-100 pbm-25">
        <div class="container">
            <div class="block-info">
                <div class="grid">
                    <div class="grid__item grid__item--6 mob-hidden"></div>
                    <div class="grid__item grid__item--6 grid__item-mob--4">
                        <?php if (!empty($articleTitle)): ?>
                            <h2 class="block-info__title">
                                <?=$articleTitle?>
                            </h2>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="grid">
                    <div class="grid__item grid__item--6 grid__item-mob--4">
                        <picture class="block-info__picture">
                            <img src="<?=$articleImage?>" alt="<?=htmlspecialchars($arResult["NAME"])?>">
                        </picture>
                    </div>
                    <div class="grid__item grid__item--6 grid__item-mob--4">
                        <?php if (!empty($articleText)): ?>
                            <div class="block-info__text text">
                                <?=$articleText?>
                            </div>
                            <p class="block-info__more text">
                                <span>Развернуть</span>
                                <svg>
                                    <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-chevrone"></use>
                                </svg>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--<script>-->
<!--    document.addEventListener('DOMContentLoaded', function() {-->
<!--        // Функционал для кнопки "Развернуть"-->
<!--        const moreButton = document.querySelector('.block-info__more');-->
<!--        const textBlock = document.querySelector('.block-info__text');-->
<!---->
<!--        if (moreButton && textBlock) {-->
<!--            const fullText = textBlock.innerHTML;-->
<!--            const words = fullText.split(' ');-->
<!---->
<!--            // Если текст длинный, обрезаем его-->
<!--            if (words.length > 50) {-->
<!--                const shortText = words.slice(0, 50).join(' ') + '...';-->
<!--                let isExpanded = false;-->
<!---->
<!--                // Изначально показываем сокращенный текст-->
<!--                textBlock.innerHTML = shortText;-->
<!---->
<!--                moreButton.addEventListener('click', function(e) {-->
<!--                    e.preventDefault();-->
<!---->
<!--                    if (isExpanded) {-->
<!--                        // Свернуть-->
<!--                        textBlock.innerHTML = shortText;-->
<!--                        moreButton.querySelector('span').textContent = 'Развернуть';-->
<!--                        moreButton.querySelector('svg').style.transform = 'rotate(0deg)';-->
<!--                        isExpanded = false;-->
<!--                    } else {-->
<!--                        // Развернуть-->
<!--                        textBlock.innerHTML = fullText;-->
<!--                        moreButton.querySelector('span').textContent = 'Свернуть';-->
<!--                        moreButton.querySelector('svg').style.transform = 'rotate(180deg)';-->
<!--                        isExpanded = true;-->
<!--                    }-->
<!--                });-->
<!--            } else {-->
<!--                // Если текст короткий, скрываем кнопку-->
<!--                moreButton.style.display = 'none';-->
<!--            }-->
<!--        }-->
<!--    });-->
<!--</script>-->

<!--<style>-->
<!--    .block-info__more {-->
<!--        cursor: pointer;-->
<!--        display: flex;-->
<!--        align-items: center;-->
<!--        gap: 10px;-->
<!--        margin-top: 20px;-->
<!--        transition: all 0.3s ease;-->
<!--    }-->
<!---->
<!--    .block-info__more:hover {-->
<!--        opacity: 0.8;-->
<!--    }-->
<!---->
<!--    .block-info__more svg {-->
<!--        transition: transform 0.3s ease;-->
<!--    }-->
<!---->
<!--    .block-info__text {-->
<!--        transition: all 0.3s ease;-->
<!--    }-->
<!--</style>-->

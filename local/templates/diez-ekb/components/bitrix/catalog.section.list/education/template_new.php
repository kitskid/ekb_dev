<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
?>

<?php if (!empty($arResult['SECTIONS'])): ?>
    <div class="education-career-content">
        <?php foreach ($arResult['SECTIONS'] as $section): ?>
            <div class="education-career-block">
                <?php if ($section['DESCRIPTION']): ?>
                    <div class="education-career-description">
                        <?= $section['DESCRIPTION'] ?>
                    </div>
                <?php endif; ?>

                <?php if ($section['DETAIL_PICTURE']): ?>
                    <div class="education-career-image d-md-none">
                        <img src="<?= $section['DETAIL_PICTURE']['SRC'] ?>"
                             alt="<?= $section['NAME'] ?>"
                             class="img-fluid">
                    </div>
                <?php endif; ?>

                <a href="<?= $section['SECTION_PAGE_URL'] ?>" class="btn btn-primary mt-3">Подробнее</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
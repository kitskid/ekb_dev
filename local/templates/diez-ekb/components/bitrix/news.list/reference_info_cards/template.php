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

<?php if (!empty($arResult['ITEMS'])): ?>
    <div class="reference-grid">
        <?php foreach ($arResult['ITEMS'] as $arItem): ?>
            <?php
            $this->AddEditAction(
                $arItem['ID'],
                $arItem['EDIT_LINK'],
                CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT')
            );
            $this->AddDeleteAction(
                $arItem['ID'],
                $arItem['DELETE_LINK'],
                CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'),
                ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
            );

            $linkType = $arItem['PROPERTIES']['LINK_TYPE']['VALUE_ENUM'] ?? '';
            $isExternalLink = (strpos($arItem['DETAIL_PAGE_URL'], 'http') === 0);
            $linkHref = $isExternalLink ? $arItem['DETAIL_PAGE_URL'] : $arItem['DETAIL_PAGE_URL'];
            $linkTarget = $isExternalLink ? ' target="_blank"' : '';
            ?>

            <div class="reference-card" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
                <a href="<?= $linkHref ?>" class="reference-card-link"<?= $linkTarget ?>>
                    <?php if ($arItem['PREVIEW_PICTURE']['SRC']): ?>
                        <div class="reference-card-image">
                            <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>">
                        </div>
                    <?php endif; ?>

                    <div class="reference-card-content">
                        <h3 class="reference-card-title"><?= $arItem['NAME'] ?></h3>
                        <?php if ($arItem['PREVIEW_TEXT']): ?>
                            <div class="reference-card-text">
                                <?= $arItem['PREVIEW_TEXT'] ?>
                            </div>
                        <?php endif; ?>

                        <span class="reference-card-more">Узнать подробности »</span>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <div class="reference-pagination">
            <?= $arResult["NAV_STRING"] ?>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="reference-empty">
        <p>В настоящее время справочная информация отсутствует.</p>
    </div>
<?php endif; ?>
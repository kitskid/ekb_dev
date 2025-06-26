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

    <h2 class="section-title"><?= $arResult['SECTION']['PATH'][0]['NAME'] ?? 'РЕСТАВРАЦИЯ' ?></h2>

<?php if (!empty($arResult['ITEMS'])): ?>
    <div class="row projects-row">
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

            $statusClass = '';
            if (isset($arItem['PROPERTIES']['STATUS']['VALUE_ENUM_ID'])) {
                switch ($arItem['PROPERTIES']['STATUS']['VALUE_ENUM_ID']) {
                    case 1: // Завершен
                        $statusClass = 'completed';
                        break;
                    case 2: // В процессе
                        $statusClass = 'in-progress';
                        break;
                    case 3: // Планируется
                        $statusClass = 'planned';
                        break;
                }
            }
            ?>
            <div class="col-md-4" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
                <div class="project-card">
                    <?php if ($arItem['PREVIEW_PICTURE']['SRC']): ?>
                        <div class="project-image">
                            <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>">
                            <?php if ($arItem['PROPERTIES']['STATUS']['VALUE']): ?>
                                <div class="project-status <?= $statusClass ?>"><?= $arItem['PROPERTIES']['STATUS']['VALUE'] ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="project-content">
                        <h3 class="project-title"><?= $arItem['NAME'] ?></h3>

                        <?php if ($arItem['PROPERTIES']['LOCATION']['VALUE']): ?>
                            <div class="project-location">
                                <i class="fa fa-map-marker"></i> <?= $arItem['PROPERTIES']['LOCATION']['VALUE'] ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($arItem['PREVIEW_TEXT']): ?>
                            <div class="project-description">
                                <?= $arItem['PREVIEW_TEXT'] ?>
                            </div>
                        <?php endif; ?>

                        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="btn btn-sm btn-outline-primary mt-3">Подробнее</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Проекты не найдены</p>
<?php endif; ?>
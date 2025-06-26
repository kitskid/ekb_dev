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

if (empty($arResult["SECTION"])) {
    return;
}

// Получаем данные раздела
$arSection = $arResult["SECTION"];

// Добавляем возможность редактирования
$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], GetMessage("CATALOG_EDIT"));
$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], GetMessage("CATALOG_DELETE"), GetMessage("CATALOG_DELETE_CONFIRM"));

// Получаем данные раздела
$sectionName = $arSection["NAME"];
$sectionDescription = $arSection["~DESCRIPTION"]; // Используем неэкранированную версию для HTML

// Получаем изображение раздела
$imgSrc = "/local/templates/diez-ekb/assets/images/people.png"; // Fallback
if (!empty($arSection["PICTURE"])) {
    // PICTURE содержит ID файла
    $imgFile = CFile::GetFileArray($arSection["PICTURE"]);
    if (!empty($imgFile["SRC"])) {
        $imgSrc = $imgFile["SRC"];
    }
}
?>

<div id="<?=$this->GetEditAreaId($arSection['ID']);?>">
    <div class="study">
        <div class="study__info">
            <h2 class="study__title title">
                <?=htmlspecialchars($sectionName)?>
            </h2>
            <?php if (!empty($sectionDescription)): ?>
                <p class="study__text text">
                    <?=$sectionDescription?>
                </p>
            <?php endif; ?>
        </div>
        <picture class="study__picture">
            <img src="<?=$imgSrc?>" alt="<?=htmlspecialchars($sectionName)?>">
        </picture>
    </div>
</div>

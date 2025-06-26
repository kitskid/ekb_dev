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

if (empty($arResult["SECTIONS"])) {
    return;
}
?>

<div class="header-block">
    <h2 class="title">История</h2>
</div>
<div class="grid">
    <?php foreach($arResult["SECTIONS"] as $arSection): ?>
        <?php
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], GetMessage("CATALOG_EDIT"));
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], GetMessage("CATALOG_DELETE"), GetMessage("CATALOG_DELETE_CONFIRM"));

        // Получаем данные раздела
        $sectionName = $arSection["NAME"];
        $sectionUrl = $arSection["SECTION_PAGE_URL"];

        // Получаем изображение раздела
        $imgSrc = "/local/templates/diez-ekb/assets/images/no-image.jpg"; // Fallback
        if (!empty($arSection["PICTURE"]["SRC"])) {
            $imgSrc = $arSection["PICTURE"]["SRC"];
        } elseif (!empty($arSection["PICTURE"])) {
            // Если PICTURE содержит ID файла
            $imgFile = CFile::GetFileArray($arSection["PICTURE"]);
            if (!empty($imgFile["SRC"])) {
                $imgSrc = $imgFile["SRC"];
            }
        }
        ?>
        <div class="grid__item grid__item--4 grid__item-mob--4">
            <a href="<?=$sectionUrl?>" class="article-history" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
                <picture class="article-history__picture">
                    <img src="<?=$imgSrc?>" alt="<?=htmlspecialchars($sectionName)?>">
                </picture>
                <div class="article-history__info">
                    <h3 class="article-history__title"><?=htmlspecialchars($sectionName)?></h3>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

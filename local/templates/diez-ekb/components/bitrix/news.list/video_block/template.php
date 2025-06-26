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

if (empty($arResult["ITEMS"])) {
    return;
}

// Берем первый (и единственный) элемент
$arItem = $arResult["ITEMS"][0];

// Добавляем возможность редактирования
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

// Получаем данные
$title = $arItem["NAME"];
$description = $arItem["~PREVIEW_TEXT"]; // Используем неэкранированную версию для поддержки HTML

// Получаем видео файл
$videoSrc = "";
if (!empty($arItem["PROPERTIES"]["VIDEO"]["VALUE"]["path"])) {
    $videoSrc = $arItem["PROPERTIES"]["VIDEO"]["VALUE"]["path"];
}

// Получаем постер видео из превью картинки элемента
$videoPoster = "/local/templates/diez-ekb/assets/images/video-preview.jpg"; // Fallback постер
if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
    $videoPoster = $arItem["PREVIEW_PICTURE"]["SRC"];
}
?>

<div id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <div class="header-block">
        <h2 class="title"><?=htmlspecialchars($title)?></h2>
        <?php if (!empty($description)): ?>
            <p class="text">
                <?=$description?>
            </p>
        <?php endif; ?>
    </div>

    <?php if (!empty($videoSrc)): ?>
        <div class="video">
            <?php
            // Определяем тип видео файла
            $fileInfo = pathinfo($videoSrc);
            $extension = strtolower($fileInfo['extension']);

            $mimeType = 'video/mp4';
            switch ($extension) {
                case 'webm':
                    $mimeType = 'video/webm';
                    break;
                case 'ogg':
                case 'ogv':
                    $mimeType = 'video/ogg';
                    break;
                case 'mov':
                    $mimeType = 'video/quicktime';
                    break;
                case 'avi':
                    $mimeType = 'video/x-msvideo';
                    break;
                default:
                    $mimeType = 'video/mp4';
            }
            ?>
            <video poster="<?=$videoPoster?>" preload="auto" controls playsinline>
                <source src="<?=$videoSrc?>" type='<?=$mimeType?>'>
                Ваш браузер не поддерживает воспроизведение видео.
            </video>
        </div>
    <?php else: ?>
        <!-- Если нет видео, но есть постер, показываем просто картинку -->
        <?php if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])): ?>
            <div class="video">
                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=htmlspecialchars($title)?>" style="width: 100%; height: auto;">
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

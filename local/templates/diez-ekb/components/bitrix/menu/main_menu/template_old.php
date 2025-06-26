<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

if (!empty($arResult)):
    ?>
    <ul>
        <?php foreach($arResult as $arItem): ?>
            <?php if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) continue; ?>
            <li>
                <a href="<?=$arItem["LINK"]?>" <?php if($arItem["SELECTED"]): ?>class="active"<?php endif; ?>>
                    <?=$arItem["TEXT"]?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

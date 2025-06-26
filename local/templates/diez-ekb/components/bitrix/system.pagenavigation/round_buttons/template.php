<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<?php if ($arResult["NavPageCount"] > 1): ?>
    <ul class="pagination">
        <?php if ($arResult["NavPageNomer"] > 1): ?>
            <li>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1" class="pagination-first">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
            <li>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"]-1) ?>" class="pagination-prev modern-page-previous">
                    <i class="fa fa-angle-left"></i>
                </a>
            </li>
        <?php else: ?>
            <li class="disabled">
                <span class="pagination-first">
                    <i class="fa fa-angle-double-left"></i>
                </span>
            </li>
            <li class="disabled">
                <span class="pagination-prev">
                    <i class="fa fa-angle-left"></i>
                </span>
            </li>
        <?php endif; ?>

        <?php
        $arPages = [];

        if ($arResult["NavPageNomer"] > 3) {
            $arPages[] = 1;
            $arPages[] = '...';
        }

        if ($arResult["NavPageNomer"] > 1) {
            $arPages[] = $arResult["NavPageNomer"] - 1;
        }

        $arPages[] = $arResult["NavPageNomer"];

        if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
            $arPages[] = $arResult["NavPageNomer"] + 1;
        }

        if ($arResult["NavPageNomer"] < $arResult["NavPageCount"] - 2) {
            $arPages[] = '...';
            $arPages[] = $arResult["NavPageCount"];
        }

        foreach ($arPages as $page):
            ?>
            <?php if ($page == '...'): ?>
            <li class="disabled">
                <span class="pagination-dots">...</span>
            </li>
        <?php elseif ($page == $arResult["NavPageNomer"]): ?>
            <li class="active">
                <span><?= $page ?></span>
            </li>
        <?php else: ?>
            <li>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $page ?>"><?= $page ?></a>
            </li>
        <?php endif; ?>
        <?php endforeach; ?>

        <?php if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
            <li>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"]+1) ?>" class="pagination-next modern-page-next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>
            <li>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>" class="pagination-last">
                    <i class="fa fa-angle-double-right"></i>
                </a>
            </li>
        <?php else: ?>
            <li class="disabled">
                <span class="pagination-next">
                    <i class="fa fa-angle-right"></i>
                </span>
            </li>
            <li class="disabled">
                <span class="pagination-last">
                    <i class="fa fa-angle-double-right"></i>
                </span>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
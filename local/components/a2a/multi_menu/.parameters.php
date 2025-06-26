<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Получаем все типы меню из файловой системы
$menuTypes = array();
$siteDir = $arCurrentValues["SITE_DIR"] ?? SITE_DIR;
$menuTypesFile = $_SERVER["DOCUMENT_ROOT"] . $siteDir . ".menu_types.php";

if (file_exists($menuTypesFile)) {
    include($menuTypesFile);
}

$arTypesEx = array();
if (is_array($aMenuTypes)) {
    foreach ($aMenuTypes as $menuType => $menuDesc) {
        $arTypesEx[$menuType] = $menuDesc;
    }
}

$arComponentParameters = array(
    "PARAMETERS" => array(
        "MENU_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("MULTI_MENU_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "top",
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ),
        "ROOT_MENU_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("MULTI_MENU_ROOT_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "top",
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ),
        "MAX_LEVEL" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("MULTI_MENU_MAX_LEVEL"),
            "TYPE" => "LIST",
            "VALUES" => array(
                "1" => GetMessage("MULTI_MENU_MAX_LEVEL_1"),
                "2" => GetMessage("MULTI_MENU_MAX_LEVEL_2"),
                "3" => GetMessage("MULTI_MENU_MAX_LEVEL_3"),
            ),
            "DEFAULT" => "2",
        ),
        "USE_EXT" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("MULTI_MENU_USE_EXT"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "ALLOW_MULTI_SELECT" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("MULTI_MENU_ALLOW_MULTI_SELECT"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "SPRITE_PATH" => array(
            "PARENT" => "VISUAL",
            "NAME" => GetMessage("MULTI_MENU_SPRITE_PATH"),
            "TYPE" => "STRING",
            "DEFAULT" => "/local/templates/diez-ekb/assets/sprite.svg",
        ),
        "CACHE_TIME" => array("DEFAULT" => 3600),
    ),
);

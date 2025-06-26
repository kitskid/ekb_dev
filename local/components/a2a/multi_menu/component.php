<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */

if (!isset($arParams["CACHE_TIME"])) {
    $arParams["CACHE_TIME"] = 3600;
}

$arParams["MENU_TYPE"] = trim($arParams["MENU_TYPE"]);
$arParams["ROOT_MENU_TYPE"] = trim($arParams["ROOT_MENU_TYPE"]);

$arParams["MAX_LEVEL"] = intval($arParams["MAX_LEVEL"]);
if ($arParams["MAX_LEVEL"] <= 0) {
    $arParams["MAX_LEVEL"] = 1;
}

$arParams["USE_EXT"] = $arParams["USE_EXT"] === "Y" ? "Y" : "N";
$arParams["ALLOW_MULTI_SELECT"] = $arParams["ALLOW_MULTI_SELECT"] === "Y" ? "Y" : "N";
$arParams["SPRITE_PATH"] = trim($arParams["SPRITE_PATH"]);

$menuType = $arParams["MENU_TYPE"];
$rootMenuType = $arParams["ROOT_MENU_TYPE"] ?: $menuType;

// Получаем текущий путь
$currentPage = $APPLICATION->GetCurPage();

// Для отладки сохраняем список проверяемых файлов подменю
$arResult["DEBUG_FILES"] = array();

if ($this->startResultCache(false, array($currentPage))) {
    // Получаем данные меню
    $menu = new CMenu($menuType);
    $menu->Init($currentPage, $arParams["USE_EXT"] === "Y", $rootMenuType);
//    var_dump($menu);
    $arResult["MENU_STRUCTURE"] = array();
    $arResult["ITEMS"] = array();

    if ($menu->arMenu) {
        // Подготавливаем структуру меню
        foreach ($menu->arMenu as $menuItem) {
//            var_dump($menuItem[3]["MENU_ITEM_ID"]);
            $menuItemId = isset($menuItem[3]["MENU_ITEM_ID"]) ? $menuItem[3]["MENU_ITEM_ID"] : "";

            $arMenuItem = array(
                "TEXT" => $menuItem[0],
                "LINK" => $menuItem[1],
                "SELECTED" => $menuItem[2],
                "PERMISSION" => $menuItem[3],
                "ADDITIONAL_LINKS" => $menuItem[4],
                "ITEM_TYPE" => $menuItem[5],
                "PARAMS" => $menuItem[6],
                "DEPTH_LEVEL" => 1,
                "IS_PARENT" => false,
                "CHILDREN" => array(),
                "MENU_ITEM_ID" => $menuItemId
            );

            if ($arParams["MAX_LEVEL"] > 1 && !empty($menuItemId)) {
                // Получаем подменю для текущего пункта
                $childMenuType = $menuType . "_" . $menuItemId;

                // Для отладки сохраняем информацию о проверяемом файле
                $arResult["DEBUG_FILES"][] = array(
                    "MENU_ITEM" => $menuItem[0],
                    "MENU_ITEM_ID" => $menuItemId,
                    "CHILD_MENU_TYPE" => $childMenuType,
                    "FILE_PATH" => $_SERVER["DOCUMENT_ROOT"] . "/{$childMenuType}.menu.php"
                );

                if (isset($menuItem[1]) && $menuItem[1] == '') {
                    $path_menu = '/' . $menuItemId . '/';
                } else {
                    $path_menu = $menuItem[1];
                }
                $childMenu = new CMenu($childMenuType);
                $childMenu->Init($path_menu, $arParams["USE_EXT"] === "Y", $menuType);


                // Проверяем, загрузилось ли подменю
                if ($childMenu->arMenu) {
                    $arMenuItem["IS_PARENT"] = true;

                    foreach ($childMenu->arMenu as $childItem) {
                        // Проверяем активность дочернего пункта меню
                        $isChildSelected = $childItem[2] || (
                                is_array($childItem[4]) &&
                                in_array($currentPage, $childItem[4])
                            );

                        // Если дочерний пункт активен, помечаем родительский как активный
                        if ($isChildSelected) {
                            $arMenuItem["SELECTED"] = true;
                        }

                        $arChildItem = array(
                            "TEXT" => $childItem[0],
                            "LINK" => $childItem[1],
                            "SELECTED" => $isChildSelected,
                            "PERMISSION" => $childItem[3],
                            "ADDITIONAL_LINKS" => $childItem[4],
                            "ITEM_TYPE" => $childItem[5],
                            "PARAMS" => $childItem[6],
                            "DEPTH_LEVEL" => 2,
                            "IS_PARENT" => false,
                        );

                        $arMenuItem["CHILDREN"][] = $arChildItem;
                    }
                }
            }

            $arResult["ITEMS"][] = $arMenuItem;
        }

        $arResult["MENU_STRUCTURE"] = $menu->arMenu;
    }

    $this->includeComponentTemplate();
} else {
    // Добавляем отладочную информацию даже при использовании кеша
    $arResult["DEBUG_FILES"] = array();

    // Получаем структуру меню для отладки
    $menu = new CMenu($menuType);
    $menu->Init($currentPage, $arParams["USE_EXT"] === "Y", $rootMenuType);

    if ($menu->arMenu) {
        foreach ($menu->arMenu as $menuItem) {
            $menuItemId = isset($menuItem[6]["MENU_ITEM_ID"]) ? $menuItem[6]["MENU_ITEM_ID"] : "";

            if ($arParams["MAX_LEVEL"] > 1 && !empty($menuItemId)) {
                $childMenuType = $menuType . "_" . $menuItemId;

                // Для отладки сохраняем информацию о проверяемом файле
                $arResult["DEBUG_FILES"][] = array(
                    "MENU_ITEM" => $menuItem[0],
                    "MENU_ITEM_ID" => $menuItemId,
                    "CHILD_MENU_TYPE" => $childMenuType,
                    "FILE_PATH" => $_SERVER["DOCUMENT_ROOT"] . "/{$childMenuType}.menu.php"
                );
            }
        }
    }
}

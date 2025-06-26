<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

/**
 * Рекурсивно загружает меню из файлов .top.menu.php
 * @param string $path - путь от корня сайта, например '' или '/about'
 * @param int $depth - уровень вложенности
 * @return array
 */
function loadMenuRecursive(string $path = '', int $depth = 1): array
{
    $menuFile = $_SERVER['DOCUMENT_ROOT'] . $path . '/.top.menu.php';
    $result = [];

    if (file_exists($menuFile)) {
        include $menuFile;

        if (isset($aMenuLinks) && is_array($aMenuLinks)) {
            foreach ($aMenuLinks as $item) {
                $children = loadMenuRecursive($item[1], $depth + 1);

                $result[] = [
                    'TEXT' => $item[0],
                    'LINK' => $item[1],
                    'DEPTH_LEVEL' => $depth,
                    'IS_PARENT' => !empty($children),
                    'CHILDREN' => $children,
                    'SELECTED' => $APPLICATION->GetCurPage(false) === $item[1],
                ];
            }
        }
    }

    return $result;
}

$arResult = loadMenuRecursive('', 1);

$this->IncludeComponentTemplate();

<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Проверяем, есть ли фильтр по типу в запросе
if (isset($_REQUEST['type']) && $_REQUEST['type'] != 'all' && !empty($_REQUEST['type'])) {
    $filterCategory = $_REQUEST['type'];

    // Фильтруем элементы по выбранной категории
    $filteredItems = array();
    foreach ($arResult["ITEMS"] as $arItem) {
        $matchesFilter = false;

        if (isset($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
            // Если свойство множественное (массив)
            if (is_array($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
                foreach ($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] as $xml_id) {
                    if ((string)$xml_id === $filterCategory) {
                        $matchesFilter = true;
                        break;
                    }
                }
            }
            // Если свойство обычное (скаляр)
            elseif ((string)$arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] === $filterCategory) {
                $matchesFilter = true;
            }
        }

        if ($matchesFilter) {
            $filteredItems[] = $arItem;
        }
    }

    // Заменяем исходный массив элементов на отфильтрованный
    if (!empty($filteredItems)) {
        $arResult["ITEMS"] = $filteredItems;
    }
}

// Получаем уникальные категории (типы) из элементов для фильтров
$categories = array();

// Добавим категорию "Все"
$categories['all'] = array(
    'NAME' => 'Все',
    'XML_ID' => 'all',
    'COUNT' => count($arResult["ITEMS_ORIGINAL"] ?? $arResult["ITEMS"]),
    'ACTIVE' => !isset($_REQUEST['type']) || $_REQUEST['type'] == 'all'
);

// Для хранения всех элементов с координатами для карты
$arResult["MAP_ITEMS"] = array();

// Массив для хранения всех оригинальных элементов (для карты)
$arResult["ITEMS_ORIGINAL"] = $arResult["ITEMS_ORIGINAL"] ?? $arResult["ITEMS"];

// Собираем категории из элементов
foreach ($arResult["ITEMS_ORIGINAL"] as $arItem) {
    // Проверяем наличие координат для карты
    if (!empty($arItem["PROPERTIES"]["COORDINATES"]["VALUE"])) {
        // Обработка координат для карты
        $coordinates = explode(",", $arItem["PROPERTIES"]["COORDINATES"]["VALUE"]);
        if (count($coordinates) == 2) {
            $arResult["MAP_ITEMS"][] = array(
                'ID' => $arItem['ID'],
                'NAME' => $arItem['NAME'],
                'LAT' => trim($coordinates[0]),
                'LON' => trim($coordinates[1]),
                'ADDRESS' => $arItem["PROPERTIES"]["ADDRESS"]["VALUE"],
                'DETAIL_URL' => $arItem['DETAIL_PAGE_URL']
            );
        }
    }

    // Получаем типы гостиниц для фильтров
    if (isset($arItem["PROPERTIES"]["TYPE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["TYPE"]["VALUE"])) {
        // Если свойство множественное
        if (is_array($arItem["PROPERTIES"]["TYPE"]["VALUE"])) {
            for ($i = 0; $i < count($arItem["PROPERTIES"]["TYPE"]["VALUE"]); $i++) {
                $value = $arItem["PROPERTIES"]["TYPE"]["VALUE"][$i];
                $xml_id = $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"][$i];

                if (!isset($categories[$xml_id])) {
                    $categories[$xml_id] = array(
                        'NAME' => $value,
                        'XML_ID' => $xml_id,
                        'COUNT' => 1,
                        'ACTIVE' => isset($_REQUEST['type']) && $_REQUEST['type'] == $xml_id
                    );
                } else {
                    $categories[$xml_id]['COUNT']++;
                }
            }
        }
        // Если свойство не множественное
        else {
            $value = $arItem["PROPERTIES"]["TYPE"]["VALUE"];
            $xml_id = $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"];

            if (!isset($categories[$xml_id])) {
                $categories[$xml_id] = array(
                    'NAME' => $value,
                    'XML_ID' => $xml_id,
                    'COUNT' => 1,
                    'ACTIVE' => isset($_REQUEST['type']) && $_REQUEST['type'] == $xml_id
                );
            } else {
                $categories[$xml_id]['COUNT']++;
            }
        }
    }
}

$arResult["CATEGORIES"] = $categories;

// Определяем, будет ли кнопка "Показать еще"
$arResult["SHOW_MORE_BUTTON"] = false;

// Если включены параметры постраничной навигации
if($arParams["DISPLAY_BOTTOM_PAGER"] == "Y" && $arResult["NAV_RESULT"]->NavPageCount > 1 && $arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->NavPageCount) {
    $arResult["SHOW_MORE_BUTTON"] = true;
}

// Обработка параметров для AJAX-пагинации
$arResult["AJAX_PARAMS"] = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ELEMENT_COUNT" => $arParams["NEWS_COUNT"],
    "SORT_BY1" => $arParams["SORT_BY1"],
    "SORT_ORDER1" => $arParams["SORT_ORDER1"],
    "SORT_BY2" => $arParams["SORT_BY2"],
    "SORT_ORDER2" => $arParams["SORT_ORDER2"],
    "FIELD_CODE" => $arParams["FIELD_CODE"],
    "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
    "PAGE_ELEMENT_COUNT" => $arParams["NEWS_COUNT"],
    "AJAX_MODE" => "Y"
);

// Уникальный идентификатор для AJAX
$arResult["AJAX_ID"] = $this->randString();

<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Сохраняем оригинальный массив элементов, если он еще не сохранен
if (!isset($arResult["ITEMS_ORIGINAL"])) {
    $arResult["ITEMS_ORIGINAL"] = $arResult["ITEMS"];
}

// ИСПРАВЛЯЕМ: Правильное получение множественных параметров type
$selectedTypes = array();

// Способ 1: Если параметры переданы как type[]
if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
    if (is_array($_REQUEST['type'])) {
        $selectedTypes = $_REQUEST['type'];
    } else {
        $selectedTypes = [$_REQUEST['type']];
    }
}

// Способ 2: Парсим QUERY_STRING вручную для параметров вида type=val1&type=val2
if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
    $queryParams = array();
    parse_str($_SERVER['QUERY_STRING'], $queryParams);

    // Ручной парсинг для множественных параметров type
    $queryString = $_SERVER['QUERY_STRING'];
    preg_match_all('/type=([^&]+)/', $queryString, $matches);

    if (!empty($matches[1])) {
        $selectedTypes = array_map('urldecode', $matches[1]);
    }
}

// Удаляем пустые значения и приводим к строкам
$selectedTypes = array_filter(array_map('strval', $selectedTypes));
$selectedTypes = array_unique($selectedTypes); // Убираем дубликаты

// Работаем всегда с оригинальным массивом элементов
$itemsToProcess = $arResult["ITEMS_ORIGINAL"];

// Отладочная информация
$debugInfo = array();
$debugInfo['query_string'] = $_SERVER['QUERY_STRING'] ?? '';
$debugInfo['selected_types'] = $selectedTypes;
$debugInfo['total_items'] = count($itemsToProcess);

// Если выбраны фильтры и не включен 'all'
if (!empty($selectedTypes) && !in_array('all', $selectedTypes)) {
    $filteredItems = array();

    foreach ($itemsToProcess as $key => $arItem) {
        $itemTypes = array();
        $matchesFilter = false;

        // Получаем все типы элемента
        if (isset($arItem["PROPERTIES"]["TYPE"])) {
            if (isset($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
                // Если есть XML_ID, используем его
                if (is_array($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
                    $itemTypes = array_map('strval', $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"]);
                } else {
                    $itemTypes = [strval($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])];
                }
            } elseif (isset($arItem["PROPERTIES"]["TYPE"]["VALUE"])) {
                // Если нет XML_ID, используем VALUE
                if (is_array($arItem["PROPERTIES"]["TYPE"]["VALUE"])) {
                    $itemTypes = array_map('strval', $arItem["PROPERTIES"]["TYPE"]["VALUE"]);
                } else {
                    $itemTypes = [strval($arItem["PROPERTIES"]["TYPE"]["VALUE"])];
                }
            }
        }

        // Проверяем пересечение массивов (логика ИЛИ)
        $intersection = array_intersect($selectedTypes, $itemTypes);
        $matchesFilter = !empty($intersection);

        // Сохраняем отладочную информацию для первых 5 элементов
        if ($key < 5) {
            $debugInfo['items'][$key] = array(
                'id' => $arItem['ID'],
                'name' => $arItem['NAME'],
                'item_types' => $itemTypes,
                'intersection' => $intersection,
                'matches' => $matchesFilter
            );
        }

        // Если элемент соответствует хотя бы одному фильтру, добавляем его
        if ($matchesFilter) {
            $filteredItems[] = $arItem;
        }
    }

    $debugInfo['filtered_count'] = count($filteredItems);

    // Заменяем массив элементов на отфильтрованный
    $arResult["ITEMS"] = $filteredItems;
} else {
    // Если фильтрация не применяется, используем оригинальные элементы
    $arResult["ITEMS"] = $itemsToProcess;
    $debugInfo['filtered_count'] = count($itemsToProcess);
    $debugInfo['filter_applied'] = false;
}

// Получаем уникальные категории (типы) из ВСЕХ элементов для фильтров
$categories = array();

// Добавим категорию "Все"
$categories['all'] = array(
    'NAME' => 'Все',
    'XML_ID' => 'all',
    'COUNT' => count($arResult["ITEMS_ORIGINAL"]),
    'ACTIVE' => empty($selectedTypes)
);

// Для хранения всех элементов с координатами для карты
$arResult["MAP_ITEMS"] = array();

// Собираем категории из ВСЕХ оригинальных элементов
foreach ($arResult["ITEMS_ORIGINAL"] as $arItem) {
    // Проверяем наличие координат для карты
    if (!empty($arItem["PROPERTIES"]["COORDINATES"]["VALUE"])) {
        $coordinates = explode(",", $arItem["PROPERTIES"]["COORDINATES"]["VALUE"]);
        if (count($coordinates) == 2) {
            $arResult["MAP_ITEMS"][] = array(
                'ID' => $arItem['ID'],
                'NAME' => $arItem['Name'],
                'LAT' => trim($coordinates[0]),
                'LON' => trim($coordinates[1]),
                'ADDRESS' => isset($arItem["PROPERTIES"]["ADDRESS"]["VALUE"]) ? $arItem["PROPERTIES"]["ADDRESS"]["VALUE"] : '',
                'DETAIL_URL' => $arItem['DETAIL_PAGE_URL']
            );
        }
    }

    // Получаем типы гостиниц для фильтров
    if (isset($arItem["PROPERTIES"]["TYPE"])) {
        $typeValues = array();
        $typeXmlIds = array();

        // Получаем значения и XML_ID
        if (isset($arItem["PROPERTIES"]["TYPE"]["VALUE"])) {
            if (is_array($arItem["PROPERTIES"]["TYPE"]["VALUE"])) {
                $typeValues = $arItem["PROPERTIES"]["TYPE"]["VALUE"];
            } else {
                $typeValues = [$arItem["PROPERTIES"]["TYPE"]["VALUE"]];
            }
        }

        if (isset($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
            if (is_array($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])) {
                $typeXmlIds = $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"];
            } else {
                $typeXmlIds = [$arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"]];
            }
        }

        // Если нет XML_ID, используем значения как XML_ID
        if (empty($typeXmlIds)) {
            $typeXmlIds = $typeValues;
        }

        // Создаем категории
        for ($i = 0; $i < count($typeValues); $i++) {
            $value = isset($typeValues[$i]) ? $typeValues[$i] : '';
            $xml_id = isset($typeXmlIds[$i]) ? strval($typeXmlIds[$i]) : strval($value);

            if (!empty($xml_id)) {
                if (!isset($categories[$xml_id])) {
                    $categories[$xml_id] = array(
                        'NAME' => $value,
                        'XML_ID' => $xml_id,
                        'COUNT' => 1,
                        'ACTIVE' => in_array($xml_id, $selectedTypes)
                    );
                } else {
                    $categories[$xml_id]['COUNT']++;
                }
            }
        }
    }
}

$arResult["CATEGORIES"] = $categories;
$arResult["SELECTED_TYPES"] = $selectedTypes;

// Определяем, будет ли кнопка "Показать еще"
$arResult["SHOW_MORE_BUTTON"] = false;

if ($arParams["DISPLAY_BOTTOM_PAGER"] == "Y" && isset($arResult["NAV_RESULT"]) && $arResult["NAV_RESULT"]->NavPageCount > 1 && $arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->NavPageCount) {
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

// Отладочная информация (включается добавлением ?debug=Y к URL)
if (isset($_GET['debug']) && $_GET['debug'] == 'Y') {
    echo '<div style="background: #f0f0f0; padding: 15px; margin: 15px 0; font-family: monospace; font-size: 12px; border: 1px solid #ccc;">';
    echo '<h3>Отладка фильтрации гостиниц</h3>';
    echo '<p><strong>Query String:</strong> ' . $debugInfo['query_string'] . '</p>';
    echo '<p><strong>Выбранные типы:</strong> [' . implode(', ', $selectedTypes) . ']</p>';
    echo '<p><strong>Количество выбранных типов:</strong> ' . count($selectedTypes) . '</p>';
    echo '<p><strong>Всего элементов в базе:</strong> ' . $debugInfo['total_items'] . '</p>';
    echo '<p><strong>Элементов после фильтрации:</strong> ' . $debugInfo['filtered_count'] . '</p>';

    echo '<h4>Доступные категории:</h4>';
    echo '<ul>';
    foreach ($categories as $xmlId => $category) {
        $activeStatus = $category['ACTIVE'] ? ' (АКТИВНА)' : '';
        echo '<li>' . $category['NAME'] . ' (XML_ID: ' . $xmlId . ', Количество: ' . $category['COUNT'] . ')' . $activeStatus . '</li>';
    }
    echo '</ul>';

    if (isset($debugInfo['items'])) {
        echo '<h4>Детальная информация по первым 5 элементам:</h4>';
        foreach ($debugInfo['items'] as $itemInfo) {
            $matchStatus = $itemInfo['matches'] ? 'ПРОШЕЛ ФИЛЬТР' : 'НЕ ПРОШЕЛ ФИЛЬТР';
            echo '<div style="margin: 10px 0; padding: 10px; background: ' . ($itemInfo['matches'] ? '#e8f5e8' : '#f5e8e8') . ';">';
            echo '<strong>ID ' . $itemInfo['id'] . ':</strong> ' . $itemInfo['name'] . '<br>';
            echo '<strong>Типы элемента:</strong> [' . implode(', ', $itemInfo['item_types']) . ']<br>';
            echo '<strong>Пересечение с фильтром:</strong> [' . implode(', ', $itemInfo['intersection']) . ']<br>';
            echo '<strong>Результат:</strong> ' . $matchStatus;
            echo '</div>';
        }
    }

    echo '</div>';
}

<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Сохраняем оригинальный массив элементов, если он еще не сохранен
if (!isset($arResult["ITEMS_ORIGINAL"])) {
    $arResult["ITEMS_ORIGINAL"] = $arResult["ITEMS"];
}

// Правильное получение множественных параметров type
$selectedTypes = array();

if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
    if (is_array($_REQUEST['type'])) {
        $selectedTypes = $_REQUEST['type'];
    } else {
        $selectedTypes = [$_REQUEST['type']];
    }
}

// Парсим QUERY_STRING вручную для параметров вида type=val1&type=val2
if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    preg_match_all('/type=([^&]+)/', $queryString, $matches);

    if (!empty($matches[1])) {
        $selectedTypes = array_map('urldecode', $matches[1]);
    }
}

// Удаляем пустые значения и приводим к строкам
$selectedTypes = array_filter(array_map('strval', $selectedTypes));
$selectedTypes = array_unique($selectedTypes);

// Получаем текущую страницу
$currentPage = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

// Получаем все категории с использованием кеширования
$categories = array();
$arResult["MAP_ITEMS"] = array();

$cacheId = "restaurant_categories_map_" . $arParams["IBLOCK_ID"] . "_" . md5(serialize($arParams));
$cacheTime = 3600;
$obCache = new CPHPCache;

if ($obCache->InitCache($cacheTime, $cacheId, "/restaurant_categories/")) {
    $res = $obCache->GetVars();
    $categories = $res["categories"];
    $arResult["MAP_ITEMS"] = $res["mapItems"];
    $totalElementsCount = $res["totalCount"];
} else {
    // Загружаем ВСЕ элементы инфоблока для получения полного списка категорий и карты
    $rsAllItems = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ACTIVE" => "Y"
        ),
        false,
        false,
        array("ID", "NAME", "DETAIL_PAGE_URL")
    );

    $totalElementsCount = $rsAllItems->SelectedRowsCount();

    // Собираем все элементы для обработки
    while ($arAllItem = $rsAllItems->GetNext()) {
        // Получаем свойство TYPE с VALUE_ENUM
        $rsTypeProp = CIBlockElement::GetProperty(
            $arParams["IBLOCK_ID"],
            $arAllItem["ID"],
            array("sort" => "asc"),
            array("CODE" => "TYPE")
        );

        $typeValues = array();
        $typeXmlIds = array();
        while ($prop = $rsTypeProp->Fetch()) {
            if (!empty($prop["VALUE"])) {
                $typeValues[] = $prop["VALUE_ENUM"];
                $typeXmlIds[] = $prop["VALUE_XML_ID"];
            }
        }

        // Получаем координаты для карты
        $rsCoordsProp = CIBlockElement::GetProperty(
            $arParams["IBLOCK_ID"],
            $arAllItem["ID"],
            array("sort" => "asc"),
            array("CODE" => "COORDINATES")
        );

        $coordinates = "";
        if ($prop = $rsCoordsProp->Fetch()) {
            $coordinates = $prop["VALUE"];
        }

        // Получаем адрес
        $rsAddressProp = CIBlockElement::GetProperty(
            $arParams["IBLOCK_ID"],
            $arAllItem["ID"],
            array("sort" => "asc"),
            array("CODE" => "ADDRESS")
        );

        $address = "";
        if ($prop = $rsAddressProp->Fetch()) {
            $address = $prop["VALUE"];
        }

        // Добавляем в карту
        if (!empty($coordinates)) {
            $coordsArray = explode(",", $coordinates);
            if (count($coordsArray) == 2) {
                $arResult["MAP_ITEMS"][] = array(
                    'ID' => $arAllItem['ID'],
                    'NAME' => $arAllItem['NAME'],
                    'LAT' => trim($coordsArray[0]),
                    'LON' => trim($coordsArray[1]),
                    'ADDRESS' => $address,
                    'DETAIL_URL' => $arAllItem['DETAIL_PAGE_URL']
                );
            }
        }

        // Создаем категории
        for ($i = 0; $i < count($typeValues); $i++) {
            $value = $typeValues[$i];
            $xml_id = isset($typeXmlIds[$i]) ? $typeXmlIds[$i] : $value;

            if (!empty($value) && !empty($xml_id)) {
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

    // Сохраняем в кеш
    if ($obCache->StartDataCache()) {
        $obCache->EndDataCache(array(
            "categories" => $categories,
            "mapItems" => $arResult["MAP_ITEMS"],
            "totalCount" => $totalElementsCount
        ));
    }
}

// Добавим категорию "Все"
$categories = array_merge(array('all' => array(
    'NAME' => 'Все',
    'XML_ID' => 'all',
    'COUNT' => $totalElementsCount,
    'ACTIVE' => empty($selectedTypes)
)), $categories);

// Получаем отфильтрованные элементы
$filteredElementsIds = array();

// Получаем все элементы с учетом сортировки
$rsAllFilteredItems = CIBlockElement::GetList(
    array(
        $arParams["SORT_BY1"] => $arParams["SORT_ORDER1"],
        $arParams["SORT_BY2"] => $arParams["SORT_ORDER2"]
    ),
    array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y"
    ),
    false,
    false,
    array("ID")
);

while ($arFilteredItem = $rsAllFilteredItems->GetNext()) {
    $shouldInclude = true;

    // Если есть фильтры, проверяем соответствие
    if (!empty($selectedTypes) && !in_array('all', $selectedTypes)) {
        $rsTypeProp = CIBlockElement::GetProperty(
            $arParams["IBLOCK_ID"],
            $arFilteredItem["ID"],
            array("sort" => "asc"),
            array("CODE" => "TYPE")
        );

        $itemTypes = array();
        while ($prop = $rsTypeProp->Fetch()) {
            if (!empty($prop["VALUE_XML_ID"])) {
                $itemTypes[] = strval($prop["VALUE_XML_ID"]);
            }
        }

        // Проверяем пересечение (логика ИЛИ)
        $intersection = array_intersect($selectedTypes, $itemTypes);
        $shouldInclude = !empty($intersection);
    }

    if ($shouldInclude) {
        $filteredElementsIds[] = $arFilteredItem["ID"];
    }
}

// Вычисляем пагинацию
$itemsPerPage = intval($arParams["NEWS_COUNT"]);
$totalFilteredItems = count($filteredElementsIds);
$totalPages = ceil($totalFilteredItems / $itemsPerPage);
$startIndex = ($currentPage - 1) * $itemsPerPage;
$currentPageElementsIds = array_slice($filteredElementsIds, $startIndex, $itemsPerPage);

// Получаем элементы для текущей страницы
if (!empty($currentPageElementsIds)) {
    $rsCurrentPageItems = CIBlockElement::GetList(
        array(
            $arParams["SORT_BY1"] => $arParams["SORT_ORDER1"],
            $arParams["SORT_BY2"] => $arParams["SORT_ORDER2"]
        ),
        array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ID" => $currentPageElementsIds,
            "ACTIVE" => "Y"
        ),
        false,
        false,
        array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "IBLOCK_ID")
    );

    $currentPageItems = array();
    while ($arCurrentItem = $rsCurrentPageItems->GetNext()) {
        // Получаем свойства элемента
        $arCurrentItem["PROPERTIES"] = array();

        $propertyCodeList = isset($arParams["PROPERTY_CODE"]) ? $arParams["PROPERTY_CODE"] : array();
        if (!is_array($propertyCodeList)) {
            $propertyCodeList = array($propertyCodeList);
        }

        foreach ($propertyCodeList as $propCode) {
            if (empty($propCode)) continue;

            $rsProp = CIBlockElement::GetProperty(
                $arParams["IBLOCK_ID"],
                $arCurrentItem["ID"],
                array("sort" => "asc"),
                array("CODE" => $propCode)
            );

            $arCurrentItem["PROPERTIES"][$propCode] = array(
                "VALUE" => array(),
                "VALUE_XML_ID" => array()
            );

            while ($prop = $rsProp->Fetch()) {
                if (!empty($prop["VALUE"])) {
                    // ИСПРАВЛЕНИЕ: для свойства TYPE используем VALUE_ENUM для правильного отображения
                    if ($propCode === "TYPE") {
                        $arCurrentItem["PROPERTIES"][$propCode]["VALUE"][] = $prop["VALUE_ENUM"];
                    } else {
                        $arCurrentItem["PROPERTIES"][$propCode]["VALUE"][] = $prop["VALUE"];
                    }
                    $arCurrentItem["PROPERTIES"][$propCode]["VALUE_XML_ID"][] = $prop["VALUE_XML_ID"];
                }
            }

            // Преобразование в скаляр для одиночных свойств
            if (is_array($arCurrentItem["PROPERTIES"][$propCode]["VALUE"])) {
                if (count($arCurrentItem["PROPERTIES"][$propCode]["VALUE"]) == 1) {
                    $arCurrentItem["PROPERTIES"][$propCode]["VALUE"] = $arCurrentItem["PROPERTIES"][$propCode]["VALUE"][0];
                    $arCurrentItem["PROPERTIES"][$propCode]["VALUE_XML_ID"] = is_array($arCurrentItem["PROPERTIES"][$propCode]["VALUE_XML_ID"]) ?
                        $arCurrentItem["PROPERTIES"][$propCode]["VALUE_XML_ID"][0] :
                        $arCurrentItem["PROPERTIES"][$propCode]["VALUE_XML_ID"];
                } elseif (count($arCurrentItem["PROPERTIES"][$propCode]["VALUE"]) == 0) {
                    $arCurrentItem["PROPERTIES"][$propCode]["VALUE"] = "";
                    $arCurrentItem["PROPERTIES"][$propCode]["VALUE_XML_ID"] = "";
                }
            }
        }

        // Получаем картинку
        if (!empty($arCurrentItem["PREVIEW_PICTURE"])) {
            $arCurrentItem["PREVIEW_PICTURE"] = CFile::GetFileArray($arCurrentItem["PREVIEW_PICTURE"]);
        }

        $currentPageItems[] = $arCurrentItem;
    }

    $arResult["ITEMS"] = $currentPageItems;
} else {
    $arResult["ITEMS"] = array();
}

// Создаем объект навигации
$arResult["NAV_RESULT"] = new stdClass();
$arResult["NAV_RESULT"]->NavPageCount = $totalPages;
$arResult["NAV_RESULT"]->NavPageNomer = $currentPage;
$arResult["NAV_RESULT"]->NavRecordCount = $totalFilteredItems;

// Простая логика для кнопки "Показать еще"
$arResult["SHOW_MORE_BUTTON"] = ($currentPage < $totalPages);

// Вычисляем количество оставшихся элементов
$remainingItems = $totalFilteredItems - ($currentPage * $itemsPerPage);
$arResult["REMAINING_ITEMS"] = max(0, $remainingItems);
$arResult["NEXT_LOAD_COUNT"] = min($itemsPerPage, $remainingItems);

$arResult["CATEGORIES"] = $categories;
$arResult["SELECTED_TYPES"] = $selectedTypes;

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


// Отладочная информация (для обычных запросов И для AJAX)
if (isset($_GET['debug']) && $_GET['debug'] == 'Y') {
    $debugOutput = '';
    $debugOutput .= '<div style="background: #f0f0f0; padding: 15px; margin: 15px 0; font-family: monospace; font-size: 12px; border: 1px solid #ccc;">';
    $debugOutput .= '<h3>ПОДРОБНАЯ ОТЛАДКА ФИЛЬТРАЦИИ И ПАГИНАЦИИ</h3>';
    $debugOutput .= '<p><strong>Тип запроса:</strong> ' . (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y' ? 'AJAX' : 'ОБЫЧНЫЙ') . '</p>';
    $debugOutput .= '<p><strong>Query String:</strong> ' . ($_SERVER['QUERY_STRING'] ?? '') . '</p>';
    $debugOutput .= '<p><strong>Выбранные типы:</strong> [' . implode(', ', $selectedTypes) . ']</p>';
    $debugOutput .= '<p><strong>Пустые ли выбранные типы:</strong> ' . (empty($selectedTypes) ? 'ДА' : 'НЕТ') . '</p>';
    $debugOutput .= '<p><strong>Есть ли "all" в выбранных:</strong> ' . (in_array('all', $selectedTypes) ? 'ДА' : 'НЕТ') . '</p>';

    $debugOutput .= '<hr>';
    $debugOutput .= '<h4>ПАРАМЕТРЫ КОМПОНЕНТА:</h4>';
    $debugOutput .= '<p><strong>$arParams["NEWS_COUNT"]:</strong> "' . $arParams["NEWS_COUNT"] . '"</p>';
    $debugOutput .= '<p><strong>intval($arParams["NEWS_COUNT"]):</strong> ' . intval($arParams["NEWS_COUNT"]) . '</p>';
    $debugOutput .= '<p><strong>$itemsPerPage:</strong> ' . $itemsPerPage . '</p>';

    $debugOutput .= '<hr>';
    $debugOutput .= '<h4>ЭТАПЫ ФИЛЬТРАЦИИ:</h4>';
    $debugOutput .= '<p><strong>1. Общее количество элементов в инфоблоке:</strong> ' . $totalElementsCount . '</p>';
    $debugOutput .= '<p><strong>2. Элементов после фильтрации (всего):</strong> ' . $totalFilteredItems . '</p>';
    $debugOutput .= '<p><strong>3. Элементов на странице:</strong> ' . $itemsPerPage . '</p>';
    $debugOutput .= '<p><strong>4. Текущая страница:</strong> ' . $currentPage . '</p>';
    $debugOutput .= '<p><strong>5. Всего страниц:</strong> ' . $totalPages . '</p>';
    $debugOutput .= '<p><strong>6. Формула для кнопки ($currentPage < $totalPages):</strong> ' . $currentPage . ' < ' . $totalPages . ' = ' . ($currentPage < $totalPages ? 'ИСТИНА' : 'ЛОЖЬ') . '</p>';
    $debugOutput .= '<p><strong>7. Показывать кнопку "Показать еще":</strong> ' . ($arResult["SHOW_MORE_BUTTON"] ? 'ДА' : 'НЕТ') . '</p>';
    $debugOutput .= '<p><strong>8. Оставшихся элементов:</strong> ' . $arResult["REMAINING_ITEMS"] . '</p>';
    $debugOutput .= '<p><strong>9. К загрузке при следующем запросе:</strong> ' . $arResult["NEXT_LOAD_COUNT"] . '</p>';

    $debugOutput .= '<hr>';
    $debugOutput .= '<h4>ПЕРВЫЕ 10 ID ОТФИЛЬТРОВАННЫХ ЭЛЕМЕНТОВ:</h4>';
    $debugOutput .= '<p>[' . implode(', ', array_slice($filteredElementsIds, 0, 10)) . ']</p>';

    $debugOutput .= '<h4>ДОСТУПНЫЕ КАТЕГОРИИ:</h4>';
    $debugOutput .= '<ul>';
    foreach ($categories as $xmlId => $category) {
        $activeStatus = $category['ACTIVE'] ? ' (АКТИВНА)' : '';
        $debugOutput .= '<li>' . $category['NAME'] . ' (XML_ID: ' . $xmlId . ', Количество: ' . $category['COUNT'] . ')' . $activeStatus . '</li>';
    }
    $debugOutput .= '</ul>';

    $debugOutput .= '</div>';

    // Для AJAX-запросов выводим отладку в консоль браузера
    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') {
        $debugJson = array(
            'type' => 'AJAX',
            'selectedTypes' => $selectedTypes,
            'totalFilteredItems' => $totalFilteredItems,
            'itemsPerPage' => $itemsPerPage,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'showMoreButton' => $arResult["SHOW_MORE_BUTTON"],
            'remainingItems' => $arResult["REMAINING_ITEMS"],
            'filteredElementsIds' => array_slice($filteredElementsIds, 0, 10)
        );

        // Добавляем отладочный скрипт
        $debugOutput .= '<script>console.log("Отладка AJAX запроса:", ' . json_encode($debugJson) . ');</script>';
    }

    echo $debugOutput;
}
?>

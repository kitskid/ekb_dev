<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Получаем фильтр раздела из параметров компонента
$sectionFilter = $arParams["SECTION_FILTER"] ?? '';

// Сохраняем оригинальный массив элементов, если он еще не сохранен
if (!isset($arResult["ITEMS_ORIGINAL"])) {
    $arResult["ITEMS_ORIGINAL"] = $arResult["ITEMS"];
}

// Получаем текущую страницу
$currentPage = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

// Правильное получение множественных параметров tag
$selectedTags = array();

// Если есть фильтр раздела, добавляем его к выбранным тегам
if (!empty($sectionFilter)) {
    $selectedTags[] = $sectionFilter;
}

if (isset($_REQUEST['tag']) && !empty($_REQUEST['tag'])) {
    if (is_array($_REQUEST['tag'])) {
        $selectedTags = array_merge($selectedTags, $_REQUEST['tag']);
    } else {
        $selectedTags[] = $_REQUEST['tag'];
    }
}

// Сохраняем оригинальный массив элементов, если он еще не сохранен
if (!isset($arResult["ITEMS_ORIGINAL"])) {
    $arResult["ITEMS_ORIGINAL"] = $arResult["ITEMS"];
}

// Правильное получение множественных параметров tag
$selectedTags = array();

if (isset($_REQUEST['tag']) && !empty($_REQUEST['tag'])) {
    if (is_array($_REQUEST['tag'])) {
        $selectedTags = $_REQUEST['tag'];
    } else {
        $selectedTags = [$_REQUEST['tag']];
    }
}

// Парсим QUERY_STRING вручную для параметров вида tag=val1&tag=val2
if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    preg_match_all('/tag=([^&]+)/', $queryString, $matches);

    if (!empty($matches[1])) {
        $selectedTags = array_map('urldecode', $matches[1]);
    }
}

// Получаем фильтры по городу и месяцу
$selectedCity = isset($_REQUEST['city']) ? strval($_REQUEST['city']) : '';
$selectedMonth = isset($_REQUEST['month']) ? strval($_REQUEST['month']) : '';

// Удаляем пустые значения и приводим к строкам
$selectedTags = array_filter(array_map('strval', $selectedTags));
$selectedTags = array_unique($selectedTags);

// Получаем текущую страницу
$currentPage = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

// Получаем все категории, города и месяцы с использованием кеширования
$categories = array();
$cities = array();
$months = array();

$cacheId = "events_categories_cities_months_" . $arParams["IBLOCK_ID"] . "_" . md5(serialize($arParams));
$cacheTime = 3600;
$obCache = new CPHPCache;

if ($obCache->InitCache($cacheTime, $cacheId, "/events_categories/")) {
    $res = $obCache->GetVars();
    $categories = $res["categories"];
    $cities = $res["cities"];
    $months = $res["months"];
    $totalElementsCount = $res["totalCount"];
} else {
    // Загружаем ВСЕ элементы инфоблока для получения полного списка категорий
    $rsAllItems = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ACTIVE" => "Y"
        ),
        false,
        false,
        array("ID", "NAME", "IBLOCK_SECTION_ID")
    );

    $totalElementsCount = $rsAllItems->SelectedRowsCount();

    // Получаем разделы
    $sections = array();
    $rsSections = CIBlockSection::GetList(
        array('SORT' => 'ASC'),
        array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ACTIVE' => 'Y'),
        false,
        array('ID', 'NAME')
    );

    while ($arSection = $rsSections->GetNext()) {
        $sections[$arSection['ID']] = $arSection['NAME'];
    }

    // Собираем все элементы для обработки
    while ($arAllItem = $rsAllItems->GetNext()) {
        // Получаем свойство TAGS
        $rsTagsProp = CIBlockElement::GetProperty(
            $arParams["IBLOCK_ID"],
            $arAllItem["ID"],
            array("sort" => "asc"),
            array("CODE" => "TAGS")
        );

        $tagValues = array();
//        while ($prop = $rsTagsProp->Fetch()) {
//            if (!empty($prop["VALUE_ENUM"])) {
//                $tagValues[] = $prop["VALUE_ENUM"];
//            }
//        }

        // Добавляем раздел как тег
        if (!empty($arAllItem["IBLOCK_SECTION_ID"]) && isset($sections[$arAllItem["IBLOCK_SECTION_ID"]])) {
            $tagValues[] = $sections[$arAllItem["IBLOCK_SECTION_ID"]];
        }

        // Получаем город
        $rsLocationProp = CIBlockElement::GetProperty(
            $arParams["IBLOCK_ID"],
            $arAllItem["ID"],
            array("sort" => "asc"),
            array("CODE" => "LOCATION")
        );

        if ($prop = $rsLocationProp->Fetch()) {
            if (!empty($prop["VALUE"])) {
                $cities[] = $prop["VALUE"];
            }
        }

        // Создаем категории
        foreach ($tagValues as $tagValue) {
            if (!empty($tagValue)) {
                if (!isset($categories[$tagValue])) {
                    $categories[$tagValue] = array(
                        'NAME' => $tagValue,
                        'COUNT' => 1,
                        'ACTIVE' => in_array($tagValue, $selectedTags)
                    );
                } else {
                    $categories[$tagValue]['COUNT']++;
                }
            }
        }
    }

    // Убираем дубликаты городов
    $cities = array_unique($cities);
    sort($cities);

    // Генерируем список месяцев (+12 месяцев от текущего)
    $currentMonth = date('n');
    $currentYear = date('Y');

    for ($i = 0; $i < 12; $i++) {
        $month = $currentMonth + $i;
        $year = $currentYear;

        if ($month > 12) {
            $month -= 12;
            $year++;
        }

        $monthNames = array(
            1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
            5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
        );

        $months[] = array(
            'value' => sprintf('%04d-%02d', $year, $month),
            'name' => $monthNames[$month] . ' ' . $year
        );
    }

    // Сохраняем в кеш
    if ($obCache->StartDataCache()) {
        $obCache->EndDataCache(array(
            "categories" => $categories,
            "cities" => $cities,
            "months" => $months,
            "totalCount" => $totalElementsCount
        ));
    }
}

// Добавим категорию "Все"
$categories = array_merge(array('all' => array(
    'NAME' => 'Все события',
    'COUNT' => $totalElementsCount,
    'ACTIVE' => empty($selectedTags)
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
    array("ID", "IBLOCK_SECTION_ID")
);

// Получаем разделы для фильтрации
$sections = array();
$rsSections = CIBlockSection::GetList(
    array('SORT' => 'ASC'),
    array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ACTIVE' => 'Y'),
    false,
    array('ID', 'NAME')
);

while ($arSection = $rsSections->GetNext()) {
    $sections[$arSection['ID']] = $arSection['NAME'];
}

while ($arFilteredItem = $rsAllFilteredItems->GetNext()) {
    $shouldInclude = true;

    // Фильтр по городу
    if (!empty($selectedCity)) {
        $rsLocationProp = CIBlockElement::GetProperty(
            $arParams["IBLOCK_ID"],
            $arFilteredItem["ID"],
            array("sort" => "asc"),
            array("CODE" => "LOCATION")
        );

        $cityMatch = false;
        if ($prop = $rsLocationProp->Fetch()) {
            if ($prop["VALUE"] == $selectedCity) {
                $cityMatch = true;
            }
        }

        if (!$cityMatch) {
            $shouldInclude = false;
        }
    }

    // Фильтр по месяцу
    if (!empty($selectedMonth) && $shouldInclude) {
        $rsDateProp = CIBlockElement::GetProperty(
            $arParams["IBLOCK_ID"],
            $arFilteredItem["ID"],
            array("sort" => "asc"),
            array("CODE" => "DATETIME")
        );

        $monthMatch = false;
        if ($prop = $rsDateProp->Fetch()) {
            if (!empty($prop["VALUE"])) {
                $eventMonth = date('Y-m', MakeTimeStamp($prop["VALUE"]));
                if ($eventMonth == $selectedMonth) {
                    $monthMatch = true;
                }
            }
        }

        if (!$monthMatch) {
            $shouldInclude = false;
        }
    }

    // Фильтр по тегам
    if (!empty($selectedTags) && !in_array('all', $selectedTags) && $shouldInclude) {
        $rsTagsProp = CIBlockElement::GetProperty(
            $arParams["IBLOCK_ID"],
            $arFilteredItem["ID"],
            array("sort" => "asc"),
            array("CODE" => "TAGS")
        );

        $itemTags = array();
        while ($prop = $rsTagsProp->Fetch()) {
            if (!empty($prop["VALUE_ENUM"])) {
                $itemTags[] = $prop["VALUE_ENUM"];
            }
        }

        // Добавляем раздел как тег
        if (!empty($arFilteredItem["IBLOCK_SECTION_ID"]) && isset($sections[$arFilteredItem["IBLOCK_SECTION_ID"]])) {
            $itemTags[] = $sections[$arFilteredItem["IBLOCK_SECTION_ID"]];
        }

        // Проверяем пересечение (логика ИЛИ)
        $intersection = array_intersect($selectedTags, $itemTags);
        $shouldInclude = !empty($intersection);
    }

    if ($shouldInclude) {
        $filteredElementsIds[] = $arFilteredItem["ID"];
    }
}

// Получаем текущую страницу
$currentPage = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

// Вычисляем пагинацию (упрощенная версия, так как фильтрация уже по разделу)
$itemsPerPage = intval($arParams["NEWS_COUNT"]);
$totalItems = count($arResult["ITEMS"]);
$totalPages = ceil($totalItems / $itemsPerPage);

// Создаем объект навигации
$arResult["NAV_RESULT"] = new stdClass();
$arResult["NAV_RESULT"]->NavPageCount = $totalPages;
$arResult["NAV_RESULT"]->NavPageNomer = $currentPage;
$arResult["NAV_RESULT"]->NavRecordCount = $totalItems;

// Логика для кнопки "Показать еще"
$arResult["SHOW_MORE_BUTTON"] = ($currentPage < $totalPages);

// Вычисляем количество оставшихся элементов
$remainingItems = $totalItems - ($currentPage * $itemsPerPage);
$arResult["REMAINING_ITEMS"] = max(0, $remainingItems);
$arResult["NEXT_LOAD_COUNT"] = min($itemsPerPage, $remainingItems);

// Уникальный идентификатор для AJAX
$arResult["AJAX_ID"] = $this->randString();

?>
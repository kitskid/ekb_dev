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

    // Заменяем элементы отфильтрованными
    if (!empty($filteredItems)) {
        $arResult["ITEMS"] = $filteredItems;
    }
}

// Дополнительно убираем возможные дубликаты по ID
$uniqueItems = [];
$uniqueIds = [];
foreach ($arResult["ITEMS"] as $item) {
    if (!in_array($item['ID'], $uniqueIds)) {
        $uniqueIds[] = $item['ID'];
        $uniqueItems[] = $item;
    }
}
$arResult["ITEMS"] = $uniqueItems;
?>

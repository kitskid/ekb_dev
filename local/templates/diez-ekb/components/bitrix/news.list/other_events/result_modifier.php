<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Получаем разделы с активными элементами с кэшированием
$cacheId = "other_events_sections_" . md5(serialize($arParams));
$cacheTime = 3600; // 1 час
$obCache = new CPHPCache;

if ($obCache->InitCache($cacheTime, $cacheId, "/other_events_sections/")) {
    $res = $obCache->GetVars();
    $arResult["SECTIONS_WITH_EVENTS"] = $res["sectionsWithEvents"];
} else {
    $sectionsWithEvents = array();

    // Получаем все элементы инфоблока для подсчета активных
    $rsAllItems = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array(
            "IBLOCK_ID" => 23,
            "ACTIVE" => "Y"
        ),
        false,
        false,
        array("ID", "IBLOCK_SECTION_ID")
    );

    $sectionCounts = array();
    while ($arAllItem = $rsAllItems->GetNext()) {
        if (!empty($arAllItem["IBLOCK_SECTION_ID"])) {
            if (!isset($sectionCounts[$arAllItem["IBLOCK_SECTION_ID"]])) {
                $sectionCounts[$arAllItem["IBLOCK_SECTION_ID"]] = 0;
            }
            $sectionCounts[$arAllItem["IBLOCK_SECTION_ID"]]++;
        }
    }

    // Получаем данные разделов
    if (!empty($sectionCounts)) {
        $rsSections = CIBlockSection::GetList(
            array('SORT' => 'ASC'),
            array(
                'IBLOCK_ID' => 23,
                'ACTIVE' => 'Y',
                'ID' => array_keys($sectionCounts)
            ),
            false,
            array('ID', 'NAME', 'CODE')
        );

        while ($arSection = $rsSections->GetNext()) {
            $sectionsWithEvents[$arSection['ID']] = array(
                'ID' => $arSection['ID'],
                'NAME' => $arSection['NAME'],
                'CODE' => $arSection['CODE'],
                'COUNT' => $sectionCounts[$arSection['ID']]
            );
        }

        // Сортируем по количеству элементов
        uasort($sectionsWithEvents, function($a, $b) {
            if ($a['COUNT'] != $b['COUNT']) {
                return $b['COUNT'] - $a['COUNT'];
            }
            return strcmp($a['NAME'], $b['NAME']);
        });
    }

    $arResult["SECTIONS_WITH_EVENTS"] = $sectionsWithEvents;

    // Сохраняем в кеш
    if ($obCache->StartDataCache()) {
        $obCache->EndDataCache(array(
            "sectionsWithEvents" => $sectionsWithEvents
        ));
    }
}
?>

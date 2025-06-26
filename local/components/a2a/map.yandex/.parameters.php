<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    "GROUPS" => array(
        "MAP_SETTINGS" => array(
            "NAME" => "Настройки карты",
        ),
    ),
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => "Тип инфоблока",
            "TYPE" => "LIST",
            "VALUES" => CIBlockParameters::GetIBlockTypes(),
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока",
            "TYPE" => "LIST",
            "VALUES" => CIBlockParameters::GetIBlockList($arCurrentValues["IBLOCK_TYPE"]),
            "REFRESH" => "Y",
        ),
        "MAP_HEIGHT" => array(
            "PARENT" => "MAP_SETTINGS",
            "NAME" => "Высота карты",
            "TYPE" => "STRING",
            "DEFAULT" => "500px",
        ),
        "MAP_WIDTH" => array(
            "PARENT" => "MAP_SETTINGS",
            "NAME" => "Ширина карты",
            "TYPE" => "STRING",
            "DEFAULT" => "100%",
        ),
        "INIT_MAP_TYPE" => array(
            "PARENT" => "MAP_SETTINGS",
            "NAME" => "Тип карты по умолчанию",
            "TYPE" => "LIST",
            "VALUES" => array(
                "MAP" => "Схема",
                "SATELLITE" => "Спутник",
                "HYBRID" => "Гибрид",
            ),
            "DEFAULT" => "MAP",
        ),
        "MAP_DATA" => array(
            "PARENT" => "MAP_SETTINGS",
            "NAME" => "Формат хранения координат",
            "TYPE" => "LIST",
            "VALUES" => array(
                "COORDINATES" => "Одно свойство (широта,долгота)",
                "COORDS_SEPARATE" => "Отдельные свойства (широта и долгота)",
            ),
            "DEFAULT" => "COORDINATES",
        ),
        "PROPERTY_CODE" => CIBlockParameters::GetReferenceProperty(
            $arCurrentValues['IBLOCK_ID'],
            "content",
            array("SORT" => "ASC")
        ),
        "FILTER_NAME" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => "Имя массива со значениями фильтра",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "CACHE_TIME" => array("DEFAULT" => 36000000),
    ),
);
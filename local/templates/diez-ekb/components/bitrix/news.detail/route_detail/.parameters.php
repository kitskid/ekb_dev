<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "DISPLAY_MAP" => array(
        "NAME" => "Показывать карту маршрута",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "DISPLAY_POINTS" => array(
        "NAME" => "Показывать точки маршрута",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "DISPLAY_GALLERY" => array(
        "NAME" => "Показывать галерею маршрута",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "DISPLAY_RELATED" => array(
        "NAME" => "Показывать другие маршруты",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "MAP_HEIGHT" => array(
        "NAME" => "Высота карты (px)",
        "TYPE" => "STRING",
        "DEFAULT" => "500",
    ),
    "RELATED_ROUTES_COUNT" => array(
        "NAME" => "Количество других маршрутов",
        "TYPE" => "STRING",
        "DEFAULT" => "3",
    ),
    "YANDEX_MAP_API_KEY" => array(
        "NAME" => "API-ключ Яндекс.Карт",
        "TYPE" => "STRING",
        "DEFAULT" => "eadd6c34-2108-42a5-9a53-b9afc638fadb",
    ),
);

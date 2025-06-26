<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => "Яндекс.Карта с объектами",
    "DESCRIPTION" => "Компонент для отображения карты с маркерами из инфоблока",
    "ICON" => "/images/map_yandex.gif",
    "CACHE_PATH" => "Y",
    "SORT" => 10,
    "PATH" => array(
        "ID" => "custom",
        "NAME" => "Пользовательские компоненты",
        "CHILD" => array(
            "ID" => "maps",
            "NAME" => "Карты",
            "SORT" => 10
        )
    ),
);
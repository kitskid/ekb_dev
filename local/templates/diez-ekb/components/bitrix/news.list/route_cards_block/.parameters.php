<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "TITLE" => array(
        "NAME" => "Заголовок блока",
        "TYPE" => "STRING",
        "DEFAULT" => "ВЫБЕРИ СВОЙ МАРШРУТ",
    ),
    "DISPLAY_ROUTE_TYPE" => array(
        "NAME" => "Показывать тип маршрута",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "DISPLAY_ROUTE_DURATION" => array(
        "NAME" => "Показывать продолжительность",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "DISPLAY_ROUTE_DISTANCE" => array(
        "NAME" => "Показывать расстояние",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    )
);
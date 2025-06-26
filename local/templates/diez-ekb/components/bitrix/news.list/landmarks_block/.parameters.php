<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "TITLE" => array(
        "NAME" => "Заголовок блока",
        "TYPE" => "STRING",
        "DEFAULT" => "ДОСТОПРИМЕЧАТЕЛЬНОСТИ",
    ),
    "DISPLAY_RATING" => array(
        "NAME" => "Показывать рейтинг",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    )
);
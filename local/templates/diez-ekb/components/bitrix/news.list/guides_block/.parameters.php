<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "TITLE" => array(
        "NAME" => "Заголовок блока",
        "TYPE" => "STRING",
        "DEFAULT" => "ВАШ ГИД ПО ЕКАТЕРИНБУРГУ",
    ),
    "DISPLAY_CONTACTS" => array(
        "NAME" => "Показывать контактную информацию",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    )
);
<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => GetMessage("MULTI_MENU_COMPONENT_NAME"),
    "DESCRIPTION" => GetMessage("MULTI_MENU_COMPONENT_DESCRIPTION"),
    "ICON" => "/images/menu.gif",
    "SORT" => 20,
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID" => "custom_components",
        "NAME" => GetMessage("CUSTOM_COMPONENTS_GROUP_NAME"),
    ),
);
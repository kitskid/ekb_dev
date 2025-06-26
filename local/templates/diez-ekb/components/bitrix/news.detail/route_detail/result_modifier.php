<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Исключаем текущий маршрут из списка "Выбери свой маршрут"
$GLOBALS["otherRoutesFilter"] = array(
    "!ID" => $arResult["ID"]
);
?>
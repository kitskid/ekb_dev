<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Для поддержки старого формата компонентов
$componentPath = __DIR__;
include __DIR__ . '/class.php';

// Создаем экземпляр компонента
$component = new CustomYandexMapComponent;

// Передаем управление компоненту
$component->arParams = $arParams;
$component->arResult = $arResult;
$component->start();
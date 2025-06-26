<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Подключаем скрипты и стили компонента
\Bitrix\Main\Page\Asset::getInstance()->addJs($templateFolder. '/script.js');
\Bitrix\Main\Page\Asset::getInstance()->addCss($templateFolder. '/style.css');
?>
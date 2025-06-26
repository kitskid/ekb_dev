<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// Подключаем API Яндекс.Карт
\Bitrix\Main\Page\Asset::getInstance()->addJs('https://api-maps.yandex.ru/2.1/?apikey=eadd6c34-2108-42a5-9a53-b9afc638fadb&lang=ru_RU');

// Подключаем скрипты и стили компонента
\Bitrix\Main\Page\Asset::getInstance()->addJs($templateFolder.'/script.js');
\Bitrix\Main\Page\Asset::getInstance()->addCss($templateFolder.'/style.css');

// Добавляем инлайн-стили для исправления проблем с отображением карты
?>
<style>
    /* Исправления для Яндекс.Карт */
    .ymaps-2-1-79-map,
    .ymaps-2-1-79-container,
    .ymaps-2-1-79-map-bg,
    .ymaps-2-1-79-ground-pane,
    .ymaps-2-1-79-copyrights-pane,
    .ymaps-2-1-79-controls-pane {
        width: 100% !important;
        height: 100% !important;
        left: 0 !important;
        top: 0 !important;
    }

    .map-container {
        z-index: 1; /* Убеждаемся что контейнер имеет правильный z-index */
    }
</style>
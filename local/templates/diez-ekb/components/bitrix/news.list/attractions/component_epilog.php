<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Регистрируем JS для работы с Яндекс.Картой
\Bitrix\Main\Page\Asset::getInstance()->addJs('/local/templates/diez-ekb/js/yandex.map.js');

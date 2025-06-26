<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */

use Bitrix\Main\Page\Asset;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">   
    <title><?$APPLICATION->ShowTitle();?></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    

    <?php $APPLICATION->ShowHead(); ?>
    <?php
    Asset::getInstance()->addCss("/local/templates/diez-ekb/css/main.css");
    Asset::getInstance()->addJs("/local/templates/diez-ekb/js/bundle.js");
    //  Панель редактирования Битрикс
    $APPLICATION->ShowPanel();?>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
</head>
<body class="theme-light">
<!-- Шапка сайта -->
<header class="header">
    <div class="container">
        <div class="header__wrapper">
            <a href="/" class="logo">
                <img src="/local/templates/diez-ekb/assets/images/logo.svg" alt="logo">
                <img src="/local/templates/diez-ekb/assets/images/logo-black.svg" hidden alt="logo">
            </a>
            <?php
            $APPLICATION->IncludeComponent(
                "a2a:multi_menu",
                "diez-ekb",
                array(
                    "MENU_TYPE" => "top", // Тип меню
                    "ROOT_MENU_TYPE" => "top", // Тип корневого меню
                    "MAX_LEVEL" => "2", // Максимальная вложенность
                    "USE_EXT" => "Y", // Использовать файлы .menu-ext.php
                    "ALLOW_MULTI_SELECT" => "N", // Разрешить несколько активных пунктов
                    "SPRITE_PATH" => "/local/templates/diez-ekb/assets/sprite.svg", // Путь к SVG-спрайту
                    "CACHE_TYPE" => "A", // Тип кеширования
                    "CACHE_TIME" => "3600" // Время кеширования (сек.)
                ),
                false
            );
            ?>

            <div class="header-control">
                <div class="header-control__button">
                    <svg class="icon">
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-search"></use>
                    </svg>
                </div>
                <div class="header-control__button">
                    <svg class="icon">
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-eye"></use>
                    </svg>
                </div>
                <div class="burger">
                    <div class="burger__item"></div>
                </div>
            </div>
        </div>
    </div>
</header>

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?$APPLICATION->ShowTitle();?></title>

    <?php $APPLICATION->ShowHead(); ?>

    <!-- Подключение стилей Битрикс -->
    <?php
    Asset::getInstance()->addCss("/bitrix/css/main/bootstrap.min.css");
    Asset::getInstance()->addCss("/bitrix/css/main/font-awesome.min.css");

    // Подключение слайдера Swiper
    Asset::getInstance()->addCss("https://unpkg.com/swiper/swiper-bundle.min.css");

    // Пользовательские стили
    Asset::getInstance()->addCss("/local/templates/diez-ekb/css/main_new.css");
    ?>

    <!-- Панель редактирования Битрикс -->
    <?$APPLICATION->ShowPanel();?>
</head>
<body>
<!-- Шапка сайта -->
<header class="header">
    <div class="container">
        <div class="header-content">
            <a href="/" class="logo">ЕКАТЕРИНБУРГ</a>

            <!-- Основное меню для десктопов -->
            <nav class="main-nav">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "main_menu",
                    Array(
                        "ROOT_MENU_TYPE" => "top",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "",
                        "USE_EXT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => Array()
                    )
                );
                ?>
                <!-- Временная структура меню -->
                <ul>
                    <li><a href="/">Главная</a></li>
                    <li><a href="/about/">О городе</a></li>
                    <li><a href="/guests/">Гостям</a></li>
                    <li><a href="/afisha/">Афиша</a></li>
                    <li><a href="/news/">Новости</a></li>
                    <li><a href="/contacts/">Контакты</a></li>
                </ul>
            </nav>

            <!-- Кнопка мобильного меню -->
            <button class="burger-menu" id="burger-menu">
                <i class="fa fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<!-- Мобильное меню -->
<div class="mobile-nav" id="mobile-nav">
    <button class="close-menu" id="close-menu">
        <i class="fa fa-times"></i>
    </button>
    <nav>
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "mobile_menu",
            Array(
                "ROOT_MENU_TYPE" => "top",
                "MAX_LEVEL" => "1",
                "CHILD_MENU_TYPE" => "",
                "USE_EXT" => "N",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => Array()
            )
        );
        ?>
        <!-- Временная структура меню -->
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="/about/">О городе</a></li>
            <li><a href="/guests/">Гостям</a></li>
            <li><a href="/afisha/">Афиша</a></li>
            <li><a href="/news/">Новости</a></li>
            <li><a href="/contacts/">Контакты</a></li>
        </ul>
    </nav>
</div>

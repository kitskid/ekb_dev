<?php
/**
 * Файл контента секции "Год Уральского Юга 2024"
 * Используется в include компоненте на главной странице
 *
 * @var $APPLICATION CMain
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="ural-year-content">
    <p class="ural-year-description">
        Узнайте о специальных мероприятиях, посвященных году южных регионов Урала!
    </p>
</div>

<style>
    .ural-year-content {
        text-align: center;
        padding: 0 15px;
    }

    .ural-year-description {
        font-size: 1.1rem;
        line-height: 1.6;
        margin: 1rem 0 2rem;
        color: #fff;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    @media (max-width: 767.98px) {
        .ural-year-description {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
    }
</style>
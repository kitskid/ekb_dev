<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="faq-list">
    <?php foreach($arResult["ITEMS"] as $key => $arItem): ?>
        <?php
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        // Получаем ответ из свойства или текста анонса
        $answer = !empty($arItem["PROPERTIES"]["ANSWER"]["VALUE"])
            ? $arItem["PROPERTIES"]["ANSWER"]["~VALUE"]["TEXT"]
            : $arItem["PREVIEW_TEXT"];

        $questionNumber = $key + 1;
        ?>

        <div class="faq-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="faq-question">
                <span class="faq-question-number">№<?=$questionNumber?></span>
                <span class="faq-question-text"><?=$arItem["NAME"]?></span>
                <span class="faq-question-icon"></span>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-content">
                    <?=$answer?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
    /* Стили для FAQ */
    .faq-list {
        margin-top: 30px;
    }

    .faq-item {
        margin-bottom: 15px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .faq-question {
        padding: 20px;
        font-weight: 600;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        position: relative;
        transition: background-color 0.3s ease;
    }

    .faq-question:hover {
        background-color: #f9f9f9;
    }

    .faq-question-number {
        color: #008CD2;
        margin-right: 15px;
        font-weight: bold;
        min-width: 30px;
    }

    .faq-question-text {
        flex-grow: 1;
        padding-right: 30px;
    }

    .faq-question-icon {
        position: absolute;
        right: 20px;
        width: 16px;
        height: 16px;
    }

    .faq-question-icon:before,
    .faq-question-icon:after {
        content: '';
        position: absolute;
        background-color: #008CD2;
        transition: transform 0.3s ease;
    }

    .faq-question-icon:before {
        top: 7px;
        left: 0;
        width: 16px;
        height: 2px;
    }

    .faq-question-icon:after {
        top: 0;
        left: 7px;
        width: 2px;
        height: 16px;
    }

    .faq-item.active .faq-question-icon:after {
        transform: rotate(90deg);
    }

    .faq-answer {
        display: none;
        padding: 0 20px 20px 65px;
        line-height: 1.6;
        color: #555;
    }

    .faq-item.active .faq-answer {
        display: block;
    }

    /* Мобильные стили */
    @media (max-width: 768px) {
        .faq-question {
            padding: 15px;
            font-size: 16px;
        }

        .faq-question-number {
            margin-right: 10px;
            min-width: 25px;
        }

        .faq-answer {
            padding: 0 15px 15px 50px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Находим все элементы FAQ
        const faqItems = document.querySelectorAll('.faq-item');

        // Функция для обработки кликов по вопросам
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');

            question.addEventListener('click', function() {
                // Проверяем, активен ли текущий вопрос
                const isActive = item.classList.contains('active');

                // Закрываем все элементы
                faqItems.forEach(faqItem => {
                    faqItem.classList.remove('active');
                });

                // Если текущий вопрос не был активен, открываем его
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });

        // Открываем первый вопрос по умолчанию
        if (faqItems.length > 0) {
            faqItems[0].classList.add('active');
        }
    });
</script>

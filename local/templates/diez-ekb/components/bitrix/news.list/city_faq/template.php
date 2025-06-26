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

if (empty($arResult["ITEMS"])) {
    return;
}
?>

<div class="container">
    <div class="header-block">
        <h2 class="title">
            пять вопросов про
            екатеринбург
        </h2>
    </div>
    <div class="faq">
        <?php foreach($arResult["ITEMS"] as $key => $arItem): ?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

            // Получаем вопрос из названия элемента
            $question = $arItem["NAME"];

            // Получаем ответ из текста анонса (неэкранированная версия для HTML)
            $answer = $arItem["~PREVIEW_TEXT"];
            ?>
            <div class="faq__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="faq__header">
                    <h3 class="faq__title"><?=htmlspecialchars($question)?></h3>
                    <svg>
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-polygon-arrow"></use>
                    </svg>
                </div>
                <div class="faq__content">
                    <p class="faq__text text text--gray">
                        <?=$answer?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!--<script>-->
<!--    document.addEventListener('DOMContentLoaded', function() {-->
<!--        // Находим все элементы FAQ-->
<!--        const faqItems = document.querySelectorAll('.faq__item');-->
<!---->
<!--        // Функция для обработки кликов по заголовкам-->
<!--        faqItems.forEach(item => {-->
<!--            const header = item.querySelector('.faq__header');-->
<!--            const content = item.querySelector('.faq__content');-->
<!--            const arrow = item.querySelector('.faq__header svg');-->
<!---->
<!--            header.addEventListener('click', function() {-->
<!--                // Проверяем, открыт ли текущий элемент-->
<!--                const isOpen = item.classList.contains('faq__item--open');-->
<!---->
<!--                // Закрываем все элементы-->
<!--                faqItems.forEach(faqItem => {-->
<!--                    faqItem.classList.remove('faq__item--open');-->
<!--                    const faqContent = faqItem.querySelector('.faq__content');-->
<!--                    const faqArrow = faqItem.querySelector('.faq__header svg');-->
<!--                    if (faqContent) {-->
<!--                        faqContent.style.display = 'none';-->
<!--                    }-->
<!--                    if (faqArrow) {-->
<!--                        faqArrow.style.transform = 'rotate(0deg)';-->
<!--                    }-->
<!--                });-->
<!---->
<!--                // Если текущий элемент не был открыт, открываем его-->
<!--                if (!isOpen) {-->
<!--                    item.classList.add('faq__item--open');-->
<!--                    content.style.display = 'block';-->
<!--                    arrow.style.transform = 'rotate(180deg)';-->
<!--                }-->
<!--            });-->
<!---->
<!--            // Изначально скрываем все ответы-->
<!--            content.style.display = 'none';-->
<!--        });-->
<!---->
<!--        // Открываем первый элемент по умолчанию-->
<!--        if (faqItems.length > 0) {-->
<!--            const firstItem = faqItems[0];-->
<!--            const firstContent = firstItem.querySelector('.faq__content');-->
<!--            const firstArrow = firstItem.querySelector('.faq__header svg');-->
<!---->
<!--            firstItem.classList.add('faq__item--open');-->
<!--            firstContent.style.display = 'block';-->
<!--            firstArrow.style.transform = 'rotate(180deg)';-->
<!--        }-->
<!--    });-->
<!--</script>-->

<!--<style>-->
<!--    /* Дополнительные стили для анимации FAQ */-->
<!--    .faq__header {-->
<!--        cursor: pointer;-->
<!--        transition: all 0.3s ease;-->
<!--    }-->
<!---->
<!--    .faq__header:hover {-->
<!--        opacity: 0.8;-->
<!--    }-->
<!---->
<!--    .faq__header svg {-->
<!--        transition: transform 0.3s ease;-->
<!--    }-->
<!---->
<!--    .faq__content {-->
<!--        overflow: hidden;-->
<!--        transition: all 0.3s ease;-->
<!--    }-->
<!---->
<!--    .faq__item--open .faq__content {-->
<!--        animation: fadeIn 0.3s ease;-->
<!--    }-->
<!---->
<!--    @keyframes fadeIn {-->
<!--        from {-->
<!--            opacity: 0;-->
<!--            transform: translateY(-10px);-->
<!--        }-->
<!--        to {-->
<!--            opacity: 1;-->
<!--            transform: translateY(0);-->
<!--        }-->
<!--    }-->
<!--</style>-->

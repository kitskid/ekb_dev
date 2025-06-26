<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<nav class="nav">
    <ul class="nav__list">
        <?php
        $previousLevel = 0;
        foreach ($arResult as $item): ?>
            <?php var_dump($item["DEPTH_LEVEL"]); ?>
            <?php var_dump($item["IS_PAREN"]); ?>
            <?php if ($previousLevel && $item["DEPTH_LEVEL"] < $previousLevel): ?>
                <?= str_repeat("</ul></li>", ($previousLevel - $item["DEPTH_LEVEL"])) ?>
            <?php endif; ?>

            <?php if ($item["IS_PARENT"]): ?>
                <li class="nav__item">
                    <a href="<?= $item["LINK"] ?>" class="nav__link">
                        <span><?= $item["TEXT"] ?></span>
                        <svg class="nav__icon">
                            <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                        </svg>
                    </a>
                    <ul class="nav__submenu">
            <?php else: ?>
                <li class="nav__item">
                    <a href="<?= $item["LINK"] ?>" class="nav__link"><?= $item["TEXT"] ?></a>
                </li>
            <?php endif; ?>

            <?php $previousLevel = $item["DEPTH_LEVEL"]; ?>
        <?php endforeach; ?>

        <?php if ($previousLevel > 1): ?>
            <?= str_repeat("</ul></li>", ($previousLevel - 1)) ?>
        <?php endif; ?>
    </ul>
</nav>

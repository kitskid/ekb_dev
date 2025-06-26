<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

// Вывод отладочной информации (только для администраторов)
global $USER;
if ($USER->IsAdmin() && isset($_GET["debug_menu"]) && $_GET["debug_menu"] === "Y" && !empty($arResult["DEBUG_FILES"])):
    ?>
    <div style="background:#f8f9fa; padding:15px; margin:15px 0; border:1px solid #ddd; font-family:monospace;">
        <h4>Отладка меню</h4>
        <p>Проверка файлов подменю:</p>
        <ul>
            <?php foreach ($arResult["DEBUG_FILES"] as $debugFile): ?>
                <li>
                    Пункт меню: <b><?= $debugFile["MENU_ITEM"] ?></b> (ID: <?= $debugFile["MENU_ITEM_ID"] ?>)<br>
                    Тип подменю: <b><?= $debugFile["CHILD_MENU_TYPE"] ?></b><br>
                    Файл: <b><?= $debugFile["FILE_PATH"] ?></b><br>
                    Существует: <b><?= file_exists($debugFile["FILE_PATH"]) ? "Да" : "Нет" ?></b>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (!empty($arResult["ITEMS"])) : ?>
    <nav class="nav">
        <ul class="nav__list">
            <?php foreach ($arResult["ITEMS"] as $item) : ?>
                <?php if ($item["PERMISSION"] > "D") : ?>
                    <li class="nav__item<?= $item["SELECTED"] ? ' nav__item--active' : '' ?>">
                        <a href="<?= $item["LINK"] ?>" class="nav__link">
                            <span><?= $item["TEXT"] ?></span>
                            <?php if ($item["IS_PARENT"] && !empty($item["CHILDREN"])) : ?>
                                <svg class="nav__icon">
                                    <use xlink:href="<?= $arParams["SPRITE_PATH"] ?>#icon-arrow-down"></use>
                                </svg>
                            <?php endif; ?>
                        </a>
                        <?php if ($item["IS_PARENT"] && !empty($item["CHILDREN"])) : ?>
                            <ul class="nav__submenu">
                                <?php foreach ($item["CHILDREN"] as $childItem) : ?>
                                    <?php if ($childItem["PERMISSION"] > "D") : ?>
                                        <li class="nav__item">
                                            <a href="<?= $childItem["LINK"] ?>" class="nav__link<?= $childItem["SELECTED"] ? ' nav__link--active' : '' ?>">
                                                <?= $childItem["TEXT"] ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </nav>
<?php endif; ?>

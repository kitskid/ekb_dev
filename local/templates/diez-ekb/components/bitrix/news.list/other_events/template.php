<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php if (!empty($arResult["ITEMS"])): ?>
<!--    --><?php
//    // Получаем все разделы для тегов
//    $sections = array();
//    $rsSections = CIBlockSection::GetList(
//        array('SORT' => 'ASC'),
//        array('IBLOCK_ID' => 23, 'ACTIVE' => 'Y'),
//        false,
//        array('ID', 'NAME', 'CODE')
//    );
//    while ($arSection = $rsSections->GetNext()) {
//        $sections[$arSection['ID']] = $arSection;
//    }
//    ?>

    <div class="grid">
        <div class="grid__item grid__item--5 grid__item-mob--4">
            <div class="poster">
                <div class="poster__info">
                    <h2 class="title">Афиша</h2>
                    <p class="text">
                        В год 300-летия Екатеринбург с особым размахом проведёт полюбившиеся многим и известные на
                        весь мир флагманские мероприятия города, а также новые уникальные события.
                    </p>
                    <a href="/afisha/" class="button mob-hidden">
                        <span>Все события</span>
                        <span class="button__icon">
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                            </svg>
                        </span>
                    </a>
                </div>
                <div class="tags">
                    <?php foreach($arResult["SECTIONS_WITH_EVENTS"] as $section): ?>
                        <a href="/afisha/?tag=<?= urlencode($section['NAME']) ?>" class="tag">
                            <?= htmlspecialchars($section['NAME']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="grid__item grid__item--7 grid__item-mob--4">
            <div class="slider slider--auto slider--visible" data-slider="poster">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php foreach($arResult["ITEMS"] as $arItem): ?>
                            <?php
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                            $title = $arItem["~NAME"];
                            $detailUrl = !empty($arItem["DETAIL_PAGE_URL"]) ? $arItem["DETAIL_PAGE_URL"] : "#";

                            // Получаем картинку
                            $imgSrc = "/local/templates/diez-ekb/assets/images/no-image.jpg";
                            if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
                                $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
                            }

                            // Получаем дату события
                            $eventDate = "";
                            $eventDateTime = "";
                            if (!empty($arItem["PROPERTIES"]["DATETIME"]["VALUE"])) {
                                $eventDate = FormatDate("d.m.Y", MakeTimeStamp($arItem["PROPERTIES"]["DATETIME"]["VALUE"]));
                                $eventDateTime = date("Y.m.d", MakeTimeStamp($arItem["PROPERTIES"]["DATETIME"]["VALUE"]));
                            }

                            // Получаем тип события и цвет
                            $eventType = "";
                            $colorClass = "article-news--yellow"; // по умолчанию

                            if (!empty($arItem["IBLOCK_SECTION_ID"]) && isset($sections[$arItem["IBLOCK_SECTION_ID"]])) {
                                $eventType = $sections[$arItem["IBLOCK_SECTION_ID"]]["NAME"];
                            }

                            // Цветовые схемы по типам
                            $colorSchemes = array(
                                "Концерты" => "article-news--yellow",
                                "Фестивали" => "article-news--green",
                                "Выставки" => "article-news--blue",
                                "Спектакли" => "article-news--purple",
                                "Спорт" => "article-news--red",
                                "Концерт" => "article-news--yellow",
                                "Фестиваль" => "article-news--green",
                                "Выставка" => "article-news--blue",
                                "Спектакль" => "article-news--purple",
                            );

                            if (isset($colorSchemes[$eventType])) {
                                $colorClass = $colorSchemes[$eventType];
                            }

                            // Проверяем топовость
                            $isTop = false;
                            $checkTopWords = array("топ", "популярный", "рекомендуем", "хит");
                            $searchText = mb_strtolower($title . " " . ($eventType ? $eventType : ""));
                            foreach ($checkTopWords as $word) {
                                if (strpos($searchText, $word) !== false) {
                                    $isTop = true;
                                    break;
                                }
                            }
                            ?>
                            <div class="swiper-slide">
                                <a href="<?=$detailUrl?>"
                                   class="article-news <?=$colorClass?>"
                                   id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                    <span class="article-news__badges">
                                        <?php if ($isTop): ?>
                                            <span class="badge">топ!</span>
                                        <?php endif; ?>
                                    </span>
                                    <picture class="article-news__picture">
                                        <img src="<?=$imgSrc?>" alt="<?=htmlspecialchars($title)?>">
                                    </picture>
                                    <div class="article-news__info">
                                        <div class="article-news__header">
                                            <?php if ($eventType): ?>
                                                <!-- Тег события тоже ведет на афишу с фильтром -->
                                                <a href="/afisha/?tag=<?= urlencode($eventType) ?>"
                                                   class="article-news__tag article-news__tag--link"
                                                   onclick="event.stopPropagation();"
                                                   title="Все события в категории <?=htmlspecialchars($eventType)?>">
                                                    <?=htmlspecialchars($eventType)?>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($eventDate): ?>
                                                <time class="article-news__time" datetime="<?=$eventDateTime?>"><?=$eventDate?></time>
                                            <?php endif; ?>
                                        </div>
                                        <h2 class="article-news__title">
                                            <?=htmlspecialchars($title)?>
                                        </h2>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="swiper-control swiper-control--end">
                        <button class="swiper-btn swiper-btn--prev">
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                            </svg>
                        </button>
                        <button class="swiper-btn swiper-btn--next">
                            <svg>
                                <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-right"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid__item grid__item-mob--4 desktop-hidden">
            <a href="/afisha/" class="button button--mob-wide">
                <span>Все события</span>
                <span class="button__icon">
                    <svg>
                        <use xlink:href="/local/templates/diez-ekb/assets/sprite.svg#icon-arrow-down"></use>
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <style>
        .article-news__tag--link {
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            position: relative;
        }

        .article-news__tag--link:hover {
            opacity: 0.8;
            transform: translateY(-1px);
        }

        .article-news__tag--link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 1px;
            background: currentColor;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .article-news__tag--link:hover::after {
            opacity: 0.5;
        }

        .tags .tag {
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .tags .tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
    </style>
<?php endif; ?>

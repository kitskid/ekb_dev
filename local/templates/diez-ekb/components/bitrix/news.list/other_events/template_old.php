<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php if (!empty($arResult["ITEMS"])): ?>
    <div class="other-events">
        <div class="header-block mb-40 mbm-30">
            <h2 class="title">Другие события</h2>
            <p class="subtitle">
                В год 300-летия Екатеринбург с особым размахом<br>
                проведёт полюбившиеся многим и известные на<br>
                весь мир флагманские мероприятия города, а также<br>
                новые уникальные события.
            </p>
        </div>

        <div class="grid">
            <?php foreach($arResult["ITEMS"] as $arItem): ?>
                <?php
                // ... код остается тот же до получения кода раздела ...

                // Получаем код раздела для ссылки на категорию
                $sectionCode = "";
                $sectionName = "";
                if (!empty($arItem["IBLOCK_SECTION_ID"])) {
                    $rsSection = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"]);
                    if ($arSection = $rsSection->GetNext()) {
                        $sectionCode = $arSection["CODE"];
                        $sectionName = $arSection["NAME"];
                    }
                }
                ?>
                <a href="<?=$detailUrl?>"
                   class="article-news grid__item--4 grid__item-mob--4 <?=$colorClass?>"
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
                            <?php if ($sectionName && $sectionCode): ?>
                                <a href="/afisha/<?=$sectionCode?>/"
                                   class="article-news__tag article-news__tag--link"
                                   onclick="event.stopPropagation();"
                                   title="Все события в категории <?=htmlspecialchars($sectionName)?>">
                                    <?=htmlspecialchars($sectionName)?>
                                </a>
                            <?php elseif ($sectionName): ?>
                                <p class="article-news__tag"><?=htmlspecialchars($sectionName)?></p>
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
            <?php endforeach; ?>
        </div>

        <!-- Кнопка "Все события" -->
        <div class="other-events__footer">
            <a href="/afisha/" class="button">
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
        .other-events__footer {
            text-align: center;
            margin-top: 40px;
        }

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

        @media (max-width: 768px) {
            .other-events__footer {
                margin-top: 30px;
            }
        }
    </style>
<?php endif; ?>
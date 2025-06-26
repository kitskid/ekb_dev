<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule("iblock")) {
    die("Модуль инфоблоков не подключен");
}

$page = intval($_REQUEST['page'] ?? 1);
$itemsPerPage = 6;

// Получаем фильтры
$cityFilter = $_REQUEST['city'] ?? '';
$monthFilter = $_REQUEST['month'] ?? '';
$tagFilters = $_REQUEST['tag'] ?? array();

if (!is_array($tagFilters)) {
    $tagFilters = array($tagFilters);
}

// Формируем фильтр для элементов
$arFilter = array(
    'IBLOCK_ID' => 23,
    'ACTIVE' => 'Y'
);

// Фильтр по городу
if (!empty($cityFilter)) {
    $arFilter['PROPERTY_LOCATION'] = $cityFilter;
}

// Фильтр по месяцу
if (!empty($monthFilter)) {
    $arFilter['>=PROPERTY_DATETIME'] = $monthFilter . '-01 00:00:00';
    $arFilter['<PROPERTY_DATETIME'] = date('Y-m-t 23:59:59', strtotime($monthFilter . '-01'));
}

// Получаем элементы с учетом фильтров по тегам
$arSelect = array('ID', 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID');
$arNavParams = array(
    'nPageSize' => $itemsPerPage,
    'iNumPage' => $page,
    'bShowAll' => false
);

$rsElements = CIBlockElement::GetList(
    array('PROPERTY_DATETIME' => 'ASC', 'ID' => 'DESC'),
    $arFilter,
    false,
    $arNavParams,
    $arSelect
);

$arItems = array();
while ($arElement = $rsElements->GetNext()) {
    // Получаем свойства элемента
    $rsProps = CIBlockElement::GetProperty(23, $arElement['ID']);
    $arElement['PROPERTIES'] = array();

    while ($arProp = $rsProps->Fetch()) {
        if (!isset($arElement['PROPERTIES'][$arProp['CODE']])) {
            $arElement['PROPERTIES'][$arProp['CODE']] = array('VALUE' => array());
        }
        if (!empty($arProp['VALUE'])) {
            $arElement['PROPERTIES'][$arProp['CODE']]['VALUE'][] = $arProp['VALUE'];
        }
    }

    // Проверяем фильтр по тегам
    if (!empty($tagFilters) && !in_array('all', $tagFilters)) {
        // Получаем теги элемента
        $itemTags = array();

        // Теги из раздела
        if (!empty($arElement['IBLOCK_SECTION_ID'])) {
            $rsSection = CIBlockSection::GetByID($arElement['IBLOCK_SECTION_ID']);
            if ($arSection = $rsSection->GetNext()) {
                $itemTags[] = $arSection['NAME'];
            }
        }

        // Теги из свойства
        if (!empty($arElement['PROPERTIES']['TAGS']['VALUE'])) {
            $itemTags = array_merge($itemTags, $arElement['PROPERTIES']['TAGS']['VALUE']);
        }

        // Проверяем пересечение тегов
        $hasMatchingTag = array_intersect($tagFilters, $itemTags);
        if (empty($hasMatchingTag)) {
            continue;
        }
    }

    // Получаем картинку
    if (!empty($arElement['PREVIEW_PICTURE'])) {
        $arElement['PREVIEW_PICTURE'] = CFile::GetFileArray($arElement['PREVIEW_PICTURE']);
    }

    $arItems[] = $arElement;
}

// Формируем HTML для новых элементов
ob_start();

foreach ($arItems as $arItem):
    $title = $arItem["NAME"];
    $detailUrl = !empty($arItem["DETAIL_PAGE_URL"]) ? $arItem["DETAIL_PAGE_URL"] : "#";

    $imgSrc = "/local/templates/diez-ekb/assets/images/no-image.jpg";
    if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
        $imgSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
    }

    $eventDate = "";
    if (!empty($arItem["PROPERTIES"]["DATETIME"]["VALUE"][0])) {
        $eventDate = FormatDate("d.m.Y", MakeTimeStamp($arItem["PROPERTIES"]["DATETIME"]["VALUE"][0]));
    }

    $eventCity = "";
    if (!empty($arItem["PROPERTIES"]["LOCATION"]["VALUE"][0])) {
        $eventCity = $arItem["PROPERTIES"]["LOCATION"]["VALUE"][0];
    }
    ?>
    <div class="event-item">
        <a href="<?=$detailUrl?>" class="event-card">
            <div class="event-image">
                <img src="<?=$imgSrc?>" alt="<?=htmlspecialchars($title)?>">
            </div>
            <div class="event-info">
                <div class="event-meta">
                    <?php if (!empty($eventDate)): ?>
                        <span class="event-date"><?=$eventDate?></span>
                    <?php endif; ?>
                    <?php if (!empty($eventCity)): ?>
                        <span class="event-city"><?=htmlspecialchars($eventCity)?></span>
                    <?php endif; ?>
                </div>
                <h3 class="event-title"><?=htmlspecialchars($title)?></h3>
                <?php if (!empty($arItem["PREVIEW_TEXT"])): ?>
                    <p class="event-description"><?=$arItem["PREVIEW_TEXT"]?></p>
                <?php endif; ?>
            </div>
        </a>
    </div>
<?php endforeach;

$html = ob_get_clean();

// Возвращаем результат
header('Content-Type: application/json');
echo json_encode(array(
    'html' => $html,
    'hasMore' => count($arItems) == $itemsPerPage
));
?>
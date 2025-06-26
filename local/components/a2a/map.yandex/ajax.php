<?php
// /local/components/custom/map.yandex/ajax.php

define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();
$action = $request->get("action");
$iblockId = intval($request->get("iblockId"));
$category = $request->get("category");

if(!Loader::includeModule("iblock"))
    die(json_encode(array("error" => "Модуль iblock не установлен")));

$result = array();

if($action == "getFilteredItems") {
    $filter = array(
        "IBLOCK_ID" => $iblockId,
        "ACTIVE" => "Y",
    );

    // Добавляем фильтр по категории, если нужно
    if($category && $category != "all") {
        $filter["PROPERTY_CUISINE_VALUE"] = $category;
    }

    $items = array();

    $res = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        $filter,
        false,
        false,
        array("ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PROPERTY_COORDINATES", "PROPERTY_ADDRESS", "PROPERTY_CUISINE")
    );

    while($ob = $res->GetNextElement()) {
        $item = $ob->GetFields();
        $coords = explode(",", $item["PROPERTY_COORDINATES_VALUE"]);

        if(count($coords) == 2) {
            $items[] = array(
                "id" => $item["ID"],
                "name" => $item["NAME"],
                "coordinates" => array(floatval($coords[0]), floatval($coords[1])),
                "address" => $item["PROPERTY_ADDRESS_VALUE"],
                "category" => $item["PROPERTY_CUISINE_VALUE"],
                "url" => $item["DETAIL_PAGE_URL"],
                "image" => CFile::GetPath($item["PREVIEW_PICTURE"]),
            );
        }
    }

    $result = array(
        "success" => true,
        "items" => $items
    );
}

header('Content-Type: application/json');
echo json_encode($result);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
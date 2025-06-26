<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;

class CustomYandexMapComponent extends CBitrixComponent
{
    protected $iblockId;
    protected $filterName;
    protected $mapItems = array();

    public function onPrepareComponentParams($arParams)
    {
        $result = array(
            "IBLOCK_TYPE" => trim($arParams["IBLOCK_TYPE"]),
            "IBLOCK_ID" => intval($arParams["IBLOCK_ID"]),
            "MAP_HEIGHT" => !empty($arParams["MAP_HEIGHT"]) ? $arParams["MAP_HEIGHT"] : "500px",
            "MAP_WIDTH" => !empty($arParams["MAP_WIDTH"]) ? $arParams["MAP_WIDTH"] : "100%",
            "INIT_MAP_TYPE" => !empty($arParams["INIT_MAP_TYPE"]) ? $arParams["INIT_MAP_TYPE"] : "MAP",
            "MAP_DATA" => !empty($arParams["MAP_DATA"]) ? $arParams["MAP_DATA"] : "COORDINATES",
            "PROPERTY_CODE" => is_array($arParams["PROPERTY_CODE"]) ? $arParams["PROPERTY_CODE"] : array(),
            "FILTER_NAME" => trim($arParams["FILTER_NAME"]),
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"] : 36000000,
        );

        $this->iblockId = $result["IBLOCK_ID"];
        $this->filterName = $result["FILTER_NAME"];

        return $result;
    }

    protected function getFilter()
    {
        $filter = array(
            "IBLOCK_ID" => $this->iblockId,
            "ACTIVE" => "Y",
        );

        // Добавляем внешний фильтр, если задан
        global ${$this->filterName};
        if(!empty($this->filterName) && is_array(${$this->filterName})) {
            $filter = array_merge($filter, ${$this->filterName});
        }

        return $filter;
    }

    protected function getItems()
    {
        if(!Loader::includeModule("iblock"))
            throw new SystemException('Модуль "Информационные блоки" не установлен');

        $filter = $this->getFilter();
        $select = array_merge(array("ID", "NAME", "DETAIL_PAGE_URL"), $this->arParams["PROPERTY_CODE"]);

        $res = CIBlockElement::GetList(
            array("SORT" => "ASC"),
            $filter,
            false,
            false,
            $select
        );

        $items = array();

        while($ob = $res->GetNextElement()) {
            $item = $ob->GetFields();
            $item["PROPERTIES"] = $ob->GetProperties();

            // Получаем координаты из свойств
            $coordinates = array();

            // В зависимости от настроек, координаты могут храниться по-разному
            if($this->arParams["MAP_DATA"] == "COORDINATES") {
                // Если координаты хранятся в свойстве типа "строка" в формате "широта,долгота"
                $coordProperty = $item["PROPERTIES"]["COORDINATES"]["VALUE"];
                if(!empty($coordProperty)) {
                    $coordinates = explode(",", $coordProperty);
                    // Преобразуем в числа и проверяем корректность
                    if(count($coordinates) == 2) {
                        $coordinates = array(
                            floatval(trim($coordinates[0])),
                            floatval(trim($coordinates[1]))
                        );
                    }
                }
            }
            else if($this->arParams["MAP_DATA"] == "COORDS_SEPARATE") {
                // Если координаты хранятся в отдельных свойствах LATITUDE и LONGITUDE
                $lat = floatval($item["PROPERTIES"]["LATITUDE"]["VALUE"]);
                $lng = floatval($item["PROPERTIES"]["LONGITUDE"]["VALUE"]);
                if($lat && $lng) {
                    $coordinates = array($lat, $lng);
                }
            }

            // Если координаты получены, добавляем точку
            if(!empty($coordinates) && count($coordinates) == 2) {
                $item["COORDINATES"] = $coordinates;

                // Добавляем дополнительные данные для карты
                $previewPicture = "";
                if(!empty($item["PREVIEW_PICTURE"])) {
                    $previewPicture = CFile::GetPath($item["PREVIEW_PICTURE"]);
                }

                $item["MAP_DATA"] = array(
                    "id" => $item["ID"],
                    "name" => $item["NAME"],
                    "coordinates" => $coordinates,
                    "address" => $item["PROPERTIES"]["ADDRESS"]["VALUE"],
                    "image" => $previewPicture,
                    "url" => $item["DETAIL_PAGE_URL"],
                );

                // Добавляем категорию, если есть (для фильтрации на карте)
                if(!empty($item["PROPERTIES"]["CATEGORY"]["VALUE"]) || !empty($item["PROPERTIES"]["CUISINE"]["VALUE"]) || !empty($item["PROPERTIES"]["STARS"]["VALUE"])) {
                    $category = !empty($item["PROPERTIES"]["CATEGORY"]["VALUE"]) ? $item["PROPERTIES"]["CATEGORY"]["VALUE"] :
                        (!empty($item["PROPERTIES"]["CUISINE"]["VALUE"]) ? $item["PROPERTIES"]["CUISINE"]["VALUE"] :
                            $item["PROPERTIES"]["STARS"]["VALUE"]);

                    $item["MAP_DATA"]["category"] = $category;
                }

                $items[] = $item;
            }
        }

        return $items;
    }

    public function executeComponent()
    {
        try {
            if($this->startResultCache()) {
                $this->arResult["ITEMS"] = $this->getItems();
                $this->arResult["MAP_ITEMS"] = array();

                // Подготавливаем данные для JavaScript
                foreach($this->arResult["ITEMS"] as $item) {
                    if(!empty($item["MAP_DATA"])) {
                        $this->arResult["MAP_ITEMS"][] = $item["MAP_DATA"];
                    }
                }

                $this->includeComponentTemplate();
            }
        }
        catch(Exception $e) {
            $this->abortResultCache();
            ShowError($e->getMessage());
        }
    }
}
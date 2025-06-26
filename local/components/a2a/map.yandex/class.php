<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\SystemException;

/**
 * Компонент для отображения Яндекс.Карты с объектами из инфоблока
 *
 * Class CustomYandexMapComponent
 */
class CustomYandexMapComponent extends CBitrixComponent
{
    /** @var int ID инфоблока */
    protected $iblockId;

    /** @var string Имя фильтра */
    protected $filterName;

    /** @var array Массив с данными для карты */
    protected $mapItems = array();

    /** @var array Массив с дополнительной информацией для отладки */
    protected $debugInfo = array();

    /**
     * Подготовка параметров компонента
     *
     * @param array $arParams Массив параметров
     * @return array
     */
    public function onPrepareComponentParams($arParams)
    {
        // Обязательные параметры с значениями по умолчанию
        $result = array(
            "IBLOCK_TYPE" => trim($arParams["IBLOCK_TYPE"]),
            "IBLOCK_ID" => intval($arParams["IBLOCK_ID"]),
            "MAP_WIDTH" => !empty($arParams["MAP_WIDTH"]) ? $arParams["MAP_WIDTH"] : "100%",
            "MAP_HEIGHT" => !empty($arParams["MAP_HEIGHT"]) ? $arParams["MAP_HEIGHT"] : "400px",
            "INIT_MAP_TYPE" => !empty($arParams["INIT_MAP_TYPE"]) ? $arParams["INIT_MAP_TYPE"] : "MAP",
            "MAP_DATA" => !empty($arParams["MAP_DATA"]) ? $arParams["MAP_DATA"] : "COORDINATES",
            "PROPERTY_CODE" => is_array($arParams["PROPERTY_CODE"]) ? $arParams["PROPERTY_CODE"] : array(),
            "FILTER_NAME" => trim($arParams["FILTER_NAME"]),
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"] : 36000000,
            "API_KEY" => trim($arParams["API_KEY"]), // API ключ для Яндекс.Карт
        );

        // Сохраняем ID инфоблока и имя фильтра для дальнейшего использования
        $this->iblockId = $result["IBLOCK_ID"];
        $this->filterName = $result["FILTER_NAME"];

        return $result;
    }

    /**
     * Проверка наличия необходимых модулей
     *
     * @return bool
     * @throws LoaderException
     */
    protected function checkModules()
    {
        if (!Loader::includeModule("iblock")) {
            throw new LoaderException('Модуль "Информационные блоки" не установлен');
        }

        return true;
    }

    /**
     * Получение фильтра для запроса к инфоблоку
     *
     * @return array
     */
    protected function getFilter()
    {
        // Базовый фильтр
        $filter = array(
            "IBLOCK_ID" => $this->iblockId,
            "ACTIVE" => "Y",
        );

        // Добавляем внешний фильтр, если задан
        global ${$this->filterName};
        if (!empty($this->filterName) && is_array(${$this->filterName})) {
            $filter = array_merge($filter, ${$this->filterName});
        }

        return $filter;
    }

    /**
     * Получение элементов инфоблока и подготовка данных для карты
     *
     * @return array
     * @throws SystemException
     */
    protected function getItems()
    {
        $filter = $this->getFilter();
        $this->debugInfo['FILTER'] = $filter;

        // Определяем поля для выборки
        $select = array(
            "ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL",
            "PROPERTY_COORDINATES", "PROPERTY_ADDRESS", "PROPERTY_PHONE",
            "PROPERTY_OPEN_HOURS", "PROPERTY_CUISINE", "PROPERTY_PRICE_LEVEL",
            "PROPERTY_FEATURES", "PROPERTY_SITE", "PROPERTY_SOCIAL_NETWORKS",
            "PROPERTY_GALLERY"
        );

        // Массив для отслеживания уже обработанных ID элементов
        $processedIds = array();

        // Получаем элементы из инфоблока
        $items = array();
        $res = CIBlockElement::GetList(
            array("SORT" => "ASC"),
            $filter,
            false,
            false,
            $select
        );

        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arProps = $ob->GetProperties();

            // Пропускаем уже обработанные элементы
            $elementId = $arFields["ID"];
            if (in_array($elementId, $processedIds)) {
                continue;
            }
            $processedIds[] = $elementId;

            // Обработка координат
            $coordinates = array();
            if (!empty($arFields["PROPERTY_COORDINATES_VALUE"])) {
                $coordsStr = $arFields["PROPERTY_COORDINATES_VALUE"];
                // Удаляем пробелы и разделяем по запятой
                $coordsArr = explode(",", str_replace(" ", "", $coordsStr));

                if (count($coordsArr) == 2) {
                    $coordinates = array(
                        floatval($coordsArr[0]),
                        floatval($coordsArr[1])
                    );
                }
            }

            // Добавляем элемент только если есть корректные координаты
            if (!empty($coordinates)) {
                // Получаем изображение из превью или первое из галереи
                $imageUrl = "";
                if (!empty($arFields["PREVIEW_PICTURE"])) {
                    $imageUrl = CFile::GetPath($arFields["PREVIEW_PICTURE"]);
                } elseif (!empty($arProps["GALLERY"]["VALUE"]) && is_array($arProps["GALLERY"]["VALUE"]) && count($arProps["GALLERY"]["VALUE"]) > 0) {
                    $imageUrl = CFile::GetPath($arProps["GALLERY"]["VALUE"][0]);
                }

                // Собираем галерею изображений
                $gallery = array();
                if (!empty($arProps["GALLERY"]["VALUE"]) && is_array($arProps["GALLERY"]["VALUE"])) {
                    foreach ($arProps["GALLERY"]["VALUE"] as $imageId) {
                        $gallery[] = CFile::GetPath($imageId);
                    }
                }

                // Получаем XML_ID для кухни
                $cuisineXmlId = '';
                if (!empty($arFields["PROPERTY_CUISINE_VALUE"])) {
                    $cuisineXmlId = $this->getXmlIdByValue(
                        $this->iblockId,
                        "CUISINE",
                        $arFields["PROPERTY_CUISINE_VALUE"]
                    );
                }

                // Получаем XML_ID для ценового уровня
                $priceLevelXmlId = '';
                if (!empty($arFields["PROPERTY_PRICE_LEVEL_VALUE"])) {
                    $priceLevelXmlId = $this->getXmlIdByValue(
                        $this->iblockId,
                        "PRICE_LEVEL",
                        $arFields["PROPERTY_PRICE_LEVEL_VALUE"]
                    );
                }

                // Обработка особенностей (множественное свойство)
                $features = array();
                $featuresXmlIds = array();

                // Проверяем как хранятся значения свойства FEATURES
                if (!empty($arProps["FEATURES"]["VALUE"]) && is_array($arProps["FEATURES"]["VALUE"])) {
                    $features = $arProps["FEATURES"]["VALUE"];

                    // Получаем XML_ID для каждой особенности
                    foreach ($features as $featureValue) {
                        $featureXmlId = $this->getXmlIdByValue(
                            $this->iblockId,
                            "FEATURES",
                            $featureValue
                        );

                        if (!empty($featureXmlId)) {
                            $featuresXmlIds[] = $featureXmlId;
                        }
                    }
                }

                // Проверка наличия определенных особенностей
                $hasParking = in_array("parking", $featuresXmlIds) || in_array("Есть парковка", $features);
                $hasWifi = in_array("wifi", $featuresXmlIds) || in_array("Есть Wi-Fi", $features);
                $hasKidsRoom = in_array("kids_room", $featuresXmlIds) || in_array("Есть детская комната", $features);
                $isAccessible = in_array("accessible", $featuresXmlIds) || in_array("Доступно для инвалидов", $features);
                $hasDelivery = in_array("delivery", $featuresXmlIds) || in_array("Есть доставка", $features);

                // Социальные сети (множественное свойство)
                $socialNetworks = array();
                if (!empty($arProps["SOCIAL_NETWORKS"]["VALUE"]) && is_array($arProps["SOCIAL_NETWORKS"]["VALUE"])) {
                    $socialNetworks = $arProps["SOCIAL_NETWORKS"]["VALUE"];
                }

                // Формируем массив данных для метки
                $mapItem = array(
                    "id" => $elementId,
                    "name" => $arFields["NAME"],
                    "coordinates" => $coordinates,
                    "address" => $arFields["PROPERTY_ADDRESS_VALUE"],
                    "phone" => $arFields["PROPERTY_PHONE_VALUE"],
                    "schedule" => $arFields["PROPERTY_OPEN_HOURS_VALUE"],
                    "category" => $cuisineXmlId ?: strtolower($arFields["PROPERTY_CUISINE_VALUE"]),
                    "cuisine" => $arFields["PROPERTY_CUISINE_VALUE"],
                    "price_category" => $priceLevelXmlId ?: strtolower($arFields["PROPERTY_PRICE_LEVEL_VALUE"]),
                    "price_level" => $arFields["PROPERTY_PRICE_LEVEL_VALUE"],
                    "features" => $features,
                    "features_xml_id" => $featuresXmlIds,
                    "has_parking" => $hasParking ? "true" : "false",
                    "has_wifi" => $hasWifi ? "true" : "false",
                    "has_kids_room" => $hasKidsRoom ? "true" : "false",
                    "accessible" => $isAccessible ? "true" : "false",
                    "delivery" => $hasDelivery ? "true" : "false",
                    "website" => $arFields["PROPERTY_SITE_VALUE"],
                    "social_networks" => $socialNetworks,
                    "url" => $arFields["DETAIL_PAGE_URL"],
                    "image" => $imageUrl,
                    "gallery" => $gallery
                );

                $items[] = $mapItem;
            }
        }

        return $items;
    }

    /**
     * Получение XML_ID по значению свойства типа "Список"
     *
     * @param int $iblockId ID инфоблока
     * @param string $propCode Код свойства
     * @param string $value Значение свойства
     * @return string XML_ID или пустая строка
     */
    protected function getXmlIdByValue($iblockId, $propCode, $value)
    {
        $xmlId = '';

        $property = CIBlockProperty::GetList(
            array(),
            array("IBLOCK_ID" => $iblockId, "CODE" => $propCode)
        )->Fetch();

        if ($property) {
            $enum = CIBlockPropertyEnum::GetList(
                array(),
                array("PROPERTY_ID" => $property["ID"], "VALUE" => $value)
            )->Fetch();

            if ($enum) {
                $xmlId = $enum["XML_ID"];
            }
        }

        return $xmlId;
    }

    /**
     * Основной метод выполнения компонента
     *
     * @throws Exception
     */
    public function executeComponent()
    {
        try {
            // Проверяем необходимые модули
            $this->checkModules();

            // Проверяем ID инфоблока
            if ($this->iblockId <= 0) {
                throw new SystemException('Не указан ID инфоблока');
            }

            // Проверяем кэширование
            $cacheId = md5(serialize(array(
                $this->arParams,
                $this->getFilter(),
                $GLOBALS[$this->filterName] ?? array()
            )));

            $cacheDir = '/a2a/map.yandex/' . $this->iblockId;

            if ($this->startResultCache($this->arParams["CACHE_TIME"], $cacheId, $cacheDir)) {
                // Получаем элементы для карты
                $this->arResult["MAP_ITEMS"] = $this->getItems();
                $this->arResult["DEBUG_INFO"] = $this->debugInfo;
                $this->arResult["DEBUG_INFO"]["COUNT"] = count($this->arResult["MAP_ITEMS"]);

                // Если элементов нет и отключен показ пустых данных, прерываем кеширование
                if (empty($this->arResult["MAP_ITEMS"]) && $this->arParams["CACHE_TIME"] > 0) {
                    $this->abortResultCache();
                    return;
                }

                // Добавляем параметры компонента в результат для использования в шаблоне
                $this->arResult["COMPONENT_PARAMS"] = array(
                    "MAP_WIDTH" => $this->arParams["MAP_WIDTH"],
                    "MAP_HEIGHT" => $this->arParams["MAP_HEIGHT"],
                    "INIT_MAP_TYPE" => $this->arParams["INIT_MAP_TYPE"],
                    "API_KEY" => $this->arParams["API_KEY"],
                    "IBLOCK_ID" => $this->iblockId,
                );

                // Подключаем шаблон компонента
                $this->includeComponentTemplate();
            }
        } catch (Exception $e) {
            // Удаляем кеш в случае ошибки
            $this->abortResultCache();

            // Показываем ошибку в режиме отладки
            if ($GLOBALS["USER"]->IsAdmin()) {
                ShowError($e->getMessage());
            }

            // Логируем ошибку
            \CEventLog::Add(array(
                "SEVERITY" => "ERROR",
                "AUDIT_TYPE_ID" => "COMPONENT_ERROR",
                "MODULE_ID" => "main",
                "ITEM_ID" => "a2a:map.yandex",
                "DESCRIPTION" => $e->getMessage() . "\n" . $e->getTraceAsString(),
            ));
        }
    }
}
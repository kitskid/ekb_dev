<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
class Menu extends CBitrixComponent {

    private static $DEFAULT_OPEN = '<ul>';
    private static $DEFAULT_CLOSE = '</ul>';
    private static $DEFAULT_SELECT = ['ID', 'CODE', 'NAME', 'IBLOCK_SECTION_ID'];

    private $RENDER_PARAMS = [];

    private function convert_bitrix_menu() {
        $MENU = [
            'FIELDS' => [],
            'PROPERTIES' => [],
            'ITEMS' => []
        ];

        foreach ($this->arParams['MENU'] as $aMenuLink) {
            $new_link = [
                'FIELDS' => array_merge(
                    $aMenuLink[3],
                    [
                        'NAME' => $aMenuLink[0],
                        'LINK' => $aMenuLink[1]
                    ]
                )
            ];
            if (!empty($aMenuLink[2]))
                $new_link['ITEMS'] = array_map(function ($item) {
                    return ['FIELDS' => ['LINK' => $item]];
            }, $aMenuLink[2]);
            
            $MENU['ITEMS'][] = $new_link;
        }

        $this->arParams['MENU'] =  $MENU;         
    }

    private function render($ITEMS, $FIELDS, $PROPERTIES, $depth = 0) {

        $params = !empty($this->RENDER_PARAMS[$depth])
            ? $this->RENDER_PARAMS[$depth]
            : (!empty($this->RENDER_PARAMS['default'])
                ? $this->RENDER_PARAMS['default']
                : (!empty($this->RENDER_PARAMS[0])
                    ? $this->RENDER_PARAMS[0]
                    : [
                        'OPEN' => self::$DEFAULT_OPEN,
                        'ITEM' => fn($FIELDS = [], $PROPERTIES = []) => "<li>{$FIELDS['NAME']}</li>",
                        'CLOSE' => self::$DEFAULT_CLOSE
                    ]
                )
            );

        $OPEN = is_callable($params['OPEN']) ? $params['OPEN']($FIELDS, $PROPERTIES) : $params['OPEN'];
        $CLOSE = is_callable($params['CLOSE']) ? $params['CLOSE']($FIELDS, $PROPERTIES) : $params['CLOSE'];

        $html = !empty($OPEN) ? $OPEN : self::$DEFAULT_OPEN;  // Начинаем список
    
        foreach ($ITEMS as $ITEM)
            if (isset($ITEM['ITEMS']))
                $html .= self::render($ITEM['ITEMS'], $ITEM['FIELDS'], $ITEM['PROPERTIES'], $depth + 1);
            elseif (
                $this->arParams['RENDER_EMPTY'] == 'Y' ||
                $ITEM['FIELDS']['TYPE'] != 'SECTION'
            )
                $html .= is_callable($params['ITEM']) ? $params['ITEM']($ITEM['FIELDS']) : $params['ITEM'];
        
        $html .= !empty($CLOSE) ? $CLOSE : self::$DEFAULT_CLOSE;  // Закрываем список

        return $html;
    }

    private function is_bitrix_menu() {
        if (array_keys($this->arParams['MENU']) !== range(0, count($this->arParams['MENU']) - 1)) {
            return false;
        }
    
        foreach ($this->arParams['MENU'] as $aMenuLink) {
            if (!is_array($aMenuLink) || count($aMenuLink) !== 5)
                return false;
    
            if (
                !is_string($aMenuLink[0]) ||
                !is_string($aMenuLink[1]) ||
                !is_array($aMenuLink[2])  ||
                !is_array($aMenuLink[3])  ||
                !is_string($aMenuLink[4])
            ) {
                return false;
            }
        }
    
        return true;
    }

    private function prepare_params() {

        if (is_string($this->arParams['MENU'])) {
            if (!file_exists($this->arParams['MENU']))
                throw new \Exception("Передана строка, а не массив меню! Файл с меню не найден!", 5);

            $MENU = require($this->arParams['MENU']);
            if (is_array($MENU))
                $this->arParams['MENU'] = $MENU;
            elseif (!isset($aMenuLinks))
                throw new \Exception('В файле не оказалось массива меню! Не найден массив $aMenuLinks!', 4);

//            $this->arParams['MENU'] = $aMenuLinks;
        }

        if (empty($this->arParams['MENU'])) {

            if (empty($this->arParams['IBLOCK_ID']))
                throw new \Exception("Не передано ни меню, ни IBLOCK_ID!", 1);

            foreach ([
                'SectionTable',
                'ElementTable'
            ] as $type) {
                $this->arParams[$type] = !empty($this->arParams[$type]) 
                    ? $this->arParams[$type]
                    : [];
            }
        } elseif ($this->is_bitrix_menu())
            $this->convert_bitrix_menu();

        $this->arParams['LIMIT'] = (int)$this->arParams['LIMIT'];

        $this->arParams['CACHE_TYPE'] = $this->arParams['CACHE_TYPE'] == 'Y' && !empty($this->arParams['CACHE_TYPE'] && is_numeric($this->arParams['CACHE_TYPE']))
            ? 'Y'
            : ($this->arParams['CACHE_TYPE'] == 'N' ? 'N' : 'A');

        if ($this->arParams['CACHE_TYPE'] == 'A')
            $this->arParams['CACHE_TIME'] = 3600;
        
    }

    private function build_tree($stack) {
        $additional_tree = $stack;

        $result_tree = [];
        foreach ($stack as $s_id => $s)
            if (!empty($s['FIELDS']['IBLOCK_SECTION_ID'])) {
                if (!isset($additional_tree[$s['FIELDS']['IBLOCK_SECTION_ID']]['ITEMS']))
                    $additional_tree[$s['FIELDS']['IBLOCK_SECTION_ID']]['ITEMS'] = [];

                $additional_tree[$s['FIELDS']['IBLOCK_SECTION_ID']]['ITEMS'][] = &$additional_tree[$s_id];
            } else
                $result_tree[] = &$additional_tree[$s_id];
        
        return $result_tree;
    }

    private function get_menu_from_iblock() {
        if (!\Bitrix\Main\Loader::includeModule('iblock'))
            throw new \Exception("Не удалось подключить модуль 'iblock'.", 2);
    
        $r_iblock = Bitrix\Iblock\IblockTable::getList([
            'filter' => ['ID' => $this->arParams['IBLOCK_ID']],
            'select' => ['DETAIL_PAGE_URL', 'SECTION_PAGE_URL']
        ]);

        if (!$iblock = $r_iblock->fetch())
            throw new \Exception("Не удалось найти инфоблок с ID={$this->arParams['IBLOCK_ID']}", 3);

        $r_SectionTable = \Bitrix\Iblock\SectionTable::getList([
            'filter' => array_merge(
                is_array($this->arParams["SectionTable"]['FILTER']) ? $this->arParams["SectionTable"]['FILTER'] : [], 
                ['IBLOCK_ID' => $this->arParams['IBLOCK_ID']]
            ),
            'select' => array_merge(is_array($this->arParams["SectionTable"]['SELECT']) ? $this->arParams["SectionTable"]['SELECT'] : [], self::$DEFAULT_SELECT),
            'order' => is_array($this->arParams["SectionTable"]['ORDER']) ? $this->arParams["SectionTable"]['ORDER'] : [],
            'limit' => $this->arParams["SectionTable"]['LIMIT'],
        ]);

        $stack = [];
        $sections_with_children = [];

        while ($section = $r_SectionTable->fetch()) {
            $sections_with_children[$section['IBLOCK_SECTION_ID']] = true;
            $section['TYPE'] = 'SECTION';
            $section['SECTION_PAGE_URL'] = str_replace(
                ['#SECTION_ID#', '#SECTION_CODE#', '#IBLOCK_ID#','#SITE_DIR#'],
                [
                    $section['ID'],
                    $section['CODE'],
                    $this->arParams['IBLOCK_ID'],
                    ''
                ],
                $iblock['SECTION_PAGE_URL']
            );
            $stack[$section['ID']] = ['FIELDS' => $section, 'PROPERTIES' => []];
        }
        
        $r_ElementTable = \Bitrix\Iblock\ElementTable::getList([
            'filter' => array_merge(
                is_array($this->arParams["ElementTable"]['FILTER']) ? $this->arParams["ElementTable"]['FILTER'] : [], 
                ['IBLOCK_ID' => $this->arParams['IBLOCK_ID']],
                isset($this->arParams["ElementTable"]['FILTER']['IBLOCK_SECTION_ID'])
                    ? $this->arParams["ElementTable"]['FILTER']['IBLOCK_SECTION_ID']
                    : array_merge(array_keys($stack), [0])
            ),
            'select' => array_merge(is_array($this->arParams["ElementTable"]['SELECT']) ? $this->arParams["ElementTable"]['SELECT'] : [], self::$DEFAULT_SELECT),
            'order' => is_array($this->arParams["ElementTable"]['ORDER']) ? $this->arParams["ElementTable"]['ORDER'] : [],
            'limit' => $this->arParams["ElementTable"]['LIMIT'],
        ]);

        $element_ids = [];
        while ($element = $r_ElementTable->fetch()) {
            $sections_with_children[$element['IBLOCK_SECTION_ID']] = true;
            $element_ids[] = $element['ID'];
            $element['TYPE'] = 'ELEMENT';
            $element['DETAIL_PAGE_URL'] = str_replace(
                ['#ELEMENT_ID#', '#ELEMENT_CODE#', '#IBLOCK_ID#', '#SECTION_ID#','#SITE_DIR#'],
                [
                    $element['ID'],
                    $element['CODE'],
                    $this->arParams['IBLOCK_ID'],
                    $element['IBLOCK_SECTION_ID'],
                    ''
                ],
                $iblock['DETAIL_PAGE_URL']
            );
            $stack[$element['ID'].'_'] = ['FIELDS' => $element, 'PROPERTIES' => []];
        }

        if (!empty($this->arParams["ElementTable"]['PROPERTIES'])) {
            $r_properties = \Bitrix\Iblock\PropertyTable::getList([
                'filter' => [
                    'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                    'CODE' => $this->arParams["ElementTable"]['PROPERTIES']
                ],
                'select' => ['ID', 'CODE', 'MULTIPLE']
            ]);

            $properties = [];
            while ($property = $r_properties->fetch())
                $properties[$property['ID']] = [
                    'CODE' => $property['CODE'], 
                    'MULTIPLE' => $property['MULTIPLE']
                ];

            if (!empty($properties)) {
                $properties_values = \Bitrix\Iblock\ElementPropertyTable::getList([
                    'filter' => [
                        'IBLOCK_ELEMENT_ID' => $element_ids,
                        'IBLOCK_PROPERTY_ID' => array_keys($properties)
                    ],
                    'select' => ['IBLOCK_ELEMENT_ID', 'IBLOCK_PROPERTY_ID', 'VALUE']
                ])->fetchAll();

                foreach ($properties_values as $property_value)
                    if ($properties[$property_value['IBLOCK_PROPERTY_ID']]['MULTIPLE'] == 'Y')
                        $stack[$property_value['IBLOCK_ELEMENT_ID'].'_']['PROPERTIES'][$properties[$property_value['IBLOCK_PROPERTY_ID']]['CODE']][] = $property_value['VALUE'];
                    else
                        $stack[$property_value['IBLOCK_ELEMENT_ID'].'_']['PROPERTIES'][$properties[$property_value['IBLOCK_PROPERTY_ID']]['CODE']] = $property_value['VALUE'];
            }
        }

        return ['ITEMS' => $this->build_tree($stack), 'FIELDS'=> [], 'PROPERTIES' => []];
    }

    public function executeComponent() {
        try {
            $this->prepare_params();

            if ($this->arParams['CACHE_TYPE'] != 'N' &&
                ($cache = \Bitrix\Main\Data\Cache::createInstance()) &&
                $cache->initCache($this->arParams['CACHE_TIME'], "menu_".json_encode([
                    $this->arParams['MENU'],
                    $this->arParams['IBLOCK_ID'], 
                    $this->arParams['ElementTable'], 
                    $this->arParams['SectionTable']
                ])
            ))
                $this->arResult['MENU'] = $cache->getVars();
            else {
                $this->arResult['MENU'] = !empty($this->arParams['MENU'])
                    ? $this->arParams['MENU']
                    : $this->get_menu_from_iblock();
                
                if (is_object($cache) && $cache->startDataCache())
                    $cache->endDataCache($this->arResult['MENU']);
            }

            $arParams = $this->arParams;
            $this->arResult['RENDER'] = function ($RENDER_PARAMS = []) use ($arParams) {
                $this->RENDER_PARAMS = $RENDER_PARAMS;
                return self::render($this->arResult['MENU']['ITEMS'], $this->arResult['MENU']['FIELDS'], $this->arResult['MENU']['PROPERTIES'], 0);
            };

            if ($this->arParams['RETURN'] != 'Y')
                $this->includeComponentTemplate();

            return $this->arResult['MENU'];
        } catch (\Exception $e) {
            $this->abortResultCache();
            ShowError($e->getMessage());
        }
    }
}

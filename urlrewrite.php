<?php
$arUrlRewrite=array (
  7 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/video/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/special/300-history/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/special/300-history/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/tourists/locations/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/tourists/locations/index.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/friends/sponsors/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/friends/sponsors/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/history/names/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/history/names/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/special/quiz/#',
    'RULE' => '',
    'ID' => 'aelita:test',
    'PATH' => '/special/quiz/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/residents/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/residents/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/tourists/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/tourists/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/citizens/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/citizens/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/bill/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/bill/index.php',
    'SORT' => 100,
  ),
  18 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  21 =>
  array(
      "CONDITION" => "#^/routes/([^/]+)?$#",
      "RULE" => "ELEMENT_CODE=\$1",
      "ID" => "bitrix:news.detail",
      "PATH" => "/routes/detail.php",
      "SORT" => 100,
  ),
  22 =>
  // Правило для списка достопримечательностей
  array(
      "CONDITION" => "#^/attractions/$#",
      "RULE" => "",
      "ID" => "bitrix:news.list",
      "PATH" => "/attractions/index.php",
  ),
  23 =>
  // Правило для детальной страницы достопримечательности по символьному коду
  array(
      "CONDITION" => "#^/attractions/([^/]+)/$#",
      "RULE" => "ELEMENT_CODE=\$1",
      "ID" => "bitrix:news.detail",
      "PATH" => "/attractions/detail.php",
  ),
  24 =>
  // ЧПУ для детальных страниц событий
  array(
      "CONDITION" => "#^/afisha/([^/]+)/([^/]+)/?$#",
      "RULE" => "SECTION_CODE=\$1&ELEMENT_CODE=\$2",
      "ID" => "",
      "PATH" => "/afisha/detail.php",
      "SORT" => 10,
  ),
  25 =>
  // ЧПУ для разделов афиши (с фильтром по тегам)
  array(
      "CONDITION" => "#^/afisha/([^/]+)/?$#",
      "RULE" => "SECTION_CODE=\$1",
      "ID" => "",
      "PATH" => "/afisha/section.php",
      "SORT" => 20,
  ),
  26 =>
  // Обычная страница афиши
  array(
      "CONDITION" => "#^/afisha/#",
      "RULE" => "",
      "ID" => "",
      "PATH" => "/afisha/index.php",
      "SORT" => 30,
  ),
  27 =>
  array(
        "CONDITION" => "#^/hotels/([^/]+)$#",
        "RULE" => "ELEMENT_CODE=\$1",
        "ID" => "bitrix:news.detail",
        "PATH" => "/hotels/detail.php",
        "SORT" => 10,
  ),
  28 =>
  array(
     "CONDITION" => "#^/tourism/([^/]+)$#",
     "RULE" => "ELEMENT_CODE=\$1",
     "ID" => "bitrix:news.detail",
     "PATH" => "/tourism/detail.php",
     "SORT" => 100,
  ),
  29 =>
  array(
      "CONDITION" => "#^/guides/([^/]+)$#",
      "RULE" => "ELEMENT_CODE=\$1",
      "ID" => "bitrix:news.detail",
      "PATH" => "/guides/detail.php",
      "SORT" => 100,
  ),
);

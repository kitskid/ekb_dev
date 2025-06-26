<?php

return [
    'ITEMS' => [
        include('about.menu.php'),
        include('development.menu.php'),
        include('tourism.menu.php'),
        ['FIELDS' => ['NAME' => 'Спецпроекты','LINK' => '/special-projects/']],
        ['FIELDS' => ['NAME' => 'Справка','LINK' => '/reference/']],
    ]
];


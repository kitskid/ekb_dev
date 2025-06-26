<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

<?=$arResult['RENDER']([
    'default' => [
        'OPEN' => fn() => "<ul class='test'>",
        'ITEM' => fn($FIELDS) => "<li>{$FIELDS['NAME']}</li>",
        'CLOSE' => '</ul>',
    ],
    1 => [
        'OPEN' => fn($FIELDS) => "<ul style='margin-left:20px;'>{$FIELDS['NAME']}",
        'ITEM' => fn($FIELDS) => "<li>->{$FIELDS['NAME']}</li>",
        'CLOSE' => '</ul>',
    ]
]);?>

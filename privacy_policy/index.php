<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Политика конфиденциальности");
?>

<div class="container">
    <? $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        array(
            "AREA_FILE_SHOW" => "file",
            "EDIT_TEMPLATE" => "",
            "PATH" => "/include/privacy_policy/privacy_policy_text.php"
        )
    );
    ?>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
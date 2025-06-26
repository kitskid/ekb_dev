<?
header("Content-type: application/json; charset=utf-8");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("form");

$FORM_ID = 4;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$getPostList = $request->getPostList();
$post = $getPostList->toArray();

$file= $request->getFile("FILE");
$list = $post["ITEM_LIST"];

$FIELDS = [
	"form_text_47" => $post["USER_NAME"],
    "form_text_48" => $post["USER_CITY"],
	"form_text_49" => $post["USER_WORK"],
    "form_text_50" => $post["USER_PHONE"],
	"form_text_51" => $post["USER_DAYS"],
    "form_text_52" => $post["USER_DATE"],
    "form_text_53" => $post["USER_NUMBER"],
    "form_text_54" => $post["USER_HELP"],
    "form_text_55" => $post["USER_CODE"],
];

if (($result = CFormResult::Add($FORM_ID, $FIELDS)) && CFormResult::Mail($result)) {
	$data["status"] = 200;
} else {
	$data["status"] = 400;
	$data["message"] = "Ошибка: почтовое уведомление не создано";
}

$data["fields"] = $FIELDS;

echo json_encode($data);
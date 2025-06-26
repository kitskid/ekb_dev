<?
header("Content-type: application/json; charset=utf-8");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("form");

$FORM_ID = 2;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$getPostList = $request->getPostList();
$post = $getPostList->toArray();

$file= $request->getFile("FILE");
$list = $post["ITEM_LIST"];

$FIELDS = [
	"form_text_7" => $post["USER_ORGANIZATION"],
    "form_text_9" => $post["USER_EMAIL"],
    "form_text_6" => $post["USER_FIO"],
	"form_text_8" => $post["USER_PHONE"],
];

if (($result = CFormResult::Add($FORM_ID, $FIELDS)) && CFormResult::Mail($result)) {
	$data["status"] = 200;
} else {
	$data["status"] = 400;
	$data["message"] = "Ошибка: почтовое уведомление не создано";
}

$data["fields"] = $FIELDS;

echo json_encode($data);
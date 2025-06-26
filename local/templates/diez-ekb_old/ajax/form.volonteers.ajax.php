<?
header("Content-type: application/json; charset=utf-8");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("form");

$FORM_ID = 3;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$getPostList = $request->getPostList();
$post = $getPostList->toArray();

$file= $request->getFile("FILE");
$list = $post["ITEM_LIST"];

$FIELDS = [
	"form_text_10" => $post["USER_SURNAME"],
    "form_text_11" => $post["USER_NAME"],
    "form_text_12" => $post["USER_SECOND_NAME"],
	"form_text_38" => $post["USER_DATE"],
    "form_text_34" => $post["USER_SEX"],
    "form_text_15" => $post["USER_REGION"],
    "form_text_35" => $post["USER_CITY"],
    "form_text_16" => $post["USER_EMAIL"],
    "form_text_17" => $post["USER_SOCIAL"],
    "form_text_18" => $post["USER_PHONE"],
    "form_text_33" => $post["USER_CAPTION"],
    "form_text_20" => $post["USER_INSTITUT"],
    "form_text_45" => $post["USER_AGE"],
    "form_text_37" => $post["PAREN_SURNAME"],
    "form_text_21" => $post["PARENT_NAME"],
    "form_text_36" => $post["PARENT_SECOND_NAME"],
    "form_text_22" => $post["PARENT_PHONE"],
    "form_text_23" => $post["PARENT_WORK"],
    "form_textarea_24" => $post["USER_WHY"],
    "form_textarea_25" => $post["USER_EXPECTATION"],
    "form_textarea_26" => $post["USER_EXPERIANCE"],
];

if (($result = CFormResult::Add($FORM_ID, $FIELDS)) && CFormResult::Mail($result)) {
	$data["status"] = 200;
} else {
	$data["status"] = 400;
	$data["message"] = "Ошибка: почтовое уведомление не создано";
}

$data["fields"] = $FIELDS;

echo json_encode($data);
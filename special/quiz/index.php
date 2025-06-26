<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
?>
<?
$APPLICATION->IncludeComponent(
	"aelita:test", 
	"template", 
	array(
		"SHOW_ALL" => "Y",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/special/quiz/",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36",
		"CACHE_TYPE" => "A",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"COMPONENT_TEMPLATE" => "template",
		"PROFILE_DETAIL_URL" => "",
		"SHOW_NO_GROUP" => "N",
		"ADD_GROUP_CHAIN" => "N",
		"SET_TITLE_GROUP" => "N",
		"ADD_TEST_CHAIN" => "N",
		"SET_TITLE_TEST" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COUNT_TEST" => "20",
		"PAGER_TITLE" => "",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"TOP_TESTS" => "N",
		"SEF_URL_TEMPLATES" => array(
			"groups" => "/special/quiz/",
			"group" => "#GROUP_CODE#/",
			"test" => "#GROUP_CODE#/#TEST_CODE#/",
		)
	),
	false
);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
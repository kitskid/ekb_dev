<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->SetTitle("Мини-игры");?>
<section class="section bg-white pt-100 pb-100 ptm-80 pbm-40">
	<div class="container">
		<? $APPLICATION->IncludeComponent(
				"bitrix:breadcrumb",
				"breadcrumbs",
				array(
					"START_FROM" => "0",
					"PATH" => "",
					"SITE_ID" => "s1"
				)
			);?>
		<?$ElementParam=array(
			"AJAX_MODE"=>$arParams["AJAX_MODE"],
			"AJAX_MODE"=>"Y",
			"AJAX_OPTION_JUMP"=>$arParams["AJAX_OPTION_JUMP"],
			"AJAX_OPTION_STYLE"=>$arParams["AJAX_OPTION_STYLE"],
			"AJAX_OPTION_HISTORY"=>$arParams["AJAX_OPTION_HISTORY"],
			"AJAX_OPTION_ADDITIONAL"=>$arParams["AJAX_OPTION_ADDITIONAL"],
			"TEST_GROUP"=>$arResult["VARIABLES"]["GROUP_CODE"],
			"TEST_ID"=>$arResult["VARIABLES"]["TEST_CODE"],
			"LIST_PAGE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["group"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["test"],
			"ADD_GROUP_CHAIN"=>$arParams["ADD_GROUP_CHAIN"],
			"SET_TITLE_GROUP"=>$arParams["SET_TITLE_GROUP"],
			"ADD_TEST_CHAIN"=>$arParams["ADD_TEST_CHAIN"],
			"SET_TITLE_TEST"=>$arParams["SET_TITLE_TEST"],
			"PROFILE_DETAIL_URL"=>$arParams["PROFILE_DETAIL_URL"],
			"QUESTIONING_URL" => $arParams["QUESTIONING_URL"],
			);?>
		<?
		if($arParams["SHOW_ALL"]=="Y" || $arResult["VARIABLES"]["GROUP_CODE"]=="0")
			$ElementParam["LIST_PAGE_URL"]=$arResult["FOLDER"];
		?>
		<?$APPLICATION->IncludeComponent(
			"aelita:test.test",
			"template",
			$ElementParam,
			$component
		);?>
	</div>
</section>
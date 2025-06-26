<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Голосование");
?>

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
			); ?>
		<div class="columns mb-50 mbm-30">
			<div class="columns__col columns__col--12">
				<h2 class="title">
					Голосование
				</h2>
			</div>
		</div>
		<?$APPLICATION->IncludeComponent(
			"bitrix:voting.list",
			"template",
			Array(
				"CHANNEL_SID" => array("VOTING"),
				"VOTE_FORM_TEMPLATE" => "vote_detail.php?VOTE_ID=#VOTE_ID#",
				"VOTE_RESULT_TEMPLATE" => "vote_detail.php?VOTE_ID=#VOTE_ID#&RESULT=TRUE"
			)
		);?>
	</div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->AddChainItem($arResult["TEST"]["NAME"]);?>
<div class="columns mb-20 mbm-30">
	<div class="columns__col columns__col--12">
		<h3 class="title">
			<?=$arResult["TEST"]["NAME"]?>
		</h3>
	</div>
</div>
<div class="test">
<?if (count($arResult["ERROR"])):?>
	<?=ShowError(implode("<br />", $arResult["ERROR"]))?>
<?endif?>
	<?if(is_array($arResult["TEST"]["PICTURE"])):?>
		<img class="detail_picture" border="0" src="<?=$arResult["TEST"]["PICTURE"]["SRC"]?>" width="<?=$arResult["TEST"]["PICTURE"]["WIDTH"]?>" height="<?=$arResult["TEST"]["PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["TEST"]["NAME"]?>"  title="<?=$arResult["TEST"]["NAME"]?>" />
	<?endif?>
	<picture class="article-card__picture">
		<?=$arResult["TEST"]["TO_TITLE"]?>
	</picture>
	<p class="mb-20"><?echo $arResult["TEST"]["DESCRIPTION"];?></p>
	<form action="<?=POST_FORM_ACTION_URI?>?testaction=Y" method="post" enctype="multipart/form-data">
		<input type="hidden" name="initquestioning" value="Y">
		<input type="submit" name="testsubmit" class="voting-post__tag" value="<?echo GetMessage("INIT_QUESTIONING")?>">
	</form>
</div>
<? // изменить на >0, если нужно отобразить ссылку назад ?>
<?if(strlen($arParams["LIST_PAGE_URL"])<0){?>
	<div class="list_page">
		<a href="<?=$arParams["LIST_PAGE_URL"]?>"><?=GetMessage("LIST_PAGE")?></a>
	</div>
<?}?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["QUESTIONING"]){?>

    <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>

    <?
    if(is_array($arResult["QUESTIONING"]["RESULT_PICTURE"])){
        $APPLICATION->SetPageProperty("og:image", "http://".$_SERVER["HTTP_HOST"].AelitaTestTools::encodeURI($arResult["QUESTIONING"]["RESULT_PICTURE"]["SRC"]));
    }
    $APPLICATION->SetPageProperty("og:title", $arResult["TEST"]["NAME"]);
    $APPLICATION->SetPageProperty("og:description", str_replace(array("'"), '"',HTMLToTxt(
        $arResult["QUESTIONING"]["~RESULT_DESCRIPTION"],
        "",
        array(),
        false
    )));
    ?>


    <script>

        new Ya.share({
            element: 'ya_share',
            elementStyle: {
                'type': 'icon ',
                'border': false,
                'quickServices': ['vkontakte', 'odnoklassniki']
            }
            ,link: window.location.origin+'<?=$arResult["QUESTIONING"]["DETAIL_URL"]?>'
            ,title: '<?=$arResult["TEST"]["NAME"]?>'
            ,description: '<?= TruncateText(str_replace(array("'","\r\n","\r","\n"), ' ',HTMLToTxt(
                $arResult["QUESTIONING"]["~RESULT_DESCRIPTION"],
                "",
                array(),
                false
            )),600);?>'
            <?if(is_array($arResult["QUESTIONING"]["RESULT_PICTURE"])){?>
            ,image: 'http://<?=$_SERVER["HTTP_HOST"]?><?=$arResult["QUESTIONING"]["RESULT_PICTURE"]["SRC"]?>'
            <?}?>
        });
    </script>


<div class="container">
	<div class="toolbar toolbar--mob-block mb-30 mbm-30">
		<h2 class="title mbm-15"><?=$arResult["TEST"]["NAME"]?></h2>
	</div>
	<div class="test editor">
		<div class="editor editor--24"><p><?echo $arResult["QUESTIONING"]["~RESULT_DESCRIPTION"];?></p></div>

		<?if($arResult["QUESTIONING"]["RESULT_NAME"]){?>
			<div class="test_item_maximum_points"><b><?=GetMessage("RESULT_NAME")?>: <?=$arResult["QUESTIONING"]["RESULT_NAME"];?></b></div>
		<?}?>
		<div class="test_item_maximum_points"><b><?=GetMessage("MAXIMUM_POINTS")?>: <?=$arResult["QUESTIONING"]["SCORES"];?> из <?=count($arResult["ITEMS"])?></b></div>
		<?if(is_array($arResult["QUESTIONING"]["RESULT_PICTURE"])):?>
			<img class="detail_picture" border="0" src="<?=$arResult["QUESTIONING"]["RESULT_PICTURE"]["SRC"]?>" width="<?=$arResult["QUESTIONING"]["RESULT_PICTURE"]["WIDTH"]?>" height="<?=$arResult["QUESTIONING"]["RESULT_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["QUESTIONING"]["RESULT_PICTURE"]["ALT"]?>"  title="<?=$arResult["TEST"]["NAME"]?>" />
		<?endif?>

		<div class="editor pt-20">Поделиться в социальных сетях: <span id="ya_share"></span></div>
	</div>
<?}?>
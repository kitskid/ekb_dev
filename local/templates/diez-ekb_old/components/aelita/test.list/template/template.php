<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? // var_dump($arResult["ITEMS"]);?>
<section class="section bg-white pt-100 pb-100 ptm-80 pbm-40">
	<div class="container">
		<div class="columns">
		<?if(count($arResult["ITEMS"])>0){?>
			<?if($arParams["DISPLAY_TOP_PAGER"]):?>
				<?=$arResult["NAV_STRING"]?><br />
			<?endif;?>
			<?foreach($arResult["ITEMS"] as $item){?>
				<div class="columns__col columns__col--4 mbm-20">
					<a class="article-card" href="<?= $item["DETAIL_URL"] ?>">
						<picture class="article-card__picture">
                        	<?=$item["TO_TITLE"]?>
                        </picture>
						<div class="article-event__content">
							<div class="article-event__main">
								<h3 class="article-event__title">
									<?= $item["NAME"] ?>
								</h3>
								<p><?= $item["DESCRIPTION"]?></p>
							</div>
						</div>
					</a>
				</div>
			<?}?>
		
		<?}else{?>
			<div class="test_item">
				<?=GetMessage("NO_TEST")?>
			</div>
		<?}?>
		<?if($arResult["GROUP"] && $arParams["MAIN_PAGE_URL"]){?>
			<div class="test_item_link">
				<a href="<?=$arParams["MAIN_PAGE_URL"]?>" title="<?=GetMessage("MAIN_URL")?>"><?=GetMessage("MAIN_URL")?></a>
			</div>
		<?}?>
		</div>
	</div>
</section>
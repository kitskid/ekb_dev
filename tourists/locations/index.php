<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Туристические маршруты");
?><? $APPLICATION->IncludeComponent(
	"bitrix:news",
	"locations",
	[
		"ADD_ELEMENT_CHAIN"               => "Y",
		"ADD_SECTIONS_CHAIN"              => "Y",
		"AJAX_MODE"                       => "N",
		"AJAX_OPTION_ADDITIONAL"          => "",
		"AJAX_OPTION_HISTORY"             => "N",
		"AJAX_OPTION_JUMP"                => "N",
		"AJAX_OPTION_STYLE"               => "Y",
		"BROWSER_TITLE"                   => "-",
		"CACHE_FILTER"                    => "N",
		"CACHE_GROUPS"                    => "Y",
		"CACHE_TIME"                      => "36000000",
		"CACHE_TYPE"                      => "A",
		"CHECK_DATES"                     => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT"       => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER"     => "Y",
		"DETAIL_DISPLAY_TOP_PAGER"        => "N",
		"DETAIL_FIELD_CODE"               => [
			"",
			""
		],
		"DETAIL_PAGER_SHOW_ALL"           => "Y",
		"DETAIL_PAGER_TEMPLATE"           => "",
		"DETAIL_PAGER_TITLE"              => "Страница",
		"DETAIL_PROPERTY_CODE"            => [
			"COLOR",
			"LOCATION",
			"PHONE",
			"TIME",
			"ADDRESS"
		],
		"DETAIL_SET_CANONICAL_URL"        => "N",
		"DISPLAY_BOTTOM_PAGER"            => "Y",
		"DISPLAY_DATE"                    => "N",
		"DISPLAY_NAME"                    => "N",
		"DISPLAY_PICTURE"                 => "Y",
		"DISPLAY_PREVIEW_TEXT"            => "Y",
		"DISPLAY_TOP_PAGER"               => "N",
		"FILE_404"                        => "",
		"FILTER_FIELD_CODE"               => [
			0 => "",
			1 => "",
		],
		"FILTER_NAME"                     => "",
		"FILTER_PROPERTY_CODE"            => [
			0 => "",
			1 => "",
		],
		"HIDE_LINK_WHEN_NO_DETAIL"        => "N",
		"IBLOCK_ID"                       => "20",
		"IBLOCK_TYPE"                     => "",
		"INCLUDE_IBLOCK_INTO_CHAIN"       => "N",
		"LIST_ACTIVE_DATE_FORMAT"         => "d.m.Y",
		"LIST_FIELD_CODE"                 => [
			"",
			""
		],
		"LIST_PROPERTY_CODE"              => [
			"",
			""
		],
		"MESSAGE_404"                     => "",
		"META_DESCRIPTION"                => "-",
		"META_KEYWORDS"                   => "-",
		"NEWS_COUNT"                      => "",
		"PAGER_BASE_LINK_ENABLE"          => "N",
		"PAGER_DESC_NUMBERING"            => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL"                  => "Y",
		"PAGER_SHOW_ALWAYS"               => "N",
		"PAGER_TEMPLATE"                  => "showmore.pagination",
		"PAGER_TITLE"                     => "",
		"PREVIEW_TRUNCATE_LEN"            => "200",
		"SEF_FOLDER"                      => "/tourists/locations/",
		"SEF_MODE"                        => "Y",
		"SEF_URL_TEMPLATES"               => [
			"detail"  => "#SECTION_CODE#/#ELEMENT_CODE#/",
			"news"    => "/tourists/locations/",
			"section" => ""
		],
		"SET_LAST_MODIFIED"               => "N",
		"SET_STATUS_404"                  => "N",
		"SET_TITLE"                       => "N",
		"SHOW_404"                        => "N",
		"SORT_BY1"                        => "SORT",
		"SORT_BY2"                        => "SORT",
		"SORT_ORDER1"                     => "ASC",
		"SORT_ORDER2"                     => "ASC",
		"STRICT_SECTION_CHECK"            => "N",
		"USE_CATEGORIES"                  => "N",
		"USE_FILTER"                      => "N",
		"USE_PERMISSIONS"                 => "N",
		"USE_RATING"                      => "N",
		"USE_REVIEW"                      => "N",
		"USE_RSS"                         => "N",
		"USE_SEARCH"                      => "N",
		"USE_SHARE"                       => "N"
	]
); ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");

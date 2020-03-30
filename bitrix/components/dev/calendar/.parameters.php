<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

$arSorts = [
	"ASC" => GetMessage("T_IBLOCK_DESC_ASC"),
	"DESC" => GetMessage("T_IBLOCK_DESC_DESC")
];
$arSortFields = [
	"ID" => GetMessage("T_IBLOCK_DESC_FID"),
	"NAME" => GetMessage("T_IBLOCK_DESC_FNAME"),
	"ACTIVE_FROM" => GetMessage("T_IBLOCK_DESC_FACT"),
	"SORT" => GetMessage("T_IBLOCK_DESC_FSORT"),
	"TIMESTAMP_X" => GetMessage("T_IBLOCK_DESC_FTSAMP")
];
$arComponentParameters = [
	"GROUPS" => [],
	"PARAMETERS" => [
		"TITLE" => [
			"PARENT" => "BASE",
			"NAME" => GetMessage("CP_BNL_SET_TITLE"),
			"TYPE" => "STRING"
		],
		"CACHE_TIME" => ["DEFAULT" => 36000000],
		"CACHE_FILTER" => [
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("IBLOCK_CACHE_FILTER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		],
		"CACHE_GROUPS" => [
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		],
	],
];
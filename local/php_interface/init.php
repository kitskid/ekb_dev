<?php

AddEventHandler("main", "OnEndBufferContent", "removeType");

function removeType(&$content)
{
	$content = replaceTextJavascript($content);
	$content = replaceCharsetUTF($content);
}

function replaceTextJavascript($d)
{
	return str_replace(' type="text/javascript"', "", $d);
}

function replaceCharsetUTF($d)
{
	return str_replace('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />', "", $d);
}
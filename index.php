<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php

$handle = pspell_new("de","","","utf-8",PSPELL_NORMAL );

$word = "Gemus";

if(pspell_check($handle,$word))
{
	echo "das wort ist gültig";
}
else 
{
	echo "ungültig";
	echo "vorschläge";	
	print_r(pspell_suggest($handle,$word));
}
?>
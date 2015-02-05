<?php

	function getHelp($id) {
		global $lang;
		echo '<img src="images/icon-help.png" alt="(Aide)" onclick="alert(\'' . $lang['fr'][$id] . '\');" />';
	}

	$lang = Array('fr' => Array());

	$lang['fr'][0] = 'Veuillez indiquer le nom d\&#39;utilisateur du compte d\&#39;administration.';
	$lang['fr'][1] = 'Veuillez indiquer le mot de passe du compte d\&#39;administration.';
	$lang['fr'][2] = '';
	$lang['fr'][3] = '';
	$lang['fr'][4] = '';
	$lang['fr'][5] = '';
	$lang['fr'][6] = '';
?>

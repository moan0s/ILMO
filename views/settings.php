<?php
$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
$form .='
<input type = hidden name="ac" value = "settings_save">';
foreach($this->settings['lang'] as $lang=>$aTexts) {
	$form.="<p><strong>".$lang."</strong><br>";
	foreach($aTexts as $key=>$val) {
		$form .= $key.': <input type=text name="'.$lang."_".$key.'" value="'.$val.'"><br>';
	}
	echo"</p>";
}


$form .= '
<input type="submit" value="'.$this->oLang->texts['BUTTON_SEND'].'">
</form>';
echo $form;
?>

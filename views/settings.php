<?php
$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
$form .='
<input type = hidden name="ac" value = "settings_save">';
$form .= 'Show library status: <input type="radio" id="yes" name="enable_status" value="1" ';
if ($this->settings['enable_status']==1){
	$form .= 'checked';
}
$form .='>
<label for="yes">'.$this->oLang->texts['YES'].'</label>
<input type="radio" id="no" name="enable_status" value="0" ';
if ($this->settings['enable_status']==0){
	$form .= 'checked';
}
$form .= '>
<label for id ="no"> '.$this->oLang->texts['NO'].'</label><br>';

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

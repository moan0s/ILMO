<?php
$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
$form .='
<input type = hidden name="ac" value = "settings_save">';
$form .= 'Debug: <input type="radio" id="yes" name="debug" value="1"';
if (DEBUG==1){
	$form .= 'checked';
}
$form .='>
<label for="yes">'.$this->oLang->texts['YES'].'</label>
<input type="radio" id="no" name="debug" value="0"';
if (DEBUG==0){
	$form .= 'checked';
}
$form .= '>
<label for id ="no"> '.$this->oLang->texts['NO'].'</label><br>';

$form .= '
<input type="submit" value="'.$this->oLang->texts['BUTTON_SEND'].'">
</form>';
echo $form;
?>

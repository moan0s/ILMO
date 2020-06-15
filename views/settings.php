<?php
$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
$form .='
<input type = hidden name="ac" value = "user_save">';
if (($_SESSION['admin']==1) and ($this->r_ac != 'user_settings')){
	$form .= $this->oLang->texts['ADMIN'].': <input type="radio" id="yes" name="admin" value="1"';
	if ($this->aRow['admin']==1){
		$form .= 'checked';
	}
	$form .='>
	<label for="yes">'.$this->oLang->texts['YES'].'</label>
	<input type="radio" id="no" name="admin" value="0"'; 
	if ($this->aRow['admin']==0){
		$form .= 'checked';
	}
	$form .= '>
	<label for id ="no"> '.$this->oLang->texts['NO'].'</label><br>'; 
}
$form .= '
<input type="submit" value="'.$this->oLang->texts['BUTTON_SEND'].'">
<input type="reset" value="'.$this->oLang->texts['BUTTON_RESET'].'">
</form>';
echo $form;
?>

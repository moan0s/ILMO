<?php
$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
	<input type = hidden name="ac" value = "presence_save">
	<input type = hidden name="presence_ID" value = "';
	if(isset($this->r_presence_ID))
	{
		$form .= $this->r_presence_ID;
	} 
	$form .= '">'.

		$lang['UID'].': <input type="text" name="UID" value="'; 
	if(isset($this->aRow['UID'])){
		$form .= $this->aRow['UID'];
	} 
	$form .='"><br>'.
		$lang['CHECKIN_AT'].': <input type="text" name="checkin_time" value="';
	if(isset($this->aRow['checkin_time'])){
		$form .= $this->aRow['checkin_time'];
	}
	$form .= '"> <br>'.
		$lang['CHECKOUT_AT'].': <input type="text" name="checkout_time" value="';
	if(isset($this->aRow['checkout_time'])){
		$form .= $this->aRow['checkout_time'];
	}
	$form .= '"> <br>';
	$form .= '
	<input type="submit" value="'.$lang['BUTTON_SEND'].'">
	<input type="reset" value="'.$lang['BUTTON_RESET'].'">
	</form>';
echo $form;
?>

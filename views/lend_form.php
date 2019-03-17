<?php
$form .= '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
	<input type = hidden name="ac" value = "lend_save">
	'.$lang['USER_ID'].': <input type="text" name="user_ID" value="'; 
if(isset($this->aRow['user_ID'])){
	$form .= $this->aRow['user_ID'];
} 
$form .= '"> <br>'.
	$lang['TYPE'].': <input type="radio" id="book" name="type" value="book"';
if ($this->aRow['type']== "book"){
	 $form .= 'checked';
}
$form .= '>
	<label for="book">'.$lang['BOOK'].'</label>
	<input type="radio" id="stuff" name="type" value="stuff"'; 
if ($this->aRow['type']=="stuff"){
	$form .= 'checked';
}
$form .= '>
	<label for id ="stuff">'.$lang['MATERIAL'].'</label><br>'.	
	$lang['ID'].': <input type="text" name="ID" value="';
if(isset($this->aRow['ID'])){
	$form .= $this->aRow['ID'];
}
$form .= '"> <br>'.
	$lang['LENT_ON'].': <input type="text" name="pickup_date" value="';
if ((isset($this->aRow['pickup_date']){
	 $form .= $this->aRow['pickup_date'];
}
$form .= '"> <br>'.
	$lang['RETURNED_ON'].': <input type="text" name="return_date" value="';
if ((isset($this->aRow['return_date']){
	 $form .= $this->aRow['return_date'];
}
$form .= '"> <br>
		<input type="submit" value="'.$lang['BUTTON_SEND'].'">
		<input type="reset" value="'.$lang['BUTTON_RESET'].'">	
</form>';
echo $form;



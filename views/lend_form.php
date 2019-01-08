<?php
$form .= '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
	<input type = hidden name="ac" value = "lend_save">
	'.USER_ID.': <input type="text" name="user_ID" value="'; 
if(isset($this->aRow['user_ID'])){
	$form .= $oObject->aRow['user_ID'];
} 
$form .= '"> <br>'.
	TYPE.': <input type="radio" id="book" name="type" value="book"';
if ($this->aRow['type']== "book"){
	 $form .= 'checked';
}
$form .= '>
	<label for="book">'.BOOK.'</label>
	<input type="radio" id="stuff" name="type" value="stuff"'; 
if ($this->aRow['type']=="stuff"){
	$form .= 'checked';
}
$form .= '>
	<label for id ="stuff">'.MATERIAL.'</label><br>'.	
	ID.': <input type="text" name="ID" value="';
if(isset($this->aRow['ID'])){
	$form .= $oObject->aRow['ID'];
} 
$form .= '"> <br>
		<input type="submit" value="'.BUTTON_SEND.'">
		<input type="reset" value="'.BUTTON_RESET.'">	
</form>';
echo $form;



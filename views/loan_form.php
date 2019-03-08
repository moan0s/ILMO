<?php
$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
	<input type = hidden name="ac" value = "loan_save">
	';
$form .= 
	USER_ID.': <input type="text" name="user_ID" value="'; 
if(isset($this->aLoan['user_ID'])){
	$form .= $this->aLoan['user_ID'];
} 
$form .= '"> <br>'.
	TYPE.': <input type="radio" id="book" name="type" value="book"';
if ($this->aLoan['type']== "book"){
	 $form .= 'checked';
}
$form .= '>
	<label for="book">'.BOOK.'</label>
	<input type="radio" id="material" name="type" value="material"'; 
if ($this->aLoan['type']=="material"){
	$form .= 'checked';
}
$form .= '>
	<label for id ="material">'.MATERIAL.'</label><br>'.	
	ID.': <input type="text" name="ID" value="';
if(isset($this->aLoan['ID'])){
	$form .= $this->aLoan['ID'];
} 
$form .=  '"> <br>'.
	LENT_ON.': <input type="text" name="pickup_date" value="'; 
if(isset($this->aLoan['pickup_date'])){
	$form .= $this->aLoan['pickup_date'];
} 
$form .=  '"> <br>'.
	RETURNED_ON.': <input type="text" name="return_date" value="'; 
if(isset($this->aLoan['return_date'])){
	$form .= $this->aLoan['return_date'];
} 
$form .= '"> <br>
		<input type="submit" value="'.BUTTON_SEND.'">
		<input type="reset" value="'.BUTTON_RESET.'">	
</form>';
echo $form;



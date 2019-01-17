<?php
$form .='
	<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
	<input type = hidden name="ac" value = "user_show">'.
	USER_ID .': <input type="text" name="user_ID" value="'; 
if(isset($oObject->aRow['user_ID'])){
	$form .= $oObject->aRow['user_ID'];
} 
$form .= '"> <br>
	'.FORENAME.': <input type="text" name="forename" value="';
if(isset($oObject->aRow['forename'])){
	$form .= $oObject->aRow['forename'];
}
$form .= '"><br>
	'.SURNAME.'<input type="text" name="surname" value="';
if(isset($oObject->aRow['surname'])){
	$form .= $oObject->aRow['surname'];
}
$form .= '"> <br>'.
	EMAIL.': <input type="text" name="email" value="';
if(isset($oObject->aRow['email'])){
	$form .= $oObject->aRow['email'];
}
$form .= '"> <br>'.
	UID.': <input type="text" name="UID" value="';
if(isset($oObject->aRow['UID'])){
	$form .= $oObject->aRow['UID'];
}
$form .= '"> <br>
		<input type="submit" value="'.BUTTON_SEARCH.'">
		<input type="reset" value="'.BUTTON_RESET.'">	
</form>';
echo $form;



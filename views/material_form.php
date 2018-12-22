<?php
$form .= '<form action="'.$_SERVER["PHP_SELF"].'" method="post">
	<input type = hidden name="ac" value = "material_save">
	'.MATERIAL_ID.': <input type="text" name="material_ID" value="'; 
if(isset($oObject->aRow['material_ID'])){
	$form .= ': '.$oObject->aRow['material_ID'];
} 
$form .= '"> <br>';

if(!isset($oObject->aRow['material_ID'])){
	$form .= NUMBER.': <input type=\"text\" name="number"> <br>';
		}
$form .= NAME.' : <input type="text" name="name" value=';
if(isset($oObject->aRow['name'])){
	$form .= $oObject->aRow['name'];
} 
$form .= '><br>'.
	LOCATION.': <input type="text" name="location" value=';
if(isset($oObject->aRow['location'])){
	$form .= $oObject->aRow['location'];
}
$form .= '> <br>
		<input type="submit" value='.BUTTON_SEND.'>
		<input type="reset" value='.BUTTON_RESET.'>	
</form>';
echo $form;
?>


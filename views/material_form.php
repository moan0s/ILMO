<?php
$form .= '<form action="'.$_SERVER["PHP_SELF"].'" method="post">
	<input type = hidden name="ac" value = "material_save">
	'.$lang['MATERIAL_ID'].': <input type="text" name="material_ID" value="'; 
if(isset($this->aRow['material_ID'])){
	$form .= $this->aRow['material_ID'];
} 
$form .= '"> <br>';

if(!isset($this->aRow['material_ID'])){
	$form .= $lang['NUMBER'].': <input type=\"text\" name="number"> <br>';
		}
$form .= $lang['NAME'].' : <input type="text" name="name" value=';
if(isset($this->aRow['name'])){
	$form .= $this->aRow['name'];
} 
$form .= '><br>'.
	$lang['LOCATION'].': <input type="text" name="location" value=';
if(isset($this->aRow['location'])){
	$form .= $this->aRow['location'];
}
$form .= '> <br>
		<input type="submit" value='.$lang['BUTTON_SEND'].'>
		<input type="reset" value='.$lang['BUTTON_RESET'].'>	
</form>';
echo $form;
?>


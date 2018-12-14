<?php
$form .= '<form action="'.$_SERVER["PHP_SELF"].'" method="post">
	<input type = hidden name="ac" value = "book_save">'.
	BOOK_ID.': <input type="text" name="book_ID" value="';
if(isset($oObject->aRow['book_ID']))
{
	$form .= $oObject->aRow['book_ID'];
}
$form .= '"> <br>';
if(!isset($oObject->aRow['book_ID'])){		
	$form .= 
		NUMBER.': <input type="text" name="number"> <br>';
}
$form .= TITLE.': <input type="text" name="title" value="';
if(isset($oObject->aRow['title'])){
	$form .= $oObject->aRow['title'];
} 
$form .= '"><br>'.
	AUTHOR.': <input type="text" name="author" value="';
if(isset($oObject->aRow['author'])){
	$form .= $oObject->aRow['author'];
} 
$form .= '"> <br>';
$form .= LOCATION.': <input type="text" name="location" value="'; 
if(isset($oObject->aRow['location'])){
	$form .= $oObject->aRow['location'];
}

$form .= '"> <br>
		<input type="submit" value="'.BUTTON_SEND.'">
		<input type="reset" value="'.BUTTON_RESET.'">	
</form>';
echo $form;
?>



	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	<input type = hidden name="ac" value = "stuff_save">
	Material-ID: <input type="text" name="stuff_ID" value="<?php if(isset($oObject->aRow['stuff_ID'])){echo $oObject->aRow['stuff_ID'];} ?>"> <br>
	<?php
		if(!isset($oObject->aRow['stuff_ID'])){		
			echo "Anzahl: <input type=\"text\" name=\"number\"> <br>";
		}
	 echo '
		Name: <input type="text" name="name" value=';
		if(isset($oObject->aRow['name'])){
			echo $oObject->aRow['name'];
		} 
	echo '><br>
		Standort: <input type="text" name="location" value=';
		if(isset($oObject->aRow['location'])){
			echo $oObject->aRow['location'];
		}
	echo '> <br>
		<input type="submit" value='.SEND.'>
		<input type="reset" value='.RESET.'>	
</form>';
?>


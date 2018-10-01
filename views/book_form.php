

	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	<input type = hidden name="ac" value = "book_save">
	Buch-ID: <input type="text" name="book_ID" value="<?php if(isset($oObject->aRow['book_ID'])){echo $oObject->aRow['book_ID'];} ?>"> <br>
	<?php
		if(!isset($oObject->aRow['book_ID'])){		
			echo "Anzahl: <input type=\"text\" name=\"number\"> <br>";
		}
	 ?>
		Titel: <input type="text" name="title" value="<?php if(isset($oObject->aRow['title'])){echo $oObject->aRow['title'];} ?>"><br>
		Autor: <input type="text" name="author" value="<?php if(isset($oObject->aRow['author'])){echo $oObject->aRow['author'];} ?>"> <br>
		Standort: <input type="text" name="location" value="<?php if(isset($oObject->aRow['location'])){echo $oObject->aRow['location'];}?>"> <br>
		<input type="submit" value="absenden">
		<input type="reset" value="Zurücksetzen">	
</form>


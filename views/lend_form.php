<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type = hidden name="ac" value = "lend_save">
	Benutzer-ID: <input type="text" name="user_ID" value="<?php if(isset($this->aRow['user_ID'])){echo $oObject->aRow['user_ID'];} ?>"> <br>
	Buch-ID: <input type="text" name="book_ID" value="<?php if(isset($this->aRow['book_ID'])){echo $oObject->aRow['book_ID'];} ?>"> <br>
		<input type="submit" value="absenden">
		<input type="reset" value="Zurücksetzen">	
</form>



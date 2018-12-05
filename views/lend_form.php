<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type = hidden name="ac" value = "lend_save">
	Benutzer-ID: <input type="text" name="user_ID" value="<?php if(isset($this->aRow['user_ID'])){echo $oObject->aRow['user_ID'];} ?>"> <br>
	<?php 
	echo '
		Admin: 
		<input type="radio" id="book" name="type" value="book"';
	if ($this->aRow['type']== "book"){echo'checked';}
	echo '>
	<label for="book">'.BOOK.'</label>
	<input type="radio" id="stuff" name="type" value="stuff"'; 
if ($this->aRow['type']=="stuff"){echo'checked';}
	echo '>
	<label for id ="stuff">'.MATERIAL.'</label><br>'; 
	?>	
	ID: <input type="text" name="ID" value="<?php if(isset($this->aRow['ID'])){echo $oObject->aRow['ID'];} ?>"> <br>
		<input type="submit" value="absenden">
		<input type="reset" value="Zurücksetzen">	
</form>



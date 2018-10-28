	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type = hidden name="ac" value = "user_save">
	<input type = hidden name="user_ID" value = "<?php if(isset($this->r_user_ID)){echo $this->r_user_ID;}  ?>">
	Vorname: <input type="text" name="forename" value="<?php if(isset($this->aRow['forename'])){echo $this->aRow['forename'];} ?>"><br>
	Nachname: <input type="text" name="surname" value="<?php if(isset($this->aRow['surname'])){echo $this->aRow['surname'];} ?>"> <br>
	E-Mail Adresse: <input type="text" name="email" value="<?php if(isset($this->aRow['email'])){echo $this->aRow['email'];}?>"> <br>
	Passwort: <input type="password" name="password"  ?><br>
<?php 
	if ($_SESSION['admin']==1){
	echo '
		Admin: 
		<input type="radio" id="yes" name="admin" value="1"';
	if ($this->aRow['admin']==1){echo'checked';}
	echo '>
	<label for="yes"> Ja</label>
	<input type="radio" id="no" name="admin" value="0"'; 
if ($this->aRow['admin']==0){echo'checked';}
	echo '>
	<label for id ="no"> Nein</label><br>'; 
	}?>	
	<input type="submit" value="absenden">
	<input type="reset" value="Zurücksetzen";
</form>



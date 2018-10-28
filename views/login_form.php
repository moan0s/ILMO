<br><h1>Melde dich bitte an:</h1><br>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<input type = hidden name="ac" value = "strt"> 

			<label for ="user_info"> Benutzer-ID oder E-Mail-Adresse: </label><br>
			<input id="user_info" type="text" name="login_user_info"><br><br>
			<label for ="pw"> Passwort: </label><br>
			<input id="pw" type="password" name="login_password"><br>
			<input type="submit" value="absenden">
			<input type="reset" value="Zurücksetzen">	
</form>



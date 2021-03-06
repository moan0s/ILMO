<?php
$login = '
<br><h1>'.$this->oLang->texts['GIVE_VALID_E_MAIL_ADRESS'].' :</h1><br>

	<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
			<input type = hidden name="ac" value = "request_token">

			<label for ="email">'.$this->oLang->texts['EMAIL'].': </label><br>
			<input id="email" type="text" name="email"><br><br>
			<input type="submit" value="'.$this->oLang->texts['BUTTON_SEND'].'">
</form>';

echo $login;

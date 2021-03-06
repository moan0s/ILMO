<?php
$login = '
<br><h1>'.$this->oLang->texts['PLEASE_LOG_IN'].' :</h1><br>

	<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
			<input type = hidden name="ac" value = "login">

			<label for ="user_info">'.$this->oLang->texts['USER_ID_OR_EMAIL'].': </label><br>
			<input id="user_info" type="text" name="login_user_info"><br><br>
			<label for ="pw"> '.$this->oLang->texts['PASSWORD'].' </label><br>
			<input id="pw" type="password" name="login_password"><br>
			<input type="submit" value="'.$this->oLang->texts['BUTTON_SEND'].'">
			<input type="reset" value="'.$this->oLang->texts['BUTTON_RESET'].'">
</form>';

echo $login;

$forgot_password = "<a href='".$_SERVER["PHP_SELF"]."?ac=forgot_password'>".$this->oLang->texts['FORGOT_PASSWORD']."</a>";
echo $forgot_password;

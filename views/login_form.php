<?php
$login .= '
<br><h1>'.PLEASE_LOG_IN.' :</h1><br>

	<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
			<input type = hidden name="ac" value = "strt"> 

			<label for ="user_info">'.USER_ID_OR_EMAIL.': </label><br>
			<input id="user_info" type="text" name="login_user_info"><br><br>
			<label for ="pw"> '.PASSWORD.' </label><br>
			<input id="pw" type="password" name="login_password"><br>
			<input type="submit" value="'.BUTTON_SEND.'">
			<input type="reset" value="'.BUTTON_RESET.'">	
</form>';
echo $login;




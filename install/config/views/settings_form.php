<?php
$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';

	$form .='
	<input type = hidden name="ac" value = "config_save">
	Database user: <input type="text" name="db_user" value=""><br>
	Password: <input type="password" name="db_password" value=""> <br>
	Database name: <input type="text" name="db_databasename" value=""><br>
	Table prefix: <input type="text" name="table_prefix" value=""><br>
	Debug mode: <input type="radio" id="on" name="debug_mode" value=True
					<label for="on">On</label>
					<input type="radio" id="no" name="debug_mode" value=False checked>
					<label for="no">No</label><br>
	Module path (e.g. "/ILMO"): <input type="text" name="module_path" value=""><br>';
	$form .= '
	<input type="submit" value="Save">
	<input type="reset" value="Reset";
	</form>';
echo $form;
?>



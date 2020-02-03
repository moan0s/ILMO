<?php
$install_instructions = '
	You have successfully linked the database. Now you can create your first user.
	Create an admin so you can manage everything!<br><br>';
echo $install_instructions;
include (MODULE_PATH."views/user_form.php");

?>



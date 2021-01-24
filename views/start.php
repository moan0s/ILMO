<?php
$start = $this->oLang->texts['WELCOME'];
if ($_SESSION['role']==1){
	$start .= $this->oLang->texts['USER_INSTRUCTION'];
}
elseif ($_SESSION['role'] == 2) {
	$start .= $this->oLang->texts['ADMIN_INSTRUCTION'];
}
echo $start;
?>

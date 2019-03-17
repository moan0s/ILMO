<?php
$start = $this->oLang->texts['WELCOME'];
if ($_SESSION['admin']==0){
$start .= $this->oLang->texts['USER_INSTRUCTION'];
}
else{
$start .= $this->oLang->texts['ADMIN_INSTRUCTION'];
}
echo $start;
?>

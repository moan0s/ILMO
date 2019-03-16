<?php
$start = $lang['WELCOME'];
if ($_SESSION['admin']==0){
$start .= $lang['USER_INSTRUCTION'];
}
else{
$start .= $lang['ADMIN_INSTRUCTION'];
}
echo $start;
?>

<?php
$start .= WELCOME;
if ($_SESSION['admin']==0){
$start .= USER_INSTRUCTION;
}
else{
$start .= ADMIN_INSTRUCTION;
}
echo $start;
?>

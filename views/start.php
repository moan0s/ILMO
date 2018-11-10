<?php
echo WELCOME;
if ($_SESSION['admin']==0){
echo USER_INSTRUCTION;
}
else{
echo ADMIN_INSTRUCTION;
}
?>

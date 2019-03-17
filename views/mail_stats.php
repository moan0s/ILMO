<?php
echo 
'<h1>'.$lang['TODAYS_MAIL_STATS'].'</h1><br>'.
$lang['TOTAL_MAILS'].': '.$this->mail_stats['total'].'<br>'.
 $lang['SUCCESSFUL_MAILS'].': '.$this->mail_stats['successful'].'<br>'.
 $lang['FAILED_MAILS'].': '.$this->mail_stats['failed'].'<br>';
?>

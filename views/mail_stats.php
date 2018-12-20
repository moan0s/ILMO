<?php
echo 
'<h1>'.TODAYS_MAIL_STATS.'</h1><br>'.
TOTAL_MAILS.': '.$this->mail_stats['total'].'<br>'.
SUCCESSFUL_MAILS.': '.$this->mail_stats['successful'].'<br>'.
FAILED_MAILS.': '.$this->mail_stats['failed'].'<br>';
?>

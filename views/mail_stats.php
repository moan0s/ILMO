<?php
echo 
'<h1>'.$this->oLang->texts['TODAYS_MAIL_STATS'].'</h1><br>'.
$this->oLang->texts['TOTAL_MAILS'].': '.$this->mail_stats['total'].'<br>'.
 $this->oLang->texts['SUCCESSFUL_MAILS'].': '.$this->mail_stats['successful'].'<br>'.
 $this->oLang->texts['FAILED_MAILS'].': '.$this->mail_stats['failed'].'<br>';
?>

<?php
	echo '<table>
	<th>'.$this->oLang->texts['W_DAY'].'</th>
	<th>'.$this->oLang->texts['W_START'].'</th>
	<th>'.$this->oLang->texts['W_END'].'</th>
	<th>'.$this->oLang->texts['W_NOTICE'].'</th>';
	
	foreach($this->settings['opening_days'] as $day){
		echo '<tr>
			<td>'.$this->oLang->texts[strtoupper($day)].'</td>
			<td>'.$this->aOpen[$day]["start"].'</td>
			<td>'.$this->aOpen[$day]["end"].'</td>
			<td>'.$this->aOpen[$day]["notice"].'</td>
			</tr>';
	}	
echo '</table>';			
echo "<br><strong>".$this->oLang->texts['OPENING_TIMES_INFO']."</strong>";
	?>



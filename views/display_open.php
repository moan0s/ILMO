<?php
	echo '<table>
	<th>'.$lang['W_DAY'].'</th>
	<th>'.$lang['W_START'].'</th>
	<th>'.$lang['W_END'].'</th>
	<th>'.$lang['W_NOTICE'].'</th>';
	
	foreach($this->settings['opening_days'] as $day){
		echo '<tr>
			<td>'.constant(strtoupper($day)).'</td>
			<td>'.$this->aOpen[$day]["start"].'</td>
			<td>'.$this->aOpen[$day]["end"].'</td>
			<td>'.$this->aOpen[$day]["notice"].'</td>
			</tr>';
	}	
echo '</table>';			

	?>



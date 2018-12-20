<?php
	echo '<table>
	<th>'.W_DAY.'</th>
	<th>'.W_START.'</th>
	<th>'.W_END.'</th>
	<th>'.W_NOTICE.'</th>';
	
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



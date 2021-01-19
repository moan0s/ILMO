<?php
	//Creates a table with a width of 200px
	echo '<table class="display_open_small" width = "200">
	<th class="display_open_small">'.$this->oLang->texts['W_DAY'].'</th>
	<th class="display_open_small">'.$this->oLang->texts['W_START'].'</th>
	<th class="display_open_small">'.$this->oLang->texts['W_END'].'</th>
	<th class="display_open_small" min-width="20px"></th>';
	
	foreach($this->settings['opening_days'] as $day){
		echo '<tr class="display_open_small">
			<td class="display_open_small">'.$this->oLang->texts[strtoupper($day.'_short')].'</td>
			<td class="display_open_small">'.$this->aOpen[$day]["start"].'</td>
			<td class="display_open_small">'.$this->aOpen[$day]["end"].'</td>
			<td wrap class="display_open_small">'.$this->aOpen[$day]["notice"].'</td>
			</tr>';
	}	
echo '</table>
	<br>
	<br>
	<strong>'.$this->oLang->texts['HINT'].'</strong>'		

	?>



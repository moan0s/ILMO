<?php
$open_form ='

	<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]);.'" method="post">
	<input type = hidden name="ac" value = "open_save">
 	<table>
	<th>'.W_DAY.'</th>
	<th>'.W_START.'</th>
	<th>'.W_END.'</th>
	<th>'.W_NOTICE.'</th>';
	foreach($this->opening_days as $day){
		$open .= '<tr>
			<td>'.constant(strtoupper($day)).'</td>
			<td><input type="text" name="'.$day.'_s" value="'.$this->aOpen[$day]["start"].'"></td>
			<td><input type="text" name="'.$day.'_e" value="'.$this->aOpen[$day]["end"].'"></td>
			<td><input type="text" name="'.$day.'_n" value="'.$this->aOpen[$day]["notice"].'"></td>
</tr>';
	}	
$open_form .= '</table>
	<input type="submit" value="'.BUTTON_SEND.'">
</form>';
?>



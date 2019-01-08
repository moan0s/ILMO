



<?php
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		'<tr>
		<th>'.STUFF_ID.'</th>
		<th>'.NAME.'</th>
		<th>'.LOCATION.'</th>
		<th>'.STATUS.'</th>';

	$table .='
		<th>'.BUTTON_CHANGE.'</th>
		<th>'.BUTTON_DELETE.'</th>';
	$table .='</tr>';

		
		foreach ($this->aStuff as $stuff_ID => $aResult)
		{
	if($aResult['lent'] == 0){
		$sClass= "available";
		$sStatus= STATUS_AVAILABLE;
	}
	else{
		$sClass = "lent";
		$sStatus = STATUS_LENT;
	}
			$table .=
			'<tr class= "'.$sClass.'">
			<td>'.$aResult['stuff_ID'].'</td>
			<td>'.$aResult['name'].'</td>
			<td>'.$aResult['location'].'</td>
			<td>'.$sStatus;
	
		
			$table .=
				'</td>
			<td> <a href="index.php?ac=stuff_change&stuff_ID='.$aResult['stuff_ID'].'" >'.BUTTON_CHANGE.' </a> </td>
			<td> <a href="index.php?ac=stuff_delete&stuff_ID='.$aResult['stuff_ID'].'" >'.BUTTON_DELETE.'</a> </td>
			</tr>';
		}	
		$table .="</table>";
		echo $table;

	$form = '<form action="'; 
	$form .= htmlspecialchars($_SERVER["PHP_SELF"]); 
	$form.= '" method="post">
	<input type = hidden name="ac" value = "stuff_new">
		<input type="submit" value="'.NEW_STUFF.'">
	</form>';
	echo $form;
?>


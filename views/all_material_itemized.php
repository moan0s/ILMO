



<?php
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		'<tr>
		<th>'.$lang['MATERIAL_ID'].'</th>
		<th>'.$lang['NAME'].'</th>
		<th>'.$lang['LOCATION'].'</th>
		<th>'.$lang['STATUS'].'</th>';

	$table .='
		<th>'.$lang['BUTTON_CHANGE'].'</th>
		<th>'.$lang['BUTTON_DELETE'].'</th>';
	$table .='</tr>';

		
		foreach ($this->aMaterial as $material_ID => $aResult)
		{
	if($aResult['lent'] == 0){
		$sClass= "available";
		$sStatus= $lang['STATUS_AVAILABLE'];
	}
	else{
		$sClass = "lent";
		$sStatus = $lang['STATUS_LENT'];
	}
			$table .=
			'<tr class= "'.$sClass.'">
			<td>'.$aResult['material_ID'].'</td>
			<td>'.$aResult['name'].'</td>
			<td>'.$aResult['location'].'</td>
			<td>'.$sStatus;
	
		
			$table .=
				'</td>
			<td> <a href="index.php?ac=material_change&material_ID='.$aResult['material_ID'].'" >'.$lang['BUTTON_CHANGE'].' </a> </td>
			<td> <a href="index.php?ac=material_delete&material_ID='.$aResult['material_ID'].'" >'.$lang['BUTTON_DELETE'].'</a> </td>
			</tr>';
		}	
		$table .="</table>";
		echo $table;

	$form = '<form action="'; 
	$form .= htmlspecialchars($_SERVER["PHP_SELF"]); 
	$form.= '" method="post">
	<input type = hidden name="ac" value = "material_new">
		<input type="submit" value="'.$lang['NEW_MATERIAL'].'">
	</form>';
	echo $form;
?>


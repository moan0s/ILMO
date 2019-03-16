



<?php
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		"<tr>
		<th>".$lang['BOOK_ID']."</th>
		<th>".$lang['TITLE']."</th>
		<th>".$lang['AUTHOR']."</th>
		<th>".$lang['LOCATION']."</th>
		<th>".$lang['STATUS']."</th>";

	$table .='
		<th>'.$lang['BUTTON_CHANGE'].'</th>
		<th>'.$lang['BUTTON_DELETE'].'</th>
		</tr>';

		
		foreach ($this->aBook as $book_ID => $aResult)
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
			<td>'.$aResult['book_ID'].'</td>
			<td>'.$aResult['title'].'</td>
			<td>'.$aResult['author'].'</td>
			<td>'.$aResult['location'].'</td>
			<td>'.$sStatus.'</td>
			<td> <a href="index.php?ac=book_change&book_ID='.$aResult['book_ID'].'" > '.$lang['BUTTON_CHANGE'].' </a> </td>
			<td> <a href="index.php?ac=book_delete&book_ID='.$aResult['book_ID'].'" > '.$lang['BUTTON_DELETE'].' </a> </td>
			</tr>';
		}	
		
		$table .="</table>";
		echo $table;

	$form = '<form action="'; 
	$form .= htmlspecialchars($_SERVER["PHP_SELF"]); 
	$form.= '" method="post">
	<input type = hidden name="ac" value = "book_new">
		<input type="submit" value="'.$lang['NEW_BOOK'].'">
	</form>';
	echo $form;
?>

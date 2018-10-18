<?php 
$table = "<table border='1'>";
		$table .=
		"<tr>
		<th>Lend-ID</th>
		<th>Ausleihe am</th>
		<th>Rückgabe am</th>
		<th>Buchtitel</th>
		<th>Buch-ID</th>
		<th>Vorname</th>
		<th>Nachname</th>
		<th>User-ID</th>
		</tr>";
		foreach ($oObject->aLend as $lend_ID => $aResult)
		{
			$table .=
			'<tr>
			<td>'.$aResult['lend_ID'].'</td>
			<td>'.$aResult['pickup_date'].'</td>
			<td>';
		if($aResult['return_date'] == 0000-00-00){
			$table .= "Verliehen";
		}
		else{
			$table.= $aResult['pickup_date'];
		}
			$table .= '</td>
			<td>'.$oObject->all_book[$aResult['book_ID']]['title'].'</td>
			<td>'.$aResult['book_ID'].'</td>
			<td>'.$oObject->all_user[$aResult['user_ID']]['forename'].'</td>
			<td>'.$oObject->all_user[$aResult['user_ID']]['surname'].'</td>
			<td>'.$aResult['user_ID'].'</td>';
			$table .=
			'<td> <a href="index.php?ac=lend_change&lend_ID='.$aResult['lend_ID'].'" > Ändern </<> </td>
			<td> <a href="index.php?ac=lend_delete&lend_ID='.$aResult['lend_ID'].'&book_ID='.$aResult['book_ID'].'" > Löschen </<> </td>
			<td> <a href="index.php?ac=lend_return&lend_ID='.$aResult['lend_ID'].'&book_ID='.$aResult['book_ID'].'" > Zurückgeben </<> </td>
		
			</tr>';
		}
		
		$table = $table."</table>";
		echo $table;


?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type = hidden name="ac" value = "lend_new">
		<input type="submit" value="Neue Ausleihe">
	</form>


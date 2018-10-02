<?php 
$table = "<table border='1'>";
		$table .= 
		"<tr>
		<th>Buch_ID</th>
		<th>Titel</th>
		<th>Autor</th>
		<th>Standort</th>
		<th>Status</th>
		<th>Bearbeiten</th>
		<th>Löschen</th>
		</tr>";

		
		foreach ($oObject->aBook as $book_ID => $aResult)
		{
			$table .=
			'<tr>
			<td>'.$aResult['book_ID'].'</td>
			<td>'.$aResult['title'].'</td>
			<td>'.$aResult['author'].'</td>
			<td>'.$aResult['location'].'</td>
			<td>';
if($aResult['lend'] == 0){
	$table .= "Verfügbar";
}
else{
	$table .= "Ausgeliehen";
}
	
		
			$table .=
				'</td>
			<td> <a href="index.php?ac=book_change&book_ID='.$aResult['book_ID'].'" > Ändern </a> </td>
			<td> <a href="index.php?ac=book_delete&book_ID='.$aResult['book_ID'].'" > Löschen </a> </td>
			</tr>';
		}
		
		$table .="</table>";
		echo $table;

?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type = hidden name="ac" value = "book_new">
		<input type="submit" value="Neues Buch">
	</form>



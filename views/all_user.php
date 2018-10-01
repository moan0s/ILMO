<?php 
$table = "<table border='1'>";
		$table .=
		"<tr>
		<th>User-ID</th>
		<th>Vorname</th>
		<th>Nachname</th>
		<th>E-Mail-Adresse</th>
		</tr>";
		
		while ($aResult=mysqli_fetch_assoc($oObject->p_result))
		{
			$table .=
			'<tr>
			<td>'.$aResult['user_ID'].'</td>
			<td>'.$aResult['forename'].'</td>
			<td>'.$aResult['surname'].'</td>
			<td>'.$aResult['email'].'</td>';
			$table .=
			'<td> <a href="index.php?ac=user_change&user_ID='.$aResult['user_ID'].'" > Ändern </<> </td>
			<td> <a href="index.php?ac=user_delete&user_ID='.$aResult['user_ID'].'" > Löschen </<> </td>
			<td> <a href="index.php?ac=lend_show&user_ID='.$aResult['user_ID'].'" > Zeige Ausleihen </<> </td>
			</tr>';
		}
		
		$table = $table."</table>";
		echo $table;


?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type = hidden name="ac" value = "user_new">
		<input type="submit" value="Neuer User">
	</form>



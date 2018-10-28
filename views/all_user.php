<?php 
$table = "<table border='1'>";
		$table .=
		"<tr>
		<th>User-ID</th>
		<th>Vorname</th>
		<th>Nachname</th>
		<th>E-Mail-Adresse</th>
		";

		
if (($_SESSION['admin']==1) or ($this->r_user_ID==$_SESSION['user_ID'])){
	$table .= 
		'<th>Ändern</th>
		<th>Löschen</th>
		<th>Zeige Ausleihen</th>';
}
$table .= '</tr>';
	foreach ($this->aUser as $user_ID => $aResult)
		{
			$table .=
			'<tr>
			<td>'.$aResult['user_ID'].'</td>
			<td>'.$aResult['forename'].'</td>
			<td>'.$aResult['surname'].'</td>
			<td>'.$aResult['email'].'</td>';
			if (($_SESSION['admin']==1) or ($this->r_user_ID==$_SESSION['user_ID'])){
				$table .=
				'<td> <a href="index.php?ac=user_change&user_ID='.$aResult['user_ID'].'" > Ändern </<> </td>
				<td> <a href="index.php?ac=user_delete&user_ID='.$aResult['user_ID'].'" > Löschen </<> </td>
				<td> <a href="index.php?ac=lend_show&user_ID='.$aResult['user_ID'].'" > Zeige Ausleihen </<> </td>';
			}

			$table .= '</tr>';
		}
		
$table = $table."</table>";
echo $table;


if (($_SESSION['admin']==1) or ($this->r_user_ID==$_SESSION['user_ID'])){
	$form =	'
		<form action="<?'.htmlspecialchars($_SERVER["PHP_SELF"]);'" method="post">
	<input type = hidden name="ac" value = "user_new">
		<input type="submit" value="Benutzer*in hinzufügen">
	</form>';
	echo $form;
}

?>


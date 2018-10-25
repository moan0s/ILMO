



<?php
if($oObject->r_ac == "book_show_plain"){
	echo'
	<html>
	<head>
	<meta http-equiv= "Content-Type" content="text/html; charset=utf-8">
	<title>Bücher</title>
	</head>
	<body>';
}
$table = "<table border='1'>";
		$table .= 
		"<tr>
		<th>Buch_ID</th>
		<th>Titel</th>
		<th>Autor</th>
		<th>Standort</th>
		<th>Status</th>";

if ($oObject->r_ac!="book_show_plain"){
	$table .="
		<th>Bearbeiten</th>
		<th>Löschen</th>";}
	$table .="</tr>";

		
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
	
		
if ($oObject->r_ac!="book_show_plain"){
			$table .=
				'</td>
			<td> <a href="index.php?ac=book_change&book_ID='.$aResult['book_ID'].'" > Ändern </a> </td>
			<td> <a href="index.php?ac=book_delete&book_ID='.$aResult['book_ID'].'" > Löschen </a> </td>
			</tr>';
		}
		}	
		$table .="</table>";
		echo $table;

if($oObject->r_ac!="book_show_plain"){	
	$form = '<form action="'; 
	$form .= htmlspecialchars($_SERVER["PHP_SELF"]); 
	$form.= '" method="post">
	<input type = hidden name="ac" value = "book_new">
		<input type="submit" value="Neues Buch">
	</form>';
	echo $form;
}
?>


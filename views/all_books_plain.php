



<?php
/*
if ($this->r_ac=="book_show_plain"
	echo'
	<html>
	<head>
	<meta http-equiv= "Content-Type" content="text/html; charset=utf-8">
	<title>Bücher</title>
	</head>
	<body>';
*/
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		"<tr>
		<th>Titel</th>
		<th>Autor</th>
		<th>Standort</th>
		<th>Verfügbar</th>
		<th>Gesamt</th>";

foreach ($this->aBook as $title => $aResult){
	//var_dump($aResult);
	if($aResult['verfuegbar']==0){
		$sClass = 'lend';
	}
	else{
	$sClass = 'available';
	}
		$table .=
			'<tr class= "'.$sClass.'">
			<td>'.$aResult['title'].'</td>
			<td>'.$aResult['author'].'</td>
			<td>'.$aResult['location'].'</td>
			<td>'.$aResult['verfuegbar'].'</td>
			<td>'.$aResult['anzahl'].'</td>';
}	
		$table .="</table>";
		echo $table;


?>


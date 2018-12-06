



<?php
if($this->r_ac == "book_show_plain"){
	echo'
	<html>
	<head>
	<meta http-equiv= "Content-Type" content="text/html; charset=utf-8">
	<title>Bücher</title>
	</head>
	<body>';
}
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		"<tr>
		<th>".BOOK_ID."</th>
		<th>".TITLE."</th>
		<th>".AUTHOR."</th>
		<th>".LOCATION."</th>
		<th>".STATUS."</th>";

if ($this->r_ac!="book_show_plain"){
	$table .="
		<th>".BUTTON_CHANGE."</th>
		<th>".BUTTON_DELETE."</th>";}
	$table .="</tr>";

		
		foreach ($this->aBook as $book_ID => $aResult)
		{
	if($aResult['lend'] == 0){
		$sClass= "available";
		$sStatus= AVAILABLE;
	}
	else{
		$sClass = "lend";
		$sStatus = LEND;
	}
			$table .=
			'<tr class= "'.$sClass.'">
			<td>'.$aResult['book_ID'].'</td>
			<td>'.$aResult['title'].'</td>
			<td>'.$aResult['author'].'</td>
			<td>'.$aResult['location'].'</td>
			<td>'.$sStatus;
	
		
if ($this->r_ac!="book_show_plain"){
			$table .=
				'</td>
			<td> <a href="index.php?ac=book_change&book_ID='.$aResult['book_ID'].'" > '.BUTTON_CHANGE.' </a> </td>
			<td> <a href="index.php?ac=book_delete&book_ID='.$aResult['book_ID'].'" > '.BUTTON_DELETE.' </a> </td>
			</tr>';
		}
		}	
		$table .="</table>";
		echo $table;

if(($this->r_ac!="book_show_plain") and ($_SESSION['admin'] == 1)){	
	$form = '<form action="'; 
	$form .= htmlspecialchars($_SERVER["PHP_SELF"]); 
	$form.= '" method="post">
	<input type = hidden name="ac" value = "book_new">
		<input type="submit" value="'.NEW_BOOK.'">
	</form>';
	echo $form;
}
?>


<?php
	echo'
	<html>
	<head>
	<meta http-equiv= "Content-Type" content="text/html; charset=utf-8">
	<title>Bücher</title>
	</head>
	<body>';

$table = "<table border='0' cellspacing='0' >";
		$table .= 
		"<tr>
		<th>Buch_ID</th>
		<th>Titel</th>
		<th>Autor</th>
		<th>Standort</th>
		<th>Verfügbar</th>
		<th>Gesamt</th>
		</tr>";

$total = 0;
$available = 0;
$aLastResult = array ('title' => "");
		foreach ($this->aBook as $book_ID => $aResult)
		{
				$total++;
			if (($aResult['title'] == $aLastResult['title']) or ($aLastResult['title'] == "")){
				echo "T".$total;
				
				if ( "" == $this->check_book_lend($aResult['book_ID'])){
					$available++;
					echo "A: ".$available;
				}
			}
			else {
				echo "Neues Buch";
			
				if($available >0){
					$sClass= "available";
				}
				else{
					$sClass = "lend";
				}	
				$table .=
					'<tr class= "'.$sClass.'">
					<td>'.$aLastResult['book_ID'].'</td>
					<td>'.$aLastResult['title'].'</td>
					<td>'.$aLastResult['author'].'</td>
					<td>'.$aLastResult['location'].'</td>
					<td>'.$available.'</td>
					<td>'.$total.'</td>
					</tr>';
				$total =1;
				$available = 0;
			}
			$aLastResult = $aResult;
		}	
			
		$table .="</table>";
		echo $table;

?>


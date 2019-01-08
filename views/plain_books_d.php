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
$aLastResult = array('title' =>"");
	foreach ($this->aBooks as $book_ID => $aResult){    
      if ($aResult['lend']==0){
		   $available++;
		}
		if (isset($aLastResult)){
			if ($aResult['title'] !=  $aLastResult['title']){	
				if($available >0){
					$sClass= "available";
				}
				else{
					$sClass = "lend";
				}
            if($aLastResult["title"]!="") {
				   $table .=
					'<tr class= "'.$sClass.'">
					<td>'.$aLastResult['book_ID'].'</td>
					<td>'.$aLastResult['title'].'</td>
					<td>'.$aLastResult['author'].'</td>
					<td>'.$aLastResult['location'].'</td>
					<td>'.$available.'</td>
					<td>'.$total.'</td>
					</tr>';
            }   
				$total =0;
				$available = 0;

			   }
			}
   	$total++;
		$aLastResult = $aResult;
		}	
		//Und hier fehlt dann noch der letzte Datensatz, denn der fällt da oben nicht ins "if", ist jetzt aber auch fertig
				   $table .=
					'<tr class= "'.$sClass.'">
					<td>'.$aResult['book_ID'].'</td>
					<td>'.$aResult['title'].'</td>
					<td>'.$aResult['author'].'</td>
					<td>'.$aResult['location'].'</td>
					<td>'.$available.'</td>
					<td>'.$total.'</td>
					</tr>';      	
		$table .="</table>";
		echo $table;

?>


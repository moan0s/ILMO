



<?php
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		'<tr>
		<th>'.$this->oLang->texts['TITLE'].'</th>
		<th>'.$this->oLang->texts['AUTHOR'].'</th>
		<th>'.$this->oLang->texts['LOCATION'].'</th>
		<th>'.$this->oLang->texts['STATUS_AVAILABLE'].'</th>
		<th>'.$this->oLang->texts['TOTAL'].'</th>
		</tr>';

foreach ($this->aBook as $title => $aResult){
	//var_dump($aResult);
	if($aResult['available']==0){
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
			<td>'.$aResult['available'].'</td>
			<td>'.$aResult['number'].'</td>';
}	
		$table .="</table>";
		echo $table;


?>


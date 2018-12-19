



<?php
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		'<tr>
		<th>'.TITLE.'</th>
		<th>'.AUTHOR.'</th>
		<th>'.LOCATION.'</th>
		<th>'.STATUS_AVAILABLE.'</th>
		<th>'.TOTAL.'</th>
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


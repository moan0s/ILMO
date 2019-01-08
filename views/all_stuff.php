



<?php
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		"<tr>
		<th>".NAME."</th>
		<th>".LOCATION."</th>
		<th>".STATUS_AVAILABLE."</th>
		<th>".TOTAL."</th>";

foreach ($this->aStuff as $title => $aResult){
	if($aResult['available']==0){
		$sClass = 'lent';
	}
	else{
	$sClass = 'available';
	}
		$table .=
			'<tr class= "'.$sClass.'">
			<td>'.$aResult['name'].'</td>
			<td>'.$aResult['location'].'</td>
			<td>'.$aResult['available'].'</td>
			<td>'.$aResult['number'].'</td>';
}	
		$table .="</table>";
		echo $table;


?>


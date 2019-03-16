



<?php
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		'<tr>
		<th>'.$lang['TITLE'].'</th>
		<th>'.$lang['AUTHOR'].'</th>
		<th>'.$lang['LOCATION'].'</th>
		<th>'.$lang['AVAILABLE'].'</th>
		<th>'.$lang['TOTAL'].'</th>';

foreach ($this->aBook as $title => $aResult){
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


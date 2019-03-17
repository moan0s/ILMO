



<?php
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		"<tr>
		<th>".$this->oLang->texts['NAME']."</th>
		<th>".$this->oLang->texts['LOCATION']."</th>
		<th>".$this->oLang->texts['STATUS_AVAILABLE']."</th>
		<th>".$this->oLang->texts['TOTAL']."</th>";

foreach ($this->aMaterial as $title => $aResult){
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


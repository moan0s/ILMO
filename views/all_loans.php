<?php 
$table = "<table border='1'>";
		$table .=
		'<tr>
		<th>'.LOAN_ID.'</th>
		<th>'.LOAN_ON.'</th>
		<th>'.RETURNED_ON.'</th>
		<th>'.TITLE_MATERIAL.'</th>
		<th>'.ID.'</th>
		<th>'.FORENAME.'</th>
		<th>'.SURNAME.'</th>
		<th>'.USER_ID.'</th>';
if ($_SESSION['admin']==1){
	$table .= '
		<th>'.BUTTON_CHANGE.'</th>
		<th>'.BUTTON_RETURN.'</th>';
}
		$table .= "</tr>";
		foreach ($this->aLoan as $loan_ID => $aResult)
		{
			$table .=
			'<tr>
			<td>'.$aResult['loan_ID'].'</td>
			<td>'.$aResult['pickup_date'].'</td>
			<td>';
		if($aResult['return_date'] == 0000-00-00){
			$table .= STATUS_LENT;
		}
		else{
			$table.= $aResult['return_date'];
		}
			$table .= '</td>
			<td>'.$this->all_book[$aResult['ID']]['title'].$this->all_material[$aResult['ID']]['name'].'</td>
			<td>'.$aResult['ID'].'</td>
			<td>'.$this->all_user[$aResult['user_ID']]['forename'].'</td>
			<td>'.$this->all_user[$aResult['user_ID']]['surname'].'</td>
			<td>'.$aResult['user_ID'].'</td>';
			if($_SESSION['admin']==1){
			$table .=
			'<td> <a href="index.php?ac=loan_change&loan_ID='.$aResult['loan_ID'].'" >'.BUTTON_CHANGE.' </<> </td>
';

			if ($aResult['return_date']==000-00-00){
				$table .='
					<td> <a href="index.php?ac=loan_return&loan_ID='.$aResult["loan_ID"].'&ID='.$aResult["ID"].'" >'.BUTTON_RETURN.' </<> </td>';
			}

			else{
				$table .=' 
					<td>'.ALREADY_RETURNED.'</td>';
			}

			$table .='</tr>';
			}
		}	
		$table = $table."</table>";
		echo $table;

$form .='
	<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
	<input type = hidden name="ac" value = "loan_new">
		<input type="submit" value='.NEW_LOAN.'>
	</form>';
echo $form;
?>


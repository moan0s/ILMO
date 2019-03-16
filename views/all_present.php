<?php 
$table = "<table border='1'>";
		$table .=
		'<tr>
		<th>'.$lang['FORENAME'].'</th>
		<th>'.$lang['SURNAME'].'</th>
		<th>'.$lang['CHECKIN_AT'].'</th>
		<th>'.$lang['CHECKOUT_AT'].'</th>';
if ($_SESSION['admin']==1){
	$table .= '
		<th>'.$lang['BUTTON_CHANGE'].'</th>
		<th>'.$lang['BUTTON_CHECKOUT'].'</th>
		<th>'.$lang['BUTTON_DELETE'].'</th>';
}
$table .= "</tr>";
foreach ($this->aPresence as $presence_ID => $aResult){
	if(isset($this->all_user[$aResult['UID']]['forename'])){
			$table .=
			'<tr>
			<td>'.$this->all_user[$aResult['UID']]['forename'].'</td>
			<td>'.$this->all_user[$aResult['UID']]['surname'].'</td>
			<td>'.$aResult['checkin_time'].'</td>
			<td>';
		if($aResult['checkout_time'] == "0000-00-00 00:00:00"){
			$table .= $lang['STATUS_PRESENT'];
		}
		else{
			$table.= $aResult['checkout_time'];
		}
			$table .= '</td>';
			if($_SESSION['admin']==1){
			$table .=
			'<td> <a href="index.php?ac=presence_change&presence_ID='.$aResult['presence_ID'].'" >'.$lang['BUTTON_CHANGE'].' </<> </td>
';

			if ($aResult['checkout_time'] == "0000-00-00 00:00:00"){
				$table .='
					<td> <a href="index.php?ac=presence_checkout&UID='.$aResult["UID"].'" >'.$lang['BUTTON_CHECKOUT'].' </<> </td>';
			}

			else{
				$table .=' 
					<td>'.$lang['ALREADY_CHECKED_OUT'].'</td>';
			}

			$table .=
				'<td> <a href="index.php?ac=presence_delete&presence_ID='.$aResult['presence_ID'].'" >'.$lang['BUTTON_DELETE'].' </<> </td>
				</tr>';
			}
	}
}	
$table = $table."</table>";

echo $table;

$form ='
	<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
	<input type = hidden name="ac" value = "presence_new">
		<input type="submit" value='.$lang['NEW_PRESENCE'].'>
	</form>';
echo $form;
?>


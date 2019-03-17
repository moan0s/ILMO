<?php 
$table = "<table border='1'>";
		$table .=
		'<tr>
		<th>'.$lang['USER_ID'].'</th>
		<th>'.$lang['SURNAME'].'</th>
		<th>'.$lang['FORENAME'].'</th>
		<th>'.$lang['EMAIL'].'</th>
		<th>'.$lang['UID'].'</th>
		';

		
if ($_SESSION['admin']==1) {
	$table .= 
		'<th>'.$lang['BUTTON_CHANGE'].'</th>
		<th>'.$lang['BUTTON_DELETE'].'</th>';
	if (($_SESSION['admin']==1) or ($this->r_user_ID = $_SESSION['user_ID'])){
		$table .= '<th>'.$lang['BUTTON_SHOW_LOANS'].'</th>';
	}
}
$table .= '</tr>';
	foreach ($this->aUser as $user_ID => $aResult)
		{
			$table .=
			'<tr>
			<td>'.$aResult['user_ID'].'</td>
			<td>'.$aResult['forename'].'</td>
			<td>'.$aResult['surname'].'</td>
			<td>'.$aResult['email'].'</td>
			<td>'.$aResult['UID'].'</td>';
			if ($_SESSION['admin']==1){
				$table .=
				'<td> <a href="index.php?ac=user_change&user_ID='.$aResult['user_ID'].'" >'.$lang['BUTTON_CHANGE'].' </<> </td>
				<td> <a href="index.php?ac=user_delete&user_ID='.$aResult['user_ID'].'" >'.$lang['BUTTON_DELETE'].' </<> </td>';
				if (($_SESSION['admin']==1) or ($this->r_user_ID = $_SESSION['user_ID'])){
					$table .='
						<td> <a href="index.php?ac=loan_show&user_ID='.$aResult['user_ID'].'" > '.$lang['BUTTON_SHOW_LOANS'].' </<> </td>';
				}
			}

			$table .= '</tr>';
		}
		
$table = $table."</table>";
echo $table;


if ($_SESSION['admin']==1){
	$form .='
		<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
		<input type = hidden name="ac" value = "user_new">
		<input type="submit" value="'.$lang['BUTTON_ADD_USER'].'">
		</form>';
	echo $form;
}

?>


<?php

/*
Outputs button that redirects to the "Add User" Page
*/
if ($this->check_permission("SAVE_USER", $_SESSION['role'])) {
    $form ='
		<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
		<input type = hidden name="ac" value = "user_new">
		<input type="submit" value="'.$this->oLang->texts['BUTTON_ADD_USER'].'">
		</form>';
    echo $form;
}
/*
Creates Table that shows all lends
*/
$table = "<table border='1'>";
        $table .=
        '<tr>
		<th>'.$this->oLang->texts['USER_ID'].'</th>
		<th>'.$this->oLang->texts['SURNAME'].'</th>
		<th>'.$this->oLang->texts['FORENAME'].'</th>
		<th>'.$this->oLang->texts['EMAIL'].'</th>
		<th>'.$this->oLang->texts['UID'].'</th>
		';


if ($this->check_permission("SAVE_USER", $_SESSION['role'])) {
    $table .=
        '<th>'.$this->oLang->texts['BUTTON_CHANGE'].'</th>
		<th>'.$this->oLang->texts['BUTTON_DELETE'].'</th>';
    if (($this->check_permission("SAVE_USER", $_SESSION['role']))) {
        $table .= '<th>'.$this->oLang->texts['BUTTON_SHOW_LOANS'].'</th>';
    }
}
$table .= '</tr>';
    foreach ($this->aUser as $user_ID => $aResult) {
        $table .=
            '<tr>
			<td>'.$aResult['user_ID'].'</td>
			<td>'.$aResult['forename'].'</td>
			<td>'.$aResult['surname'].'</td>
			<td>'.$aResult['email'].'</td>
			<td>'.$aResult['UID'].'</td>';
        if ($this->check_permission("SAVE_USER", $_SESSION['role'])) {
            $table .=
                '<td> <a href="index.php?ac=user_change&user_ID='.$aResult['user_ID'].'" >'.$this->oLang->texts['BUTTON_CHANGE'].' </<> </td>
				<td> <a href="index.php?ac=user_delete&user_ID='.$aResult['user_ID'].'" >'.$this->oLang->texts['BUTTON_DELETE'].' </<> </td>';
            if (($this->check_permission("SHOW_LOAN", $_SESSION['role']))) {
                $table .='
						<td> <a href="index.php?ac=loan_show&user_ID='.$aResult['user_ID'].'" > '.$this->oLang->texts['BUTTON_SHOW_LOANS'].' </<> </td>';
            }
        }

        $table .= '</tr>';
    }
$table = $table."</table>";
echo $table;
?>


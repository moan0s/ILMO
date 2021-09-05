



<?php
/*
Adds Button to add api_token
*/

$form = '<form action="';
$form .= htmlspecialchars($_SERVER["PHP_SELF"]);
$form.= '" method="post">
	<input type = hidden name="ac" value = "api_token_new">
	<input type="submit" value="'.$this->oLang->texts['NEW_API_TOKEN'].'">
	</form>';
echo $form;

/*
Adds a table of all itemized api_tokens
*/
$table = "<table border='0' cellspacing='0' >";
        $table .=
        "<tr>
		<th>".$this->oLang->texts['API_TOKEN_ID']."</th>
		<th>".$this->oLang->texts['NAME']."</th>
		<th>".$this->oLang->texts['USER_ID']."</th>
		<th>".$this->oLang->texts['TOKEN']."</th>
		<th>".$this->oLang->texts['STATUS']."</th>";

    if ($this->check_permission("SAVE_API_TOKEN", $_SESSION['role'])) {
        $table .='
		<th>'.$this->oLang->texts['BUTTON_CHANGE'].'</th>
		<th>'.$this->oLang->texts['BUTTON_DELETE'].'</th>';
    }
    $table .= '</tr>';


        foreach ($this->aToken as $api_token_ID => $aResult) {
            if ($aResult['active'] == 0) {
                $sClass= "active";
                $sStatus= $this->oLang->texts['STATUS_ACTIVE'];
            } else {
                $sClass = "inactive";
                $sStatus = $this->oLang->texts['STATUS_INACTIVE'];
            }

            $table .=
            '<tr class= "'.$sClass.'">
			<td>'.$aResult['api_token_ID'].'</td>
			<td>'.$aResult['name'].'</td>
			<td>'.$aResult['user_ID'].'</td>
			<td>'.$aResult['token'].'</td>
			<td>'.$sStatus.'</td>';
            if ($this->check_permission("SAVE_API_TOKEN", $_SESSION['role'])) {
                $table .= '
			<td> <a href="index.php?ac=api_token_change&api_token_ID='.$aResult['api_token_ID'].'" > '.$this->oLang->texts['BUTTON_CHANGE'].' </a> </td>
			<td> <a href="index.php?ac=api_token_delete&api_token_ID='.$aResult['api_token_ID'].'" > '.$this->oLang->texts['BUTTON_DELETE'].' </a> </td>';
            }
            $table .= '</tr>';
        }

        $table .="</table>";
        echo $table;

?>

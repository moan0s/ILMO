<?php
$table = "<table border='1'>";
        $table .=
        '<tr>
		<th>'.$this->oLang->texts['LOAN_ID'].'</th>
		<th>'.$this->oLang->texts['LENT_ON'].'</th>
		<th>'.$this->oLang->texts['RETURNED_ON'].'</th>
		<th>'.$this->oLang->texts['TITLE_MATERIAL'].'</th>
		<th>'.$this->oLang->texts['ID'].'</th>
		<th>'.$this->oLang->texts['USERNAME'].'</th>
		<th>'.$this->oLang->texts['USER_ID'].'</th>';
if ($this->check_permission("SAVE_LOAN", $_SESSION['role'])) {
    $table .= '
		<th>'.$this->oLang->texts['BUTTON_CHANGE'].'</th>
		<th>'.$this->oLang->texts['BUTTON_RETURN'].'</th>';
}
        $table .= "</tr>";
        foreach ($this->aLoan as $loan_ID => $aResult) {
            $table .=
            '<tr>
			<td>'.$aResult['loan_ID'].'</td>
			<td>'.$aResult['pickup_date'].'</td>
			<td>';
            if ($aResult['return_date'] == 0000-00-00) {
                $table .= $this->oLang->texts['STATUS_LENT'];
            } else {
                $table.= $aResult['return_date'];
            }
            $table .= '</td>
			<td>'.$aResult['material_name'].$aResult['book_name'].'</td>
			<td>'.$aResult['ID'].'</td>
			<td>'.$aResult['user_name'].'</td>
			<td>'.$aResult['user_ID'].'</td>';
            if ($this->check_permission("SAVE_LOAN", $_SESSION['role'])) {
                $table .=
            '<td> <a href="index.php?ac=loan_change&loan_ID='.$aResult['loan_ID'].'" >'.$this->oLang->texts['BUTTON_CHANGE'].' </<> </td>
';

                if ($aResult['return_date']==000-00-00) {
                    $table .='
					<td> <a href="index.php?ac=loan_return&loan_ID='.$aResult["loan_ID"].'&ID='.$aResult["ID"].'" >'.$this->oLang->texts['BUTTON_RETURN'].' </<> </td>';
                } else {
                    $table .=' 
					<td>'.$this->oLang->texts['ALREADY_RETURNED'].'</td>';
                }

                $table .='</tr>';
            }
        }
        $table = $table."</table>";
        echo $table;

$form ='
	<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
	<input type = hidden name="ac" value = "loan_new">
		<input type="submit" value='.$this->oLang->texts['NEW_LOAN'].'>
	</form>';
echo $form;
?>


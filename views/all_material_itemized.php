<?php
$table = "<table border='0' cellspacing='0' >";
$table .=
'<tr>
	<th>'.$this->oLang->texts['MATERIAL_ID'].'</th>
	<th>'.$this->oLang->texts['NAME'].'</th>
	<th>'.$this->oLang->texts['LOCATION'].'</th>
	<th>'.$this->oLang->texts['STATUS'].'</th>';

if ($this->check_permission("SAVE_MATERIAL", $_SESSION['role'])) {
    $table .='
		<th>'.$this->oLang->texts['BUTTON_CHANGE'].'</th>
		<th>'.$this->oLang->texts['BUTTON_DELETE'].'</th>';
}
$table .='</tr>';


foreach ($this->aMaterial as $material_ID => $aResult) {
    if ($aResult['lent'] == 0) {
        $sClass= "available";
        $sStatus= $this->oLang->texts['STATUS_AVAILABLE'];
    } else {
        $sClass = "lent";
        $sStatus = $this->oLang->texts['STATUS_LENT'];
    }
    $table .=
    '<tr class= "'.$sClass.'">
		<td>'.$aResult['material_ID'].'</td>
		<td>'.$aResult['name'].'</td>
		<td>'.$aResult['location'].'</td>
		<td>'.$sStatus;

    if ($this->check_permission("SAVE_MATERIAL", $_SESSION['role'])) {
        $table .=
        '</td>
			<td> <a href="index.php?ac=material_change&material_ID='.$aResult['material_ID'].'" >'.$this->oLang->texts['BUTTON_CHANGE'].' </a> </td>
			<td> <a href="index.php?ac=material_delete&material_ID='.$aResult['material_ID'].'" >'.$this->oLang->texts['BUTTON_DELETE'].'</a> </td>';
    }
    $table .='</tr>';
}
$table .="</table>";
echo $table;

$form = '<form action="';
$form .= htmlspecialchars($_SERVER["PHP_SELF"]);
$form.= '" method="post">
<input type = hidden name="ac" value = "material_new">
	<input type="submit" value="'.$this->oLang->texts['NEW_MATERIAL'].'">
</form>';
echo $form;
?>


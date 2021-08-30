<?php
$table = "<table border='1'>";
        $table .=
        '<tr>
		<th>'.$this->oLang->texts['ACESS_ID'].'</th>
		<th>'.$this->oLang->texts['UID'].'</th>
		<th>'.$this->oLang->texts['TIMESTAMP'].'</th>
		<th>'.$this->oLang->texts['USERNAME'].'</th>
		<th>'.$this->oLang->texts['USER_ID'].'</th>';
        $table .= "</tr>";
        foreach ($this->aAcess as $ACESS_ID => $aResult) {
            $table .=
            '<tr>
			<td>'.$aResult['ACESS_ID'].'</td>
			<td>'.$aResult['UID'].'</td>
			<td>'.$aResult['TIMESTAMP']'</td>
			<td>'.$aResult['USERNAME'].'</td>
			<td>'.$aResult['USER_ID'].'</td>'
            $table .='</tr>';
            }
        }
        $table = $table."</table>";
        echo $table;
?>






<?php
$table = "<table border='0' cellspacing='0' >";
		$table .= 
		"<tr>
		<th>".$this->oLang->texts['BOOK_ID']."</th>
		<th>".$this->oLang->texts['TITLE']."</th>
		<th>".$this->oLang->texts['AUTHOR']."</th>
		<th>".$this->oLang->texts['LOCATION']."</th>
		<th>".$this->oLang->texts['STATUS']."</th>";

	$table .='
		<th>'.$this->oLang->texts['BUTTON_CHANGE'].'</th>
		<th>'.$this->oLang->texts['BUTTON_DELETE'].'</th>
		</tr>';

		
		foreach ($this->aBook as $book_ID => $aResult)
		{
		if($aResult['lent'] == 0){
			$sClass= "available";
			$sStatus= $this->oLang->texts['STATUS_AVAILABLE'];
		}
		else{
			$sClass = "lent";
			$sStatus = $this->oLang->texts['STATUS_LENT'];
		}
	
		$table .=
			'<tr class= "'.$sClass.'">
			<td>'.$aResult['book_ID'].'</td>
			<td>'.$aResult['title'].'</td>
			<td>'.$aResult['author'].'</td>
			<td>'.$aResult['location'].'</td>
			<td>'.$sStatus.'</td>
			<td> <a href="index.php?ac=book_change&book_ID='.$aResult['book_ID'].'" > '.$this->oLang->texts['BUTTON_CHANGE'].' </a> </td>
			<td> <a href="index.php?ac=book_delete&book_ID='.$aResult['book_ID'].'" > '.$this->oLang->texts['BUTTON_DELETE'].' </a> </td>
			</tr>';
		}	
		
		$table .="</table>";
		echo $table;

	$form = '<form action="'; 
	$form .= htmlspecialchars($_SERVER["PHP_SELF"]); 
	$form.= '" method="post">
	<input type = hidden name="ac" value = "book_new">
		<input type="submit" value="'.$this->oLang->texts['NEW_BOOK'].'">
	</form>';
	echo $form;
?>

<?php
$header = '
<div id="header">
	<div class="side-description">				
		<a class="logo" href="./index.php" title="'.$lang['HOME'].'">
			<img src="images/logo_library.png" border=0 />
		</a>
		<h1>'.$library_info['LIBRARY_NAME'].'</h1>
		<p>'.$library_info['LIBRARY_DESCRIPTION'].'</p>
	</div>';
if ($this->settings['enable_status'] == 1){
	$oPresence = new Presence;
	$status = $oPresence->get_status();
	$header .=
		'<div class="status">
			<h1>'.$lang['CURRENT_STATUS'].'</h1>';
			if($status){
				$header.= $lang['OPEN'];
			}
			else{
				$header.= $lang['CLOSE'];
			}
}
	$header.='<br><br>	
		<div class="language">
			<form action="'.$_SERVER["PHP_SELF"].'" method="post">
			<input type = hidden name="ac" value = "language_change">'.
			$lang['LANGUAGE'].':<input type="radio" id="english" name="language" value="english"';
				if ($_SESSION['language']=='english'){
					$header .= 'checked';
				}
					$header.=  '>
						<label for="english">'.$lang['ENGLISH'].' </label>
						<input type="radio" id="german" name="language" value="german"'; 
				if ($_SESSION['language']=="german"){
					$header .= ' checked';
				}
		$header.= '>
			<label for id ="german">'.$lang['GERMAN'].'</label><br>
			<input type="submit" value="'.$lang['CHANGE_LANGUAGE'].'">
			</form>
		</div>

	</div>
</div>';
echo $header;
?>

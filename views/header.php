<?php
$header = '
<div id="header">
	<div class="side-description">				
		<a class="logo" href="./index.php" title="'.$this->oLang->texts['HOME'].'">
			<img src="images/logo_library.png" border=0 />
		</a>
		<h1>'.$this->oLang->library_info['LIBRARY_NAME'].'</h1>
		<p>'.$this->oLang->library_info['LIBRARY_DESCRIPTION'].'</p>
	</div>';
if ($this->settings['enable_status'] == 1){
	$oPresence = new Presence;
	$status = $oPresence->get_status();
	$header .=
		'<div class="status">
			<h1>'.$this->oLang->texts['CURRENT_STATUS'].'</h1>';
			if($status){
				$header.= $this->oLang->texts['OPEN'];
			}
			else{
				$header.= $this->oLang->texts['CLOSE'];
			}
}
	$header.='<br><br>	
		<div class="oLang->textsuage">
			<form action="'.$_SERVER["PHP_SELF"].'" method="post">
			<input type = hidden name="ac" value = "oLang->textsuage_change">'.
			$this->oLang->texts['LANGUAGE'].':<input type="radio" id="english" name="oLang->textsuage" value="english"';
				if ($_SESSION['oLang->textsuage']=='english'){
					$header .= 'checked';
				}
					$header.=  '>
						<label for="english">'.$this->oLang->texts['ENGLISH'].' </label>
						<input type="radio" id="german" name="oLang->textsuage" value="german"'; 
				if ($_SESSION['oLang->textsuage']=="german"){
					$header .= ' checked';
				}
		$header.= '>
			<label for id ="german">'.$this->oLang->texts['GERMAN'].'</label><br>
			<input type="submit" value="'.$this->oLang->texts['CHANGE_LANGUAGE'].'">
			</form>
		</div>

	</div>
</div>';
echo $header;
?>

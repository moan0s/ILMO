<?php
$header = '
<div id="header">
	<div id="side-description" class"side-description">				
		<a id="logo" href="./index.php" title="'.HOME.'">
			<span class="site_logo"></span>
		</a>
		<h1>'.LIBRARY_NAME.'</h1>
		<p>'.LIBRARY_DESCRIPTION.'</p>
	</div>
	
	<div id="language">
		<form action="'.$_SERVER["PHP_SELF"].'" method="post">
		<input type = hidden name="ac" value = "language_change">'.
		LANGUAGE.':<input type="radio" id="english" name="language" value="english"';
			if ($_SESSION['language']=='english'){
				$header .= 'checked';
			}
				$header.=  '>
					<label for="english">'.ENGLISH.' </label>
					<input type="radio" id="german" name="language" value="german"'; 
			if ($_SESSION['language']=="german"){
				$header .= ' checked';
			}
	$header.= '>
		<label for id ="german">'.GERMAN.'</label><br>
		<input type="submit" value="'.CHANGE_LANGUAGE.'">
		</form>
	</div>
	<div id="opening-status" class="status">
		<h1>'.CURRENT_STATUS.'</h1><br>';
		if($this->status){
			$header.= OPEN;
		}
		else{
			$header.= CLOSE;
		}
	$header.='
	</div>
</div>';
echo $header;
?>

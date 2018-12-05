<body>
<?php
if (substr($this->r_ac, -5) != "plain"){
echo '	
<div id="header">
	<div id="side-description" class"side-description">				
		<a id="logo" class="logo" href="./index.php" title="Foren-Übersicht">
			<span class="site_logo"></span>
		</a>
		<h1>Lerninselbibliothek</h1>
		<p>Bibliothek des Studiengangs Medizintechnik</p>
	</div>
	
	<div id="language">
		<form action="'.$_SERVER["PHP_SELF"].'" method="post">
		<input type = hidden name="ac" value = "language_change">';
	echo LANGUAGE.': 
		<input type="radio" id="english" name="language" value="english"';
	if ($_SESSION['language']=='english'){echo' checked';}
	echo '>
	<label for="english">'.ENGLISH.' </label>
	<input type="radio" id="german" name="language" value="german"'; 
	if ($_SESSION['language']=="german"){echo' checked';}
	echo '>
	<label for id ="german">'.GERMAN.'</label><br>'; 
	echo	'<input type="submit" value="'.CHANGE_LANGUAGE.'">
		</form>
	</div>
</div>

</div>
<div id="navi">';
echo $this->navigation;
}
?>
</div>

<?php
if ((isset($this->error)) and ($this->error != "")){
	echo "<div id=error>";
	echo $this->error;
	echo "</div>";
}
echo "<div id=content>";
echo $this->output;
echo "</div>";
?>

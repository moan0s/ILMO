<body>
<?php
if ($this->r_ac!="book_show_plain"){
echo '	
<div id="header">
	<div id="side-description" class"side-description">				
		<a id="logo" class="logo" href="./index.php" title="Foren-Übersicht">
			<span class="site_logo"></span>
		</a>
		<h1>Lerninselbibliothek</h1>
		<p>Bibliothek des Studiengangs Medizintechnik</p>
	</div>
</div>

</div>
<div id="navi">';
echo $this->navigation;
}
?>
</div>

<div id=content>
<?php
echo $this->output;
?>
</div>

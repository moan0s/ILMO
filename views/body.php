<body>
<?php
if (substr($this->r_ac, -5) != "plain"){
include ("header.php");
echo '<div id="navi">';
echo $this->navigation;
echo "</div>";
}
?>


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

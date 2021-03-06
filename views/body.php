<body>
<?php
if (isset($this->r_ac) and substr($this->r_ac, -5) == "plain") {
} else {
    include(MODULE_PATH."views/header.php");
    echo '<div id="navi">';
    echo $this->navigation;
    echo "</div>";
}
?>


<?php
if ((isset($this->error)) and ($this->error != "")) {
    echo "<div id=error>";
    foreach ($this->error as $key=>$error) {
        echo "<div>".$error."</div>";
    }
    echo "</div>";
}
echo "<div id=content>";
echo $this->output;
echo "</div>";
?>

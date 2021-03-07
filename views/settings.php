<?php

$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
$form .='
<input type = hidden name="ac" value = "settings_save">';
foreach ($this->settings['lang'] as $lang=>$aTexts) {
    $form.="<p><strong>".$lang."</strong><br>";
    foreach ($aTexts as $key=>$val) {
        $form .= $key.': <input type=text name="'.$lang."_".$key.'" value="'.$val.'"><br>';
    }
    echo"</p>";
}

foreach ($this->settings as $key=>$val) {
    if (is_string($val)) {
        $form .= "<div class=input_label_container><label for=$key>".$this->oLang->texts[strtoupper($key)]."</label>
		<input type=text id=$key name=$key value=$val></div>";
    }
}


$form .= '
<input type="submit" value="'.$this->oLang->texts['BUTTON_SEND'].'">
</form>';
echo $form;
?>

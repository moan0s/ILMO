<?php

function text_input($label, $id, $value ="")
{
    /* Generates an input field with label
     */
    $output = "<div class=input_label_container><label for='$id'>$label</label>
					<input type=text id='$id' name='$id' value='$value'></div>";
    return $output;
}


function gen_form_inputs($texts, $array, $output = "", $prefix = "")
{
    /* Generate a form from an array of adjustable values
     *
     * $texts: array
     * $array: array
     * 		Array to be turned into form
     * $output: String
     * 		Output form
     * $prefix: String
     * 		Sting that will be added to the form ID
     *
     * Returns output form for array
     */
    foreach ($array as $key=>$val) {
        if (is_string($val)) {
            $id = $prefix.$key;
            $key_in_texts = strtoupper($key);
            if (array_key_exists($key_in_texts, $texts)) {
                $label = $texts[$key_in_texts];
            } else {
                $label = $id;
            }
            $value = $val;
            $output .= text_input($label, $id, $value);
        } elseif (is_array($val)) {
            $prefix = $prefix.$key."_";
            $output = gen_form_inputs($texts, $val, $output, $prefix);
        }
    }
    return $output;
}

$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
$form .='<input type = hidden name="ac" value = "settings_save">';
/*
foreach ($this->settings['lang'] as $lang=>$aTexts) {
    $form.="<p><strong>".$lang."</strong><br>";
    foreach ($aTexts as $key=>$val) {
        $form .= $key.': <input type=text name="'.$lang."_".$key.'" value="'.$val.'"><br>';
    }
    echo"</p>";
}
 */

$form .= gen_form_inputs($this->oLang->texts, $this->settings);

$form .= '<input type="submit" value="'.$this->oLang->texts['BUTTON_SEND'].'"></form>';
echo $form;

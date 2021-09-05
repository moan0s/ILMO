<?php

/*
 * Add token for self
 */


$action = $this->payload['ac'];

$output = "<h1>".$this->oLang->texts['CREATE_API_TOKEN']."</h1>";
$aToken = $this->aToken;
$text_fields_to_show = ["name"];
$checkbox_fields_to_show = [
    "read_access_privileges"=> ["0" => "NO",  "1" => "YES"],
    "write_access" =>  ["0" => "NO",  "1" => "YES"]
    ];
    $output.='<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
    $output .= '<input type = hidden name="ac" value = "api_token_register">';


/* The user has certain properties that shoud be searchable
* These properties are listed in text_field_to_show and checkbox_fields_to_show
*/
foreach ($text_fields_to_show as $key) {
    // Show a text field with th values filled in
    $label = "<div class='label'><label for='$key'>".$this->oLang->texts[strtoupper($key)]."</label></div>\n";
    $input_box = "<input type='text' name=$key id=$key>\n";
    $output .= $label.$input_box;
}

foreach ($checkbox_fields_to_show as $key=>$val) {
    // Show checkboxes for all options
    $div = "<div class=radio_container id=".$key.">";
    $label = "<div class=label>".$this->oLang->texts[strtoupper($key)]."</div>";
    $div .= $label;
    foreach ($val as $option => $label) {
        $box = "<label for='".$key."_".$option."'>".$this->oLang->texts[$label];
        $box  .= "<input type='radio' name='$key' id='".$key."_".$option."' value='$option'";
        $box .= "><span class=checkmark></span></label>";
        $div .= $box;
    }
    $div .= "</div>";
    $output .= $div;
}

$output .= '<input type="submit" value="'.$this->oLang->texts['CREATE_API_TOKEN'].'"></form>';
echo $output;

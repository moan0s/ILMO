<?php

/*
 * This should cover user search
 */

$action = $this->payload['ac'];

# For case 2 and 3
$text_fields_to_show = array("forename", "surname", "email", "password");
$checkbox_fields_to_show = ["role"=> ["2" => "ADMIN", "1" => "USER"],
                            "language" => ["english" => "ENGLISH", "german" => "GERMAN"],
                "access" => ["1" => "FABLAB", "0" => "NO_ACCESS"]
    ];
$output = "";
$output.='<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
$output .= '<input type = hidden name="ac" value = "user_save">';

/* The user has certain properties that shoud be searchable
* These properties are listed in text_field_to_show and checkbox_fields_to_show
*/
foreach ($text_fields_to_show as $key) {
    // Show a text field with th values filled in
    $label = "<label for='$key'>".$this->oLang->texts[strtoupper($key)]."</label>";
    if ($key === "password") {
        $input_box = "<input type='password' name=$key id=$key>";
    } else {
        $input_box = "<input type='text' name=$key id=$key>";
    }
    $output .= $label.$input_box;
}
foreach ($checkbox_fields_to_show as $key=>$val) {
    // Show checkboxes for all options
    $div = "<div class=radio_container>";
    foreach ($val as $option => $label) {
        $box = "<label for='".$key."_".$option."'>".$this->oLang->texts[$label];
        $box  .= "<input type='radio' name='$key' id='".$key."_".$option."' value='$option'";
        $box .= "><span class=checkmark></span></label>";
        $div .= $box;
    }
    $div .= "</div>";
    $output .= $div;
}
$output .= '<input type="submit" value="'.$this->oLang->texts['BUTTON_ADD_USER'].'"></form>';
echo $output;

?>


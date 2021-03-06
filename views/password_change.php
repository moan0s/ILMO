<?php
$form = '<div class="container">';
$form .= '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
$form .='
<input type = hidden name="ac" value = "self_pw_save">';
if (isset($this->payload['user_ID'])) {
    $form .= '<input type = hidden name="user_ID" value = "';
    $form .= $this->payload['user_ID'];
    $form .= '">';
} else {
    $form .= "<div class=input_label_container><label class=text_label for='user_ID'>".$this->oLang->texts['USER_ID']."</label>";
    $form .= "<input type=text id='user_ID' name='user_ID'></div>";
}

//If a user is not logged in and requests this action
// we display the possibility to enter a passwort reset
// token
if ($_SESSION['role'] == 0) {
    $form .= "<div class=input_label_container><label class=text_label for='token'>".$this->oLang->texts['TOKEN']."</label>";
    $form .= "<input type=text id='token' name='token'></div>";
} else {
    //Old password
    $form .= '<div class=input_label_container><label class=text_label for="old_password">'.$this->oLang->texts['OLD_PASSWORD'].'</label>';
    $form .='<input type="password" name="old_password" id="old_password"></div>';
}

//New password
$form .= '<div class=new_password_container><div class=input_label_container><label class=text_label for="new_password">'.$this->oLang->texts['NEW_PASSWORD'].'</label>';
$form .='<input type="password" name="new_password" id="new_password">  </div>';

//Confirm password
$form .= '<div class=input_label_container><label class=text_label for="confirm_password">'.$this->oLang->texts['CONFIRM_PASSWORD'].'</label>';
$form .='<input type="password" name="confirm_password" id="confirm_password"></div></div>';

$form .= '<input type="submit" value="'.$this->oLang->texts['BUTTON_SEND'].'"></form></div>';
$minimum_pw_length = $this->settings['minimum_pw_length'];
$message = <<<EOT
<div id="message">
  <h3>Password must:</h3>
  <p id="length" class="invalid">have a minimum of <b>$minimum_pw_length characters</b></p>
  <p id="match" class="invalid"><b>Match</b></p>
</div>
EOT;

$script = <<<EOT
<script>
var new_password = document.getElementById("new_password");
var confirm_password = document.getElementById("confirm_password");
var length = document.getElementById("length");
var match = document.getElementById("match");

new_password.onkeyup = function() {
  // Validate length
  if(new_password.value.length >= $minimum_pw_length) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
  // Validate match
  if(new_password.value == confirm_password.value) {
    match.classList.remove("invalid");
    match.classList.add("valid");
  } else {
    match.classList.remove("valid");
    match.classList.add("invalid");
  }
}

confirm_password.onkeyup = function() {
  // Validate match
  if(new_password.value == confirm_password.value) {
    match.classList.remove("invalid");
    match.classList.add("valid");
  } else {
    match.classList.remove("valid");
    match.classList.add("invalid");
  }
}

</script>
EOT;
echo $form;
echo $message;
echo $script;

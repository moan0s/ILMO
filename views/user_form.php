<?php
$form = '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
if ($this->payload['ac'] == 'user_search') {
    $form .='
	<input type = hidden name="ac" value = "user_show">';
} else {
    $form .='
	<input type = hidden name="ac" value = "user_save">
	<input type = hidden name="user_ID" value = "';
    if (isset($this->payload['user_ID'])) {
        $form .= $this->payload['user_ID'];
    }
    $form .= '">';
}
$form .=	$this->oLang->texts['FORENAME'].': <input type="text" name="forename" value="';
    if (isset($this->aRow['forename'])) {
        $form .= $this->aRow['forename'];
    }
    $form .='"><br>'.
        $this->oLang->texts['SURNAME'].': <input type="text" name="surname" value="';
    if (isset($this->aRow['surname'])) {
        $form .= $this->aRow['surname'];
    }
    $form .= '"> <br>'.
        $this->oLang->texts['EMAIL'].': <input type="text" name="email" value="';
    if (isset($this->aRow['email'])) {
        $form .= $this->aRow['email'];
    }
    $form .= '"> <br>'.
        $this->oLang->texts['UID'].': <input type="text" name="UID" value="';
    if (isset($this->aRow['UID'])) {
        $form .= $this->aRow['UID'];
    }
    $form .= '"> <br>'.
        $this->oLang->texts['LANGUAGE'].': <input type="radio" id="english" name="language" value="english"';

    if (!isset($this->aRow['language'])) {
        $this->aRow['language'] = $this->settings['default_language'];
    }
    if (($this->aRow['language']== "english") and ($this->payload['ac'] != 'user_search')) {
        $form .= 'checked';
    }
    $form .= '>
			<label for="english">'.$this->oLang->texts['ENGLISH'].'</label>
			<input type="radio" id="german" name="language" value="german" ';
    if (($this->aRow['language']=="german") and ($this->payload['ac'] != 'user_search')) {
        $form .= 'checked';
    }
    $form .= '>
		<label for="german">'.$this->oLang->texts['GERMAN'].'</label>
		<br>';
    if ($this->payload['ac'] != 'user_search') {
        $form .=$this->oLang->texts['PASSWORD'].': <input type="password" name="password">  <br>';
    }
    if (($_SESSION['role']==2) and ($this->payload['ac'] != 'user_search')) {
        $form .= $this->oLang->texts['ADMIN'].': <input type="radio" id="yes" name="admin" value="1"';
        if ($this->aRow['admin']==1) {
            $form .= 'checked';
        }
        $form .='>
		<label for="yes">'.$this->oLang->texts['YES'].'</label>
		<input type="radio" id="no" name="admin" value="0"';
        if ($this->aRow['admin']==0) {
            $form .= 'checked';
        }
        $form .= '>
		<label for id ="no"> '.$this->oLang->texts['NO'].'</label><br>';
    }
    $form .= '
	<input type="submit" value="'.$this->oLang->texts['BUTTON_SEND'].'">
	<input type="reset" value="'.$this->oLang->texts['BUTTON_RESET'].'";
	</form>';
echo $form;

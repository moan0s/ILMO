<?php
$navigation ='
<ul>
	<li><a href="index.php">'.$this->oLang->texts['HOME'].'</a></li>
	<li><a href="index.php?ac=book_show">'.$this->oLang->texts['ALL_BOOKS'].'</a></li>
	<li><a href="index.php?ac=material_show">'.$this->oLang->texts['ALL_MATERIAL'].'</a></li>
 	<li><a href="index.php?ac=open_show">'.$this->oLang->texts['OPENING_HOURS'].'</a></li>';
if ($this->check_permission("SHOW_USER", $_SESSION['role'])) {
    $navigation .= '<li><a href="index.php?ac=user_show">'.$this->oLang->texts['ALL_USER'].'</a></li>';
    $navigation .= '<li><a href="index.php?ac=user_search">'.$this->oLang->texts['SEARCH_USER'].'</a></li>';
}
if ($this->check_permission("SAVE_USER", $_SESSION['role'])) {
    $navigation .= '
	<li><a href="index.php?ac=user_new">'.$this->oLang->texts['NEW_USER'].'</a></li>';
}
if ($this->check_permission("SAVE_OPEN", $_SESSION['role'])) {
    $navigation .= '
	<li><a href="index.php?ac=open_change">'.$this->oLang->texts['CHANGE_OPENING_HOURS'].'</a></li>';
}
if ($this->check_permission("SHOW_LOAN", $_SESSION['role'])) {
    $navigation .= '
	<li><a href="index.php?ac=loan_show">'.$this->oLang->texts['ALL_LOAN'].'</a></li>';
}
if ($this->check_permission("SAVE_LOAN", $_SESSION['role'])) {
    $navigation .= '
    <li><a href="index.php?ac=loan_new">'.$this->oLang->texts['NEW_LOAN'].'</a></li>';
}
if ($this->check_permission("SHOW_BOOK", $_SESSION['role'])) {
    $navigation .= '
	<li><a href="index.php?ac=book_show_itemized">'.$this->oLang->texts['SHOW_BOOKS_ITEMIZED'].'</a></li>';
}
if ($this->check_permission("SHOW_MATERIAL", $_SESSION['role'])) {
    $navigation .= '
	<li><a href="index.php?ac=material_show_itemized">'.$this->oLang->texts['SHOW_MATERIAL_ITEMIZED'].'</a></li>';
}
if ($this->check_permission("SHOW_ACCESS", $_SESSION['role']) and $this->settings['access_key_feature']) {
    $navigation .= '
	<li><a href="index.php?ac=access_show">'.$this->oLang->texts['SHOW_ALL_access'].'</a></li>';
}

if ($this->check_permission("SAVE_SETTINGS", $_SESSION['role'])) {
    $navigation .= '
    <li><a href="index.php?ac=settings_change">'.$this->oLang->texts['SETTINGS'].'</a></li>';
}
if ($this->check_permission("SHOW_SELF", $_SESSION['role'])) {
    $navigation .=	'
	<li><a href="index.php?ac=user_self">'.$this->oLang->texts['MY_PROFIL'].'</a></li>
	<li><a href="index.php?ac=loan_self">'.$this->oLang->texts['MY_LOANS'].'</a></li>';
	if($this->settings['access_key_feature']){
		$navigation .=	'		
		<li><a href="index.php?ac=access_self">'.$this->oLang->texts['SHOW_MY_access'].'</a></li>';
	}
	$navigation .=	'
	<li><a href="index.php?ac=logout">'.$this->oLang->texts['LOGOUT'].'</a></li>';
	
}
$navigation .= '</ul>';

echo $navigation;

?>


<?php
$navigation ='
<ul>
	<li><a href="index.php">'.$lang['HOME'].'</a></li>
	<li><a href="index.php?ac=book_show">'.$lang['ALL_BOOKS'].'</a></li>
	<li><a href="index.php?ac=material_show">'.$lang['ALL_MATERIAL'].'</a></li>
 	<li><a href="index.php?ac=open_show">'.$lang['OPENING_HOURS'].'</a></li>';
if ($_SESSION['admin'] ==1){  
$navigation .= '
	<li><a href="index.php?ac=user_show">'.$lang['ALL_USER'].'</a></li>
	<li><a href="index.php?ac=user_search">'.$lang['SEARCH_USER'].'</a></li>
	<li><a href="index.php?ac=user_new">'.$lang['NEW_USER'].'</a></li>
	<li><a href="index.php?ac=open_change">'.$lang['CHANGE_OPENING_HOURS'].'</a></li>
	<li><a href="index.php?ac=loan_show">'.$lang['ALL_LOAN'].'</a></li>
	<li><a href="index.php?ac=loan_new">'.$lang['NEW_LOAN'].'</a></li>
	<li><a href="index.php?ac=book_show_itemized">'.$lang['SHOW_BOOKS_ITEMIZED'].'</a></li>
	<li><a href="index.php?ac=material_show_itemized">'.$lang['SHOW_MATERIAL_ITEMIZED'].'</a></li>
	<li><a href="index.php?ac=presence_show_all">'.$lang['SHOW_PRESENCE'].'</a></li>
';
}
$navigation .=	'
	<li><a href="index.php?ac=user_self">'.$lang['MY_PROFIL'].'</a></li>
	<li><a href="index.php?ac=loan_self">'.$lang['MY_LOANS'].'</a></li>
	<li><a href="index.php?ac=logo">'.$lang['LOGOUT'].'</a></li>
</ul>';
echo $navigation;

?>


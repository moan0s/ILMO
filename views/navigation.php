<?php
$navigation .='
<ul>
	<li><a href="index.php">'.HOME.'</a></li>
	<li><a href="index.php?ac=book_show">'.ALL_BOOKS.'</a></li>
	<li><a href="index.php?ac=material_show">'.ALL_MATERIAL.'</a></li>
 	<li><a href="index.php?ac=open_show">'.OPENING_HOURS.'</a></li>';
if ($_SESSION['admin'] ==1){  
$navigation .= '
	<li><a href="index.php?ac=user_show">'.ALL_USER.'</a></li>
	<li><a href="index.php?ac=user_search">'.SEARCH_USER.'</a></li>
	<li><a href="index.php?ac=user_new">'.NEW_USER.'</a></li>
	<li><a href="index.php?ac=open_change">'.CHANGE_OPENING_HOURS.'</a></li>
	<li><a href="index.php?ac=loan_show">'.ALL_LOAN.'</a></li>
	<li><a href="index.php?ac=loan_new">'.NEW_LOAN.'</a></li>
	<li><a href="index.php?ac=book_show_itemized">'.SHOW_BOOKS_ITEMIZED.'</a></li>
	<li><a href="index.php?ac=material_show_itemized">'.SHOW_MATERIAL_ITEMIZED.'</a></li>
	<li><a href="index.php?ac=presence_show_all">'.SHOW_PRESENCE.'</a></li>
';
}
$navigation .=	'
	<li><a href="index.php?ac=user_self">'.MY_PROFIL.'</a></li>
	<li><a href="index.php?ac=loan_self">'.MY_LOANS.'</a></li>
	<li><a href="index.php?ac=logo">'.LOGOUT.'</a></li>
</ul>';
echo $navigation;

?>


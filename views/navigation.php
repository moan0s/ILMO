<?php
$navigation .='
<ul>
	<li><a href="index.php">'.HOME.'</a></li>
	<li><a href="index.php?ac=book_show">'.ALL_BOOKS.'</a></li>
	<li><a href="index.php?ac=stuff_show">'.ALL_STUFF.'</a></li>
 	<li><a href="index.php?ac=open_show">'.OPENING_HOURS.'</a></li>';
if ($_SESSION['admin'] ==1){  
$navigation .= '
	<li><a href="index.php?ac=user_show">'.ALL_USER.'</a></li>
	<li><a href="index.php?ac=lend_show">'.ALL_LEND.'</a></li>
	<li><a href="index.php?ac=open_change">'.CHANGE_OPENING_HOURS.'</a></li>
	<li><a href="index.php?ac=book_new">'.NEW_BOOK.'</a></li>
	<li><a href="index.php?ac=stuff_new">'.NEW_STUFF.'</a></li>
	<li><a href="index.php?ac=user_new">'.NEW_USER.'</a></li>
	<li><a href="index.php?ac=lend_new">'.NEW_LEND.'</a></li>
	<li><a href="index.php?ac=user_search">'.SEARCH_USER.'</a></li>
	<li><a href="index.php?ac=book_show_itemized">'.SHOW_BOOKS_ITEMIZED.'</a></li>
	<li><a href="index.php?ac=stuff_show_itemized">'.SHOW_STUFF_ITEMIZED.'</a></li>';
}
$navigation .=	'
	<li><a href="index.php?ac=user_self">'.MY_PROFIL.'</a></li>
	<li><a href="index.php?ac=lend_self">'.MY_LENDS.'</a></li>
	<li><a href="index.php?ac=logo">'.LOGOUT.'</a></li>
</ul>';
echo $navigation;

?>


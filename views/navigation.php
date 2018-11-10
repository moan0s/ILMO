<ul>

<li><a href="index.php">Home</a></li>
<?php 
echo '<li><a href="index.php?ac=book_show">Alle Bücher</a></li>';
if ($_SESSION['admin'] ==1){ echo '
<li><a href="index.php?ac=user_show">Alle Nutzer*innen</a></li>
<li><a href="index.php?ac=lend_show">Alle Ausleihen</a></li>
<li><a href="index.php?ac=book_new">Neues Buch</a></li>
<li><a href="index.php?ac=user_new">Neue*r Nutzer*in</a></li>
<li><a href="index.php?ac=lend_new">Neue Ausleihe</a></li>
<li><a href="index.php?ac=user_search">Benutzer*in suchen</a></li>
<li><a href="index.php?ac=book_show_itemized">Zeige Bücher einzeln</a></li>';
}
echo '
<li><a href="index.php?ac=user_self">Mein Profil</a></li>
<li><a href="index.php?ac=lend_self">Meine Ausleihen</a></li>
<li><a href="index.php?ac=logo">Ausloggen</a></li>
</ul>';
?>


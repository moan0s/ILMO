<?php
$footer .='
<div id= footer>
	<div>
	<a id=logo class=logo href="https://www.fs-medtech.de/" title="Website der Fachschaft">
	<span class="fs_logo"></span>
	</a>
	<a href="https://www.medtechs.de/" title="Forum Medizintechnik" >
	<span class="forum_logo"></span>
	</a>
	<span class="link_list">
	<h1>'.LINKS.': </h1>
	<ul>
		<li><a  href="'.CONTACT_LINK.'" title="'.CONTACT.'" >'.CONTACT.'</a></li>
		<li><a href="'.PRIVACY_LINK.'" title="'.PRIVACY.'">'.PRIVACY.'</a></li>
	</ul>
	</span>
</div>
</div>';
echo $footer;

?>

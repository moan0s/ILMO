<?php
$footer ='
<div id= footer>
	<div>
	<a id=logo class=logo href="https://www.fs-medtech.de/" title="Website der Fachschaft">
	<span class="fs_logo"></span>
	</a>
	<a href="https://www.medtechs.de/" title="Forum Medizintechnik" >
	<span class="forum_logo"></span>
	</a>
	<span class="link_list">
	<h1>'.$this->oLang->library_information['LINKS'].': </h1>
	<ul>
		<li><a  href="'.$this->oLang->library_information['CONTACT_LINK'].'" title="'.$this->oLang->library_information['CONTACT'].'" >'.$this->oLang->library_information['CONTACT'].'</a></li>
		<li><a href="'.$this->oLang->library_information['PRIVACY_LINK'].'" title="'.$this->oLang->library_information['PRIVACY'].'">'.$this->oLang->library_information['PRIVACY'].'</a></li>
	</ul>
	</span>
</div>
</div>';
echo $footer;

?>

<?php
$footer ='
<div id= footer>
	<div>
	<a id=logo class=logo href="'.$this->oLang->library_info['FOOTER_LINK_1'].'" title="'.$this->oLang->library_info['FOOTER_LINK_1_TITLE'].'">
	<span class="fs_logo"></span>
	</a>
	<a href="'.$this->oLang->library_info['FOOTER_LINK_2'].'" title="'.$this->oLang->library_info['FOOTER_LINK_2_TITLE'].'" >
	<span class="forum_logo"></span>
	</a>
	<span class="link_list">
	<h1>'.$this->oLang->texts['LINKS'].': </h1>
	<ul>
		<li><a  href="'.$this->oLang->library_info['CONTACT_LINK'].'" title="'.$this->oLang->texts['CONTACT'].'" >'.$this->oLang->texts['CONTACT'].'</a></li>
		<li><a href="'.$this->oLang->library_info['PRIVACY_LINK'].'" title="'.$this->oLang->texts['PRIVACY'].'">'.$this->oLang->texts['PRIVACY'].'</a></li>
	</ul>
	</span>
</div>
</div>';
echo $footer;

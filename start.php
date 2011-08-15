<?php
elgg_register_action("myblog/save", dirname(__FILE__) . "/actions/myblog/save.php");

elgg_register_page_handler('wiki', 'wiki_page_handler');
 
function wiki_page_handler($segments) {
	//add page
    if ($segments[0] == 'add') {
		include (dirname(__FILE__) . '/pages/wiki/add.php');
    }
	//edit page
	else if ($segments[0] == 'edit') {
		include (dirname(__FILE__) . '/pages/wiki/edit.php?wiki=');
	}
	//view page
	else {
	
	}
	
}

?>
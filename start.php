<?php
elgg_register_action("wikis/save", dirname(__FILE__) . "/actions/wikis/save.php");

elgg_register_page_handler('socialwiki', 'socialwiki_page_handler');
 
function socialwiki_page_handler($segments) {

	//wiki management pages
    if ($segments[0] == 'wikis') {
		switch($segments[1]) {
			case 'add':
				include (dirname(__FILE__) . '/pages/wikis/add.php');
				break;
				
			case 'manage':			
				$wiki = get_entity($segments[2]);
				
				$area = elgg_view_title("Edit wiki!");
				$area .= elgg_view_form('wikis/save', array(),array('api'=>$wiki->api,'entity'=>$wiki));
			    $body = elgg_view_layout('two_column_left_sidebar', '', $area);
			    echo elgg_view_page($title, $body);
				break;
			default: //wiki overview
				
				break;
		}
		}
	
	//view page
	else {
	
	}
	
}

?>
<?php

elgg_register_event_handler('init', 'system', 'socialwiki_init');

elgg_register_action("wikis/save", dirname(__FILE__) . "/actions/wikis/save.php");

elgg_register_action("wikis/delete", dirname(__FILE__) . "/actions/wikis/delete.php");

elgg_register_page_handler('socialwiki', 'socialwiki_page_handler');
 
function socialwiki_init() {
	// add a site navigation item
	$item = new ElggMenuItem('wikis', 'Wikis', 'socialwiki/wikis/all');
	elgg_register_menu_item('site', $item);
} 
 
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
				$area .= elgg_view('output/url', array('text'=>'Delete this wiki!', 'href'=>"action/wikis/delete?guid=$segments[2]", 'is_action'=>true));
				$area .= elgg_view_form('wikis/save', array(), array('guid'=>$wiki->guid));
			    $body = elgg_view_layout('two_column_left_sidebar', '', $area);
			    echo elgg_view_page($title, $body);
				break;
				
			case 'all':
				$body = elgg_view('output/longtext', array('value'=>'Here you can find a complete list of wikis on our website!'));
				
				$body .= elgg_view('output/url', array('text'=>'Add a new wiki!', 'href'=>'/socialwiki/wikis/add'));
								
				$body .= elgg_list_entities(array(
				    'type' => 'object',
				    'subtype' => 'wiki',
				));
				$body = elgg_view_layout('one_column', $body);
 
				echo elgg_view_page("List of supported wikis!", $body);
				
				break;
			}
		}
	
	//view page
	else {
	
	}
	
}

?>
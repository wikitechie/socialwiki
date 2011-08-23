<?php
	
    $body = elgg_view_title("Wikis");
		
	$body .= elgg_view('output/url', array('text'=>'Add a new wiki!', 'href'=>'/socialwiki/wikis/add'));
					
	$body .= elgg_list_entities(array(
	    'type' => 'object',
	    'subtype' => 'wiki',
	));
	
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo('socialwiki:wikis'));
	
	//elgg_register_title_button('socialwiki/wikis/add','My button');
	
	
	$body = elgg_view_layout('two_column_left_sidebar', '', $body);
 
	echo elgg_view_page("All wikis", $body);
?>
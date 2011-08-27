<?php
	$title = elgg_echo('wiki:all');
    						
	$body = elgg_list_entities(array(
	    'type' => 'object',
	    'subtype' => 'wiki',
	));
	
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo('socialwiki:wikis'));
	
	elgg_register_title_button('wiki','add');
	
	$params = array(
		'content' => $body,//]        HTML of main content area
		'title'=> $title ,//]          Title text (override)
		'filter'=>false,//] Filter context: everyone, friends, mine
		
	);	
	
	$body = elgg_view_layout('content', $params);
		 
	echo elgg_view_page($title, $body);
?>
<?php

	$wiki = get_entity(get_input("wiki_guid"));
	$wiki_page = get_input("wiki_page");
	#FIXME: get_input() is not giving default values !!
	
	elgg_push_breadcrumb(elgg_echo('socialwiki:wikis'),elgg_normalize_url('wiki/all'));
    elgg_push_breadcrumb($wiki->title);
    
    $body = elgg_view_entity($wiki);
   	//layout the page
    $body = elgg_view_layout('two_column_left_sidebar', '', $body);
 
    // draw the page
    echo elgg_view_page($title, $body);

?>
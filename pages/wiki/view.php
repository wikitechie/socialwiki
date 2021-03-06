<?php

	$wiki = get_entity(get_input("wiki_guid"));
	$wiki_page = get_input("wiki_page");
	#FIXME: get_input() is not giving default values !!
	
	elgg_push_breadcrumb(elgg_echo('socialwiki:wikis'),elgg_normalize_url('wiki/all'));
    elgg_push_breadcrumb($wiki->title);
    
    $body = elgg_view_entity($wiki);
    
    $body .="<hr />";
    
    $body .=elgg_view_title("People wikiing on this wiki");
    
    
    
	$wikiusers = elgg_get_entities_from_metadata(array(
		'types'=>'object', 
		'subtypes'=>'wikiuser',
		'metadata_names'=>array('wiki_id'),
		'metadata_values'=>array($wiki->guid)
	));
	if(!$wikiusers)
		$body .= elgg_view('output/longtext', array('value'=>'There are currently no users wikiing on this wiki!'));
	else
		$body .= elgg_view_entity_list($wikiusers, array());
    
   	//layout the page
    $body = elgg_view_layout('two_column_left_sidebar', '', $body);
 
    // draw the page
    echo elgg_view_page($title, $body);

?>
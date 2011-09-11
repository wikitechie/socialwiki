<?php

	
    $wikiuser = get_entity(get_input('wikiuser_guid'));
    
 	$wiki_id = (int)get_input('wiki_id');
 	
	$wikis = elgg_get_entities(array('types'=>'object', 'subtypes'=>'wiki'));
	$options = array();
	foreach ($wikis as $wiki){
		$options[$wiki->guid] = $wiki->title;	
	}
	$content .= elgg_view_form('wikiuser/save',array(),array('entity'=>$wikiuser,'options' => $options, 'wiki_id'=>$wiki_id));
	
	elgg_push_breadcrumb(elgg_echo('wikiuser:my'),elgg_normalize_url('wikiuser'));
    elgg_push_breadcrumb(elgg_echo('wikiuser:add'));
	
	$params = array(
		'content' => $content,//]        HTML of main content area
		'title'=> $title ,//]          Title text (override)
		'filter'=>false,//] Filter context: everyone, friends, mine		
	);	
	$body = elgg_view_layout('content', $params);
		 
	
	echo elgg_view_page('Manage your accounts', $body);

?>

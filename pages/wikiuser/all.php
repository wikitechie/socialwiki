<?php 
    
    		  
	$owner_guid = $segments[1];
	$wikiusers = elgg_get_entities(array('types'=>'object', 'subtypes'=>'wikiuser', 'owner_guids'=>$owner_guid));
	if(!$wikiusers)
		$content .= elgg_view('output/longtext', array('value'=>'You currently have no users!'));
	else
		$content .= elgg_view_entity_list($wikiusers, array());
		
	elgg_register_title_button('wikiuser','add');		
		
	$params = array(
		'content' => $content,//]        HTML of main content area
		'title'=> $title ,//]          Title text (override)
		'filter'=>false,//] Filter context: everyone, friends, mine		
	);	
	$body = elgg_view_layout('content', $params);
		 
	
	echo elgg_view_page('Manage your accounts', $body);
?>

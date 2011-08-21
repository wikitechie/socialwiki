<?php
	
	$title = elgg_view('output/url',array('text'=>$wiki->title,'href'=>$wiki->getURL()));
	
	$options = array(
	       'type'	=>'object',
	       'subtype'=>'wikiactivity',
	       'metadata_name_value_pairs' => array(
				array('name' => 'wiki_id','value' => $wiki->guid)
			),
	       'metadata_name_value_pairs_operator' => 'AND'
	) ;
	$results = elgg_get_entities_from_metadata($options);
	
	$content = elgg_view_entity_list($results);
	
		
	$params = array(
		'content' => $content,//]        HTML of main content area
		'title'=> 'Amjad' ,//]          Title text (override)
		'filter_context'=>'all',//] Filter context: everyone, friends, mine					
	);	
	
	$body = elgg_view_layout('content', $params);
		
	echo elgg_view_page("Wiki activity", $body);	
	
?>
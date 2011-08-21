<?php
	
	$title = "Recent changes of ".elgg_view('output/url',array('text'=>$wiki->title,'href'=>$wiki->getURL()));
	
	$options = array(
	       'type'	=>'object',
	       'subtype'=>'wikiactivity',
	       'metadata_name_value_pairs' =>  array(
				array('name' => 'wiki_id','value' => $wiki->guid)
			),
	       'metadata_name_value_pairs_operator' => 'AND'
	) ;
	

	
	$loggedin_userid = elgg_get_logged_in_user_guid();	
	switch ($wiki_context) {
		case 'mine':
			array_push($options, array('name' => 'owner_guid','value' => $loggedin_userid));			
			break;
		case 'friends':
			break;
	}
	
	$results = elgg_get_entities_from_metadata($options);

	
	$content = elgg_view_entity_list($results);
	$context = "socialwiki/wikis/".$wiki->guid."/recentchanges";
	
		
	$params = array(
		'content' => $content,//]        HTML of main content area
		'title'=> $title ,//]          Title text (override)
		'filter_context'=>$wiki_context,//] Filter context: everyone, friends, mine
		'context' =>$context
	);	
	
	$body = elgg_view_layout('content', $params);
		
	echo elgg_view_page("Wiki activity", $body);	
	
?>
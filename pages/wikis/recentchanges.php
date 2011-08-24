<?php
	$wiki = get_entity(get_input("wiki_guid"));
	$title = elgg_echo('socialwiki:recentchanges')." at ".$wiki->title;
	
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
	
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo('socialwiki:wikis'),elgg_normalize_url('socialwiki/wikis/all'));
	elgg_push_breadcrumb($wiki->title,$wiki->getURL());
	elgg_push_breadcrumb(elgg_echo('socialwiki:recentchanges'));
	
	$body = elgg_view_layout('content', $params);
		
	echo elgg_view_page("Wiki activity", $body);	
	
?>
<?php

  // get the form input
  $username = get_input('username');
  $password = get_input('password');
  $wiki_id = get_input('wiki_id');
  $guid = get_input('guid');
  $owner_guid = elgg_get_logged_in_user_guid();
  
  if(!$guid){  	
	  // create a new wikiuser object
	  $wikiuser = new ElggObject();  
	  $wikiuser->subtype = "wikiuser";
  
    	$options = array(
			'type'		=> 'object',
			'subtype'	=> 'wikiuser',
  			'owner_guid' => $owner_guid,
			'metadata_name_value_pairs' => array(
				array('name' => 'wikiuser_name','value' => $username),
				array('name' => 'wiki_id','value' => $wiki_id)
				
			),
			'metadata_name_value_pairs_operator' => 'AND'
		);
		$users = elgg_get_entities_from_metadata($options);
		
		if ($users){
			register_error(elgg_echo('wikiuser:duplication',array($username)));
			forward(REFERER);
						
		}
  }
  else {
  	//edit existing wikiuser object
  	$wikiuser = get_entity($guid);
  }


	
	$wikiuser->title = $username;
	$wikiuser->wikiuser_name = $username;
	//$wikiuser->description = $body;
	 
	$wikiuser->access_id = ACCESS_PUBLIC;
	 
	// owner is logged in user
	$wikiuser->owner_guid = $owner_guid;
	
 	if(!sw_user_check($username, $password, $wiki_id)) {
		forward(REFERER);
	}
	// save to database
	$wikiuser->save();
	  
	$wikiuser->password = $password;
	
	 
	$wikiuser->save();
	
	
	
	add_entity_relationship($wiki_id, 'wiki_father', $owner_guid);	
	add_entity_relationship($wikiuser->guid, 'wiki_member', $wiki_id );

	$wikiuser->wiki_id = $wiki_id;
	$wikiuser->save();
		
	forward(get_entity($wiki_id)->getURL());			
	
  
?>
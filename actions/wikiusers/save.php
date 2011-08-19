<?php
  echo "I'm here!";

  // get the form input
  $username = get_input('username');
  $password = get_input('password');
  $wiki_id = get_input('wikiuser_id');
  $guid = get_input('guid');
  
  if(!$guid){  	
	  // create a new wikiuser object
	  $wikiuser = new ElggObject();  
	  $wikiuser->subtype = "wikiuser";	
  }
  else {
  	//edit existing wikiuser object
  	$wikiuser = get_entity($guid);
  } 
  
  
  $wikiuser->title = $username;
  //$wikiuser->description = $body;
 
  $wikiuser->access_id = ACCESS_PUBLIC;
 
  // owner is logged in user
  $wikiuser->owner_guid = elgg_get_logged_in_user_guid();
 
  $wikiuser->password = $password;
  $wikiuser->wiki_id = $wiki_id;
 
  // save to database
  $wikiuser->save();
 
  // forward user to a page that displays the post
  forward($wikiuser->getURL());
  
?>
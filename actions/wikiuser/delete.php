<?php

$wikiuser_guid = get_input('guid');
$wikiuser = get_entity($wikiuser_guid);

$wiki_id = $wikiuser->wiki_id;
$owner_guid = $wikiuser->owner_guid;

	if ($wikiuser->delete()){
		remove_entity_relationship($wiki_id, 'wiki_father', $owner_guid);	
		remove_entity_relationship($wikiuser_guid, 'wiki_member', $wiki_id );
		system_message("You disconnected your user sucessfully");		
	}
	else{ 
		register_error("Could not pereform deleting action");
	}
	
	forward(get_entity($wiki_id)->getURL());			
	
  
?>
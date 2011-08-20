<?php

$wikiuser_guid = get_input('guid');
$wikiuser= get_entity($wikiuser_guid);

	if ($wikiuser->delete()){ 
		system_message("WikiUser deleted!");
		forward('socialwiki/wikiusers/all');
	}
	else{ 
		register_error("Could not pereform deleting action");
		forward("/socialwiki/wikiusers/manage/$wiki_guid");
	}
	

  
?>
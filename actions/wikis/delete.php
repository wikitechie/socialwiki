<?php

$wiki_guid = get_input('guid');
$wiki= get_entity($wiki_guid);

	if ($wiki->delete()){ 
		system_message("Wiki deleted!");
		forward('socialwiki/wikis/all');
	}
	else{ 
		register_error("Could not pereform deleting action");
		forward("/socialwiki/wikis/manage/$wiki_guid");
	}
	

  
?>
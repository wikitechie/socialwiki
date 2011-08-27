<?php

$wiki_guid = get_input('guid');
$wiki= get_entity($wiki_guid);

	if ($wiki->delete()){ 
		system_message("Wiki deleted!");
		forward('socialwiki/wiki/all');
	}
	else{ 
		register_error("Could not pereform deleting action");
		forward("/socialwiki/wiki/manage/$wiki_guid");
	}
	

  
?>
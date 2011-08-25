<?php

$wikiuser_guid = get_input('guid');
$wikiuser= get_entity($wikiuser_guid);

	if ($wikiuser->delete()){ 
		system_message("Wikiuser deleted!");		
	}
	else{ 
		register_error("Could not pereform deleting action");
	}
	
	forward('/wikiuser');

  
?>
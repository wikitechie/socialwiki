<?php
	
    $body = elgg_view('output/longtext', array('value'=>'Here you can find a complete list of wikis on our website!'));
	
	$body .= elgg_view('output/url', array('text'=>'Add a new wiki!', 'href'=>'/socialwiki/wikis/add'));
					
	$body .= elgg_list_entities(array(
	    'type' => 'object',
	    'subtype' => 'wiki',
	));
	$body = elgg_view_layout('one_column', $body);
 
	echo elgg_view_page("List of supported wikis!", $body);
?>
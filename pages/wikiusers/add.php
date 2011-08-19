<?php 
    
    
	$content = elgg_view_title('MediaWiki accounts');
	
	$content .= elgg_view('output/longtext', array('value'=>'Here you can manage your accounts on [[MediaWiki]]-based wikis.'));
	
	$content = elgg_view_title('Current Accounts');
	  
	$owner_guid = $segments[1];
	$wikiusers = elgg_get_entities(array('types'=>'object', 'subtypes'=>'wikiuser', 'owner_guids'=>$owner_guid));
	if(!$wikiusers)
		$content .= elgg_view('output/longtext', array('value'=>'You currently have no users!'));
	else
		foreach ($wikiusers as $wikiuser)
			$content .= $wikiuser->title."<br />";
		

	$content .= "<hr />";
	$content .= elgg_view_title('Add a new account');
 
$wikis = elgg_get_entities(array('types'=>'object', 'subtypes'=>'wiki'));
$options = array();
foreach ($wikis as $wiki){
	$options[$wiki->guid] = $wiki->title;	
}

$content .= elgg_view_form('wikiusers/save',array(),array('wiki_options' => $options));
$body = elgg_view_layout('two_column_left_sidebar', '', $content);

echo elgg_view_page('Manage your accounts', $body);



?>

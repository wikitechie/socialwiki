<?php

	
    $wiki = get_entity(get_input('wiki_guid'));
    $body_vars = array(
    	'title'	=> $wiki->title,
    	'guid'	=> $wiki->guid,
    	'body'	=> $wiki->description,
    	'url'	=> $wiki->url,
    	'api'	=> $wiki->api
    );
    $body_vars['entity'] = $wiki;
    
    if (elgg_is_sticky_form('wiki_edit')) {
    	$sticky_values = elgg_get_sticky_values('wiki_edit');
    	foreach ($sticky_values as $key => $value) {
    		$body_vars[$key] = $value;
    	}
    }
    
    elgg_clear_sticky_form('wiki_edit');
    
	$area = elgg_view_title("Edit wiki!");
	$area .= elgg_view('output/url', array('text'=>'Delete this wiki!', 'href'=>"action/wiki/delete?guid=$segments[2]", 'is_action'=>true));
	
	$form_vars = array(
		'enctype' => 'multipart/form-data',
		'class' => 'elgg-form-alt',
	);
	
	elgg_push_breadcrumb(elgg_echo('socialwiki:wikis'), elgg_normalize_url('socialwiki/wiki/all'));
	elgg_push_breadcrumb($wiki->title, $wiki->getURL());
	elgg_push_breadcrumb('Manage');
	
	$area .= elgg_view_form('wiki/save', $form_vars, $body_vars);
    $body = elgg_view_layout('two_column_left_sidebar', '', $area);
    echo elgg_view_page($title, $body);
	
?>
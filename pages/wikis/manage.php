<?php
	
    $wiki = get_entity($segments[2]);
				
	$area = elgg_view_title("Edit wiki!");
	$area .= elgg_view('output/url', array('text'=>'Delete this wiki!', 'href'=>"action/wikis/delete?guid=$segments[2]", 'is_action'=>true));
	
	$form_vars = array(
		'enctype' => 'multipart/form-data',
		'class' => 'elgg-form-alt',
	);
	
	elgg_push_breadcrumb(elgg_echo('socialwiki:wikis'), elgg_normalize_url('socialwiki/wikis/all'));
	elgg_push_breadcrumb($wiki->title, $wiki->getURL());
	elgg_push_breadcrumb('Manage');
	
	$area .= elgg_view_form('wikis/save', $form_vars, array('guid'=>$wiki->guid));
    $body = elgg_view_layout('two_column_left_sidebar', '', $area);
    echo elgg_view_page($title, $body);
	
?>
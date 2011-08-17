<?php
	
	$title = elgg_view('output/url',array('text'=>$wiki->title,'href'=>$wiki->getURL()));
	$title .= " >> Recent changes";
	
	$list = elgg_get_entities(array('types'=>'object','subtypes'=>'wiki'));
	
	$params = array(
		'content' => $list,//]        HTML of main content area
		'sidebar'=> '',//]        HTML of the sidebar
		'header'=>'',//]         HTML of the content area header (override)
		'nav'=>'',//]            HTML of the content area nav (override)
		'footer'=>'',//]         HTML of the content area footer
		'filter'=>'',//]         HTML of the content area filter (override)
		'title'=> $title ,//]          Title text (override)
		'context'=>'',//]        Page context (override)
		'filter_context'=>'all',//] Filter context: everyone, friends, mine
		'class'=>''//]          Additional class to apply to layout						
	);
	
	$body = elgg_view_layout('content', $params);
	
	echo elgg_view_page("Wiki activity", $body);	
	
?>
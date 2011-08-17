<?php	
	$title = elgg_view('output/url',array('text'=>$wiki->title,'href'=>$wiki->getURL()))." >> ".($page->getTitle());
	$body = elgg_view_title($title);
	$body .= elgg_view('output/longtext',array('value'=>$page->getText()));					
    $body = elgg_view_layout('two_column_left_sidebar', '', $body);
	echo elgg_view_page("Social Browser", $body);
?>
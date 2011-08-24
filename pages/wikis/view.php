<?php
	elgg_load_library("elgg:wikimate");
	$wiki = get_entity(get_input("wiki_guid"));
	$wiki_page = get_input("wiki_page","MainPage");
	$_GET["api"] = $wiki->api;
	$_SERVER['REQUEST_METHOD']="GET";
	$requester = new Wikimate();
	$page = $requester->getPage($wiki_page);
	
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo('socialwiki:wikis'),elgg_normalize_url('socialwiki/wikis/all'));
	elgg_push_breadcrumb($wiki->title, $wiki->getURL());
	elgg_push_breadcrumb("Social browser");
	elgg_push_breadcrumb($page->getTitle());
	
	$body = elgg_view_title($page->getTitle());
	$body .= elgg_view('output/longtext',array('value'=>$page->getText()));					
    $body = elgg_view_layout('two_column_left_sidebar', '', $body);
	echo elgg_view_page("Social Browser", $body);
?>
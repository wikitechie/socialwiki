<?php
	
	$title = elgg_view('output/url',array('text'=>$wiki->title,'href'=>$wiki->getURL()));
	$title .= " >> Recent changes";
	
	include_once('../../wikimate/globals.php');
	
	// some useful functions :)
	function inc_time_str($base,$format="Y-m-d H:i:s")
	{
		$temp	=strtotime($base);
		$newtime=strtotime("+1 second",$temp);
		$newtime=date($format,$newtime);
		return $newtime;
	}
	
	$_GET["api"] = $wiki->api;
	$_SERVER['REQUEST_METHOD']="GET";
	if (isset($requester)) unset($requester);
	$requester = new Wikimate;
	$data = array(
		'list' => 'recentchanges',
		'rcprop' => 'user|comment|timestamp|title|ids|sizes|redirect|loginfo|flags',
		'rcend' => $wiki->get('rcstart'),		
		'rclimit' => 10
	);
	$results = $requester->query( $data );
	
	$content;
	
	foreach ($results['query']['recentchanges'] as $recentchange){
		$content .= "<p>".print_r($recentchange, true)."</p>";
		$check_user = 1;
		
		if($check_user){
			$wikiactivity = new ElggObject();
			$wikiactivity->subtype = "wikiactivity";
			$wikiactivity->title =  $recentchange['title'];
			$wikiactivity->descritption =  $recentchange['comment'];
			$wikiactivity->access_id = 2; 
			if($wikiactivity->save())		
				add_to_river(
					'river/object/wikiactivity/create',
					'create',
					elgg_get_logged_in_user_guid(),
					$wikiactivity->getGUID());	
		}				
	}
	
	if($list = elgg_get_entities(array('types'=>'object'),array('subtypes'=>'blog')))
		$content .= elgg_view_entity_list($list, array('count'=>100));
	else
		$content .= "No list!";
	
	$params = array(
		'content' => $content,//]        HTML of main content area
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
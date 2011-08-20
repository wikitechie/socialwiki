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
		'rcend' => $wiki->rcstart,		
		'rclimit' => 10
	);
	$results = $requester->query( $data );
	
	$content;
	
	//some code to check the validatiy of our request
	$changes_count=count($results['query']['recentchanges']);
	if($results && (count($results)>0) && ($changes_count>0) )		
		foreach ($results['query']['recentchanges'] as $recentchange){
			$options = array(
			       'type'	=>'object',
			       'subtype'=>'wikiuser'
			,
			       'metadata_name_value_pairs' => array(
						array('matadata_name' => 'wikiuser_name','matadata_value' => $recentchange['user']),
						array('matadata_name' => 'wiki_id','matadata_value' => $wiki->title)
					),
			       'metadata_name_value_pairs_operator' => 'AND'
			) ;
			$results = elgg_get_entities_from_metadata($options);
			$check_user = count($results); //to be replaced with checking user code
			
			if($check_user){
				$content .= "<p>".print_r($recentchange, true)."</p>";
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
	//recording last time we visited fetched this wiki	
	$rcts=$results['query']['recentchanges'][0]['timestamp'];
	$wiki->rcend = inc_time_str($rcts);
	$wiki->last_rcid = $results['query']['recentchanges'][0]['rcid'];	
	$wiki->save();	
		
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
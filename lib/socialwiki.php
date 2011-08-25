<?php
define("WIKI_USERNAME", "");
define("WIKI_PASSWORD", "");
function inc_time_str($base,$format="Y-m-d H:i:s")
{
	$temp	=strtotime($base);
	$newtime=strtotime("+1 second",$temp);
	$newtime=gmdate($format,$newtime);
	return $newtime;
}

function sw_update_wiki_changes($wiki) {
	elgg_load_library("elgg:wikimate");
	if (isset($requester)) unset($requester);
	$requester = new Wikimate($wiki->api);
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
	{
		foreach ($results['query']['recentchanges'] as $recentchange){
			$options = array(
					'type'		=> 'object',
					'subtype'	=> 'wikiuser',
					'metadata_name_value_pairs' => array(
							array('name' => 'wikiuser_name','value' => $recentchange['user']),
							array('name' => 'wiki_id','value' => $wiki->guid)
					),
					'metadata_name_value_pairs_operator' => 'AND'
			) ;
			$user_results = elgg_get_entities_from_metadata($options);
			
			$check_user = count($user_results);
			print_r($results['query']['recentchanges']);
			if($check_user){
				echo "user checked";
				$actor = $user_results[0]; 
				$user_guid = $actor->getOwnerGUID(); // getting author name
				$content .= "<p>".print_r($recentchange, true)."</p>";
				$wikiactivity = new ElggObject();
				$wikiactivity->subtype = "wikiactivity";
				$wikiactivity->title =  $recentchange['title'];
				$wikiactivity->descritption =  $recentchange['comment'];
				$wikiactivity->access_id = 2;
				$wikiactivity->wiki_id = $wiki->guid;
				if($wikiactivity->save())
				add_to_river(
								'river/object/wikiactivity/create',
								'create',
				$user_guid,
				$wikiactivity->getGUID());
			}
		}
		//recording last time we visited fetched this wiki
		$rcts=$results['query']['recentchanges'][0]['timestamp'];
		$wiki->rcstart = inc_time_str($rcts);
		$wiki->last_rcid = $results['query']['recentchanges'][0]['rcid'];
		$wiki->save();
		echo "done";
	}
	else
	{
		echo "no changes";
		echo "<br/> rcstart : $wiki->rcstart <br/>";
	}
}
function sw_update_all_changes() {
	$wikis = elgg_get_entities(array(
				'type' => 'object',
				'subtype' => 'wiki'
				)
	);
	foreach ($wikis as $wiki){
		sw_update_wiki_changes($wiki);
	}
	
}

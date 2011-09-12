<?php
	elgg_load_library("elgg:wikimate");
	$id = (int)$vars['id'];
	/** @var ElggRiverItem */
	$item = elgg_get_river(array('ids'=>$id));
	$item = $item[0];
	/** @var ElggObject */
	$wikiactivity = $item->getObjectEntity();
	if ($wikiactivity->diff == "") {
		sw_update_wiki_diff($wikiactivity);
	}
	echo $wikiactivity->diff;
	
?>
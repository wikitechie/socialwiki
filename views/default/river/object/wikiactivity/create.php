<?php
/**
 * Wikiactivity river view.
 */

$object = $vars['item']->getObjectEntity();
$subject = $vars['item']->getSubjectEntity();
$wiki = get_entity($object->wiki_id);

$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
));


$object_url = str_replace('api', 'index', $wiki->api)."?title=".$object->title;

$object_link = elgg_view('output/url', array(
	'href' => $object_url,
	'text' => $object->title ? $object->title : $object->name,
	'class' => 'elgg-river-object',
));

$summary = elgg_echo("river:create:object:wikiactivity", array($subject_link, $object_link , $wiki_link));

//diff
$toggleDiff_link = "<p><a href='#toggleDiff' >" . elgg_echo("wikiactivity:hide:diff") . "</a></p>";
$page_diff = "<div class='wiki-data sliding-extender'>" . $object->diff . "$toggleDiff_link </div>";

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $object->descritption,
	'summary'	=> $summary,
	'attachments' => $page_diff
));
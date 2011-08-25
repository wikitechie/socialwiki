<?php
/**
 * ElggObject default view.
 *
 * @warning This view may be used for other ElggEntity objects
 *
 * @package Elgg
 * @subpackage Core
 */


$wikiuser = $vars['entity'];
$wiki = get_entity($wikiuser->wiki_id);

$icon = elgg_view_entity_icon($wiki, 'small');

$title = $vars['entity']->title;
if (!$title) {
	$title = $vars['entity']->name;
}
if (!$title) {
	$title = get_class($vars['entity']);
}

if (elgg_instanceof($vars['entity'], 'object')) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $wikiuser,
		'handler' => 'wikiuser',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

$owner_link = '';
$owner = $vars['entity']->getOwnerEntity();
if ($owner) {
	$owner_link = elgg_view('output/url', array(
		'href' => $owner->getURL(),
		'text' => $owner->name,
	));
}

$date = elgg_view_friendly_time($vars['entity']->time_created);

$subtitle = $wiki->title;

$params = array(
	'entity' => $vars['entity'],
	'title' => $title,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'tags' => $vars['entity']->tags,
);
$params = $params + $vars;
$body = elgg_view('object/elements/summary', $params);

echo elgg_view_image_block($icon, $body);

<?php
/**
 * Wikiactivity river view.
 */

$object = $vars['item']->getObjectEntity();

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $object->comment
));
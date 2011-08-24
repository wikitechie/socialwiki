<?php
/**
 * Icon display
 *
 * @package Elggwikis
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$wiki_guid = get_input('wiki_guid');
$wiki = get_entity($wiki_guid);

$size = strtolower(get_input('size'));
if (!in_array($size,array('large','medium','small','tiny','master','topbar')))
	$size = "medium";

$success = false;

$filehandler = new ElggFile();
$filehandler->owner_guid = $wiki->owner_guid;
$filehandler->setFilename("wikis/" . $wiki->guid . $size . ".jpg");

$success = false;
if ($filehandler->open("read")) {
	if ($contents = $filehandler->read($filehandler->size())) {
		$success = true;
	}
}

if (!$success) {
	$location = elgg_get_plugins_path() . "wikis/graphics/default{$size}.jpg";
	$contents = @file_get_contents($location);
}

header("Content-type: image/jpeg");
header('Expires: ' . date('r',time() + 864000));
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));
echo $contents;

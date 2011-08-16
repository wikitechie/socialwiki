<?php

include('globals.php');
$wiki = new Wikimate;

	$data = array(
		'list' => 'recentchanges',
	);
	
	// Send data as a query
	$array_result = $wiki->query( $data );
	
	foreach ($array_result as $value)
		echo $value."</br>";
?>
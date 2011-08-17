<div>Here you can manage your accounts on MediaWiki-based wikis.</div>

<?php 
$wikis = elgg_get_entities(array('types'=>'object', 'subtypes'=>'wiki'));
$options = array();
foreach ($wikis as $wiki){
	$options[$wiki->guid] = $wiki->title;	
}
?>

<div>
<label>Choose a wiki:</label>
<?php echo elgg_view('input/dropdown', array('options'=>$options));?>
</div>

<div>
<label>Username</label>
<?php echo elgg_view('input/text', array('name'=>'username'));?>
</div>

<div>
<label>Password</label>
<?php echo elgg_view('input/password', array('name'=>'password'));?>
</div>

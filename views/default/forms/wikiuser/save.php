<?php 

if ($vars['entity'])
	echo elgg_view('input/hidden',array('internalname' => 'guid', 'value'=>$vars['entity']->guid));
	
?>

<div>
<label>Wiki:</label>
<?php echo elgg_view('input/dropdown', array('internalname'=>'wiki_id','options_values'=>$vars['options'], 'value'=>$vars['entity']->wiki_id));?>
    
</div>

<div>
<label>Username</label>
<?php echo elgg_view('input/text', array('internalname'=>'username', 'value'=>$vars['entity']->wikiuser_name));?>
</div>

<div>
<label>Password</label>
<?php echo elgg_view('input/password', array('internalname'=>'password', 'value'=>$vars['entity']->password));?>
</div>

<div><?php 
$button = "save";
if($vars['entity']) $button = "edit";
echo elgg_view('input/submit', array('value' => elgg_echo($button))); ?>
</div>
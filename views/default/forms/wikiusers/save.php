<div>
<label>Username</label>
<?php echo elgg_view('input/text', array('internalname'=>'username'));?>
</div>

<div>
<label>Password</label>
<?php echo elgg_view('input/password', array('internalname'=>'password'));?>
</div>

<div>
<label>Choose a wiki:</label>
<?php echo elgg_view('input/dropdown', array('internalname'=>'wikiuser_id','options'=>$vars['wiki_options']));?>

    <?php echo elgg_view('input/submit', array('value' => elgg_echo('add'))); ?>
</div>
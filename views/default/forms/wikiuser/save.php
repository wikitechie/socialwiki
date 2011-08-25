<div>
<label>Username</label>
<?php echo elgg_view('input/text', array('internalname'=>'username', 'value'=>$vars['entity']->wikiuser_name));?>
</div>

<div>
<label>Password</label>
<?php echo elgg_view('input/password', array('internalname'=>'password', 'value'=>$vars['entity']->password));?>
</div>

<div>
<label>Choose a wiki:</label>
<?php echo elgg_view('input/dropdown', array('internalname'=>'wiki_id','options_values'=>$vars['options'], 'value'=>$vars['entity']->wiki_id));?>

    <?php echo elgg_view('input/submit', array('value' => elgg_echo('add'))); ?>
</div>
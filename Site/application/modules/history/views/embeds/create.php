<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class='alert alert-block alert-error fade in'>
	<a class='close' data-dismiss='alert'>&times;</a>
	<h4 class='alert-heading'>
		<?php echo lang('history_errors_message'); ?>
	</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

$id = isset($history->id) ? $history->id : '';

?>
<div class='admin-box'>
	<h3>History</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
            

			<div class="control-group<?php echo form_error('ipaddress') ? ' error' : ''; ?>">
				<?php echo form_label('Ipaddress', 'ipaddress', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='ipaddress' type='text' name='ipaddress' maxlength='100' value="<?php echo set_value('ipaddress', isset($history->ipaddress) ? $history->ipaddress : ''); ?>" />
					<span class='help-inline'><?php echo form_error('ipaddress'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('createdon') ? ' error' : ''; ?>">
				<?php echo form_label('Createdon', 'createdon', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='createdon' type='text' name='createdon'  value="<?php echo set_value('createdon', isset($history->createdon) ? $history->createdon : ''); ?>" />
					<span class='help-inline'><?php echo form_error('createdon'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('modifiedon') ? ' error' : ''; ?>">
				<?php echo form_label('Modifiedon', 'modifiedon', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='modifiedon' type='text' name='modifiedon'  value="<?php echo set_value('modifiedon', isset($history->modifiedon) ? $history->modifiedon : ''); ?>" />
					<span class='help-inline'><?php echo form_error('modifiedon'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('pageurl') ? ' error' : ''; ?>">
				<?php echo form_label('Pageurl', 'pageurl', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='pageurl' type='text' name='pageurl' maxlength='100' value="<?php echo set_value('pageurl', isset($history->pageurl) ? $history->pageurl : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pageurl'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('count') ? ' error' : ''; ?>">
				<?php echo form_label('Count', 'count', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='count' type='text' name='count' maxlength='11' value="<?php echo set_value('count', isset($history->count) ? $history->count : ''); ?>" />
					<span class='help-inline'><?php echo form_error('count'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('instances') ? ' error' : ''; ?>">
				<?php echo form_label('Instances', 'instances', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='instances' type='text' name='instances' maxlength='11' value="<?php echo set_value('instances', isset($history->instances) ? $history->instances : ''); ?>" />
					<span class='help-inline'><?php echo form_error('instances'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('active') ? ' error' : ''; ?>">
				<div class='controls'>
					<label class='checkbox' for='active'>
						<input type='checkbox' id='active' name='active'  value='1' <?php echo set_checkbox('active', 1, isset($history->active) && $history->active == 1); ?> />
                        'Active'
					</label>
                    <span class='help-inline'><?php echo form_error('active'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('embedid') ? ' error' : ''; ?>">
				<?php echo form_label('Embedid', 'embedid', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='embedid' type='text' name='embedid' maxlength='11' value="<?php echo set_value('embedid', isset($history->embedid) ? $history->embedid : ''); ?>" />
					<span class='help-inline'><?php echo form_error('embedid'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('isedited') ? ' error' : ''; ?>">
				<div class='controls'>
					<label class='checkbox' for='isedited'>
						<input type='checkbox' id='isedited' name='isedited'  value='1' <?php echo set_checkbox('isedited', 1, isset($history->isedited) && $history->isedited == 1); ?> />
                        'Isedited'
					</label>
                    <span class='help-inline'><?php echo form_error('isedited'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('editedembedid') ? ' error' : ''; ?>">
				<?php echo form_label('Editedembedid', 'editedembedid', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='editedembedid' type='text' name='editedembedid' maxlength='11' value="<?php echo set_value('editedembedid', isset($history->editedembedid) ? $history->editedembedid : ''); ?>" />
					<span class='help-inline'><?php echo form_error('editedembedid'); ?></span>
				</div>
			</div>
        </fieldset>
		<fieldset class='form-actions'>
			<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('history_action_create'); ?>" />
			<?php echo lang('bf_or'); ?>
			<?php echo anchor(SITE_AREA . '/embeds/history', lang('history_cancel'), 'class="btn btn-warning"'); ?>
			
		</fieldset>
    <?php echo form_close(); ?>
</div>
<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class='alert alert-block alert-error fade in'>
	<a class='close' data-dismiss='alert'>&times;</a>
	<h4 class='alert-heading'>
		<?php echo lang('templates_errors_message'); ?>
	</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

$id = isset($templates->id) ? $templates->id : '';

?>
<div class='admin-box'>
	<h3>Templates</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
            

			<div class="control-group<?php echo form_error('name') ? ' error' : ''; ?>">
				<?php echo form_label('Name', 'name', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='name' type='text' name='name' maxlength='100' value="<?php echo set_value('name', isset($templates->name) ? $templates->name : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('filename') ? ' error' : ''; ?>">
				<?php echo form_label('Filename', 'filename', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='filename' type='text' name='filename' maxlength='100' value="<?php echo set_value('filename', isset($templates->filename) ? $templates->filename : ''); ?>" />
					<span class='help-inline'><?php echo form_error('filename'); ?></span>
				</div>
			</div>

			
        </fieldset>
		<fieldset class='form-actions'>
			<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('templates_action_edit'); ?>" />
			<?php echo lang('bf_or'); ?>
			<?php echo anchor(SITE_AREA . '/embeds/templates', lang('templates_cancel'), 'class="btn btn-warning"'); ?>
			
			<!--<?php if ($this->auth->has_permission('Templates.Embeds.Delete')) : ?>
				<?php echo lang('bf_or'); ?>
				<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('templates_delete_confirm'))); ?>');">
					<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('templates_delete_record'); ?>
				</button>
			<?php endif; ?>-->
		</fieldset>
    <?php echo form_close(); ?>
</div>
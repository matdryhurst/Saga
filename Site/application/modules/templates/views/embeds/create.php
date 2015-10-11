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
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
            

			<div class="control-group<?php echo form_error('name') ? ' error' : ''; ?>">
				<?php echo form_label('Name', 'name', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='name' type='text' name='name' maxlength='100' value="<?php echo set_value('name', isset($templates->name) ? $templates->name : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('filename') ? ' error' : ''; ?>">
				<?php echo form_label('Zip file', 'filename', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='filename' type='file' name='filename' value="<?php echo set_value('filename'); ?>" />
					<span class='help-inline'><?php echo form_error('filename'); ?></span>
				</div>
			</div>

			
        </fieldset>
		<fieldset class='form-actions'>
			<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('templates_action_create'); ?>" />
			<?php echo lang('bf_or'); ?>
			<?php echo anchor(SITE_AREA . '/embeds/templates', lang('templates_cancel'), 'class="btn btn-warning"'); ?>
			
		</fieldset>
    <?php echo form_close(); ?>
</div>
<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class='alert alert-block alert-error fade in'>
	<a class='close' data-dismiss='alert'>&times;</a>
	<h4 class='alert-heading'>
		<?php echo lang('editedembed_errors_message'); ?>
	</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

$id = isset($editedembed->id) ? $editedembed->id : '';

?>
<div class='admin-box'>
	<h3>EditedEmbed</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
            <div class="control-group<?php echo form_error('name') ? ' error' : ''; ?>">
				<?php echo form_label('Name', 'name', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='name' type='text' name='name' maxlength='100' value="<?php echo set_value('name', isset($editedembed->name) ? $editedembed->name : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('sourceurl') ? ' error' : ''; ?>">
				<?php echo form_label('Sourceurl', 'sourceurl', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='sourceurl' type='text' name='sourceurl' maxlength='100' value="<?php echo $goodies['embed']->sourceurl ?>" />
					<span class='help-inline'><?php echo form_error('sourceurl'); ?></span>
				</div>
			</div>

			<!-- <div class="control-group<?php echo form_error('count') ? ' error' : ''; ?>">
				<?php echo form_label('Count', 'count', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='count' type='text' name='count' maxlength='11' value="<?php echo set_value('count', isset($editedembed->count) ? $editedembed->count : ''); ?>" />
					<span class='help-inline'><?php echo form_error('count'); ?></span>
				</div>
			</div> -->

			<div class="control-group<?php echo form_error('embedid') ? ' error' : ''; ?>">
				<?php echo form_label('Embedid', 'embedid', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='embedid' type='text' name='embedid' maxlength='11' value="<?php  echo $goodies['embed']->name  ?>" disabled/>
					<span class='help-inline'><?php echo form_error('embedid'); ?></span>
				</div>
			</div>

			<!-- <div class="control-group<?php echo form_error('created_on') ? ' error' : ''; ?>">
				<?php echo form_label('Created On', 'created_on', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='created_on' type='text' name='created_on'  value="<?php echo set_value('created_on', isset($editedembed->created_on) ? $editedembed->created_on : ''); ?>" />
					<span class='help-inline'><?php echo form_error('created_on'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('modified_on') ? ' error' : ''; ?>">
				<?php echo form_label('Modified On', 'modified_on', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='modified_on' type='text' name='modified_on'  value="<?php echo set_value('modified_on', isset($editedembed->modified_on) ? $editedembed->modified_on : ''); ?>" />
					<span class='help-inline'><?php echo form_error('modified_on'); ?></span>
				</div>
			</div> -->

			<!-- <div class="control-group<?php echo form_error('deleted_on') ? ' error' : ''; ?>">
				<?php echo form_label('Deleted On', 'deleted_on', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='deleted_on' type='text' name='deleted_on'  value="<?php echo set_value('deleted_on', isset($editedembed->deleted_on) ? $editedembed->deleted_on : ''); ?>" />
					<span class='help-inline'><?php echo form_error('deleted_on'); ?></span>
				</div>
			</div> -->

			
        </fieldset>
		<fieldset class='form-actions'>
			<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('editedembed_action_create'); ?>" />
			<?php echo lang('bf_or'); ?>
			<?php echo anchor(SITE_AREA . '/embeds/editedembed', lang('editedembed_cancel'), 'class="btn btn-warning"'); ?>
			
		</fieldset>
    <?php echo form_close(); ?>
</div>
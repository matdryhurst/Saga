<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class='alert alert-block alert-error fade in'>
	<a class='close' data-dismiss='alert'>&times;</a>
	<h4 class='alert-heading'>
		<?php echo lang('embedcontent_errors_message'); ?>
	</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

$id = isset($embedcontent->id) ? $embedcontent->id : '';

?>
<div class='admin-box'>
	<h3>EmbedContent</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
            

			<div class="control-group<?php echo form_error('name') ? ' error' : ''; ?>">
				<?php echo form_label('Name'. lang('bf_form_label_required'), 'name', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='name' type='text' required='required' name='name' maxlength='100' value="<?php echo set_value('name', isset($embedcontent->name) ? $embedcontent->name : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>

			<!-- <div class="control-group<?php echo form_error('count') ? ' error' : ''; ?>">
				<?php echo form_label('Count', 'count', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='count' type='text' name='count' maxlength='11' value="<?php echo set_value('count', isset($embedcontent->count) ? $embedcontent->count : ''); ?>" />
					<span class='help-inline'><?php echo form_error('count'); ?></span>
				</div>
			</div> -->

			<div class="control-group<?php echo form_error('templateid') ? ' error' : ''; ?>">
				
				
					<?php echo form_dropdown(array('name' => 'templateid', 'class' => 'required'), $templatesDrop, set_value('templateid', isset($embedcontent->templateid) ? $embedcontent->templateid : ''),'Template *'); ?>
					
					<span class='help-inline'><?php echo form_error('templateid'); ?></span>
				
			</div>
			
			<!-- <div class="control-group<?php echo form_error('sourceurtemplateidl') ? ' error' : ''; ?>">
				<?php echo form_label('Sourceurl'. lang('bf_form_label_required'), 'sourceurl', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='sourceurl' type='text' required='required' name='sourceurl' maxlength='100' value="<?php echo set_value('sourceurl', isset($embedcontent->sourceurl) ? $embedcontent->sourceurl : ''); ?>" />
					<span class='help-inline'><?php echo form_error('sourceurl'); ?></span>
				</div>
			</div> -->

			<div class="control-group<?php echo form_error('active') ? ' error' : ''; ?>">
				<div class='controls'>
					<label class='checkbox' for='active'>
						<input type='checkbox' id='active' name='active'  value='1' <?php echo set_checkbox('active', 1, isset($embedcontent->active) && $embedcontent->active == 1); ?> />
                        'Is Active'
					</label>
                    <span class='help-inline'><?php echo form_error('active'); ?></span>
				</div>
			</div>

			
        </fieldset>
		<fieldset class='form-actions'>
			<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('embedcontent_action_create'); ?>" />
			<?php echo lang('bf_or'); ?>
			<?php echo anchor(SITE_AREA . '/embeds/embedcontent', lang('embedcontent_cancel'), 'class="btn btn-warning"'); ?>
			
		</fieldset>
    <?php echo form_close(); ?>
</div>
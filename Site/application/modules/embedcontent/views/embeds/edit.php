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

			<div class="control-group<?php echo form_error('count') ? ' error' : ''; ?>">
				<?php echo form_label('Count', 'count', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='count' type='text' name='count' maxlength='11' value="<?php echo set_value('count', isset($embedcontent->count) ? $embedcontent->count : ''); ?>" disabled/>
					<span class='help-inline'><?php echo form_error('count'); ?></span>
				</div>
			</div>
			

			<!--?php // Change the values in this array to populate your dropdown as required
				$options = array(
					11 => 11,
				);
				echo form_dropdown(array('name' => 'templateid', 'required' => 'required'), $options, set_value('templateid', isset($embedcontent->templateid) ? $embedcontent->templateid : ''), 'Template. lang('bf_form_label_required')');
			?-->

			<div class="control-group<?php echo form_error('templateid') ? ' error' : ''; ?>">
    
    
		     <?php echo form_dropdown(array('name' => 'templateid', 'class' => 'required'), $templatesDrop, set_value('templateid', isset($embedcontent->templateid) ? $embedcontent->templateid : ''),'Template *'); ?>
		     
		     <span class='help-inline'><?php echo form_error('templateid'); ?></span>
		    
		   </div>

			<div class="control-group<?php echo form_error('sourceurl') ? ' error' : ''; ?>">
				<?php echo form_label('Sourceurl'. lang('bf_form_label_required'), 'sourceurl', array('class' => 'control-label')); ?>
				<div class='controls'>
					<input id='sourceurl' type='text' required='required' name='sourceurl' maxlength='100' value="<?php echo set_value('sourceurl', isset($embedcontent->sourceurl) ? $embedcontent->sourceurl : ''); ?>" />
					<span class='help-inline'><?php echo form_error('sourceurl'); ?></span>
				</div>
			</div>

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
			<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('embedcontent_action_edit'); ?>" />
			<?php echo lang('bf_or'); ?>
			<?php echo anchor(SITE_AREA . '/embeds/embedcontent', lang('embedcontent_cancel'), 'class="btn btn-warning"'); ?>
			
			<?php if ($this->auth->has_permission('EmbedContent.Embeds.Delete')) : ?>
				<?php echo lang('bf_or'); ?>
				<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('embedcontent_delete_confirm'))); ?>');">
					<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('embedcontent_delete_record'); ?>
				</button>
			<?php endif; ?>
		</fieldset>
    <?php echo form_close(); ?>
</div>
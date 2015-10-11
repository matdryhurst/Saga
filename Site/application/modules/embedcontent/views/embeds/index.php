<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('EmbedContent.Embeds.Delete');
$can_edit		= $this->auth->has_permission('EmbedContent.Embeds.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('embedcontent_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('embedcontent_field_name'); ?></th>
					<th><?php echo lang('embedcontent_field_count'); ?></th> 
					<th><?php echo lang('embedcontent_field_templateid'); ?></th>
					<!-- <th><?php echo lang('embedcontent_field_sourceurl'); ?></th> -->
					<th><?php echo lang('embedcontent_field_active'); ?></th>
					<th><?php echo lang('embedcontent_field_created_on'); ?></th>
					<th><?php echo lang('embedcontent_field_modified_on'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('embedcontent_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					$counter = 0;
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/embeds/embedcontent/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->name); ?></td>
				<?php else : ?>
					<td><?php e($record->name); ?></td>
				<?php endif; ?>
					<td><?php e($record->count); ?></td> 
					<td><?php e($templatenames[$counter]); ?></td>
					<!-- <td><?php e($record->sourceurl); ?></td> -->
					<td><?php e($record->active); ?></td>
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->modified_on); ?></td>
				</tr>
				<?php
					$counter++;
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('embedcontent_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>
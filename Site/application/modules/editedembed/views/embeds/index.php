<?php

$num_columns	= 7;
$can_delete	= $this->auth->has_permission('EditedEmbed.Embeds.Delete');
$can_edit		= $this->auth->has_permission('EditedEmbed.Embeds.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('editedembed_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('editedembed_field_sourceurl'); ?></th>
					<th><?php echo lang('editedembed_field_name'); ?></th>
					<th><?php echo lang('editedembed_field_count'); ?></th>
					<th><?php echo lang('editedembed_field_embedid'); ?></th>
					<th><?php echo lang('editedembed_field_created_on'); ?></th>
					<th><?php echo lang('editedembed_field_modified_on'); ?></th>
					<th><?php echo lang('editedembed_field_deleted_on'); ?></th>
					
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('editedembed_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/embeds/editedembed/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->sourceurl); ?></td>
				<?php else : ?>

					<td><?php e($record->sourceurl); ?></td>
				<?php endif; ?>
					<td><?php e($record->name) ; ?></td>
					<td><?php e($record->count); ?></td>
					<td><?php e($record->embedid); ?></td>
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->modified_on); ?></td>
					<td><?php e($record->deleted_on); ?></td>
					
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('editedembed_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>
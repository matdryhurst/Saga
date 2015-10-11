<?php

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('History.Embeds.Delete');
$can_edit		= $this->auth->has_permission('History.Embeds.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('history_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<!-- <th class='column-check'><input class='check-all' type='checkbox' /></th> -->
					<?php endif;?>
					
					<th><?php echo lang('history_field_ipaddress'); ?></th>
					<th><?php echo lang('history_field_createdon'); ?></th>
					<th><?php echo lang('history_field_modifiedon'); ?></th>
					<th><?php echo lang('history_field_pageurl'); ?></th>
					<th><?php echo lang('history_field_count'); ?></th>
					<th><?php echo lang('history_field_instances'); ?></th>
					<th><?php echo lang('history_field_active'); ?></th>
					<th><?php echo lang('history_field_embedname'); ?></th>
					<th><?php echo lang('history_field_isedited'); ?></th>
					<!-- <th><?php echo lang('history_field_editedembedid'); ?></th> -->
					<th><?php echo lang('history_field_editedembedname'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<!--?php echo lang('bf_with_selected'); ?-->
						<!-- <input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('history_delete_confirm'))); ?>')" /> -->
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<div id="myModal" class="modal fade">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				                <h4 class="modal-title">Confirmation</h4>
				            </div>
				            <div class="modal-body">
				                <p>Do you want to make changes to the existing embed?</p>
				                <p class="text-warning"><small>This will create a new embed based on the current embed.</small></p>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				                <button type="button" class="btn btn-primary" id="modalsave">Yes</button>
				            </div>
				        </div>
				    </div>
				</div>
				<?php
				$i=0;
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<!-- <td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td> -->
					<?php endif;?>
					
				<?php if ($can_edit && !$record->isedited) : ?>
					<!-- <td><?php echo anchor(SITE_AREA . '/embeds/history/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->ipaddress); ?></td> -->
					<td><?php echo anchor(SITE_AREA . '/embeds/history/checkEditedEmbed/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->ipaddress, array('id' => 'edit_'.$record->id,'class'=>'editrecord')); ?></td>
				<?php else : ?>
					<td><?php e($record->ipaddress); ?></td>
				<?php endif; ?>
					<td><?php e($record->createdon); ?></td>
					<td><?php e($record->modifiedon); ?></td>
					<td><?php e($record->pageurl); ?></td>
					<td><?php e($record->count); ?></td>
					<td><?php e($record->instances); ?></td>
					<td><?php e($record->active); ?></td>

					<td><?php e($embedNames[$i]); ?></td>
					
					<td><?php e($record->isedited); ?></td>
					<td><?php e($editedEmbedNames[$i]); ?></td>
				</tr>
				<?php
					$i++;
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('history_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>
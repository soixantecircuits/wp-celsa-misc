<table>
	<?php $groups = array(); ?>
	<?php if(count($settings) > 0): ?>
	<?php foreach($settings as $key => $value): ?>

	<?php if(!isset($value) || !is_array($value)) continue; ?>

	<?php if(!empty($value['group']) && !isset($groups[$value['group']])): $groups[$value['group']] = true; ?>
	<tr>
		<td colspan="3" style="border-bottom: 1px solid #dfdfdf; text-align: center;">
			<span style="display: inline-block; position: relative; top: 9px; padding: 0 12px; background: #f8f8f8;">
				<?php echo $value['group']; ?> <?php _e('settings', 'slideshow-plugin'); ?>
			</span>
		</td>
	</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
	<?php endif; ?>
	<tr
		<?php echo !empty($value['group'])? 'class="group-' . strtolower(str_replace(' ', '-', $value['group'])) . '"': ''; ?>
		<?php echo !empty($value[5])? 'style="display:none;"': ''; ?>
	>
		<td><?php echo $value[3]; ?></td>
		<td><?php echo $inputFields[$key]; ?></td>
		<td><?php _e('Default', 'slideshow-plugin'); ?>: &#39;<?php echo (isset($value[4]))? $value[4][$value[2]]: $value[2]; ?>&#39;</td>
	</tr>

	<?php endforeach; ?>
	<?php endif; ?>
</table>
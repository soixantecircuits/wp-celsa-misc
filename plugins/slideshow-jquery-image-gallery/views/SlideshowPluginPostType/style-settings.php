<table>
	<?php if(count($settings) > 0): ?>
	<?php foreach($settings as $key => $value): ?>

	<tr <?php if(!empty($value[5])) echo 'style="display:none;"'; ?>>
		<td><?php echo $value[3]; ?></td>
		<td><?php echo $inputFields[$key]; ?></td>
		<td><?php _e('Default', 'slideshow-plugin'); ?>: &#39;<?php echo $value[2]; ?>&#39;</td>
	</tr>

	<?php endforeach; ?>
	<?php endif; ?>
</table>
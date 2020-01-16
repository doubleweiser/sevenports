<?php
//wp_nonce_field(plugin_basename( __FILE__ ), "_classes_noncename");
?>
<table>
<?php
if($data->pdfAttachmentUrl!='')
{
?>
	<tr>
		<td>
			<a href="<?php echo $data->pdfAttachmentUrl; ?>" target="_blank"><?php _e('Download PDF Rent Receipt', 'wp-rent-receipts'); ?></a>
		</td>
	</tr>
<?php
}
?>
</table>
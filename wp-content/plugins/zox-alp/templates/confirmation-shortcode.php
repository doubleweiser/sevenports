<div class="rent-receipts-wrapper">
	<div class="rent-receipts">
		<div class="row">
			<div class="col-md-12 text-center">
<?php
if(!is_null($data))
{
?>
				<h2><?php esc_html_e('Congratulations!', 'wp-rent-receipts'); ?></h2>
				<p><?php esc_html_e('Your rent receipts are generated succesfully and link to pdf has been sent to you on the email. You can also download the receipts by click the below button', 'wp-rent-receipts'); ?></p>
				<p><a class="btn btn-primary" href="<?php echo $data->pdfAttachmentUrl; ?>" target="_blank"><?php _e('Download Rent Receipt', 'wp-rent-receipts'); ?></a></p>
<?php
} else {
?>
				<h2><?php esc_html_e('Error!', 'wp-rent-receipts'); ?></h2>
				<p><?php esc_html_e('We couldn\'t find rent receipt for your request. Please make sure that the URL address is correct.', 'wp-rent-receipts'); ?></p>
<?php
}
?>
			</div>
		</div>
	</div>
</div>

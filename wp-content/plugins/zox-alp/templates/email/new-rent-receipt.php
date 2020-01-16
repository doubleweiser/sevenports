<?php

?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php _e('Rent Receipt', 'wp-rent-receipts'); ?></title>
		<style>
			
		</style>
	</head>
	<body>
		<div class="alp-wraper">
			<p><?php echo sprintf(__('Hi %s', 'wp-rent-receipts'), $data->meta['tenant_name']); ?></p>
			<p><?php _e('Thanks for using NoBroker for generating rent receipts for your tax saving needs. Now you know whom to look up to for a brokerage free house for rent, buy or sell.', 'wp-rent-receipts'); ?></p>
			<p><?php _e('Happy Tax Saving!', 'wp-rent-receipts'); ?></p>
			
			<p><a href="<?php echo $data->pdfAttachmentUrl; ?>"><?php _e('Download Rent Receipt', 'wp-rent-receipts'); ?></a></p>
			
			<p><?php _e('Thanks,<br>NoBroker Team', 'wp-rent-receipts'); ?></p>
			
		</div>
	</body>
</html>
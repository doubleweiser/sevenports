<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $data->post_title; ?></title>
		<style>
			@font-face {
				font-family: "Lato";
				font-style: normal;
				font-weight: normal;
				src: url("<?php echo ALP_PLUGIN_FONTS_URL . 'Lato-Regular.ttf'; ?>") format("truetype");
			}
			@font-face {
				font-family: "Lato";
				font-style: normal;
				font-weight: bold;
				src: url("<?php echo ALP_PLUGIN_FONTS_URL . 'Lato-Bold.ttf'; ?>") format("truetype");
			}
			.alp-wraper
			{
				font-family: "Lato";
				font-weight: 400;
				font-style: normal;
			}
			.alp-row
			{
				margin: 0;
				padding: 0;
			}
			.alp-row::after
			{
				display: block;
				content: "";
				clear: both;
				opacity: 0;
				visibility: hidden;
			}
			.alp-col-100,
			.alp-col-50x50
			{
				float: left;
				margin: 0;
				padding: 0;
			}
			.alp-col-100
			{
				width: 100%;
			}
			.alp-col-50x50
			{
				width: 50%;
			}
			.text-align-right
			{
				text-align: right;
			}
			.text-align-center
			{
				text-align: center;
			}
			.page_break
			{
				page-break-before: always;
			}
			.footer
			{
				position: fixed;
				bottom: 30px;
				left: 0px;
				right: 0px;
				
			}
		</style>
	</head>
	<body>
		<div class="alp-wraper">
<?php
for($loopDate = $data->FromDate, $i=0; $loopDate<=$data->ToDate; $loopDate->modify('first day of next month'), $i++):
?>
			<div class="alp-row">
				<div class="alp-col-100">
					<h1 class="text-align-center"><?php _e('House Rent Receipt', 'wp-rent-receipts'); ?></h1>
					<p><?php echo sprintf(__('<b>Dated</b>: %s', 'wp-rent-receipts'), $loopDate->format('1/n/Y')); ?></p>
					<p><?php echo sprintf(__('This is to acknowledge the receipt from <b>%s</b> the sum of rupees  <b>%s/-</b> towards house rent for the month of %s, towards the property bearing the address "%s"', 'wp-rent-receipts'), $data->meta['tenant_name'], $data->meta['rent'], $loopDate->format('F Y'), $data->meta['tenant_address']); ?></p>
					<p><?php _e('<b>Owner\'s Name and Address</b>', 'wp-rent-receipts'); ?></p>
				</div>
			</div>
			<div class="alp-row">
				<div class="alp-col-50x50">
					<p><?php echo $data->meta['owner_name']; ?></p>
					<p><?php echo $data->meta['owner_address']; ?></p>
					<p><?php echo sprintf(__('Pan: %s', 'wp-rent-receipts'), $data->meta['owner_pan']); ?></p>
				</div>
				<div class="alp-col-50x50 text-align-right">
					<p><?php echo sprintf(__('Signature<br>(%s)', 'wp-rent-receipts'), $data->meta['owner_name']); ?></p>
				</div>
			</div>
<?php
	if($i && $i%2==1):
?>
			<div class="alp-row footer">
				<div class="alp-col-100 text-align-center">
					<p><?php echo sprintf(__('This is system generated from %s', 'wp-rent-receipts'), 'nestaway.com'); ?></p>
				</div>
			</div>
			<div class="page_break"></div>
<?php
	endif;
endfor;
?>
		</div>
	</body>
</html>
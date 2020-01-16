<div class="rent-receipts-wrapper">
	<div class="rent-receipts">
		<form class="rent-receipts-form">
			<input type="hidden" name="confirmation_page_id" value="<?php echo $data['confirmation_page_id']; ?>"/>
			<div class="row">
				<div class="col-md-12 text-center">
					<h2><?php esc_html_e('Create Rent Receipt', 'wp-rent-receipts'); ?></h2>
					<p><?php esc_html_e('Looking for rent receipts for tax saving? Do it in a click by filling the form below, take the print of the generated pdf and you are done. Easy', 'wp-rent-receipts'); ?></p>				
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-4">
							<label for="alp_tenant_name"><?php esc_html_e('Tenant Name', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<input type="text" id="alp_tenant_name" class="form-control" name="tenant_name" placeholder="<?php esc_attr_e('Tenant\'s Name', 'wp-rent-receipts'); ?>" value=""/>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<label for="alp_tenant_phone"><?php esc_html_e('Tenant Phone', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<input type="text" id="alp_tenant_phone" class="form-control" name="tenant_phone" placeholder="<?php esc_attr_e('to receive sms with receipts', 'wp-rent-receipts'); ?>" value=""/>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<label for="alp_rent"><?php esc_html_e('Rent', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<input type="text" id="alp_rent" class="form-control" name="rent" placeholder="<?php esc_attr_e('Monthly Rent in Rs.', 'wp-rent-receipts'); ?>" value=""/>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<label for="alp_tenant_address"><?php esc_html_e('Rented Property Address', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<textarea id="alp_tenant_address" class="form-control" name="tenant_address" placeholder="<?php esc_attr_e('Address of property as required in rent receipts', 'wp-rent-receipts'); ?>"></textarea>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<label for="alp_from_date"><?php esc_html_e('Receipt Start Date', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<input type="text" id="alp_from_date" class="form-control datepicker" name="from_date" placeholder="<?php esc_attr_e('yyyy-mm-dd', 'wp-rent-receipts'); ?>" value=""/>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<label for="alp_email"><?php esc_html_e('Email', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<input type="text" id="alp_email" class="form-control" name="email" placeholder="<?php esc_attr_e('Email to receive PDF link', 'wp-rent-receipts'); ?>" value=""/>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-4">
							<label for="alp_owner_name"><?php esc_html_e('Owner Name', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<input type="text" id="alp_owner_name" class="form-control" name="owner_name" placeholder="<?php esc_attr_e('Owner\'s Name', 'wp-rent-receipts'); ?>" value=""/>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<label for="alp_owner_phone"><?php esc_html_e('Owner Phone', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<input type="text" id="alp_owner_phone" class="form-control" name="owner_phone" placeholder="<?php esc_attr_e('Owners 10 digit phone number', 'wp-rent-receipts'); ?>" value=""/>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<label for="alp_owner_pan"><?php esc_html_e('Owner Pan', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<input type="text" id="alp_owner_pan" class="form-control" name="owner_pan" placeholder="<?php esc_attr_e('Owner\'s Pan', 'wp-rent-receipts'); ?>" value=""/>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<label for="alp_owner_address"><?php esc_html_e('Owner Address', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<textarea id="alp_owner_address" class="form-control" name="owner_address" placeholder="<?php esc_attr_e('Current Adress of the owner as required in rental receipts', 'wp-rent-receipts'); ?>"></textarea>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<label for="alp_to_date"><?php esc_html_e('Receipt End Date', 'wp-rent-receipts'); ?></label>
						</div>
						<div class="col-md-8">
							<input type="text" id="alp_to_date" class="form-control datepicker" name="to_date" placeholder="<?php esc_attr_e('yyyy-mm-dd', 'wp-rent-receipts'); ?>" value=""/>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row mt-4">
				<div class="col-md-12 text-center">
					<button id="alp_submit" type="submit" class="btn btn-success generateButton">
						<?php esc_html_e('Generate Rent Receipt Now', 'wp-rent-receipts'); ?>
					</button>
				</div>
			</div>
			
		</form>
	</div>
</div>

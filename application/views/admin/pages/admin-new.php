<div class="body-container">
	<div class="add-new-admin-container">
		<h1>New Administrator</h1>
		<hr>
		<?php echo form_open('admin/admins/new'); ?>
			<div class="row">
				<div class="col-md-2">
					<label <?php if(form_error('admin_username')){ echo 'class="txt-has-error"'; } ?> for="admin-add-username">Username *</label>
				</div>
				<div class="col-md-10">
					<input id="admin-add-username" <?php if(form_error('admin_username')){ echo 'class="input-has-error"'; } ?> type="text" name="admin_username" value="<?php echo set_value('admin_username'); ?>" placeholder="Username" required>
					<?php echo form_error('admin_username'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label <?php if(form_error('admin_password')){ echo 'class="txt-has-error"'; } ?> for="admin-add-password">Password *</label>
				</div>
				<div class="col-md-10">
					<input id="admin-add-password" <?php if(form_error('admin_password')){ echo 'class="input-has-error"'; } ?> type="password" name="admin_password" value="<?php echo set_value('admin_password'); ?>" placeholder="Password" required>
					<?php echo form_error('admin_password'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label <?php if(form_error('admin_email')){ echo 'class="txt-has-error"'; } ?> for="admin-add-email">Email Address *</label>
				</div>
				<div class="col-md-10">
					<input id="admin-add-email" <?php if(form_error('admin_email')){ echo 'class="input-has-error"'; } ?> type="email" name="admin_email" value="<?php echo set_value('admin_email'); ?>" placeholder="Email Address" required>
					<?php echo form_error('admin_email'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label <?php if(form_error('admin_name')){ echo 'class="txt-has-error"'; } ?> for="admin-add-name">Name *</label>
				</div>
				<div class="col-md-10">
					<input id="admin-add-name" <?php if(form_error('admin_name')){ echo 'class="input-has-error"'; } ?> type="text" name="admin_name" value="<?php echo set_value('admin_name'); ?>" placeholder="Name" required>
					<?php echo form_error('admin_name'); ?>
				</div>
			</div>
			<hr>
			<button type="submit" class="btn button-primary">Save Changes</button>
			<a href="<?php echo base_url(); ?>admin/admins" class="btn button-cancel">Cancel</a>
		<?php echo form_close(); ?>
</div>
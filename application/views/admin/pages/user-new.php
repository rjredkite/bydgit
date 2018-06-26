<div class="body-container">
	<div class="edit-container">
		<h1>New User</h1>
		<hr>
		<?php echo form_open(''); ?>
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-sm-3">
							<label  for="user-email" <?php if(form_error('email')){ echo 'class="txt-has-error"'; } ?>>* Email</label>
						</div>
						<div class="col-sm-8">
							<input id="user-email" class="textbox <?php if(form_error('email')){ echo 'input-has-error'; } ?>" type="text" name="email">
							<?php echo form_error('email'); ?>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-password" <?php if(form_error('password')){ echo 'class="txt-has-error"'; } ?>>* Password</label>
						</div>
						<div class="col-sm-8">
							<input id="user-password" class="textbox <?php if(form_error('password')){ echo 'input-has-error'; } ?>" type="password" name="password">
							<?php echo form_error('password'); ?>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-firstname">Firstname</label>
						</div>
						<div class="col-sm-8">
							<input id="user-firstname" class="textbox" type="text" name="firstname">
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-lastname">Lastname</label>
						</div>
						<div class="col-sm-8">
							<input id="user-lastname" class="textbox" type="text" name="lastname">
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-phone">Phone</label>
						</div>
						<div class="col-sm-8">
							<input id="user-phone" class="textbox" type="text" name="phone">
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-address">Address</label>
						</div>
						<div class="col-sm-8">
							<textarea id="user-address" name="address" rows="4" cols="50"></textarea>
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-postcode">Postcode</label>
						</div>
						<div class="col-sm-8">
							<input id="user-postcode" class="textbox" type="text" name="post_code">
						</div>
					</div>
					
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-country" <?php if(form_error('country_id')){ echo 'class="txt-has-error"'; } ?>>* Country</label>
						</div>
						<div class="col-sm-8">
							<select id="user-country" name="country_id" <?php if(form_error('country_id')){ echo 'class="input-has-error"'; } ?>>
								<option value=""></option>
								<?php foreach($countries as $country): ?>
									<option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
								<?php endforeach; ?>
							</select>
							<?php echo form_error('country_id'); ?>
						</div>
					</div>
					
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-website">Website</label>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon">http://</span>
								<input id="user-website" type="text" class="website" name="website">
							</div>
						</div>
					</div>
					
					<div class="row space">
						<div class="col-sm-3">
							<label for="user-credits">Credits</label>
						</div>
						<div class="col-sm-8">
							<input id="user-credits" class="textbox" type="number" name="credits">
						</div>
					</div>
					
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-ffw">Free Featured week</label>
						</div>
						<div class="col-sm-8">
							<input id="user-ffw" class="textbox" type="number" name="free_featured_week">
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-newsletter">Newsletter</label>
						</div>
						<div class="col-sm-8">
							<input id="user-newsletter" class="checkbox" type="checkbox" name="newsletter">
						</div>
					</div>
										
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-monthly-report">Monthly report</label>
						</div>
						<div class="col-sm-8">
							<input id="user-monthly-report" class="checkbox" type="checkbox" name="monthly_report">
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-suspended">Suspended</label>
						</div>
						<div class="col-sm-8">
							<input id="user-suspended" class="checkbox" type="checkbox" name="suspended">
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-banned">Banned</label>
						</div>
						<div class="col-sm-8">
							<input id="user-banned" class="checkbox" type="checkbox" name="banned">
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-cc">Confirm code</label>
						</div>
						<div class="col-sm-8">
							<input id="user-cc" class="textbox" type="text" name="confirm_code">
							<p class="label-txt">Blank means user is confirmed</p>
						</div>
					</div>

				</div>
				<div class="col-md-4">
				</div>
				<div class="col-md-12">
					<div class="row space">
						<div class="col-sm-2">
							<label  for="user-notes">Notes</label>
						</div>
						<div class="col-sm-10">
							<textarea id="user-notes" name="notes" rows="4" cols="50"></textarea>
						</div>
					</div>
				</div>
			</div>

			<hr>

			<button type="submit" class="btn button-primary">Save changes</button>
			<a href="<?php echo base_url('admin/users/search'); ?>" class="btn button-cancel">Cancel</a>
		<?php echo form_close(); ?>
	</div>	
</div>


<script>
    CKEDITOR.replace( 'notes' );
</script>

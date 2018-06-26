<div class="body-container">
	<div class="edit-container">
		<h1>Edit User</h1>
		<hr>
		<?php echo form_open(''); ?>
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-sm-3">
							<label  for="user-email" <?php if(form_error('email')){ echo 'class="txt-has-error"'; } ?>>* Email</label>
						</div>
						<div class="col-sm-8">
							<input id="user-email" class="textbox <?php if(form_error('email')){ echo 'input-has-error'; } ?>" type="text" name="email" value="<?php echo $user['email'] ?>">
							<?php echo form_error('email'); ?>
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-password">Password</label>
						</div>
						<div class="col-sm-8">
							<input id="user-password" class="textbox" type="password" name="password">
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-firstname">Firstname</label>
						</div>
						<div class="col-sm-8">
							<input id="user-firstname" class="textbox" type="text" name="firstname" value="<?php echo $user['first_name'] ?>">
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-lastname">Lastname</label>
						</div>
						<div class="col-sm-8">
							<input id="user-lastname" class="textbox" type="text" name="lastname" value="<?php echo $user['last_name'] ?>">
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-phone">Phone</label>
						</div>
						<div class="col-sm-8">
							<input id="user-phone" class="textbox" type="text" name="phone" value="<?php echo $user['phone'] ?>">
						</div>
					</div>
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-address">Address</label>
						</div>
						<div class="col-sm-8">
							<textarea id="user-address" name="address" rows="4" cols="50"><?php echo $user['address'] ?></textarea>
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-postcode">Postcode</label>
						</div>
						<div class="col-sm-8">
							<input id="user-postcode" class="textbox" type="text" name="post_code" value="<?php echo $user['post_code'] ?>">
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
									<option value="<?php echo $country['id']; ?>" <?php
			                      		if($this->input->get('country_id', TRUE)){
			                      			if($this->input->get('country_id', TRUE) == $country['id']){
												echo 'selected';
											}
			                      		}else{
			                      			if($user['country_id'] == $country['id']){
												echo 'selected';
											}
			                      		}
			                      	?>><?php echo $country['name']; ?></option>
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
								<input id="user-website" type="text" class="website" name="website" value="<?php echo $user['website'] ?>">
							</div>
						</div>
					</div>
					
					<div class="row space">
						<div class="col-sm-3">
							<label for="user-credits">Credits</label>
						</div>
						<div class="col-sm-8">
							<input id="user-credits" class="textbox" type="number" name="credits" value="<?php echo $user['credits'] ?>">
						</div>
					</div>
					
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-ffw">Free Featured week</label>
						</div>
						<div class="col-sm-8">
							<input id="user-ffw" class="textbox" type="number" name="free_featured_week" value="<?php echo $user['featured_credits'] ?>">
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-newsletter">Newsletter</label>
						</div>
						<div class="col-sm-8">
							<input id="user-newsletter" class="checkbox" type="checkbox" name="newsletter" 
								<?php
									if($user['newsletter'] == 1){
										echo 'checked';
									}
								?>
							>
						</div>
					</div>
										
					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-monthly-report">Monthly report</label>
						</div>
						<div class="col-sm-8">
							<input id="user-monthly-report" class="checkbox" type="checkbox" name="monthly_report" 
								<?php
									if($user['monthly_report'] == 1){
										echo 'checked';
									}
								?>
							>
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-suspended">Suspended</label>
						</div>
						<div class="col-sm-8">
							<input id="user-suspended" class="checkbox" type="checkbox" name="suspended" 
								<?php
									if($user['suspended'] == 1){
										echo 'checked';
									}
								?>
							>
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-banned">Banned</label>
						</div>
						<div class="col-sm-8">
							<input id="user-banned" class="checkbox" type="checkbox" name="banned" 
								<?php
									if($user['banned'] == 1){
										echo 'checked';
									}
								?>
							>
						</div>
					</div>

					<div class="row space">
						<div class="col-sm-3">
							<label  for="user-cc">Confirm code</label>
						</div>
						<div class="col-sm-8">
							<input id="user-cc" class="textbox" type="text" name="confirm_code" value="<?php echo $user['confirm_code'] ?>">
							<p class="label-txt">Blank means user is confirmed</p>
						</div>
					</div>

				</div>
				<div class="col-md-4">
					<a href="<?php echo base_url('admin/listings/search?listing_type=dog&user_id='.$user['id']); ?>" class="btn btn-info btn-block">View User's Dogs ( <?php echo count($stud); ?> )</a>
					<a href="<?php echo base_url('admin/listings/search?listing_type=pup&user_id='.$user['id']); ?>" class="btn btn-info btn-block">View User's Puppies ( <?php echo count($pup); ?> )</a>
					<a href="<?php echo base_url('admin/listings/search?listing_type=mem&user_id='.$user['id']); ?>" class="btn btn-info btn-block">View User's Memorials ( <?php echo count($mem); ?> )</a>
					<a href="" class="btn btn-info btn-block">View User's Classifieds ( 0 )</a>

					<?php if($user['deleted_at'] == NULL || $user['deleted_at'] == '0000-00-00 00:00:00'){
						echo '<a class="btn btn-danger btn-delete btn-block" data-toggle="modal" data-target="#deleteuser">Delete User</a>';
					}else{
						echo '<a class="btn btn-default btn-delete btn-block" data-toggle="modal" data-target="#undeleteuser">Un-delete User</a>';
					}?>

				</div>
				<div class="col-md-12">
					<div class="row space">
						<div class="col-sm-2">
							<label  for="user-notes">Notes</label>
						</div>
						<div class="col-sm-10">
							<textarea id="user-notes" name="notes" rows="4" cols="50"><?php echo $user['notes']; ?></textarea>
						</div>
					</div>
				</div>
			</div>

			<hr>

			<button class="btn button-primary">Save changes</button>
			<a href="<?php echo base_url('admin/users/search'); ?>" class="btn button-cancel">Cancel</a>
		<?php echo form_close(); ?>

		<div id="deleteuser" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
				<?php echo form_open('/admin/user_delete/'.$user['id']); ?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Delete User</h4>
					</div>
					<div class="modal-body">
						<p>
							Deleting this user will also perminantly cancel any active subscriptions in PayPal, please confirm you want to delete this user.
						</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-danger">Delete User</button>
					</div>
				<?php echo form_close(); ?>
				</div>
			</div>
		</div>

		<div id="undeleteuser" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
				<?php echo form_open('/admin/user_un_delete/'.$user['id']); ?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Un Delete User</h4>
					</div>
					<div class="modal-body">
						<p class="text-center">
							Are you sure you want to Un delete this user account ?
						</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-default">Un Delete User</button>
					</div>
				<?php echo form_close(); ?>
				</div>
			</div>
		</div>

		<div id="modal-suspended" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Suspended</h4>
					</div>
					<div class="modal-body">
						<p class="text-center">
							Are you sure you want to Suspended this account ?
						</p>
					</div>
					<div class="modal-footer">
						<button id="check-suspended" class="btn btn-default" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i> Yes</button>
						<button type="submit" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> NO</button>
					</div>
				</div>
			</div>
		</div>

		<div id="modal-unsuspended" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Unsuspended</h4>
					</div>
					<div class="modal-body">
						<p class="text-center">
							Are you sure you want to Unsuspended this account ?
						</p>
					</div>
					<div class="modal-footer">
						<button id="check-unsuspended" class="btn btn-default" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i> Yes</button>
						<button type="submit" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> NO</button>
					</div>
				</div>
			</div>
		</div>
	
		<div id="modal-banned" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Banned</h4>
					</div>
					<div class="modal-body">
						<p class="text-center">
							Are you sure you want to Banned this account ?
						</p>
					</div>
					<div class="modal-footer">
						<button id="check-banned" class="btn btn-default" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i> Yes</button>
						<button type="submit" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> NO</button>
					</div>
				</div>
			</div>
		</div>

		<div id="modal-unbanned" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Unbanned</h4>
					</div>
					<div class="modal-body">
						<p class="text-center">
							Are you sure you want to Unbanned this account ?
						</p>
					</div>
					<div class="modal-footer">
						<button id="check-unbanned" class="btn btn-default" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i> Yes</button>
						<button type="submit" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> NO</button>
					</div>
				</div>
			</div>
		</div>

	</div>	
</div>
<script>
	$(document).ready(function(){
		$('#user-suspended').click(function(){
			if($('#user-suspended').prop('checked')){
				$('#user-suspended').prop('checked',false);
				$("#modal-suspended").modal("show");
			}else{
				$('#user-suspended').prop('checked',true);
				$("#modal-unsuspended").modal("show");
			}
		});

		$('#check-suspended').click(function(){
			$('#user-suspended').prop('checked',true);
		});
		$('#check-unsuspended').click(function(){
			$('#user-suspended').prop('checked',false);
		});

		$('#user-banned').click(function(){
			if($('#user-banned').prop('checked')){
				$('#user-banned').prop('checked',false);
				$("#modal-banned").modal("show");
			}else{
				$('#user-banned').prop('checked',true);
				$("#modal-unbanned").modal("show");
			}
		});

		$('#check-banned').click(function(){
			$('#user-banned').prop('checked',true);
		});
		$('#check-unbanned').click(function(){
			$('#user-banned').prop('checked',false);
		});


	});
</script>


<script>
    CKEDITOR.replace( 'notes' );
</script>

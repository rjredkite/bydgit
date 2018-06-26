<?php
	$countries = $this->getdata_model->get_countries(); 
?>
<div class="body-container">
	<?php if($this->session->flashdata('flashdata_danger')) : ?>
		<?php echo '
		  <div class="alert alert-danger alert-dismissable fade in">
		    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
		    .$this->session->flashdata('flashdata_danger').
		'</div>'
		; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('flashdata_info')) : ?>
		<?php echo '
		  <div class="alert alert-info alert-dismissable fade in">
		    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
		    .$this->session->flashdata('flashdata_info').
		'</div>'
		; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('flashdata_success')) : ?>
		<?php echo '
		  <div class="alert alert-success alert-dismissable fade in">
		    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
		    .$this->session->flashdata('flashdata_success').
		'</div>'
		; ?>
    <?php endif; ?>
	<div class="users-with-many-listings">
		<h1>Users with many Listings</h1>
		<hr>
			<?php echo form_open('',array( 'method' => 'get')); ?>
				<div class="row">
					<div class="col-md-12">
						<span>Find users with more than</span>
						<input type="number" class="" name="number_of" placeholder="User ID" value="<?php 
						if($this->input->get('number_of', TRUE) != ''){
							echo $this->input->get('number_of', TRUE);
						}else{
							echo '5';
						}
						?>">
						<select name="listing_type">
							<option value="dog" <?php if($this->input->get('listing_type', TRUE) == 'dog'){ echo 'selected'; } ?>>Stud Dogs / Bitches</option>
							<option value="pup"<?php if($this->input->get('listing_type', TRUE) == 'pup'){ echo 'selected'; } ?>>Litters</option>
						</select>
						<button type="submit" class="button-primary">Search</button>
					</div>
				</div>
				
			<?php echo form_close(); ?>
	</div>
</div>

<?php if($this->input->get('number_of', TRUE) != '' && $this->input->get('listing_type', TRUE) != ''): ?>
	<div class="body-container">
		<div class="table-max table-responsive">
			<p>
				<?php echo $this->admin_model->count_users_with_many_listings(); ?> <?php 
					if($this->admin_model->count_users_with_many_listings() <= 1){
						echo 'User Found';
					}else{
						echo 'Users Found';
					}
				?>
			</p>

			<div class="table-responsive">
		
				<?php if($this->pagination->create_links() != ''){ ?>
					<div class="pagination-links">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				<?php } ?>

				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Email</th>
							<th>Name</th>
							<th>Country</th>
							<th>Plan</th>
							<th>Credits</th>
							<th style="width: 100px;">Joined</th>
							<th>Suspended</th>
							<th>Banned</th>
							<th>Confirmed</th>
							<th>Option</th> 
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $user): ?>
							<tr>
								<td><?php echo $user['user_id'] ;?></td>
								<td><?php echo $user['email'] ;?></td>
								<td><?php echo $user['first_name'] .' '. $user['last_name'] ;?></td>
								<td><?php 
										$country_id = $user['country_id'];
										$country = $this->getdata_model->get_countries_id($country_id);
										echo $country['name'];
								;?></td>
								<td><?php 
									$plan_id = $user['plan_id'];
									$plan = $this->getdata_model->get_plans_id($plan_id);
									echo $plan['name'];
								?></td>
								<td><?php echo $user['credits'] ;?></td>
								<td><?php 
									$date_joined=date_create($user['created_at']);
									echo date_format($date_joined,"Y-m-d");
								?></td>
								<td><?php 
									if($user['suspended'] == 0){
										echo 'No';
									}else{
										echo 'Yes';
									}
								?></td>
								<td><?php 
									if($user['banned'] == 0){
										echo 'No';
									}else{
										echo 'Yes';
									}
								?></td>
								<td><?php 
									if(!empty($user['confirm_code'])){
										echo 'No';
									}else{
										echo 'Yes';
									}
								?></td>
								<td class="text-center">
									<a href="<?php echo base_url('/admin/users/'.$user['user_id'].'/edit'); ?>" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
									<a href="<?php echo base_url('/admin/users/'.$user['user_id'].'/log_in_as'); ?>" class="btn btn-default"><i class="fa fa-sign-in" aria-hidden="true"></i> Log In As User</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php if($this->pagination->create_links() != ''){ ?>
					<div class="pagination-links">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php endif; ?>

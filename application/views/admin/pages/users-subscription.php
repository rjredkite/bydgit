<?php
	$plans = $this->getdata_model->get_plans(); 
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
	<div class="search-container">
		<h1>Search Subscriptions</h1>
		<hr>
		<button id="admin-search-button" class="search-fields-button" data-toggle="popovers" data-placement="right" title="Toggle Search Fields" data-content='Click this button to hide or show the search fields.' data-trigger="hover"><i class="fa fa-bars" aria-hidden="true"></i> Toggle Search fields</button> 
		<div class="admin-search-fields">
			<hr>
			<?php echo form_open('',array( 'method' => 'get')); ?>
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="textbox" name="id" placeholder="User ID" value="<?php echo $this->input->get('id', TRUE); ?>">
						<div class="date-calendar">
							<div class="input-group">
								<input type="text" class="datepicker" data-date-format="mm/dd/yyyy" name="start_date_before" placeholder="Start Date Before" value="<?php echo  $this->input->get('start_date_before', TRUE); ?>">
								<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="date-calendar">
							<div class="input-group">
								<input type="text" class="datepicker" data-date-format="mm/dd/yyyy" name="start_date_after"  placeholder="Start Date After" value="<?php echo  $this->input->get('start_date_after', TRUE); ?>">
								<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<select name="plan_id">
							<option value="all">Any Plan</option>
							<?php foreach($plans as $plan): ?>
								<option value="<?php echo $plan['id']; ?>" <?php
		                      		if($this->input->get('plan_id', TRUE)){
		                      			if($this->input->get('plan_id', TRUE) == $plan['id']){
											echo 'selected';
										}
		                      		}
		                      	?>><?php echo $plan['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<input type="text" class="textbox" name="paypal_id" placeholder="Paypal ID" value="<?php echo $this->input->get('id', TRUE); ?>">
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-2">
									<span>Active?</span>
								</div>
								<div class="col-sm-10">
									<label class="radio-inline">
								    	<input type="radio" name="active" value="all" <?php if($this->input->get('active', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="active" value="1" <?php if($this->input->get('active', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="active" value="0" <?php if($this->input->get('active', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<button type="submit" class="btn button-primary">Search</button>
				<a href="" class="bnt button-cancel">Cancel</a>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="body-container">
	<div class="table-max">
		<p>
			<?php echo $this->admin_model->count_users_subscription(); ?> <?php 
				if($this->admin_model->count_users_subscription() <= 1){
					echo 'Subscription Found';
				}else{
					echo 'Subscription Found';
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
						<th>User</th>
						<th>Plan</th>
						<th>Status</th>
						<th>StartDate</th>
						<th>NextPayment</th>
						<th>Paypal ID</th>
						<th>Notes</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($subscriptions as $sub): ?>
						<?php $user = $this->getdata_model->get_user($sub['user_id']); ?>
						<?php $plan = $this->getdata_model->get_plans_id($user['plan_id']); ?>
						
						<tr>
							<td><?php echo $sub['id'] ;?></td>
							<td><?php echo $user['email'] ;?></td>
							<td><?php echo $plan['name'] ;?></td>
							<td><?php echo $sub['status'];?></td>
							<td><?php echo $sub['start_date'];?></td>
							<td><?php echo $sub['next_payment_date'];?></td>
							<td><?php echo $sub['paypal_id'];?></td>
							<td><?php echo $sub['error'];?></td>
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

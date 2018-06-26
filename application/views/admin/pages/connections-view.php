<?php
	$listing = $this->getdata_model->get_listing_connections($connect['listing_id']); 

	$breed = $this->getdata_model->get_breed_id($listing['breed_id']);

	$breeder = $this->getdata_model->get_user($listing['user_id']); 

	$buyer = $this->getdata_model->get_user($connect['buyer_id']); 
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
	<div class="admin-connections-container">
		<?php echo form_open('admin/connections_update/'.$connect['id']); ?>
			<h1>Connections</h1>
			<hr>
			<div class="row">
				<div class="col-md-4">
					<h5>Connection Details <a href="<?php echo base_url('admin/listings/'.$listing['id'].'/edit'); ?>" class="btn btn-default btn-sm">View Listing</a></h5>
					<div class="row space">
						<div class="col-sm-5  text-right">
							Date and time
						</div>
						<div class="col-sm-7">
							<?php echo $listing['created_at']; ?> UTC
						</div>
						<div class="col-sm-5  text-right">
							Listing Type
						</div>
						<div class="col-sm-7">
							<?php
								if($listing['listing_type'] == 'dog'){
									echo 'Stud Dog / Bitch';
								}elseif($listing['listing_type'] == 'pup'){
									echo 'Litter';	
								}elseif($listing['listing_type'] == 'mem'){
									echo 'Memorial';
								}
							?>
						</div>
						<div class="col-sm-5  text-right">
							Listing Breed 
						</div>
						<div class="col-sm-7">
							<?php echo $breed['name']; ?>
						</div>
						<div class="col-sm-5  text-right">
							Listing Name 
						</div>
						<div class="col-sm-7">
							<?php echo $listing['name']; ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<h5>Breeder Info <a href="<?php echo base_url('admin/users/'.$breeder['id'].'/edit'); ?>" class="btn btn-default btn-sm">View Breeder</a></h5>
					<div class="row space">
						<div class="col-sm-5  text-right">
							Name
						</div>
						<div class="col-sm-7">
							<?php echo $breeder['first_name'].' '.$breeder['last_name']; ?>
						</div>
						<div class="col-sm-5  text-right">
							Email
						</div>
						<div class="col-sm-7">
							<?php echo $breeder['email']; ?>
						</div><div class="col-sm-5  text-right">
							Telephone
						</div>
						<div class="col-sm-7">
							<?php echo $breeder['phone']; ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<h5>Buyer Info <a href="<?php echo base_url('admin/users/'.$buyer['id'].'/edit'); ?>" class="btn btn-default btn-sm">View Buyer</a></h5>
					<div class="row space">
						<div class="col-sm-5  text-right">
							Name
						</div>
						<div class="col-sm-7">
							<?php echo $buyer['first_name'].' '.$buyer['last_name']; ?>
						</div>
						<div class="col-sm-5  text-right">
							Email
						</div>
						<div class="col-sm-7">
							<?php echo $buyer['email']; ?>
						</div>
						<div class="col-sm-5  text-right">
							Telephone
						</div>
						<div class="col-sm-7">
							<?php echo $buyer['phone']; ?>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-2">
					<label for="connection-notes" class="connection-notes">Notes</label>
				</div>
				<div class="col-md-10">
					<textarea id="connection-notes" class="full-textarea" name="notes" placeholder="Notes" rows="7" cols="50"><?php echo $connect['notes']; ?></textarea>
				</div>
			</div>
			<hr>
			<button type="submit" class="btn button-primary">Save Notes</button>
			<a href="<?php echo base_url('admin/connections'); ?>" class="btn button-cancel">Cancel</a>
		<?php echo form_close(); ?>
	</div>
</div>
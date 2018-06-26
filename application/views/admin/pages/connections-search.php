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
	<div class="search-container">
		<h1>Search Connections</h1>
		<hr>
		<button id="admin-search-button" class="search-fields-button" data-toggle="popovers" data-placement="right" title="Toggle Search Fields" data-content='Click this button to hide or show the search fields.' data-trigger="hover"><i class="fa fa-bars" aria-hidden="true"></i> Toggle Search fields</button> 
		<div class="admin-search-fields">
			<hr>
			<?php echo form_open('',array( 'method' => 'get')); ?>
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="textbox" name="breeder_id" placeholder="Breeder ID" value="<?php echo $this->input->get('breeder_id', TRUE); ?>">
						<input type="text" class="textbox" name="breeder_name" placeholder="Breeder Name" value="<?php echo $this->input->get('breeder_name', TRUE); ?>">
						<input type="text" class="textbox" name="breeder_email" placeholder="Breeder Email" value="<?php echo $this->input->get('breeder_email', TRUE); ?>">
						<input type="text" class="textbox" name="breeder_phone" placeholder="Breeder Phone" value="<?php echo $this->input->get('breeder_phone', TRUE); ?>">
					</div>
					<div class="col-md-6">
						<input type="text" class="textbox" name="buyer_id" placeholder="Buyer ID" value="<?php echo $this->input->get('buyer_id', TRUE); ?>">
						<input type="text" class="textbox" name="buyer_name" placeholder="Buyer Name" value="<?php echo $this->input->get('buyer_name', TRUE); ?>">
						<input type="text" class="textbox" name="buyer_email" placeholder="Buyer Email" value="<?php echo $this->input->get('buyer_email', TRUE); ?>">
						<input type="text" class="textbox" name="buyer_phone" placeholder="Buyer Phone" value="<?php echo $this->input->get('buyer_phone', TRUE); ?>">
					</div>
				</div>
				<hr>
				<button type="submit" class="btn button-primary">Search</button>
				<a href="<?php echo base_url('admin/connections/search'); ?>" class="btn button-cancel">Cancel</a>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="body-container">
	<div class="table-max">

		<div class="table-responsive">
	
			<?php if($this->pagination->create_links() != ''){ ?>
				<div class="pagination-links">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			<?php } ?>
			
			
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Date</th>
						<th>Buyer</th>
						<th>Listing Type</th>
						<th>Listing Name</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($connections as $connect): ?>
						<tr>
							<td><?php echo $connect['created_at'] ;?></td>
							<td><?php echo $connect['first_name'].' '.$connect['last_name'] ;?></td>
							<td>
								<?php
									if($connect['listing_type'] == 'dog'){
										echo 'Stud Dog / Bitch';
									}elseif($connect['listing_type'] == 'pup'){
										echo 'Litter';	
									}elseif($connect['listing_type'] == 'mem'){
										echo 'Memorial';
									}
								?>
							</td>
							<td><?php echo $connect['name'] ;?></td>
							<td class="text-center">
								<a href="<?php echo base_url('admin/connections/'.$connect['connect_id']); ?>" class="btn btn-default">View</a>
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

<?php
	$countries = $this->getdata_model->get_countries(); 

	print_pre($connections);
	exit();
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
	<div class="connections-container">
		<h1>All Connections</h1>
		<br>
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
</div>

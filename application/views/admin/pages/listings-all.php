<?php
	$countries = $this->getdata_model->get_countries(); 
	$breeds = $this->getdata_model->get_breeds();
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
	<h1>All Listings</h1>
	<hr>
	<div class="table-max">
		<p>
			<?php echo $this->admin_model->count_listings(); ?> <?php 
				if($this->admin_model->count_listings() <= 1){
					echo 'Listing Found';
				}else{
					echo 'Listings Found';
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
						<th>Type</th>
						<th>Title</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Breed</th>
						<th>Country</th>
						<th>Pedigree</th>
						<th>Published</th>
						<th>Option</th> 
					</tr>
				</thead>
				<tbody>
					<?php foreach($listings as $list): ?>
						<tr>
							<td><?php echo $list['id'] ;?></td>
							<td><?php
								if($list['listing_type'] == 'dog'){
		                          echo 'Stud Dog / Bitch';
		                        }elseif($list['listing_type'] == 'pup'){
		                          echo 'Litter';
		                        }elseif($list['listing_type'] == 'mem'){
		                          echo 'Memorial';
		                        }
							?>
							</td>
							<td><?php echo $list['title'] ;?></td>
							<td><?php echo $list['name'] ;?></td>
							<td><?php 
								if($list['gender'] = 'm'){
									echo 'Dog';
								}else{
									echo 'Bitch';
								}
							?></td>
							<td><?php 
									$breed_id = $list['breed_id'];
									$breed = $this->getdata_model->get_breed_id($breed_id);
									echo $breed['name'];
							;?></td>
							<td><?php 
									$country_id = $list['country_id'];
									$country = $this->getdata_model->get_countries_id($country_id);
									echo $country['name'];
							;?></td>
							<td><?php 
								if($list['pedigree'] == 0){
									echo 'No';
								}else{
									echo 'Yes';
								}
							?></td>
							<td><?php 
								if($list['published'] == 0){
									echo 'No';
								}else{
									echo 'Yes';
								}
							?></td>
							<td class="text-center">
								<a href="<?php echo base_url('/admin/listings/'.$list['id'].'/edit'); ?>" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
								<a href="<?php echo base_url('/admin/connections?listing_id='.$list['id']); ?>" class="btn btn-default"><i class="fa fa-exchange" aria-hidden="true"></i> Connections</a>
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

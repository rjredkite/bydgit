<div class="body-container">
	<div class="search-container">
		<?php echo form_open('',array('method' => 'get')); ?>
			<div class="row">
				<div class="col-md-6 col-md-lg-6">
		  			<input type="text" class="textbox" name="breed_name" placeholder="Breed Name" value="<?php echo $this->input->get('breed_name', TRUE); ?>">
		  		</div>
		  		<div class="col-md-4 col-md-lg-4">
		  			<select id="kennel-club" name="kennel_club_group" value="<?php echo set_value('kennel_club_group'); ?>">
						<option value="all"> - Any Breeds - </option>
						<?php foreach($kennels as $kennel) : ?>
							<option value="<?php echo $kennel['id']; ?>" 
							<?php	
								if($this->input->get('kennel_club_group', TRUE) == $kennel['id']){
									echo 'selected';
								}
							?>
							><?php echo $kennel['name']; ?></option>		
						<?php endforeach; ?>
					</select>
		  		</div>
		  		<div class="col-md-2 col-md-lg-2">
		  			<button type="submit" class="button-primary btn-block">Search</button>
		  		</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div class="body-container">
	<?php if($this->session->flashdata('flashdata_success')) : ?>
		<?php echo '
	    	<div class="alert alert-success alert-dismissable fade in">
	    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
	    		.$this->session->flashdata('flashdata_success').
	 		'</div>'
 		; ?>
  	<?php endif; ?>
  	<?php if($this->session->flashdata('flashdata_danger')) : ?>
		<?php echo '
	    	<div class="alert alert-danger alert-dismissable fade in">
	    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
	    		.$this->session->flashdata('flashdata_danger').
	 		'</div>'
 		; ?>
  	<?php endif; ?>
	<div class="table-max all-breeds-container">
		<h1>All Breeds</h1>
		<br>

		<div class="table-responsive">

			<?php if($this->pagination->create_links() != ''){ ?>
				<div class="pagination-links">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			<?php } ?>

			
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>IMAGE</th>
						<th>BREED NAME</th>
						<th>KENNEL CLUB GROUP</th>
						<th>OPTIONS</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($breeds as $breed) : ?>
					<tr>
						<td>
							<?php if($breed['image'] != ''): ?>
								<img src="<?php echo site_url(); ?>uploads/breeds/<?php echo $breed['id']; ?>/thumb_<?php echo $breed['image']; ?>" alt="<?php echo $breed['name'];?> Breed Image">
							<?php else: ?>
								<img src="<?php echo site_url(); ?>uploads/noimage.png" alt="<?php echo $breed['name'];?> Breed Image">
							<?php endif; ?>
						</td>
						<td><?php echo $breed['name']; ?></td>
						<td>
						<?php 
							$kennel_id = $breed['kennel_club_group_id'];
							$kennel_club_name = $this->admin_model->get_kennel_with_id($kennel_id);
							echo $kennel_club_name['name'];
						?>
						</td>
						<td>
							<a href="<?php echo base_url('/admin/breeds/'.$breed['id'].'/edit'); ?>" type="button" class="btn btn-default btn-block"><i class="fa fa-pencil" aria-hidden="true"></i> EDIT</a>	
							<button type="button" class="btn btn-default  btn-block" data-toggle="modal" data-target="#breed-modal-<?php echo $breed['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> DELETE</button>
						</td>
					</tr>
					
						<div class="modal fade" id="breed-modal-<?php echo $breed['id']; ?>" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><i class="fa fa-trash" aria-hidden="true"></i> Breed Delete</h4>
									</div>
									<div class="modal-body">
										<p style="text-align: center;color:#ff5555;">Are you sure , You want to delete breed with id of <?php echo $breed['id']; ?> ?</p>
									</div>
									<div class="modal-footer">
									<?php echo form_open('/admin/breed_delete/'.$breed['id']); ?>
										<button type="submit" class="btn btn-danger"><i class="fa fa-check" aria-hidden="true"></i> YES</button>
									<?php echo form_close(); ?>
										<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> NO</button>
									</div>
								</div>
							</div>
						</div>
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
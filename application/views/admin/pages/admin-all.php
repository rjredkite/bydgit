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
	<div class="all-admin-container">
		<h1>All Administrator</h1>
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
						<th>ID</th>
						<th>USERNAME</th>
						<th>EMAIL</th>
						<th>NAME</th>
						<th>OPTIONS</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($admins as $admin) : ?>
					<tr>
						<td><?php echo $admin['id']; ?></td>
						<td><?php echo $admin['username']; ?></td>
						<td><?php echo $admin['email']; ?></td>
						<td><?php echo $admin['name']; ?></td>
						<td>
						<?php if($this->session->userdata('admin_id_byd') == $admin['id']): ?>
							<a href="<?php echo base_url('/admin/admins/'.$admin['id'].'/edit'); ?>" type="button" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i> EDIT</a>
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#admin-modal-<?php echo $admin['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> DELETE</button>
						<?php else: ?>
							<span class="">This entry is not editable</span>
						<?php endif; ?>
						</td>
					</tr>
						<div class="modal fade" id="admin-modal-<?php echo $admin['id']; ?>" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><i class="fa fa-trash" aria-hidden="true"></i> Admin Delete</h4>
									</div>
									<div class="modal-body">
										<p style="text-align: center;color:#ff5555;">Are you sure , You want to delete admin with id of <?php echo $admin['id']; ?> ?</p>
									</div>
									<div class="modal-footer">
									<?php echo form_open('/admin/admin_delete/'.$admin['id']); ?>
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
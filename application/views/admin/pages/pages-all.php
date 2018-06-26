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
	<div class="all-pages-container">
		<h1>All Pages</h1>
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
						<th>URL</th>
						<th>LANGUAGE</th>
						<th>TITLE</th>
						<th>TEMPLATE</th>
						<th>PUBLISHED</th>
						<th style="width: 200px;">OPTIONS</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($pages as $page) : ?>
					<tr>
						<td><?php echo $page['id']; ?></td>
						<td><?php echo $page['url']; ?></td>
						<td>
							<?php 
								if($page['language'] == 'en'){
									echo 'English';
								}else{
									echo 'America';
								}
							?>
						</td>
						<td><?php echo $page['title']; ?></td>
						<td>
							<?php  
								if($page['template'] == 'home'){
									echo 'Home Page';
								}else{
									echo 'Standard Page';
								}
							?>
						</td>
						<td>
							<?php 
								if($page['published'] == 1){
									echo 'Yes';
								}else{
									echo 'No';
								}
							?>
						</td>

						<td>
							<a href="<?php echo base_url('/admin/pages/'.$page['id'].'/edit'); ?>" type="button" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i> EDIT</a>	
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#page-modal-<?php echo $page['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> DELETE</button>
						</td>
					</tr>
					
					<div class="modal fade" id="page-modal-<?php echo $page['id']; ?>" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><i class="fa fa-trash" aria-hidden="true"></i> Page Delete</h4>
									</div>
									<div class="modal-body">
										<p style="text-align: center;color:#ff5555;">Are you sure , You want to delete page with id of <?php echo $page['id']; ?> ?</p>
									</div>
									<div class="modal-footer">
									<?php echo form_open('/admin/page_delete/'.$page['id']); ?>
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
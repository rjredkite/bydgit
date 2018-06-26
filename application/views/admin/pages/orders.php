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
		<h1>ORDERS</h1>
		<br>

		<div class="table-responsive">

			<?php if($this->pagination->create_links() != ''){ ?>
				<div class="pagination-links">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			<?php } ?>
			
			<table class="order table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>USER</th>
						<th>DETAILS</th>
						<th>DATE</th>
						<th style="width: 200px;">OPTIONS</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($orders as $order) : ?>
					<?php $user = $this->getdata_model->get_user($order['user_id']); ?>
					<tr>
						<td><?php echo $order['id']; ?></td>
						<td><?php
							if($user['email'] != ''){
								echo '<a href="'.base_url('admin/users/'.$order['user_id'].'/edit').'">'.$user['email'].'</a>';
							}else{
								echo 'Close Account';
							}
						?></td>
						<td><?php echo $order['description']; ?></td>
						<td><?php echo $order['created_at']; ?></td>
						<td>
							<a href="<?php echo base_url(''); ?>admin/orders/<?php echo $order['id']; ?>" type="button" class="btn btn-default">View Full Order Details</a>	
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
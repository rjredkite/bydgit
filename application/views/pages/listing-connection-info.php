<?php
  $users_id = $listing['user_id'];
  $userinfo = $this->users_model->get_users($users_id);
?>
<div class="container">
	<div class="alert-container">
		<?php if($this->session->flashdata('flashdata_info')) : ?>
			<?php echo '
				<div class="alert alert-info alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
			    	.$this->session->flashdata('flashdata_info').
				'</div>'
			; ?>
			<?php endif; ?>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="connection-body">
				<h1>Contact the owner of <?php echo $listing['title']; ?></h1>
				<p>Name : <?php echo $userinfo['first_name'];?> <?php echo $userinfo['last_name']; ?></p>
				<p>Email Address : <a href="mailto:<?php echo $userinfo['email'];?>"><?php echo $userinfo['email'];?></a></p>
				<p>Phone Number : <?php echo $userinfo['phone'];?></p>
			</div>
		</div>
		<div class="col-md-4">
			<?php 
				$this->load->view('users/templates/sidebar');
			?>
    	</div>
	</div>
</div>
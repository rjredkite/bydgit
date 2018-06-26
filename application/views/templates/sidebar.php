<?php
	if($this->uri->segment(1) == 'us'){
		$iploc['country'] = 'US - United States';
	}else{
		$iploc = geoCheckIP($this->input->ip_address());
    	$iploc['country'] = $iploc['country_code'].' - '.$iploc['country_name'];
	}

	if($iploc['country'] == 'US - United States'){
		$country_lang = 'us';
	}else{
		$country_lang = '';
	} 
?>
<aside>
	<?php if($this->session->userdata('userlogged_in')) : ?>
		<?php
			$users_id = $this->session->userdata('user_id_byd');
			$userinfo =	$this->users_model->get_users($users_id);
			$plan_id = $userinfo['plan_id'];
        	$plans = $this->getdata_model->get_plans_id($plan_id);
		?>
		<div class="customer-backend-sidebar-frontend">
		  <p>Welcome back <?php echo $userinfo['first_name']; ?></p>
		  <p>Your plan: <?php echo $plans['name']; ?></p>
		  <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/user/plans').'"';
              }else{
                echo 'href="'.base_url('user/plans').'"';
              }
            ?> type="button">Change Plan</a>
		  <hr>
		  <p>You have <?php echo $userinfo['credits']; ?> credits</p>
		  <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/user/dashboard').'"';
              }else{
                echo 'href="'.base_url('user/dashboard').'"';
              }
            ?> type="button">Account</a>
		  <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/payment/new').'"';
              }else{
                echo 'href="'.base_url('payment/new').'"';
              }
            ?> type="button">Add Credits</a>
		  <a href="<?php echo base_url(); ?>pages/userlogout" type="button">Log Out</a>
		</div>
	<?php else : ?>
			
			<div class="sidebar-contianer">
				<a href="<?php echo base_url(); ?>"><img class="img-responsive dog-banner" src="<?php echo base_url() ?>assets/img/sidebar-dog-now.jpg" alt="Sidebar Image"></a>
				<div class="customer-login">
					<?php if($this->session->flashdata('flashdata_failed')) : ?>
						<?php echo '
				    	<div class="alert alert-danger alert-dismissable fade in">
				    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
				    		.$this->session->flashdata('flashdata_failed').
				 		'</div>'; ?>
				  	<?php endif; ?>
				  	<?php if($this->session->flashdata('flashdata_info')) : ?>
						<?php echo '
				    	<div class="alert alert-info alert-dismissable fade in">
				    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
				    		.$this->session->flashdata('flashdata_info').
				 		'</div>'; ?>
				  	<?php endif; ?>
					<?php echo form_open('pages/userlogin'); ?>
						<h5>Login to your account!</h5>
						<input type="email" name="email" placeholder="Email Address" 
						<?php
							if($this->session->flashdata('flashdata_failed') || $this->session->flashdata('flashdata_info')){
								echo 'autofocus';
							}else{
								echo '';
							}
						?>
						required>
						<input type="password" name="password" placeholder="Password" required>

						<div class="row">
							<div class="col-md-4">
								<button type="submit">Login</button>
							</div>
							<div class="col-md-8">
								<p>
									<a <?php 
										if($country_lang == 'us'){
						                	echo 'href="'.base_url('us/user/lost').'"';
						             	}else{
						                	echo 'href="'.base_url('user/lost').'"';
						              	}
									?>><span class="forgot">Forgot Password?</span></a> <br>
									<a class="text-white" <?php
										if($country_lang == 'us'){
						                	echo 'href="'.base_url('us/user/plans').'"';
						             	}else{
						                	echo 'href="'.base_url('user/plans').'"';
						              	}
									?>>Create Account</a>
								</p>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
	<?php endif; ?>
</aside>

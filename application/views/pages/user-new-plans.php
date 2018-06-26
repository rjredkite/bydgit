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
<div class="join-container">
	<div class="header-container">
		<div class="container">
			<div class="join-header">
				<h1>Join Breed Your Dog</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="join-body">
					<p><img src="<?php echo base_url();?>/assets/img/check-icon.jpg" alt="Check Icon"> Advertise your dogs and puppies for free</p>
					<p><img src="<?php echo base_url();?>/assets/img/person-icon.jpg" alt="Personal Icon"> Your listings will be seen by over 3,500 people each day, the UK's largest dog breeding community</p>
					<p> <img src="<?php echo base_url();?>/assets/img/comment-icon.jpg" alt="Comment Icon">Easy to get in touch with other dog owners</p>

					<p><b>Simply fill in the form below to join Breed Your Dog</b></p>

					<div class="row">
						<div class="col-sm-9">
							<div class="form-group">
								<?php 
									if($country_lang == 'us'){
										echo form_open('us/user/new');
									}else{
										echo form_open('user/new');
									}
								?>
									<input class="form-control <?php if(form_error('email')){ echo 'input-has-error'; } ?>" type="email" name="email" placeholder="Email" autofocus required>
									<?php echo form_error('email'); ?>
									<input class="form-control" type="password" name="password" placeholder="Password" required>
									<div class="row">
										<div class="col-xs-6">
											<select class="form-control" name="plans">
												<option value="1" 
												<?php if(@$_GET['plan_id'] == 1){
													echo 'selected';
												} ?>
												>Basic - Free for life</option>
												<option value="5"
												<?php if(@$_GET['plan_id'] == 5){
													echo 'selected';
												} ?>
												>Personal - <?php 
													if($country_lang == 'us'){
														echo '$ '; 
														echo number_format($personal['price_us']/100,2);
													}else{
														echo '£ '; 
														echo number_format($personal['price_en']/100,2);
													}
												?> / Month</option>
												<option value="6"
												<?php if(@$_GET['plan_id'] == 6){
													echo 'selected';
												} ?>
												>Business - <?php 
													if($country_lang == 'us'){
														echo '$ '; 
														echo number_format($business['price_us']/100,2);
													}else{
														echo '£ '; 
														echo number_format($business['price_en']/100,2);
													}
												?> / Month</option>
												<option value="7"
												<?php if(@$_GET['plan_id'] == 7){
													echo 'selected';
												} ?>
												>Ultimate - <?php 
													if($country_lang == 'us'){
														echo '$ '; 
														echo number_format($ultimate['price_us']/100,2);
													}else{
														echo '£ '; 
														echo number_format($ultimate['price_en']/100,2);
													}
												?> / Month</option>
											</select>
										</div>
										<div class="col-xs-6">
											<div class="newsletter">
												<label for="newsletter-check"><input id="newsletter-check" type="checkbox" name="newsletter"> Receive Newsletter</label>
											</div>
										</div>
									</div>
									<p><b>By clicking 'Join Now' you are agreeing to our <a href="<?php echo base_url('tandc'); ?>" class="green" target="_blank">Terms and Conditions</a></b></p>
									<button type="submit">Join Now</button>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
					<img class="dog-join" src="<?php echo base_url();?>/assets/img/join-us-dog.png" alt="Join US Now Dog Image">
				</div>
			</div>
			<div class="col-md-3 col-lg-3">
				<?php 
			       $this->load->view('templates/sidebar');
			    ?>
			</div>
		</div>	
	</div>
</div>
	
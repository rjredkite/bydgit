<?php
	$users_id = $this->session->userdata('user_id_byd');
	$userinfo =	$this->users_model->get_users($users_id);
	$plan_id = $userinfo['plan_id'];
    $plans = $this->getdata_model->get_plans_id($plan_id);

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
<div class="plan-container">
	<div class="header-container">
		<div class="container">
			<div class="plan-header">
				<h1>PLANS AND PACKAGES</h1>
			</div>
		</div>
	</div>
	<div class="container">
	
		<?php if($userinfo['suspended'] == 1): ?>
			<div class="alert-container">
					<div class="alert alert-danger alert-dismissable fade in">
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    Your account is currently suspended, your listings will not be visible to other users.
					</div>
		    </div>
		<?php endif; ?>

		<div class="plan-body">
			<div class="row">

				<div class="col-md-3 col-lg-3">
					<div class="basic-container">
						<div class="image-basic">
							<img src="<?php echo base_url();?>assets/img/basic-dog.png" alt="Basic Plan Dog">
						</div>
						<div class="plan-basic">
							<p>Basic</p>
						</div>
						<div class="price-basic">
							<p>Free For Life</p>
						</div>
						<div class="top-col">
							<p><?php echo $basic['active_listings']; ?> Active Listing</p>
						</div>
						<div class="cols">
							<p><?php echo $basic['photos_per_listing']; ?> Photos per Listing</p>
						</div>
						<div class="bottom-basic">
							<p>Users must pay to enquire

							<a data-toggle="popover" data-placement="top" title="Users must pay to enquire" data-content="With a free Breed Your Dog account, other users must pay a small admin fee ( £1.00 / $1.50 ) to enquire about your listings."><i class="fa fa-question-circle" aria-hidden="true"></i></a>

							</p>
							
							<?php if($plan_id == 1): ?>
								<p><button class="button-disabled" disabled>This is your current plan</button></p>
							<?php elseif(isset($users_id)): ?>
								<?php echo form_open('user/change_plan'); ?>
									<input id="plan_id" name="plan_id" type="hidden" value="1">
									<p><button type="submit">Change to this plan</button></p>
								<?php echo form_close(); ?>
							<?php else: ?>
								<p><a rel="alternate" href="<?php
									if($country_lang == 'us'){
					                  echo base_url('us/user/new');
					                }else{
					                  echo base_url('user/new');
					                }
								?>?plan_id=1" <?php
									if($country_lang == 'us'){
			                          echo 'hreflang="en-us"';
			                        }else{
			                          echo 'hreflang="en-gb"';
			                        }
								?>><button>Join Now!</button></a></p>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-lg-3">
					<div class="personal-container">
						<div class="image-personal">
							<img src="<?php echo base_url();?>assets/img/personal-dog.png" alt="Personal Plan Dog">
						</div>
						<div class="plan-personal">
							<p>Personal</p>
						</div>
						<div class="price-personal">
							<?php 
								if($country_lang == 'us'){
									echo '<p><i class="fa fa-usd" aria-hidden="true"></i> '; 
									echo number_format($personal['price_us']/100,2);
								}else{
									echo '<p><i class="fa fa-gbp" aria-hidden="true"></i> '; 
									echo number_format($personal['price_en']/100,2);
								}
							?> / Month</p>
						</div>
						<div class="top-col">
							<p><?php echo $personal['active_listings']; ?> Active Listings</p>
						</div>
						<div class="cols">
							<p><?php echo $personal['photos_per_listing']; ?> Photos per Listing</p>
						</div>
						<div class="bottom-personal">
							<p>
								Users can enquire without paying

								<a data-toggle="popover" data-placement="top" title="Users can enquire without paying" data-content="With a paid Breed Your Dog account, other users can enquire about your listings free of charge."><i class="fa fa-question-circle" aria-hidden="true"></i></a>

							</p>
							<?php if($plan_id == 5): ?>
								<p><button class="button-disabled" disabled>This is your current plan</button></p>
							<?php elseif(isset($users_id)): ?>
								<?php echo form_open('user/change_plan'); ?>
									<input id="plan_id" name="plan_id" type="hidden" value="5">
									<p><button type="submit">Change to this plan</button></p>
								<?php echo form_close(); ?>
							<?php else: ?>
								<p><a rel="alternate" href="<?php
									if($country_lang == 'us'){
					                  echo base_url('us/user/new');
					                }else{
					                  echo base_url('user/new');
					                }
								?>?plan_id=5" <?php
									if($country_lang == 'us'){
			                          echo 'hreflang="en-us"';
			                        }else{
			                          echo 'hreflang="en-gb"';
			                        }
								?>><button>Join Now!</button></a></p>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<?php 
                
              ?>

				<div class="col-md-3 col-lg-3">
					<div class="business-container">
						<div class="image-business">
							<img src="<?php echo base_url();?>assets/img/business-dog.png" alt="Business Plan Dog">
						</div>
						<div class="plan-business">
							<p>Business</p>
						</div>
						<div class="price-business">
							<?php 
								if($country_lang == 'us'){
									echo '<p><i class="fa fa-usd" aria-hidden="true"></i> '; 
									echo number_format($business['price_us']/100,2);
								}else{
									echo '<p><i class="fa fa-gbp" aria-hidden="true"></i> '; 
									echo number_format($business['price_en']/100,2);
								}
							?> / Month</p>
						</div>
						<div class="top-col">
							<p><?php echo $business['active_listings']; ?> Active Listings</p>
						</div>
						<div class="cols">
							<p><?php echo $business['photos_per_listing']; ?> Photos per Listing</p>
						</div>
						<div class="cols">
							<p>

								Users can enquire without paying

								<a data-toggle="popover" data-placement="top" title="Users can enquire without paying" data-content="With a paid Breed Your Dog account, other users can enquire about your listings free of charge."><i class="fa fa-question-circle" aria-hidden="true"></i></a>

							 </p>
						</div>
						<div class="cols">
							<p>All listings highlighted<br><b>Worth £520.00 / Year!</b></p>
						</div>
						<div class="bottom-business">
							<p>1 weeks free featured listings / month</p>
							<?php if($plan_id == 6): ?>
								<p><button class="button-disabled" disabled>This is your current plan</button></p>
							<?php elseif(isset($users_id)): ?>
								<?php echo form_open('user/change_plan'); ?>
									<input id="plan_id" name="plan_id" type="hidden" value="6">
									<p><button type="submit">Change to this plan</button></p>
								<?php echo form_close(); ?>
							<?php else: ?>
								<p><a rel="alternate" href="<?php
									if($country_lang == 'us'){
					                  echo base_url('us/user/new');
					                }else{
					                  echo base_url('user/new');
					                }
								?>?plan_id=6" <?php
									if($country_lang == 'us'){
			                          echo 'hreflang="en-us"';
			                        }else{
			                          echo 'hreflang="en-gb"';
			                        }
								?>><button>Join Now!</button></a></p>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-lg-3">
					<div class="ultimate-container">
						<div class="image-ultimate">
							<img src="<?php echo base_url();?>assets/img/ultimate-dog.png" alt="Ultimate Plan Dog">
						</div>
						<div class="plan-ultimate">
							<p>Ultimate</p>
						</div>
						<div class="price-ultimate">
							<?php 
								if($country_lang == 'us'){
									echo '<p><i class="fa fa-usd" aria-hidden="true"></i> '; 
									echo number_format($ultimate['price_us']/100,2);
								}else{
									echo '<p><i class="fa fa-gbp" aria-hidden="true"></i> '; 
									echo number_format($ultimate['price_en']/100,2);
								}
							?> / Month</p>
						</div>
						<div class="top-col">
							<p><?php echo $ultimate['active_listings']; ?> Active Listings</p>
						</div>
						<div class="cols">
							<p><?php echo $ultimate['photos_per_listing']; ?> Photos per Listing</p>
						</div>
						<div class="cols">
							<p>

								Users can enquire without paying 

								<a data-toggle="popover" data-placement="top" title="Users can enquire without paying " data-content="With a paid Breed Your Dog account, other users can enquire about your listings free of charge."><i class="fa fa-question-circle" aria-hidden="true"></i></a>	

							</p>
						</div>
						<div class="cols">
							<p>All listings highlighted<br><b>Worth £1,040.00 / Year!</b></p>
						</div>
						<div class="cols">
							<p>2 weeks free featured listings / month</p>
						</div>
						<div class="cols">
							<p>
								Link back to your site
								<a data-toggle="popover" data-placement="top" title="Link back to your site" data-content="This link will appear next to your listings, and will help boost your Google rankings."><i class="fa fa-question-circle" aria-hidden="true"></i></a>
							</p>
						</div>
						<div class="bottom-ultimate">
							<p>
								Full Listing Analytics
								<a data-toggle="popover" data-placement="top" title="Full Listing Analytics" data-content="With Breed Your Dog's Analytics package, you'll be able to see which of your listings and images get the most views, graph performance over time, and get tips to improve your listing's performance"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
							</p>
							<?php if($plan_id == 7): ?>
								<p><button class="button-disabled" disabled>This is your current plan</button></p>
							<?php elseif(isset($users_id)): ?>
								<?php echo form_open('user/change_plan'); ?>
									<input id="plan_id" name="plan_id" type="hidden" value="7">
									<p><button type="submit">Change to this plan</button></p>
								<?php echo form_close(); ?>
							<?php else: ?>
								<p><a rel="alternate" href="<?php
									if($country_lang == 'us'){
					                  echo base_url('us/user/new');
					                }else{
					                  echo base_url('user/new');
					                }
								?>?plan_id=7" <?php
									if($country_lang == 'us'){
			                          echo 'hreflang="en-us"';
			                        }else{
			                          echo 'hreflang="en-gb"';
			                        }
								?>><button>Join Now!</button></a></p>
							<?php endif; ?>
						</div>
					</div>
				</div>

			</div>
		</div>
			
	</div>
</div>
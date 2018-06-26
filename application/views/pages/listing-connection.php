<?php
  $users_id = $this->session->userdata('user_id_byd');
  $userinfo = $this->users_model->get_users($users_id);

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


<div class="container">
	<div class="alert-container">
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="listing-connection-body">
				<h1>Contact the owner of <?php echo $listing['title']; ?></h1>
				
				<?php if($userinfo['credits'] == 0): ?>

					<p> You need at least 1 credit to contact a listings owner, please click the 'Buy Credits' link to purchase creditsPurchase Credits </p>

					<a <?php
						if($country_lang == 'us'){
                          echo 'href="'.base_url('us/payment/new').'"';
                        }else{
                          echo 'href="'.base_url('payment/new').'"';
                        }
					?>><button>Purchase Credits</button></a>

				<?php else: ?>
					<?php
						if($country_lang == 'us'){
                          $form_listing_url = 'us/listings/'.$listing['id'].'/connections';
                        }else{
                          $form_listing_url = 'listings/'.$listing['id'].'/connections';
                        }
					?>
					<?php echo form_open($form_listing_url); ?>
						<p>You have indicated that you wish to find the contact details of the owner of this dog. By clicking the continue button below, you confirm that you understand our terms and accept that a credit will be debited from the <?php echo $userinfo['credits']; ?> credits in your account.</p>
						
						<button type="submit">Continue</button>
						<a <?php
							if($country_lang == 'us'){
	                          echo 'href="'.base_url('us/listings/'.$listing['id']).'"';
	                        }else{
	                          echo 'href="'.base_url('listings/'.$listing['id']).'"';
	                        }
						?>><button type="button" class="cancel-button">Cancel</button></a>
						<?php echo form_close(); ?>


				<?php endif; ?>

				
			</div>
		</div>
		<div class="col-md-4">
			<?php 
				$this->load->view('users/templates/sidebar');
			?>
    	</div>
	</div>
</div>



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
	<?php foreach($userinformations as $info): ?>
      <?php 
        $plan_id = $info['plan_id'];
        $plans = $this->getdata_model->get_plans_id($plan_id);
      ?>

      <?php if($plans['link_back'] == 1  && $userinfo['website'] == ''): ?>
        <div class="alert alert-info alert-dismissable fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Remember to specify your business website on your account details page, as this will put a link to your website on your listings.
        </div>
      <?php endif; ?>

      <?php if($info['suspended'] == 1): ?>
        <div class="alert alert-danger alert-dismissable fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Your account is currently suspended, your listings will not be visible to other users.
        </div>
      <?php endif; ?>

    <?php endforeach; ?>
	</div>
	<div class="row">
		<div class="col-md-8">
      <?php 
        if($country_lang == 'us'){
          echo form_open('us/payment/credits'); 
        }else{
          echo form_open('payment/credits'); 
        }
      ?>
  			<div class="customer-credits-body">
  				<h1>Credit available for contacting dog's/puppies' <br> owners (1 credit required per contact)</h1>
  				<p> Credit available on your account: <?php echo $userinfo['credits']; ?></p>
  				<p> If you wish to add credit to your account, first make sure that you have read and understood our terms and conditions, then please click the one of the following buttons. This will take you to the secure server of PayPal, our payment partner: </p>

  				<button type="submit" name="credits" value="1">Buy 1 Credit - <?php 

            if($country_lang == 'us'){ 
              echo '$1.50';
            }else{
              echo '£1.00';
            } 

          ?>
          </button>
  				<button type="submit" name="credits" value="5">Buy 5 Credits - <?php 

            if($country_lang == 'us'){ 
              echo '$6.00';
            }else{
              echo '£4.00';
            } 

          ?></button>
  			</div>
      <?php echo form_close(); ?>
		</div>
		<div class="col-md-4">
			<?php 
				$this->load->view('users/templates/sidebar');
			?>
    </div>
	</div>
</div>



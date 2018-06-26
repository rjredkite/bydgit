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
	<?php
		$users_id = $this->session->userdata('user_id_byd');
		$userinfo =	$this->users_model->get_users($users_id);
		$plan_id = $userinfo['plan_id'];
        $plans = $this->getdata_model->get_plans_id($plan_id);
	?>
	<div class="customer-backend-sidebar">
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
</aside>
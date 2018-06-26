<?php
  $users = $this->users_model->users();
  $studdogs = $this->users_model->get_stud_dogs();
  $puppies = $this->users_model->get_puppies();

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
	<div class="canceled-container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="alert-container">
				</div>
				<div class="body-container">
					<h1>Subscription canceled</h1>
					<p>You have not been charged, and your account has been set up on the Basic (Free) plan.</p>
					<a class="btn button-default-white" href="<?php 

			            if($country_lang == 'us'){ 
			            	echo base_url('us/user/dashboard');
			            }else{
			            	echo base_url('user/dashboard');
			            } 

			        ?>">Return to Account</a>
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
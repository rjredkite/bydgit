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

  $token = $_GET['token'];
  $payer_id = $_GET['PayerID'];

?>
<div class="container">	
	<div class="canceled-container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="alert-container">
				</div>
				<div class="body-container">
					<h1>Please review and complete your subscription</h1>
					<p>You are about to purchase Breed Your Dog , please click the Complete Purchase button to finalise this subscription.</p>
					<a class="btn button-default-white" href="<?php 

			            if($country_lang == 'us'){ 
			            	echo base_url('us/subscription/cancelled?token='.$token.'&PayerID='.$payer_id);
			            }else{
			            	echo base_url('subscription/cancelled?token='.$token.'&PayerID='.$payer_id);
			            } 

			        ?>">Cancel</a>
			        <a class="btn btn-success" href="<?php
			        	if($country_lang == 'us'){ 
			            	echo base_url('us/subscription/completed?token='.$token.'&PayerID='.$payer_id);
			            }else{
			            	echo base_url('subscription/completed?token='.$token.'&PayerID='.$payer_id);
			            } 
			        ?>">Complete Purchase</a>
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
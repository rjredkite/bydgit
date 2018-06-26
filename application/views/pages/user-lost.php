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
	if($country_lang == 'us'){
		$form = 'us/user/reset';
	}else{
		$form = 'user/reset';
	}
?>
<div class="pages-container">
	<div class="container">
		<div class="alert-container">
			<?php if($this->session->flashdata('flashdata_danger')) : ?>
				<?php echo '
				  <div class="alert alert-danger alert-dismissable fade in">
				    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
				    .$this->session->flashdata('flashdata_danger').
				'</div>'
				; ?>
		    <?php endif; ?>
		    <?php if($this->session->flashdata('flashdata_info')) : ?>
				<?php echo '
				  <div class="alert alert-info alert-dismissable fade in">
				    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
				    .$this->session->flashdata('flashdata_info').
				'</div>'
				; ?>
		    <?php endif; ?>
		    <?php if($this->session->flashdata('flashdata_success')) : ?>
				<?php echo '
				  <div class="alert alert-success alert-dismissable fade in">
				    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
				    .$this->session->flashdata('flashdata_success').
				'</div>'
				; ?>
		    <?php endif; ?>
		</div>
		<div class="row">
			<div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
				<div class="pages-body-lost">
					<div class="row">
						<?php echo form_open($form); ?>
							<div class="col-xs-3 col-sm-3">
								Email
							</div>
							<div class="col-xs-9 col-sm-9">
								<input class="textbox" type="email" name="email" placeholder="Email" required>
							</div>
							<div class="col-xs-12 col-sm-12">
								<br>
								<button type="submit" class="btn btn-success">Reset Password</button>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
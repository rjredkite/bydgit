<div class="contactus-container">
	<div class="header-container">
		<div class="container">
			<div class="contactus-header">
				<h1>Contact Breed Your Dog</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="contactus-body-container">
					<div class="contactus-body">
						<?php if($this->session->flashdata('flashdata_success')) : ?>
							<?php echo '
								<div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
								.$this->session->flashdata('flashdata_success').
								'</div>'
							; ?>
						<?php endif; ?>
						<?php if($this->session->flashdata('flashdata_failed_recapthca')) : ?>
							<?php echo '
								<div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
								.$this->session->flashdata('flashdata_failed').
								'</div>'
							; ?>
						<?php endif; ?>

						<img src="<?php echo base_url() ?>assets/img/contact-us-dog.png" alt="Contact Us Image">

						<span style="color: #ff0000; font-weight: bold; font-size: 13px;">
							This page is for contacting Breed Your Dog admin. Not for contacting the owners of stud dogs or puppies.
						</span>
						<p style="font-size: 16px;">
							Please contact us using the enquiry form below. Make sure you enter your email address correctly.
						</p>

						<?php echo form_open(); ?>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-5">
										<input class="form-control" type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" placeholder="Firstname">
									</div>

									<div class="col-sm-5">
										<input class="form-control" type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" placeholder="Lastname">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-5">
										<input class="form-control <?php if(form_error('email')){ echo 'input-text-has-error'; } ?>" type="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="*Email" required>
									</div>
									<div class="col-sm-5">
										<input class="form-control" type="text" name="phone" value="<?php echo set_value('phone'); ?>" placeholder="Phone">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-10">
										<textarea class="form-control <?php if(form_error('message')){ echo 'input-text-has-error'; } ?>" rows="7" name="message" placeholder="*Message" required><?php echo set_value('message'); ?></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-10">
										<div class="g-recaptcha" data-sitekey="6Lc5N0IUAAAAAEPfz65c0oFHyYMAsawjwh5IBfiR"></div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-10">
										<br>
										<button type='submit'>Send Message</button>
									</div>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
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
<div class="pages-container">
	<div class="container">
		<div class="pages-body">
			<?php if($this->session->flashdata('flashdata_success')) : ?>
				<?php echo '
				  <div class="alert alert-success alert-dismissable fade in">
				    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
				    .$this->session->flashdata('flashdata_success').
				'</div>'
				; ?>
			<?php endif; ?>
			<h1>Thankyou for joining Breed Your Dog</h1>
			<p>
				Before you can start using Breed Your Dog you will need to confirm your email address.
			</p>
			<p>
				A confirmation email has been sent to <strong><?php echo $this->session->userdata('user_email_register'); ?></strong>, this email contains instructions on how to confirm your email address.
			</p>
			<p>
				Your confirmation email should arrive straight away, however, if you do not recieve your confirmation email in the next 24 hours, please <a href="/contact">contact us.</a>
			</p>
			<p>
				If you don't confirm your email address within 14 days your account will be deleted.
			</p>
		</div>
	</div>
</div>
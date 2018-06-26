<?php
	$countries = $this->getdata_model->get_countries(); 
?>

<div class="body-container">
	<div class="users-send-bulk-email">
		<?php echo form_open(''); ?>
			<h1>Compose Email</h1>
			<hr>
			<div class="row">
				<div class="col-md-2 col-lg-2">
					<label for="email-to" <?php if(form_error('sent_to_email')){ echo 'class="txt-has-error"'; } ?>>* To</label>
				</div>
				<div class="col-md-10 col-lg-10">

					<textarea id="email-to" name="sent_to_email" class="textbox <?php if(form_error('sent_to_email')){ echo 'input-has-error'; } ?>" rows="10" cols="50" ><?php

						if($this->input->get('sent_to_email', TRUE)){
							echo $this->input->get('sent_to_email', TRUE);
						}else{
							echo set_value('sent_to_email');
						}
						
						
					?></textarea>
					<?php echo form_error('sent_to_email'); ?>
				</div>
				<div class="col-md-2 col-lg-2">
					<label for="email-subject" <?php if(form_error('subject')){ echo 'class="txt-has-error"'; } ?>>* Subject</label>
				</div>
				<div class="col-md-10 col-lg-10">
					<input id="email-subject" class="textbox <?php if(form_error('subject')){ echo 'input-has-error'; } ?>" type="text" name="subject" value="<?php 

						if($this->input->get('subject', TRUE)){
							echo $this->input->get('subject', TRUE);
						}else{
							echo set_value('subject');
						}

					?>" >
					<?php echo form_error('subject'); ?>
				</div>
				<div class="col-md-2 col-lg-2">
					<label for="email-html-message" <?php if(form_error('html-message')){ echo 'class="txt-has-error"'; } ?>>* HTML Content</label>
				</div>
				<div class="col-md-10 col-lg-10">
					<textarea id="email-html-message" name="html-message" class="textbox <?php if(form_error('html-message')){ echo 'input-has-error'; } ?>"><?php 

						if($this->input->get('html-message', TRUE)){
							echo $this->input->get('html-message', TRUE);
						}else{
							echo set_value('html-message');
						}

					?></textarea>
					<?php echo form_error('html-message'); ?>
				</div>
				<div class="col-md-2 col-lg-2">
					<label for="email-text-message" <?php if(form_error('text-message')){ echo 'class="txt-has-error"'; } ?>>* Raw Content</label>
				</div>
				<div class="col-md-10 col-lg-10">
					<textarea id="email-text-message" name="text-message" class="textbox <?php if(form_error('text-message')){ echo 'input-has-error'; } ?>" rows="10" cols="50"><?php echo set_value('text-message'); ?><?php 

						if($this->input->get('text-message', TRUE)){
							echo $this->input->get('text-message', TRUE);
						}else{
							echo set_value('text-message');
						}

					?></textarea>
					<?php echo form_error('text-message'); ?>
				</div>
			</div>
			<hr>
			<button type="submit" class="button-primary">Send</button>
			<a href="<?php echo base_url('admin/users/bulk_email'); ?>" class="button-cancel">Cancel</a>
		<?php echo form_close(); ?>
	</div>
</div>


<script>
    CKEDITOR.replace( 'html-message' );
</script>
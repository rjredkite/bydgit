<?php
	$countries = $this->getdata_model->get_countries(); 
?>
<div class="body-container">
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
	<div class="search-container">
		<h1>Filter Users</h1>
		<hr>
		<button id="admin-search-button" class="search-fields-button" data-toggle="popovers" data-placement="right" title="Toggle Search Fields" data-content='Click this button to hide or show the search fields.' data-trigger="hover"><i class="fa fa-bars" aria-hidden="true"></i> Toggle Search fields</button> 
		<div class="admin-search-fields">
			<hr>
			<?php echo form_open('',array( 'method' => 'get')); ?>
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="textbox" name="id" placeholder="User ID" value="<?php echo $this->input->get('id', TRUE); ?>">
						<input type="email" class="textbox" name="email" placeholder="Email" value="<?php echo  $this->input->get('email', TRUE); ?>">
						<input type="text" class="textbox" name="name" placeholder="Name" value="<?php echo  $this->input->get('name', TRUE); ?>">
						<select name="country_id">
							<option value="all">Any Country</option>
							<?php foreach($countries as $country): ?>
								<option value="<?php echo $country['id']; ?>" <?php
		                      		if($this->input->get('country_id', TRUE)){
		                      			if($this->input->get('country_id', TRUE) == $country['id']){
											echo 'selected';
										}
		                      		}
		                      	?>><?php echo $country['name']; ?></option>
							<?php endforeach; ?>
						</select>
						<input type="text" class="textbox" name="post_code" placeholder="Zip/Postcode" value="<?php echo  $this->input->get('post_code', TRUE); ?>">
						<input type="text" class="textbox" name="phone" placeholder="Phone" value="<?php echo  $this->input->get('phone', TRUE); ?>">
					</div>
					<div class="col-md-6">
						<div class="date-calendar">
							<div class="input-group">
								<input type="text" class="datepicker" data-date-format="mm/dd/yyyy" name="join_date_after" placeholder="Joined After" value="<?php echo  $this->input->get('join_date_after', TRUE); ?>">
								<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="date-calendar">
							<div class="input-group">
								<input type="text" class="datepicker" data-date-format="mm/dd/yyyy" name="join_date_before"  placeholder="Joined Before" value="<?php echo  $this->input->get('join_date_before', TRUE); ?>">
								<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Newsletter</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="newsletter" value="all" <?php if($this->input->get('newsletter', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="newsletter" value="1" <?php if($this->input->get('newsletter', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="newsletter" value="0" <?php if($this->input->get('newsletter', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Banned</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="banned" value="all" <?php if($this->input->get('banned', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="banned" value="1" <?php if($this->input->get('banned', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="banned" value="0" <?php if($this->input->get('banned', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Suspended</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="suspended" value="all" <?php if($this->input->get('suspended', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="suspended" value="1" <?php if($this->input->get('suspended', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="suspended" value="0" <?php if($this->input->get('suspended', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Deleted</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="deleted" value="all" <?php if($this->input->get('deleted', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="deleted" value="1" <?php if($this->input->get('deleted', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="deleted" value="0" <?php if($this->input->get('deleted', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Paying</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="paying" value="all" <?php if($this->input->get('paying', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="paying" value="1" <?php if($this->input->get('paying', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="paying" value="0" <?php if($this->input->get('paying', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
						<div class="radio-inputs">
							<div class="row">
								<div class="col-sm-3">
									<span>Confirmed</span>
								</div>
								<div class="col-sm-9">
									<label class="radio-inline">
								    	<input type="radio" name="confirmed" value="all" <?php if($this->input->get('confirmed', TRUE) == 'all'){ echo 'checked'; } ?>>Either
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="confirmed" value="1" <?php if($this->input->get('confirmed', TRUE) == '1'){ echo 'checked'; } ?>>Yes 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="confirmed" value="0" <?php if($this->input->get('confirmed', TRUE) == '0'){ echo 'checked'; } ?>>No
								    </label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<button type="submit" class="btn button-primary">Search</button>
				<a href="" class="btn button-cancel">Cancel</a>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<?php if($this->input->get('id', TRUE) || $this->input->get('email', TRUE) || $this->input->get('name', TRUE) || $this->input->get('country_id', TRUE) || $this->input->get('post_code', TRUE) || $this->input->get('phone', TRUE) || $this->input->get('join_date_after', TRUE) || $this->input->get('join_date_before', TRUE) || $this->input->get('sent_to_email', TRUE)){ ?>
	<div class="body-container">
		<div class="users-send-bulk-email">
			<?php echo form_open('admin/users/send_to',array( 'method' => 'get')); ?>
				<h4>Compose Email</h4>
				<hr>
				<div class="row">
					<div class="col-md-2 col-lg-2">
						<label for="email-to">* To</label>
					</div>
					<div class="col-md-10 col-lg-10">

						<textarea id="email-to" name="sent_to_email" class="textbox" rows="10" cols="50"><?php

							foreach($users as $user){
								$email[] = $user['email'];
							} 

						    $pattern = "/\s*/m";
						    $replace = '';
						    
						    $testString = implode(",",$email);
						 
						    $removedWhitespace = preg_replace( $pattern, $replace,$testString );

						    echo str_replace(",",", ",$removedWhitespace);
						 							
						?></textarea>
					</div>
					<div class="col-md-2 col-lg-2">
						<label for="email-subject">* Subject</label>
					</div>
					<div class="col-md-10 col-lg-10">
						<input id="email-subject" class="textbox" type="text" name="subject">
					</div>
					<div class="col-md-2 col-lg-2">
						<label for="email-html-message">* HTML Content</label>
					</div>
					<div class="col-md-10 col-lg-10">
						<textarea id="email-html-message" name="html-message" class="textbox"></textarea>
					</div>
					<div class="col-md-2 col-lg-2">
						<label for="email-text-message">* Raw Content</label>
					</div>
					<div class="col-md-10 col-lg-10">
						<textarea id="email-text-message" name="text-message" class="textbox" rows="10" cols="50"></textarea>
					</div>
				</div>
				<hr>
				<button type="submit" class="btn button-primary">Send</button>
				<a href="<?php echo base_url('admin/users/bulk_email'); ?>" class="btn button-cancel">Cancel</a>
			<?php echo form_close(); ?>
		</div>
	</div>
<?php } ?>

<?php if($this->input->get('id', TRUE) || $this->input->get('email', TRUE) || $this->input->get('name', TRUE) || $this->input->get('country_id', TRUE) || $this->input->get('post_code', TRUE) || $this->input->get('phone', TRUE) || $this->input->get('join_date_after', TRUE) || $this->input->get('join_date_before', TRUE) || $this->input->get('sent_to_email', TRUE)){ ?>
<script>
    CKEDITOR.replace( 'html-message' );
</script>
<?php } ?>
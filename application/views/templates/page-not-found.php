<?php
  $users = $this->users_model->users();
  $studdogs = $this->users_model->get_stud_dogs();
  $puppies = $this->users_model->get_puppies();
?>
<div class="container">	
	<div class="not-found-container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="alert-container">
				</div>
				<div class="body-container">
					<h1>Page Not found</h1>
					<p>The page you have requested could not be found, please check the address and try again. Return to the home page</p>
					<p>If you came here from a link on this or any other site, please <a class="underline" href="<?php echo base_url('contact'); ?>">let us know</a> so that we can ammend this.</p>
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
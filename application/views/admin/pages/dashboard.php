<div class="body-container">
	<?php if($this->session->flashdata('flashdata_success')) : ?>
		<?php echo '
	    	<div class="alert alert-success alert-dismissable fade in">
	    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
	    		.$this->session->flashdata('flashdata_success').
	 		'</div>'
 		; ?>
  	<?php endif; ?>
	<div class="dashboard-admin-container">
		<h1>Dashboard</h1>
		<br>
		
	</div>
</div>
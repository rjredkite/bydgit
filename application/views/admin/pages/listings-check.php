<?php
	$countries = $this->getdata_model->get_countries(); 
	$breeds = $this->getdata_model->get_breeds();

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

	<h1>Check Listings</h1>
	<hr>
	<?php echo form_open('',array('method' => 'get') ); ?>
		<div class="row space">
			<div class="col-md-3">
				<p class="text-right">Keywords</p>
			</div>
			<div class="col-md-6">
				<input type="text" class="textbox" name="keywords" placeholder="keywords" value="<?php echo  $this->input->get('keywords', TRUE); ?>">
			</div>
		</div>
		<div class="row space">
			<div class="col-md-3">
				<label for="check-include-paid-accounts" class="text-right float-right">Include Paid Users</label>
			</div>
			<div class="col-md-6">
				<input id="check-include-paid-accounts" type="checkbox" name="include_paid_accounts" value="true" <?php if($this->input->get('include_paid_accounts', TRUE)){ echo 'checked'; } ?>>
			</div>
		</div>
		<div class="row space">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">
				<button type="submit" class="button-primary">Check Listings</button>
			</div>
		</div>
	<?php echo form_close(); ?>

	
	<hr>
	<div class="table-max">
		<p>
			<?php echo $this->admin_model->count_listings_check(); ?> <?php 
				if($this->admin_model->count_listings_check() <= 1){
					echo 'Listing Found';
				}else{
					echo 'Listings Found';
				}
			?>
		</p>
	</div>
	<div class="">
		<?php if($this->pagination->create_links() != ''){ ?>
			<div class="text-center pagination-links">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		<?php } ?>
	
		<div class="listing-checking-container">
			<?php foreach($listings as $list): ?>
				<h5>
					<a href=<?php echo base_url('admin/listings/'.$list['listing_id'].'/edit'); ?> class="button-primary btn-xs">EDIT</a>
					<?php 
						$string_title = $list['title'];
						echo highlight_phrase($string_title, $this->input->get('keywords', TRUE), '<span class="label label-warning">', '</span>');
					 ?>
				</h5>
				<?php 
					$string_description = $list['description']; 
					echo highlight_phrase($string_description, $this->input->get('keywords', TRUE), '<span class="label label-warning">', '</span>');
				?>

				<hr>
			<?php endforeach; ?>
		</div>

		<?php if($this->pagination->create_links() != ''){ ?>
			<div class="text-center pagination-links">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		<?php } ?>
	</div>
</div>


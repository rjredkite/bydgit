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
	<div class="images-contianer">
		<h1>On Home Page</h1>
		<br>
		<?php if($this->pagination->create_links() != ''){ ?>
			<div class="pagination-links text-center">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		<?php } ?>

		<div class="row">
			<?php $ajaximages = 1; ?>
			<?php foreach($images as $image): ?>
				<?php $list = $this->getdata_model->get_user_listing_row($image['listing_id']); ?>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="image-collumn">
						<a href="<?php echo base_url('admin/listings/'.$image['listing_id'].'/edit'); ?>">
							<div class="image-border">
								<img id="image-replace<?php echo $ajaximages; ?>"  src="<?php echo base_url('uploads/listing_images/'.$image['listing_id'].'/'.$image['id'].'/thumb_small_'.$image['image'].'?'.uniqid()); ?>">
								<?php if($image['on_homepage'] != 1){ ?>
									<p class="not"><i class="fa fa-times" aria-hidden="true"></i> Not on Homepage</p>
								<?php }else{ ?>
									<p class="on"><i class="fa fa-check" aria-hidden="true"></i> On Homepage</p>
								<?php } ?>
								<?php if($image['dont_display'] == 1){ ?>
									<p class="not"><i class="fa fa-times" aria-hidden="true"></i> Not in Frontend</p>
								<?php }else{ ?>
									<p class="on"><i class="fa fa-check" aria-hidden="true"></i> in Frontend</p>
								<?php } ?>
							</div>
						</a>
						<div class="image-bottom">
							<a id="rotate-left<?php echo $ajaximages; ?>" class="button-normal"><i class="fa fa-undo" aria-hidden="true"></i></a>
							<a class="button-normal" data-toggle="modal" data-target="#<?php echo $image['id']; ?>images">Homepage</a>
							<a id="rotate-right<?php echo $ajaximages; ?>" class="button-normal"><i class="fa fa-repeat" aria-hidden="true"></i></a>
						</div>

						<script>
							$(document).ajaxStart(function(){
						        $("#imagerotatingmodal").modal("show");
						    });
						   
							$(document).ready(function(){
							    $("#rotate-left<?php echo $ajaximages; ?>").on('click',function(){

							        $.post("<?php echo base_url('admin/images_rotate/'.$image['id'].'/left');?>",
							        {
							          images_rotate: "<?php echo base_url('uploads/listing_images/'.$image['listing_id'].'/'.$image['id'].'/thumb_small_'.$image['image'].'?'); ?>",
							        },
							        function(data,status){
							            $('#image-replace<?php echo $ajaximages; ?>').attr('src',data);
							        });

							    });

							    $("#rotate-right<?php echo $ajaximages; ?>").click(function(){

							        $.post("<?php echo base_url('admin/images_rotate/'.$image['id'].'/right');?>",
							        {
							          images_rotate: "<?php echo base_url('uploads/listing_images/'.$image['listing_id'].'/'.$image['id'].'/thumb_small_'.$image['image'].'?'); ?>",
							        },
							        function(data,status){
							            $('#image-replace<?php echo $ajaximages; ?>').attr('src',data);
							        });

							    });
							});

							$(document).ajaxComplete(function(){
						        $("#imagerotatingmodal").modal("hide");
						    });

						</script>
						</script>
					</div>

				</div>
			
				<div id="<?php echo $image['id']; ?>images" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
						<?php echo form_open('admin/images_home_save/'.$image['id']); ?>
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4>Homepage Settings</h4>
							</div>
							<div class="modal-body">
								<h5>Listing Details</h5>
								<div class="row">
									<div class="col-sm-3 text-right">
										Title:
									</div>
									<div class="col-sm-9">
										<?php echo $list['title']; ?>
									</div>
								</div>
								<div class="row  space">
									<div class="col-sm-3 text-right">
										Description:
									</div>
									<div class="col-sm-9">
										<?php echo $list['description']; ?>
									</div>
								</div>
								<br><br>
								<hr>
								<h5>Homepage Options</h5>
								<div class="row">
									<div class="col-sm-3 text-right">
										On homepage
									</div>
									<div class="col-sm-9">
										<input type="checkbox" name="on_homepage" <?php if($image['on_homepage'] == '1'){ echo 'checked'; } ?>>
									</div>
								</div>
								<div class="row  space">
									<div class="col-sm-3 text-right">	
										Homepage title
									</div>
									<div class="col-sm-9">
										<input type="" class="textbox-nomargin" name="homepage_title" value="<?php echo $image['homepage_title']; ?>">
									</div>
								</div>
								<hr>
								<h5>Frontend Option</h5>
								<div class="row">
									<div class="col-sm-3 text-right">
										Not in Frontend
									</div>
									<div class="col-sm-9">
										<input type="checkbox" name="dont_display" <?php if($image['dont_display'] == '1'){ echo 'checked'; } ?>>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-success btn-green">Save</button>
							</div>
						<?php echo form_close(); ?>
						</div>
					</div>
				</div>
				<?php $ajaximages++ ;?>
			<?php endforeach; ?>
		</div>

		<?php if($this->pagination->create_links() != ''){ ?>
			<div class="pagination-links text-center">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		<?php } ?>
	</div>
</div>

<!-- Modal -->
<div id="imagerotatingmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-images"></i> Image Rotating</h4>
      </div>
      <div class="modal-body text-center">
       	<p>
       		<img src="<?php echo base_url('assets/img/loading.gif'); ?>" width="100" height="100" />
       	</p>
       	<p>
       		Image Rotating pls wait ...
       	</p>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

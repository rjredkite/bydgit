<?php
  $featureds = $this->users_model->featured();
?>

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
?>

<div class="home-first-fold-container">
	<div class="container">
		<div class="col-md-7 col-lg-7">
			<div class="row">
				<div class="first-fold-contents">
					<h1>
						Find your <span>perfect stud dog,</span><br>
						<span>bitch</span> or <span>puppy today.</span>
					</h1>
					<p class="first-fold-mid">
						<span class="green">FREE</span> to advertise, <span>FREE</span> to join<br>
						browse <span>10,000s of listings</span>.
					</p>

					<?php echo form_open('listings', array('method' => 'get')); ?>
						<div class="first-fold-input">
							<input class='form-control' type="text" name="keywords" placeholder="QUICK SEARCH">
							<i class="fa fa-search" aria-hidden="true"></i>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">	
	<div class="home-container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="homepage-body">
					<div class="homepage-top-adverts hide">
						ADD ADVERBS
					</div>
					<div class="featured-grid">
						<img src="<?php echo base_url() ?>assets/img/featured_banner.png" alt="Featured Banner">
						<div class="featured-dogs">
							<?php 
								foreach($featureds as $featured){
									$listing_id = $featured['id'];
									$listing_image = $this->users_model->get_listing_images($listing_id);

									?>
										<a <?php
												if($country_lang == 'us'){
						                          echo 'href="'.base_url('us/listings/'.$featured['id'].'?context=show_homepage').'"';
						                        }else{
						                          echo 'href="'.base_url('listings/'.$featured['id'].'?context=show_homepage').'"';
						                        }
											?>>
											<?php if($listing_image['image'] != ''): ?>
											<img id="featured-img<?php echo $featured['id'];?>" class="lazyload homepage-featured" src="<?php echo base_url('/uploads/listing_images/'.$listing_image['listing_id'].'/'.$listing_image['id'].'/thumb_small_'.$listing_image['image']); ?>" data-src="<?php echo base_url('/uploads/listing_images/'.$listing_image['listing_id'].'/'.$listing_image['id'].'/thumb_small_'.$listing_image['image']); ?>" alt="<?php echo $featured['title']; ?> Featured Image">
											<?php else: ?>
											<img id="featured-img<?php echo $featured['id'];?>" class="homepage-featured" src="<?php echo base_url('/uploads/thumb_small_noimage.png'); ?>" alt="<?php echo $featured['title']; ?> No Featured Image">
											<?php endif; ?>
										</a>

										<script>
											$(document).ready(function(){
											    $('#featured-img<?php echo $featured['id']; ?>').popover({title: "Featured Listing", content: "<?php
												
													$breed_id =  $featured['breed_id'];;
				                              		$getbreed = $this->getdata_model->get_breed_id($breed_id);
				                              		echo $getbreed['name'];

											    ?>", trigger: "hover", placement: "bottom"})
											});
										</script>

									<?php
								}
							?>
						</div>
						<p class="text-right">
							<a <?php
								if($country_lang == 'us'){
		                          echo 'href="'.base_url('us/listings').'"';
		                        }else{
		                          echo 'href="'.base_url('listings').'"';
		                        }
							?>>MORE LISTINGS...</a>
						</p>
					</div>
				</div>
				<div class="dog-fold-container">
					<div class="home-dog-fold">

						<img src="<?php echo base_url() ?>assets/img/home-dog-fold.png" alt="Dog Fold">

						<div class="row">
							<div class="col-sm-4">

							</div>
							<div class="col-sm-8">
								<div class="dog-fold-contents">
									<p>
										<span> NO TRIAL PERIODS, NO OFFERS JUST </span><span class="green"> PERMANENTLY FREE</span> 
										<span> TO ADVERTISE AND JOIN.</span>
									</p>
									<?php if($country_lang == 'us'){
											echo '
									<p>
										BreedYourDog is the USA’s largest and fastest growing dog breeding website. Even though we are an English based site we advertise dogs from all countries, so no matter where you are in the world you can still join and use BreedYourDog.com to advertise your dogs.
									</p>
									<p>
										The USA&#8217;s No 1 site and No 1 Choice for Stud Dogs, Bitches and Puppies, with over 3500 visitors a day that&#8217;s over 1,000,000 visitors a year all looking at your adverts. BreedYourDog.com is also Europe&#8217;s largest stud dogs breeding website.
									</p>
									
									';
									}else{
										echo '<p>BreedYourDog is the UK&#8217;s largest and fastest growing dog breeding website. Even though we are UK based we advertise dogs from all countries, so no matter where you are in the world you can still join and use BreedYourDog.com to advertise your dogs.</p>
									<p>The UK&#8217;s No 1 site and No 1 Choice for Stud Dogs, Bitches and Puppies, with over 3500 visitors a day that&#8217;s over 1,000,000 visitors a year all looking at your adverts. BreedYourDog.com is also Europe&#8217;s largest stud dogs breeding website.</p>
									
									';}?>
									<?php /*<p>
										Its a website dedicated to dog breeding in the UK where you can <a <?php
											if($country_lang == 'us'){
					                          echo 'href="'.base_url('us/stud-dogs').'"';
					                        }else{
					                          echo 'href="'.base_url('stud-dogs').'"';
					                        }
										?>> advertise your stud dog</a>, bitch and <a <?php
											if($country_lang == 'us'){
					                          echo 'href="'.base_url('us/puppies').'"';
					                        }else{
					                          echo 'href="'.base_url('puppies').'"';
					                        }

										?>>puppies</a> FREE.
									</p> */ ?>
								</div>
							</div>
						</div>	
					</div>
				</div>
				<div class="home-contents-container">
					<?= $content ?>
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
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
<div class="pages-container">
	<div class="header-container">
		<div class="container">
			<div class="pages-header">
				<h1><?php echo $breed['name'];?></h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="pages-body">
					<div class="breed-single-page-container">
						<?php 
							if(!empty($breed['image'])){
								echo '<img src="'.base_url('uploads/breeds/'.$breed['id'].'/thumb_'.$breed['image']).'" alt="Breed Information '.$breed['name'].'">';
							}

							if(!empty($breed['description'])){
								echo '<h3>General Description</h3>';
								echo '<p>'.$breed['description'].'</p>';
							}
							if(!empty($breed['health'])){
								echo '<h3>General Health</h3>';
								echo '<p>'.$breed['health'].'</p>';
							}
							if(!empty($breed['illnesses'])){
								echo '<h3>Hereditary Illnesses</h3>';
								echo '<p>'.$breed['illnesses'].'</p>';
							}
							if(!empty($breed['temperament'])){
								echo '<h3>Character and Temperament</h3>';
								echo '<p>'.$breed['temperament'].'</p>';
							}
							if(!empty($breed['food'])){
								echo '<h3>Food</h3>';
								echo '<p>'.$breed['food'].'</p>';
							}
							if(!empty($breed['exercise'])){
								echo '<h3>Exercise</h3>';
								echo '<p>'.$breed['exercise'].'</p>';
							}
							if(!empty($breed['grooming'])){
								echo '<h3>Grooming</h3>';
								echo '<p>'.$breed['grooming'].'</p>';
							}
							if(!empty($breed['origin'])){
								echo '<h3>Origin</h3>';
								echo '<p>'.$breed['origin'].'</p>';
							}
							if(!empty($breed['other_info'])){
								echo '<h3>Other_info</h3>';
								echo '<p>'.$breed['other_info'].'</p>';
							}

							if(!empty($breed['dog_size']) || !empty($breed['dog_weight']) || !empty($breed['bitch_size']) || !empty($breed['bitch_weight']) || !empty($breed['litter_size']) || !empty($breed['life_expectancy'])){
								echo '<h3>Stats</h3>';
							}
							

							if(!empty($breed['dog_size'])){
								echo '<p>Average Dog Size</p>';
								echo '<p><span>'.$breed['dog_size'].'</span></p>';
							}
							if(!empty($breed['dog_weight'])){
								echo '<p>Average Dog Weight</p>';
								echo '<p><span>'.$breed['dog_weight'].'</span></p>';
							}
							if(!empty($breed['bitch_size'])){
								echo '<p>Average Bitch Size</p>';
								echo '<p><span>'.$breed['bitch_size'].'</span></p>';
							}
							if(!empty($breed['bitch_weight'])){
								echo '<p>Average Bitch Weight</p>';
								echo '<p><span>'.$breed['bitch_weight'].'</span></p>';
							}
							/*if(!empty($breed['puppy_price'])){
								echo '<p>Puppy Price</p>';
								echo '<p><span>'.$breed['puppy_price'].'</span></p>';
							}*/
							if(!empty($breed['litter_size'])){
								echo '<p>Average Litter Size</p>';
								echo '<p><span>'.$breed['litter_size'].'</span></p>';
							}
							if(!empty($breed['life_expectancy'])){
								echo '<p>Average Life Expectancy</p>';
								echo '<p><span>'.$breed['life_expectancy'].'</span></p>';
							}
						?>	
						<br>
						<?php 
							$breed_id = $breed['id'];
							$stud_dog = $this->pages_model->count_stud_dogs_breeds($breed_id);
							$puppies = $this->pages_model->count_puppies_breeds($breed_id);

						?>
						<a <?php
							if($country_lang == 'us'){
	                          echo 'href="'.base_url('us/stud-dogs/'.$breed['url_name']).'"';
	                        }else{
	                          echo 'href="'.base_url('stud-dogs/'.$breed['url_name']).'"';
	                        }
						?>><button><?php echo $breed['name'];?> Stud Dogs ( <?php echo $stud_dog; ?> )</button></a>
						<a <?php
							if($country_lang == 'us'){
	                          echo 'href="'.base_url('us/puppies/'.$breed['url_name']).'"';
	                        }else{
	                          echo 'href="'.base_url('puppies/'.$breed['url_name']).'"';
	                        }

						?>><button><?php echo $breed['name'];?> Puppies ( <?php echo $puppies; ?> )</button></a>
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
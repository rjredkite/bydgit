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
				<h1>Breeds</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="breeds-container">
					<div class="breeds-select">
						Kennel Club Group
						<select id="breeds-kc-group" name="kennel_club_group" required>
							<option value="all">ALL</option>
							<?php foreach($kennels_sort as $kennel) : ?>
								<option value="#<?php echo url_title($kennel['name'], 'dash', TRUE); ?>" 
								<?php	
									if(set_value('kennel_club_group') == $kennel['id']){
										echo 'selected';
									}
								?>
								><?php echo $kennel['name']; ?></option>		
							<?php endforeach; ?>
						</select>
						<?php echo form_error('kennel_club_group'); ?>
					</div>
					
					<?php foreach($kennels_sort as $kennel): ?>
						<div id="<?php echo url_title($kennel['name'], 'dash', TRUE); ?>" class="breeds-kennel-container">
							<h3><?php echo $kennel['name']; ?></h3>
							<?php
								$id = $kennel['id']; 
								$kennel_breeds = $this->getdata_model->get_kennel_breeds($id);

								foreach($kennel_breeds as $kbreed){
									echo '<ul>';
									echo '<li><span class="breeds-header">'.$kbreed['name'].'</span></li>';
									echo '<li><a href="';
									if($country_lang == 'us'){
			                          echo base_url('us/breeds/'.$kbreed['url_name']);
			                        }else{
			                          echo base_url('breeds/'.$kbreed['url_name']);
			                        }
									if($country_lang == 'us'){
			                          echo '"';
			                        }else{
			                          echo '"';
			                        }
									echo'>Breed Information</a></li>';
									echo '<li><a href="';
									if($country_lang == 'us'){
			                          echo base_url('us/stud-dogs/'.$kbreed['url_name']);
			                        }else{
			                          echo base_url('stud-dogs/'.$kbreed['url_name']);
			                        }
									if($country_lang == 'us'){
			                          echo '"';
			                        }else{
			                          echo '"';
			                        }
									echo'>'.$kbreed['name'].' Stud Dogs</a></li>';
									echo '<li><a href="';
									if($country_lang == 'us'){
			                          echo base_url('us/puppies/'.$kbreed['url_name']);
			                        }else{
			                          echo base_url('puppies/'.$kbreed['url_name']);
			                        }
									if($country_lang == 'us'){
			                          echo '"';
			                        }else{
			                          echo '"';
			                        }
									echo'>'.$kbreed['name'].' Puppies</a></li>';
									echo '</ul>';
								}
							?>
						</div>
					<?php endforeach; ?>

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
<div class="body-container">
	<div class="breeds-admin-container">
		<h1>New Breed</h1>
		<hr>
		<?php echo form_open_multipart('admin/breeds/new'); ?>
			<div class="row">
					<div class="col-md-2">
						<label <?php if(form_error('breed_name')){ echo 'class="txt-has-error"'; } ?> for="breed-name">Breed Name *</label>
					</div>
					<div class="col-md-10">
						<input id="breed-name" class="textbox <?php if(form_error('breed_name')){ echo 'input-has-error'; } ?>" type="text" name="breed_name" placeholder="Breed Name" value="<?php echo set_value('breed_name'); ?>" required>
						<?php echo form_error('breed_name'); ?>
					</div>
				</div>
			<div class="row">
				<div class="col-md-2">
					<label <?php if(form_error('kennel_club_group')){ echo 'class="txt-has-error"'; } ?> for="kennel-club">Kennel Club Group *</label>
				</div>
				<div class="col-md-10">
					<select id="kennel-club" <?php if(form_error('kennel_club_group')){ echo 'class="input-has-error"'; } ?> name="kennel_club_group" value="<?php echo set_value('kennel_club_group'); ?>" required>
						<option value=""> - Please Choose - </option>
						<?php foreach($kennels as $kennel) : ?>
							<option value="<?php echo $kennel['id']; ?>" 
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
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-sm-4">
							<label for="dog-size">Dog Size</label>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<input id="dog-size" class="textbox-nomargin" type="text" name="dog_size" value="<?php echo set_value('dog_size'); ?>" placeholder="Dog Size">
								<span class="input-group-addon">inches</span>
							</div>
						     
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label for="dog-weight">Dog Weight</label>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<input id="dog-weight" class="textbox-nomargin" type="text" name="dog_weight" value="<?php echo set_value('dog_weight'); ?>" placeholder="Dog Weight">
								<span class="input-group-addon">lbs</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label for="litter-size">Litter Size</label>
						</div>
						<div class="col-sm-8">
							<input id="litter-size" class="textbox-nomargin" type="text" name="litter_size" value="<?php echo set_value('litter_size'); ?>" placeholder="Litter Size">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label for="puppy-price">Puppy Price</label>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon">£</span>
								<input id="puppy-price" class="textbox-nomargin" type="text" name="puppy_price" value="<?php echo set_value('puppy_price'); ?>" placeholder="Puppy Price">
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-6">	
					<div class="row">
						<div class="col-sm-4">
							<label for="bitch-size">Bitch Size</label>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<input id="bitch-size" class="textbox-nomargin" type="text" name="bitch_size" value="<?php echo set_value('bitch_size'); ?>" placeholder="Bitch Size">
								<span class="input-group-addon">inches</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label for="bitch-weight">Bitch Weight</label>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<input id="bitch-weight" class="textbox-nomargin" type="text" name="bitch_weight" value="<?php echo set_value('bitch_weight'); ?>" placeholder="Bitch Weight">
								<span class="input-group-addon">lbs</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label for="life-expectancy">Life Expectancy</label>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<input id="life-expectancy"  class="textbox-nomargin" type="text" name="life_expectancy" value="<?php echo set_value('life_expectancy'); ?>" placeholder="Life Expectancy">
								<span class="input-group-addon">years</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="general-description">General Description</label>
				</div>
				<div class="col-md-10">
					<textarea id="general-description" name="general_description" rows="4" cols="50" placeholder="General Description"><?php echo set_value('general_description'); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="general-health">General Health</label>
				</div>
				<div class="col-md-10">
					<textarea id="general-health" name="general_health" rows="4" cols="50" placeholder="General Health"><?php echo set_value('general_health'); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="hereditary-illnesses">Hereditary Illnesses</label>
				</div>
				<div class="col-md-10">
					<textarea id="hereditary-illnesses" name="hereditary_illnesses" rows="4" cols="50" placeholder="Hereditary Illnesses"><?php echo set_value('hereditary_illnesses'); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="character-temperament">Character and Temperament</label>
				</div>
				<div class="col-md-10">
					<textarea id="character-temperament" name="character_temperament" rows="4" cols="50" placeholder="Character and Temperament"><?php echo set_value('character_temperament'); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="food">Food</label>
				</div>
				<div class="col-md-10">
					<textarea id="food" name="food" rows="4" cols="50" placeholder="Food"><?php echo set_value('food'); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="exercise">Exercise</label>
				</div>
				<div class="col-md-10">
					<textarea id="exercise" name="exercise" rows="4" cols="50" placeholder="Exercise"><?php echo set_value('exercise'); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="grooming">Grooming</label>
				</div>
				<div class="col-md-10">
					<textarea id="grooming" name="grooming" rows="4" cols="50" placeholder="Grooming"><?php echo set_value('grooming'); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="origin">Origin</label>
				</div>
				<div class="col-md-10">
					<textarea id="origin" name="origin" rows="4" cols="50" placeholder="Origin"><?php echo set_value('origin'); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label for="other-info">Other Info</label>
				</div>
				<div class="col-md-10">
					<textarea id="other-info" name="other_info" rows="4" cols="50" placeholder="Other Info"><?php echo set_value('other_info'); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="upload-image">
					<div class="col-md-2">
						<label for="breed-image">Image</label>
					</div>
					<div class="col-md-10">
						<input id="breed-image" class="file-browse" type="file" name="userfile" size="20">
					</div>
				</div>
			</div>
		</div>
		<hr>
		<button type="submit" class="button-primary">Save Changes</button>
		<a href="<?php echo base_url(); ?>admin/breeds" class="btn button-cancel">Cancel</a>
	<?php echo form_close(); ?>
</div>


<script>
    CKEDITOR.replace( 'general-description' );
    CKEDITOR.replace( 'general-health' );
    CKEDITOR.replace( 'hereditary-illnesses' );
    CKEDITOR.replace( 'character-temperament' );
    CKEDITOR.replace( 'food' );
    CKEDITOR.replace( 'exercise' );
    CKEDITOR.replace( 'grooming' );
    CKEDITOR.replace( 'origin' );
    CKEDITOR.replace( 'other-info' );
</script>

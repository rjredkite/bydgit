<?php
  $users_id = $this->session->userdata('user_id_byd');
  $userinfo = $this->users_model->get_users($users_id);
  $userlistings = $this->getdata_model->get_user_listing($users_id);
  $userlistings_number = $this->getdata_model->get_user_listing_number($users_id);
  date_default_timezone_set("Europe/London");
  $datenow = date('Y-m-d');

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

<?php 
  $address = strtr($userinfo['post_code'],' ','+');
  $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

  $output= json_decode($geocode);

  if($output->status != 'ZERO_RESULTS'){

    $latitude2 = $output->results[0]->geometry->location->lat;
    $longitude2 = $output->results[0]->geometry->location->lng;

  }else{

    $countries = $this->getdata_model->get_countries();
      foreach($countries as $country):
          if($listing['country_id'] == $country['id']):
            $country_code =  $country['code'];
          endif;
      endforeach; 

    $country_address = strtr($country_code,' ','+');

    $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$country_address.'&key=AIzaSyCB6W4Aw95lpIiCvNBzCnIw28QXCciURns');

    $output= json_decode($geocode);

    $latitude2 = $output->results[0]->geometry->location->lat;
    $longitude2 = $output->results[0]->geometry->location->lng;

  }
?>

<div class="container">
  <div class="alert-container">
   <?php if($this->session->flashdata('flashdata_success')) : ?>
      <?php echo '
          <div class="alert alert-success alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
            .$this->session->flashdata('flashdata_success').
        '</div>'
      ; ?>
      <?php endif; ?>
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
    <?php foreach($userinformations as $info): ?>
      <?php 
        $plan_id = $info['plan_id'];
        $plans = $this->getdata_model->get_plans_id($plan_id);
      ?>
      <?php if($plans['link_back'] == 1  && $userinfo['website'] == ''): ?>
        <div class="alert alert-info alert-dismissable fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Remember to specify your business website on your account details page, as this will put a link to your website on your listings.
        </div>
      <?php endif; ?>

      <?php if($info['suspended'] == 1): ?>
        <div class="alert alert-danger alert-dismissable fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Your account is currently suspended, your listings will not be visible to other users.
        </div>
      <?php endif; ?>
      
    <?php endforeach; ?>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="body-container">
        <div class="listing-yours-container">
      
          <?php if($userlistings_number == 0): ?>
            <p>No entries found</p>
          <?php else: ?>
            <p>Display all <?php echo $userlistings_number ;?> listings</p>
            <?php foreach($userlistings as $listing){ ?>

                <div class="listing-container<?php

                  if($userinfo['plan_id'] == 7){
                    echo ' ultimate-listing';
                  }

                  date_default_timezone_set("Europe/London");
                  $datenow = date('Y-m-d');

                  if($listing['featured'] == 1 && $listing['featured_until'] >= $datenow && $listing['highlight'] == 1 && $listing['highlight_until'] >= $datenow){

                    echo ' featured-and-highlighted';
                  
                  }elseif($listing['featured'] == 1 && $listing['featured_until'] >= $datenow){

                    echo ' featured';

                  }elseif($listing['highlight'] == 1 && $listing['highlight_until'] >= $datenow || $userinfo['plan_id'] == 7 || $userinfo['plan_id'] == 6){

                    echo ' highlighted';

                  }
          
                ?>"> 

                  <?php if($userinfo['plan_id'] == 1 || $userinfo['plan_id'] == 5){ ?>
    
                      <?php
                        if($listing['featured'] == 1 && $listing['featured_until'] >= $datenow && $listing['highlight'] == 1 && $listing['highlight_until'] >= $datenow){
                      ?>

                        <img src="<?php echo base_url('assets/img/featured-highlighted.png'); ?>" class="listing-all-banner" alt="Featured and Highlighted Listing Banner">                

                      <?php  
                        }elseif($listing['featured'] == 1 && $listing['featured_until'] >= $datenow){
                      ?>

                        <img src="<?php echo base_url('assets/img/featured.png'); ?>" class="listing-banner" alt="Featured Listing Banner">

                      <?php
                        }elseif($listing['highlight'] == 1 && $listing['highlight_until'] >= $datenow){
                      ?>

                        <img src="<?php echo base_url('assets/img/highlighted.png'); ?>" class="listing-banner" alt="Highlighted Listing Banner">

                      <?php
                        }
                      ?>

                    <?php }else{ ?>

                      <?php
                        if($listing['featured'] == 1 && $listing['featured_until'] >= $datenow){
                      ?>

                        <img src="<?php echo base_url('assets/img/featured-highlighted.png'); ?>" class="listing-all-banner" alt="Featured and Highlighted Listing Banner">                

                      <?php  
                        }elseif($listing['highlight'] == 1){
                      ?>

                        <img src="<?php echo base_url('assets/img/highlighted.png'); ?>" class="listing-banner" alt="Highlighted Listing Banner">

                      <?php
                        }
                      ?>

                    <?php } ?>

                  <div class="row"> 
                    <div class="col-sm-11"> 
                      <h3><a <?php
                        if($country_lang == 'us'){
                          echo 'href="'.base_url('us/');
                        }else{
                          echo 'href="'.base_url();
                        }
                        if($listing['listing_type'] == 'dog'){
                          echo 'stud-dogs';
                        }elseif($listing['listing_type'] == 'pup'){
                          echo 'puppies';
                        }elseif($listing['listing_type'] == 'mem'){
                          echo 'memorials';
                        }

                        $slug_title = url_title($listing['title'], 'dash', TRUE);

                        echo '/'.$listing['id'].'/'.$slug_title;

                        if($country_lang == 'us'){
                          echo '"';
                        }else{
                          echo '"';
                        }

                      ?>><?php echo $listing['title']; ?></a></h3>
                    </div>
                    <div class="col-sm-4">
                      <?php 
                        $listing_id = $listing['id'];
                        $listing_image = $this->users_model->get_listing_images($listing_id);
                      ?>
                      <?php if($listing_image['image'] != ''): ?>
                        <img src="<?php echo base_url('/uploads/listing_images/'.$listing_image['listing_id'].'/'.$listing_image['id'].'/thumb_'.$listing_image['image']); ?>" alt="<?php echo $listing['title']; ?> Listing Image">
                      <?php else: ?>
                        <img src="<?php echo base_url('/uploads/noimage.png'); ?>" alt="<?php echo $listing['title']; ?> Listing Image">
                      <?php endif; ?>
                    </div>
                    <div class="col-sm-8">
                      <div class="listing-contents">
                        <div class="row">
                          <div class="col-xs-4">
                            <b>Location:</b>
                          </div>
                          <div class="col-xs-7">
                            <?php

                              $latitude1 = $listing['latitude'];
                              $longitude1 = $listing['longitude'];

                              echo $listing['region'].' '.(int)miles_distance($latitude1,$longitude1,$latitude2,$longitude2,$miles = true). ' Miles from you';  
    
                            ?>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-4"><b>Breed:</b></div>
                          <div class="col-xs-7">
                            <?php 
                              $breed_id = $listing['breed_id'];
                              $getbreed = $this->getdata_model->get_breed_id($breed_id);

                              echo $getbreed['name'];
                            ?>
                          </div>
                        </div>
                        
                        <?php if($listing['date_of_death'] != ''): ?>
                          <div class="row">
                            <div class="col-xs-4"><b>R.I.P:</b></div>
                            <div class="col-xs-7">
                              <?php 
                                echo $listing['date_of_death'];
                              ?>
                            </div>
                          </div>
                         
                        <?php endif; ?>  
                        <?php if($listing['gender'] != ''): ?>
                       
                          <div class="row">
                            <div class="col-xs-4"><b>Gender:</b></div>
                            <div class="col-xs-7">
                              <?php 
                                if($listing['gender'] == 'm'){
                                  echo 'Dog (Male)';
                                }else{
                                  echo 'Bitch (Female)';
                                }
                              ?>
                            </div>
                          </div>
                         
                        <?php endif; ?>
                       
                        <div class="row">
                          <div class="col-xs-4">
                            <b>Age:</b>
                          </div>
                          <div class="col-xs-7">
                            <?php 
                              $date1 = new DateTime($datenow);
                              $date2 =  new DateTime($listing['date_of_birth']);
                              $diff = $date1->diff($date2);

                              echo $diff->y . " years, " . $diff->m." months, ".$diff->d." days "
                            ?>
                          </div>
                        </div>
                     
                        <div class="row">
                          <div class="col-xs-4"><b>Pedigree:</b></div>
                          <div class="col-xs-7">
                            <?php 
                              if($listing['pedigree'] == 1){
                                echo 'Yes';
                              }else{
                                echo 'No';
                              }
                            ?>
                          </div>
                        </div>
                      
                        <p class="listing-description">
                          <?php echo word_limiter($listing['description'], 25); ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-xs-6">
                      <?php if($listing['listing_type'] == 'dog'): ?>
                        <a type="button" class="btn btn-default" data-toggle="modal" data-target="#memorialise-modal-<?php echo $listing['id']; ?>">Memorialise</a>
                      <?php endif; ?>
                    </div>
                    <div class="col-xs-6">
                      <a <?php 
                        if($country_lang == 'us'){
                          echo 'href="'.base_url('us/listings/'.$listing['id'].'/edit').'"';
                        }else{
                          echo 'href="'.base_url('listings/'.$listing['id'].'/edit').'"';
                        }
                      ?> type="button" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#listing-modal-<?php echo $listing['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                      <a <?php
                        if($country_lang == 'us'){
                          echo 'href="'.base_url('us/');
                        }else{
                          echo 'href="'.base_url();
                        }
                        if($listing['listing_type'] == 'dog'){
                          echo 'stud-dogs';
                        }elseif($listing['listing_type'] == 'pup'){
                          echo 'puppies';
                        }elseif($listing['listing_type'] == 'mem'){
                          echo 'memorials';
                        }

                        $slug_title = url_title($listing['title'], 'dash', TRUE);

                        echo '/'.$listing['id'].'/'.$slug_title;

                        if($country_lang == 'us'){
                          echo '"';
                        }else{
                          echo '"';
                        }

                      ?> type="button" class="btn btn-success"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Read More</a>
                    </div>
                  </div>
                </div>
              

              <div class="modal fade" id="listing-modal-<?php echo $listing['id']; ?>" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete Listing</h4>
                    </div>
                    <div class="modal-body">
                      <p style="text-align: center;">Are you sure you want to permanently delete this listing ?</p>
                    </div>
                    <div class="modal-footer">
                    <?php echo form_open('/users/listing_delete/'.$listing['id']); ?>

                      <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>
                      <button type="submit" class="btn btn-danger"> Delete Listing</button>
                    
                    <?php echo form_close(); ?>
                    </div>
                  </div>
                </div>
              </div>
              
              <?php echo form_open('/users/listing_memorial/'.$listing['id']); ?>
                <div class="modal fade" id="memorialise-modal-<?php echo $listing['id']; ?>" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Memorialise Listing</h4>
                      </div>
                      <div class="modal-body">
                        <p>
                          Creating a memorial for your dog will remove it from the active listings, and should only be done for dogs which have passed away.
                        </p>
                        <p>
                          Only click the 'Create Memorial' button if you sure you wish to create a memorial for this dog.
                        </p>
                        <p class="date-memorial">
                          <label for="memorail-date">Date of Memorial: </label>
                          <input id="memorail-date" type="text" class="datepicker datepicker-not-fullwidth" name="memorial_date" required>
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>
                        <button type="submit" class="btn btn-success"> Create Memorial</button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php echo form_close(); ?>


            <?php } ?>

          <?php endif; ?>

        </div>
      </div>
    </div>
    <div class="col-md-4">
      <?php 
        $this->load->view('users/templates/sidebar');
      ?>
    </div>
  </div>
</div>

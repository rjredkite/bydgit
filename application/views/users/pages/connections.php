<?php
  date_default_timezone_set("Europe/London");
  $datenow = date('Y-m-d');
  $users_id = $this->session->userdata('user_id_byd');
  $userinfo = $this->users_model->get_users($users_id);
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
    
    <?php if($userinfo['suspended'] == 1): ?>
      <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          Your account is currently suspended, your listings will not be visible to other users.
      </div>
    <?php endif; ?>

  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="body-container">
        <div class="listing-users-container">
      
   			<h1>Your Connections</h1>

            <?php foreach($userconnections as $uconnect){ ?>
  
              <?php 
                $connect_id = $uconnect['listing_id'];
                $listing = $this->connection_model->get_connection_listing($connect_id);
              ?>
                
              <?php if(!empty($listing)): ?>
                <div class="listing-container"> 

                  <div class="row"> 
                    <div class="col-sm-11"> 
                      <h3><a <?php 
                        if($country_lang == 'us'){
                          echo 'href="'.base_url('us/connections/'.$uconnect['id']).'"';
                        }else{
                          echo 'href="'.base_url('connections/'.$uconnect['id']).'"';
                        }
                    ?>><?php echo $listing['title']; ?></a></h3>
                    </div>
                    <div class="col-sm-6">
                      <?php 
                        $listing_id = $listing['id'];
                        $listing_image = $this->users_model->get_listing_images($listing_id);
                      ?>
                      <a <?php 
                        if($country_lang == 'us'){
                          echo 'href="'.base_url('us/connections/'.$uconnect['id']).'"';
                        }else{
                          echo 'href="'.base_url('connections/'.$uconnect['id']).'"';
                        }
                      ?>>
                        <?php if($listing_image['image'] != ''): ?>
                          <img src="<?php echo base_url('/uploads/listing_images/'.$listing_image['listing_id'].'/'.$listing_image['id'].'/thumb_'.$listing_image['image']); ?>" alt="<?php echo $listing['title']; ?> Listing Image">
                        <?php else: ?>
                          <img src="<?php echo base_url('/uploads/noimage.png'); ?>" alt="<?php echo $listing['title']; ?> Listing Image">
                        <?php endif; ?>
                      </a>
                    </div>
                    <div class="col-sm-6">
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
                      
                      </div>
                    </div>
                  </div>
                  <p class="text-right"><a <?php
                    if($country_lang == 'us'){
                      echo 'href="'.base_url('us/connections/'.$uconnect['id']).'"';
                    }else{
                      echo 'href="'.base_url('connections/'.$uconnect['id']).'"';
                    }
                  ?>>View Contact Details...</a></p>
                </div>
              <?php endif; ?>

            <?php } ?>

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

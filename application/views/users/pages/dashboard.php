<?php
  $users_id = $this->session->userdata('user_id_byd');
  $userinfo = $this->users_model->get_users($users_id);
  $userlisting_number = $this->getdata_model->get_listings_number($users_id);
  $userconnections = $this->connection_model->get_user_connections($users_id);

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
    <?php foreach($userinformations as $info): ?>
      <?php 
        $plan_id = $info['plan_id'];
        $plans = $this->getdata_model->get_plans_id($plan_id);
      ?>

      <?php if($plans['link_back'] == 1 && $userinfo['website'] == ''): ?>
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
        <h1>Dashboard</h1>
        <div class="row">
          <div class="col-sm-4">
            <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/user/edit').'"';
              }else{
                echo 'href="'.base_url('user/edit').'"';
              }
            ?>>
              <div class="dashboard-buttons">
                  <i class="fa fa-address-book fa-4x" aria-hidden="true"></i> 
                  <p>Edit Account Details</p>
              </div>
            </a>
          </div>
          <div class="col-sm-4">
            <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/user/plans').'"';
              }else{
                echo 'href="'.base_url('user/plans').'"';
              }
            ?>>
              <div class="dashboard-buttons">
                <i class="fa fa-shopping-cart fa-4x" aria-hidden="true"></i>
                <p>Change Plan</p>
              </div>
            </a>
          </div>
          <div class="col-sm-4">
            <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/payment/new').'"';
              }else{
                echo 'href="'.base_url('payment/new').'"';
              }
            ?>>
              <div class="dashboard-buttons">
                <span class="badge badge-info"><?php echo $userinfo['credits']; ?></span>
                <i class="fa fa-money fa-4x" aria-hidden="true"></i>
                <p>Purchase Credits</p>
              </div>
            </a>
          </div>
          <div class="col-sm-4">
            <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/listings/yours').'"';
              }else{
                echo 'href="'.base_url('listings/yours').'"';
              }
            ?>>
              <div class="dashboard-buttons">
                <span class="badge badge-info"><?php echo $userlisting_number; ?></span>
                <i class="fa fa-list-alt fa-4x" aria-hidden="true"></i>
                <p>Your Listings</p>
              </div>
            </a>
          </div>
          <div class="col-sm-4">
            <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/listings/new/dog').'"';
              }else{
                echo 'href="'.base_url('listings/new/dog').'"';
              }
            ?>>
              <div class="dashboard-buttons">
                <i class="fa fa-pencil fa-4x" aria-hidden="true"></i>
                <p>New Stud Dog Listing</p>
              </div>
            </a>
          </div>
          <div class="col-sm-4">
            <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/listings/new/litter').'"';
              }else{
                echo 'href="'.base_url('listings/new/litter').'"';
              }
            ?>>
              <div class="dashboard-buttons">
                <i class="fa fa-pencil fa-4x" aria-hidden="true"></i>
                <p>New Puppies Listing</p>
              </div>
            </a>
          </div>
          <?php if($userinfo['plan_id'] == 7){ ?>
            <div class="col-sm-4">
              <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/statistics').'"';
              }else{
                echo 'href="'.base_url('statistics').'"';
              }
            ?>>
                <div class="dashboard-buttons">
                  <i class="fa fa-bar-chart fa-4x" aria-hidden="true"></i>
                  <p>Listing Statistics</p>
                </div>
              </a>
            </div>
          <?php } ?>
          <div class="col-sm-4">
            <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/connections').'"';
              }else{
                echo 'href="'.base_url('connections').'"';
              }
            ?>>
              <div class="dashboard-buttons">
                <span class="badge badge-info"><?php echo count($userconnections); ?></span>
                <i class="fa fa-exchange fa-4x" aria-hidden="true"></i>
                <p>Connections</p>
              </div>
            </a>
          </div>
          <div class="col-sm-4">
            <div class="dashboard-buttons" data-toggle="modal" data-target="#close-account">
              <i class="fa fa-window-close fa-4x" aria-hidden="true"></i>
              <p>Close Account</p>
            </div>
          </div>

          <div class="modal fade" id="close-account" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Close Account</h4>
                </div>
                <div class="modal-body">
                 <p style="text-align: center;">Are you sure you wish to close your Breed Your Dog account? If you have an active paid subscription, this will also be cancelled.</p>
                </div>
                <div class="modal-footer">
                  <?php echo form_open('users/close_account/'.$users_id); ?>

                  <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>
                  <button type="submit" class="btn btn-danger"> Close Account</button>

                <?php echo form_close(); ?>
                </div>
              </div>
            </div>
          </div>
      
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

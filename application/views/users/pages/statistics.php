<?php
  $users_id = $this->session->userdata('user_id_byd');
  $listings = $this->getdata_model->get_user_listing($users_id);
  date_default_timezone_set("Europe/London");
  $olddate = strtotime('2015-06-1');
  $newdate = strtotime(date("Y-m-1"));

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

  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="body-container">
        <h1>Listing Statistics</h1>
        <div class="row">
        <?php echo form_open('', array( 'method' => 'get')); ?>
          <div class="col-sm-5">
            <select class="input-default" name="date_from">
              <?php
                while($olddate <= $newdate){

                  if($this->input->get('date_from', TRUE) == date('Y-m-d',  $newdate)){
                    $select = 'selected';
                  }else{
                    $select = '';
                  }

                  echo '<option value="'.date('Y-m-d',  $newdate).'" '.$select.'>'.date('F Y',  $newdate).'</option>';
                  $newdate = strtotime("-1 month",  $newdate);
                }
              ?>
            </select>
          </div>
          <div class="col-sm-3">
            <button type="submit" class="button-default width-full">Change Month</button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
  
      <?php foreach($listings as $list): ?>
        <?php 
          if($this->input->get('date_from', TRUE)){
            $numshow = $this->users_model->daily_views_result_show($this->input->get('date_from', TRUE),$list['id']);
            $numclick = $this->users_model->daily_views_result_click($this->input->get('date_from', TRUE),$list['id']);
            $choosedate = $this->input->get('date_from', TRUE);
          }else{
            $newdate = strtotime(date("Y-m-1"));
            $numshow = $this->users_model->daily_views_result_show(date('Y-m-d',  $newdate),$list['id']);
            $numclick = $this->users_model->daily_views_result_click(date('Y-m-d',  $newdate),$list['id']);
            $choosedate = date('Y-m-d',  $newdate);
          }
        ?>

        <div class="body-container">
          <h4><b><?php echo $list['title'];?></b></h4>
          
          <p>Times shown in search results: <?php 

            if($numshow['views'] != ''){ 
              echo $numshow['views'];
            }else{
              echo '0';
            } 
          ?></p>

          <p>Times clicked from search results: <?php 
            if($numclick['views'] != ''){
              echo $numclick['views']; 
            }else{
              echo '0';
            }
          ?></p>

          <a <?php 
            if($country_lang == 'us'){
              echo 'href="'.base_url('us/statistics/'.$list['id'].'?date_from='.$choosedate).'"';
            }else{
              echo 'href="'.base_url('statistics/'.$list['id'].'?date_from='.$choosedate).'"';
            }
          ?> class="button-default">View Full Listing Statistics</a>
        </div>
      <?php endforeach; ?>

    </div>
    <div class="col-md-4">
      <?php 
        $this->load->view('users/templates/sidebar');
      ?>
    </div>
  </div>
</div>

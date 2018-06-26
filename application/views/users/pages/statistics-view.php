<script src="<?php echo base_url() ?>assets/js/mdb.min.js"></script>
<?php
  date_default_timezone_set("Europe/London");

  if($this->input->get('date_from', TRUE) != '' && $this->input->get('date_to', TRUE) == ''){
    $startdate = $this->input->get('date_from', TRUE);

    $enddate = date('Y-m-t', strtotime(date($startdate)));

  }elseif($this->input->get('date_to', TRUE)){

    $startdate = $this->input->get('date_from', TRUE);

    $enddate = $this->input->get('date_to', TRUE);

  }else{
    $startdate = date('Y-m-d',  strtotime(date("Y-m-1")));

    $enddate = date('Y-m-t', strtotime(date($startdate)));
  }

  $list_stats = createRangeStat($startdate, $enddate);

  foreach ($list_stats as $list_date){

    $search_result = $this->users_model->daily_views_result_show_graph($list_date,$listing['id']);
    if(!empty($search_result)){
      $array_views_shown[] = $search_result['views'];
    }else{
      $array_views_shown[] = 0;
    }

  }

  $list_stats2 = createRangeStat($startdate, $enddate);

  foreach ($list_stats2 as $list_date2){

    $search_result_click = $this->users_model->daily_views_result_click_graph($list_date2,$listing['id']);
    if(!empty($search_result_click)){
      $array_views_shown_click[] = $search_result_click['views'];
    }else{
      $array_views_shown_click[] = 0;
    }

  }

?>

<div class="container">
  <div class="alert-container">
      <div class="alert alert-info alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          Tip: Avoid using all capital letters and ambigous abreiviations in listing titles
      </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="body-container">
        <h1><?php echo $listing['title']; ?></h1>
        <div class="row">
        <?php echo form_open('', array( 'method' => 'get')); ?>
          <div class="col-md-4 col-lg-4">
            <div class="date-calendar">
              <br>
              <label for="from-date">From Date</label>
              <div class="input-group">
                <input id="from-date" type="text" id="listing-featured-until" class="datepicker" data-date-format="yyyy-mm-dd" name="date_from" placeholder="" value="<?php echo $startdate; ?>">
                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="date-calendar">
              <br>
              <label for="from-date">To Date</label>
              <div class="input-group">
                <input id="from-date" type="text" id="listing-featured-until" class="datepicker" data-date-format="yyyy-mm-dd" name="date_to" placeholder="" value="<?php echo $enddate; ?>">
                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <br>
            <label class="text-white">space</label>
            <div class="input-group width-full">
              <button class="button-default width-full">Update</button>
            </div>
          </div>
        <?php echo form_close(); ?>
        </div>
      </div>
      <div class="body-container">
        <h4>Times shown in search results</h4>
        <canvas id="lineChart"></canvas>
        <script>
          var js_array =<?php echo json_encode($list_stats);?>;
          var js_search_result =<?php echo json_encode($array_views_shown);?>;

          $labels = js_array;

          var ctxL = document.getElementById("lineChart").getContext('2d');
          var myLineChart = new Chart(ctxL, {
              type: 'line',
              data: {
                  labels: $labels,
                  datasets: [
                      {
                          label: "Times shown in search results",
                          fillColor: "rgba(220,220,220,0.2)",
                          strokeColor: "rgba(220,220,220,1)",
                          pointColor: "rgba(220,220,220,1)",
                          pointStrokeColor: "#fff",
                          pointHighlightFill: "#fff",
                          pointHighlightStroke: "rgba(220,220,220,1)",
                          data: js_search_result
                      }
                  ]
              },
              options: {
                  responsive: true
              }    
          });
        </script>
      </div>
      <div class="body-container">
        <h4>Times viewed in detail from search results (clicks)</h4>
        <canvas id="lineChart2"></canvas>
        <script>
          var js_array2 = <?php echo json_encode($list_stats2);?>;
          var js_search_result_click = <?php echo json_encode($array_views_shown_click);?>;
          $labels2 = js_array2;
          var ctxL = document.getElementById("lineChart2").getContext('2d');
          var myLineChart2 = new Chart(ctxL, {
              type: 'line',
              data: {
                  labels: $labels2,
                  datasets: [
                      {
                          label: "Times viewed in detail from search results (clicks)",
                          fillColor: "rgba(220,220,220,0.2)",
                          strokeColor: "rgba(220,220,220,1)",
                          pointColor: "rgba(220,220,220,1)",
                          pointStrokeColor: "#fff",
                          pointHighlightFill: "#fff",
                          pointHighlightStroke: "rgba(220,220,220,1)",
                          data: js_search_result_click
                      }
                  ]
              },
              options: {
                  responsive: true
              }    
          });
        </script>
      </div>
    </div>
    <div class="col-md-4">
      <?php 
        $this->load->view('users/templates/sidebar');
      ?>
    </div>
  </div>
</div>

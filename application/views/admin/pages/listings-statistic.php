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
	      <button class="button-search width-full">Update</button>
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

<?php 
$listing_images = $this->getdata_model->get_listing_images_for_thumbnails($listing['id']);

$image = 1;
foreach($listing_images as $list_image){
?>
	<div class="body-container">
		<h4>Image <?php echo $image; ?></h4>
		
		<?php $list_statsimage = createRangeStat($startdate, $enddate); ?>

		<?php

			foreach($list_statsimage as $list_dateimage){

				$show_result_listing_image = $this->users_model->daily_views_listing_image($list_dateimage,$list_image['id']);

				if(!empty($show_result_listing_image)){
				  ${'array_views_shown_images'.$image}[] = $show_result_listing_image['views'];
				}else{
				  ${'array_views_shown_images'.$image}[] = 0;
				}

			}
			
		?>

		<canvas id="lineChartimage<?php echo $image; ?>"></canvas>
		<script>
		  var js_arrayimage = <?php echo json_encode($list_statsimage);?>;
		  var js_search_show_image<?php echo $image; ?> = <?php echo json_encode(${'array_views_shown_images'.$image});?>;
		  $labelsimage<?php echo $image; ?> = js_arrayimage;
		  var ctxL = document.getElementById("lineChartimage<?php echo $image; ?>").getContext('2d');
		  var myLineChart<?php echo $image; ?> = new Chart(ctxL, {
		      type: 'line',
		      data: {
		          labels: $labelsimage<?php echo $image; ?>,
		          datasets: [
		              {
		                  label: "Times viewed in detail from search results (clicks)",
		                  fillColor: "rgba(220,220,220,0.2)",
		                  strokeColor: "rgba(220,220,220,1)",
		                  pointColor: "rgba(220,220,220,1)",
		                  pointStrokeColor: "#fff",
		                  pointHighlightFill: "#fff",
		                  pointHighlightStroke: "rgba(220,220,220,1)",
		                  data: js_search_show_image<?php echo $image; ?>
		              }
		          ]
		      },
		      options: {
		          responsive: true
		      }    
		  });
		</script>

		<div class="row">
			<div class="col-md-12 col-lg-12 text-right">
				<br>
				<a href="<?php echo base_url('uploads/listing_images/'.$list_image['listing_id'].'/'.$list_image['id'].'/'.$list_image['image']); ?>" class="button-normal">View Image</a>
			</div>
		</div>
	</div>
<?php 
$image++;
}

?>


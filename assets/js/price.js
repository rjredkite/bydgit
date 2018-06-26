$(document).ready(function(){

  $('#user-highlighted').change(function(){
    $highlighted_listing  =   $('#user-highlighted').val();
    $featured_listing     =   $('#user-featured-listing').val();
    $fl_sign = '£';

    if($highlighted_listing != 0){

      if($featured_listing != 0){
        /* Highlights != 0 && != '' and Featured is != 0 && != '' */
        switch ($highlighted_listing + "|" + $featured_listing) {
          case "1|1":
            $('#listing-price').text($fl_sign+'2.25');
            break;
          case "1|2":
            $('#listing-price').text($fl_sign+'3.75');
            break;
          case "1|3":
            $('#listing-price').text($fl_sign+'5.25');
            break;
          case "1|4":
            $('#listing-price').text($fl_sign+'6.75');
            break;
          case "1|5":
            $('#listing-price').text($fl_sign+'8.25');
            break;
          case "2|1":
            $('#listing-price').text($fl_sign+'3.25');
            break;
          case "2|2":
            $('#listing-price').text($fl_sign+'4.50');
            break;
          case "2|3":
            $('#listing-price').text($fl_sign+'6.00');
            break;
          case "2|4":
            $('#listing-price').text($fl_sign+'7.50');
            break;
          case "2|5":
            $('#listing-price').text($fl_sign+'9.00');
            break;
          case "3|1":
            $('#listing-price').text($fl_sign+'4.25');
            break;
          case "3|2":
            $('#listing-price').text($fl_sign+'5.50');
            break;
          case "3|3":
            $('#listing-price').text($fl_sign+'6.75');
            break;
          case "3|4":
            $('#listing-price').text($fl_sign+'8.25');
            break;
          case "3|5":
            $('#listing-price').text($fl_sign+'9.75');
            break;
          case "4|1":
            $('#listing-price').text($fl_sign+'5.25');
            break;
          case "4|2":
            $('#listing-price').text($fl_sign+'6.50');
            break;
          case "4|3":
            $('#listing-price').text($fl_sign+'7.75');
            break;
          case "4|4":
            $('#listing-price').text($fl_sign+'9.00');
            break;
          case "4|5":
            $('#listing-price').text($fl_sign+'10.50');
            break;
          case "5|1":
            $('#listing-price').text($fl_sign+'6.25');
            break;
          case "5|2":
            $('#listing-price').text($fl_sign+'7.50');
            break;
          case "5|3":
            $('#listing-price').text($fl_sign+'8.75');
            break;
          case "5|4":
            $('#listing-price').text($fl_sign+'10.00');
            break;
          case "5|5":
            $('#listing-price').text($fl_sign+'11.25');
            break;
          default:
            $('#listing-price').text('Free');
        }

      }else{

        $fl_val = 1.00 * $highlighted_listing;
        $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
        /* Highlights != 0 && != '' and Featured is == 0 && == '' */
      }
    }else if($featured_listing != 0){

      $fl_val = 1.50 * $featured_listing;
      $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
      /* Highlights == 0 && == '' and Featured is != 0 && != '' */
    }else{
      $('#listing-price').text('Free');
    }
  });

  $('#user-featured-listing').change(function(){
    $highlighted_listing  =   $('#user-highlighted').val();
    $featured_listing     =   $('#user-featured-listing').val();
    $fl_sign = '£';

    if($highlighted_listing != 0){

      if($featured_listing != 0){
        /* Highlights != 0 && != '' and Featured is != 0 && != '' */
        switch ($highlighted_listing + "|" + $featured_listing) {
          case "1|1":
            $('#listing-price').text($fl_sign+'2.25');
            break;
          case "1|2":
            $('#listing-price').text($fl_sign+'3.75');
            break;
          case "1|3":
            $('#listing-price').text($fl_sign+'5.25');
            break;
          case "1|4":
            $('#listing-price').text($fl_sign+'6.75');
            break;
          case "1|5":
            $('#listing-price').text($fl_sign+'8.25');
            break;
          case "2|1":
            $('#listing-price').text($fl_sign+'3.25');
            break;
          case "2|2":
            $('#listing-price').text($fl_sign+'4.50');
            break;
          case "2|3":
            $('#listing-price').text($fl_sign+'6.00');
            break;
          case "2|4":
            $('#listing-price').text($fl_sign+'7.50');
            break;
          case "2|5":
            $('#listing-price').text($fl_sign+'9.00');
            break;
          case "3|1":
            $('#listing-price').text($fl_sign+'4.25');
            break;
          case "3|2":
            $('#listing-price').text($fl_sign+'5.50');
            break;
          case "3|3":
            $('#listing-price').text($fl_sign+'6.75');
            break;
          case "3|4":
            $('#listing-price').text($fl_sign+'8.25');
            break;
          case "3|5":
            $('#listing-price').text($fl_sign+'9.75');
            break;
          case "4|1":
            $('#listing-price').text($fl_sign+'5.25');
            break;
          case "4|2":
            $('#listing-price').text($fl_sign+'6.50');
            break;
          case "4|3":
            $('#listing-price').text($fl_sign+'7.75');
            break;
          case "4|4":
            $('#listing-price').text($fl_sign+'9.00');
            break;
          case "4|5":
            $('#listing-price').text($fl_sign+'10.50');
            break;
          case "5|1":
            $('#listing-price').text($fl_sign+'6.25');
            break;
          case "5|2":
            $('#listing-price').text($fl_sign+'7.50');
            break;
          case "5|3":
            $('#listing-price').text($fl_sign+'8.75');
            break;
          case "5|4":
            $('#listing-price').text($fl_sign+'10.00');
            break;
          case "5|5":
            $('#listing-price').text($fl_sign+'11.25');
            break;
          default:
            $fl_val = 1.50 * $featured_listing;
            $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
        }

      }else{

        if($highlighted_listing != undefined){
          $fl_val = 1.00 * $highlighted_listing;
          $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
          /* Highlights != 0 && != '' and Featured is == 0 && == '' */
        }else{
          $('#listing-price').text('Free');
        }
      }
    }else if($featured_listing != 0){

      $fl_val = 1.50 * $featured_listing;
      $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
      /* Highlights == 0 && == '' and Featured is != 0 && != '' */
    }else{
      $('#listing-price').text('Free');
    }
  });

});

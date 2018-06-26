<?php foreach($userinformations as $info): ?>
<?php 
  $plan_id = $info['plan_id'];
  $plans = $this->getdata_model->get_plans_id($plan_id);

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
    <?php if($plans['link_back'] == 1  && $info['website'] == ''): ?>
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
      
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="user-listings-body">
        <h1>Create new Stud Dog / Bitch</h1>
        <div class="alert alert-warning">
          Please note: We are sorry but breedyourdog.com comes under English Law, and as such we cannot advertise any breeds banned under the UK Dangerous Dogs Act 1991. The Pit Bull Terrier, Japanese Tosa, Dogo Argentino, Fila Braziliero or any cross of these breeds or their puppies are all banned from advertising on breedyourdog.com. We appreciate your understanding and co operation.
        </div>
        <?php 

          if($country_lang == 'us'){
            echo form_open_multipart('us/listings/new/dog');
          }else{
            echo form_open_multipart('listings/new/dog');
          }

        ?>
          <div class="row">
            <div class="col-md-4">
              <label for="user-listing-title">* Listing Title:</label>
            </div>
            <div class="col-md-8">
              <input type="text" class="textbox" id="user-listing-title" autocomplete="false" data-toggle="popover" data-placement="right" title="Listing Title" data-content='This is the brief description that appears at the top of each listing e.g. "Chocolate brown labrador". Required, maximum 255 characters.' name="listing_title" value="<?php echo set_value('listing_title'); ?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-dogname">* Dogname:</label>
            </div>
            <div class="col-md-8">
              <input type="text" class="textbox" id="user-dogname" autocomplete="false" data-toggle="popover" data-placement="right" title="Dogname" data-content='The name you call your dog / bitch, not its kennel club name. Required, maximum 255 characters.' name="dogname" value="<?php echo set_value('dogname'); ?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-kcn">Kennel Club Name:</label>
            </div>
            <div class="col-md-8">
              <input type="text" class="textbox" id="user-kcn" autocomplete="false" data-toggle="popover" data-placement="right" title="Kennel Club Name" data-content="Your dog's registered Kennel Club Name, if it has one. maximum 255 characters." name="kennel" value="<?php echo set_value('kennel'); ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-gender">* Gender:</label>
            </div>
            <div class="col-md-8">
              <select id="user-gender" name="gender" required>
                <option value=""></option>
                <option value="m" <?php if(set_value('gender') == 'm'){ echo 'selected'; }?>>Dog (Male)</option>
                <option value="f" <?php if(set_value('gender') == 'f'){ echo 'selected'; }?>>Bitch (Female)</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-breed">* Breed:</label>
            </div>
            <div class="col-md-8">
              <select id="user-breed" data-toggle="popover" data-placement="right" title="Breed" data-content="If tyhe breed isn't available from this list of kennel Club recognised breeds, please ensure that your dog's breed is described in the listing title above. Required." name="breed" required>
                <option value=""></option>
                <?php 
                  $breeds = $this->getdata_model->get_breeds();
                  foreach($breeds as $breed): 
                ?>  
                  <option value="<?php echo $breed['id']; ?>" <?php if(set_value('breed') == $breed['id']){ echo 'selected'; }?>><?php echo $breed['name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-dob">* Date of Birth:</label>
            </div>
            <div class="col-md-8">
              <input type="text" class="datepicker" id="user-dob" data-date-format="mm/dd/yyyy" autocomplete="false" data-provide="datepicker" data-toggle="popover" data-placement="right" title="Date of Birth" data-content="For puppies, enter the expected date of birth if they have not yet been born. Format YYYY-MM-DD, Required." name="date" value="<?php echo set_value('date'); ?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-listing-description" <?php if(form_error('listing_description')){ echo 'class="txt-has-error"'; } ?>>* Listing Description:</label>
            </div>
            <div class="col-md-8">
              <textarea class="textbox <?php if(form_error('listing_description')){ echo 'input-text-has-error'; } ?>" id="user-listing-description" autocomplete="false" data-toggle="popover" data-placement="right" title="Listing description" data-content="Describe your listing here, please do not include your contact details, as this breaks the terms and conditions of use of this site. Required." name="listing_description" rows="5"><?php echo set_value('listing_description'); ?></textarea>
              <?php echo form_error('listing_description'); ?>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-country">* Country:</label>
            </div>
            <div class="col-md-8">
              <select class="" id="user-country" data-toggle="popover" data-placement="right" title="Country" data-content="The country in which your dog or litter is located. Required." name="country" required>
                <option value=""></option>
                 <?php $countries = $this->getdata_model->get_countries(); ?>
                    <?php foreach($countries as $country): ?>
                      <option value="<?php echo $country['id']; ?>" 
                        <?php if(set_value('country') == $country['id']): ?>
                          <?php echo 'selected'; ?>
                        <?php elseif($info['country_id'] == $country['id']): ?>
                          <?php echo 'selected'; ?>
                        <?php endif; ?>
                      ><?php echo $country['name']; ?></option>
                    <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-region">* Region:</label>
            </div>
            <div class="col-md-8">
              <input type="text" class="textbox" id="user-region" autocomplete="false" data-toggle="popover" title="Region" data-placement="right" data-content="The region, country or state in which your dog or litter is located. Required, maximum 255 characters." name="region" value="<?php echo set_value('region'); ?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-post-code">* Post Code:</label>
            </div>
            <div class="col-md-8">
              <input type="text" class="textbox" id="user-post-code" autocomplete="false" data-toggle="popover" data-placement="right" title="Post Code" data-content="The post code of where your dog or litter is located. Required, maximum 255 characters." name="post_code" value="<?php echo $info['post_code']; ?>" value="<?php echo set_value('post_code'); ?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-pedigree">Pedigree?</label>
            </div>
            <div class="col-md-8">
              <input id="user-pedigree" class="user-pedigree" type="checkbox" name="pedigree" data-toggle="popover" data-placement="right" title="Pedigree?" data-content="Please only tick this box if you are able to provide a pedigree document should it be required." <?php if(set_value('pedigree') != '' ){ echo 'checked'; }?>>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="user-published">Published?</label>
            </div>
            <div class="col-md-8">
              <input id="user-published" class="user-published" type="checkbox" name="published" data-toggle="popover" data-placement="right" title="Published?" data-content="Untick this box if you do not yet want this listing to be visible to other users." checked>
            </div>
          </div>
          <h3>Pictures</h3> 
          <div class="well">
            <p>You may upload up to <?php echo $plans['photos_per_listing']; ?> pictures of your stud dog / bitch. Image 1 should be the picture that best represents your stud dog / bitch as this will be used in search results and other pages which list dogs. Only the page that describes your listing in detail will use the other images.
  
            <br><br>
            "Note: Please upload your image files in lowercase (.jpg) extensions."
            
            </p>
          </div>
          <div class="user-picture">
            <?php 
              $plan_id = $info['plan_id'];
              $plan = $this->getdata_model->get_plans_id($plan_id);
            ?>
            
              <div class="row">
                <div class="col-md-4">
                  <label for="user-image1">Image 1</label>
                </div>
                <div class="col-md-8">
                  <input id="user-image1" class="upload_images" type="file" name="userfile[]">
                </div>
              </div>
              <span class="add-files"></span>
              <?php $ppl_number = $plan['photos_per_listing']; ?>

              <?php 
                $fileimgupload = 1;
                while( $fileimgupload <= $plans['photos_per_listing'] ){
              ?>
                
                <script>
                  $("#user-image<?php echo $fileimgupload; ?>").change(function() {
                      
                      var fileExtension = ['gif,jpg,png,jpeg'];
                      if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                          $("#modalfileformat").modal({show: true});
                          $(this).val('');
                      }

                      if(this.files[0].size/ 1024 / 1024 > 1){
                        $("#modalwarning").modal({show: true});
                        $(this).val('');
                      }

                  });
                </script>

              <?php 
                $fileimgupload++;
                }
              ?>

              <script>
                $(document).ready(function(){
                  var count = 1;
                  var number = 2
                  var icon = "<i class='fa fa-folder-open' aria-hidden='true'></i>"

                  $(".add_image").click(function(){
                      if(count < <?php echo $ppl_number ?> ) {
                          var $addinput = $('<div class="row"><div class="col-md-4"><label for="user-image' + number + '">Image ' + number + '</label></div> <div class="col-md-8"><input id="user-image' + number + '" class="upload_images" type="file" name="userfile[]"></div></div>');
                          $(".add-files").append($addinput);
                           $(".upload_images").jfilestyle({buttonText: '<i class="fa fa-folder-open" aria-hidden="true"></i>'});
                          count++;
                          number++;
                      }
                    else{
                      $(".add_image").hide();
                   }
                  });
                });
              </script>
            
            <div class="row">
              <div class="col-md-4">
              </div>
              <div class="col-md-8">
                <button type="button" class="add_image">Add another picture</button>
              </div>
            </div>
          </div>
          <h3>Extras</h3> 
          <div class="alert alert-info">
          <?php if($plans['highlight_listings'] == 0): ?>
            10% Combination Discount <br>
            If you both feature and highlight your listing, it will only cost you <?php 
              if($country_lang == 'us'){
                echo '$3.40';
              }else{
                echo '£2.25';
              }
            ?> per week, saving you 10%!
          <?php else: ?>
            Your listings are all automatically highlighted
          <?php endif; ?>
          </div>
          
          <?php 
            if($info['featured_credits'] != 0){
          ?>
            <div class="alert alert-info">
              You have <?php 
                if($info['featured_credits'] == 1){
                  echo $info['featured_credits'].' week';
                }else{
                  echo $info['featured_credits'].' weeks';
                }
              ?> of free featured listings
            </div>
          <?php   
            }
          ?>
  
          <?php if($plans['highlight_listings'] == 0): ?>
            <div class="row">
              <div class="col-md-4">
                <label for="user-highlighted">Highlighted listing</label>
              </div>
              <div class="col-md-8">
                <select id="user-highlighted" class="highlighted-listing" data-toggle="popover" data-placement="right" title="Highlighted Lising" data-content="Highlighted listings are displayed in an eye-catching green box, making them stand out more to other users. Highlighted listings cost <?php 

                  if($country_lang == 'us'){
                    echo '$1.50';
                  }else{
                    echo '£1.00';  
                  }

                ?> per week." name="highlighted_listing">
                  <option value=""></option>
                  <option value="0">Not Highlighted</option>
                  <option value="1">Highlighted for 1 week</option>
                  <option value="2">Highlighted for 2 weeks</option>
                  <option value="3">Highlighted for 3 weeks</option>
                  <option value="4">Highlighted for 4 weeks</option>
                  <option value="5">Highlighted for 5 weeks</option>
                </select>
              </div>
            </div>
          <?php endif; ?>
          <div class="row">
            <div class="col-md-4">
              <label for="user-featured-listing">Featured listing</label>
            </div>
            <div class="col-md-8">
              <select id="user-featured-listing" class="featured-listing" data-toggle="popover" data-placement="right" title="Featured Listing" data-content="Featured listings are always shown at the top of the search result, giving them extra exposure. Featured listings costs <?php 

                  if($country_lang == 'us'){
                    echo '$2.25';
                  }else{
                    echo '£1.50';  
                  }

                ?> per week." name="featured_listing">
                <option value=""></option>
                <option value="0">Not Featured</option>
                <option value="1">Featured for 1 week</option>
                <option value="2">Featured for 2 weeks</option>
                <option value="3">Featured for 3 weeks</option>
                <option value="4">Featured for 4 weeks</option>
                <option value="5">Featured for 5 weeks</option>
              </select>
            </div>
          </div>
          <div class="user-listing-price-container">
            <div class="row">
              <div class="col-md-4">
                <label >Listing price</label>
              </div>
              <div class="col-md-8">
                <p id="listing-price">Free</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-8">
              <div class="user-button">
                <button type="submit" class="">Create Listing</button>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
    <div class="col-md-4">
      <?php 
        $this->load->view('users/templates/sidebar');
      ?>
    </div>
  </div>
</div>

<?php
  if($info['featured_credits'] != 0){
?>
  <script>
    $(document).ready(function(){

      $('#user-highlighted').change(function(){
        $highlighted_listing  =   $('#user-highlighted').val();
        $featured_listing     =   $('#user-featured-listing').val();

        <?php if($country_lang == 'us'){ ?>

            if($featured_listing != 0 && $highlighted_listing == 0){ 
  
              if($featured_listing <= <?php echo $info['featured_credits']; ?>){

                if($highlighted_listing != 0){
                  $fl_sign = '$';
                  $fl_val = 1.50 * $highlighted_listing;
                  $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                }else{
                  $('#listing-price').text('Free');
                }

              }else{

                $fl_sign = '$';
                $fl_val = 2.25 * $featured_listing;
                $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

              }

            }else if($featured_listing == 0 && $highlighted_listing != 0){

              $fl_sign = '$';
              $fl_val = 1.50 * $highlighted_listing;
              $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

            }else if($featured_listing != 0 && $highlighted_listing != 0){

              if($featured_listing <= <?php echo $info['featured_credits']; ?>){

                $fl_sign = '$';
                $fl_val = 1.50 * $highlighted_listing;
                $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

              }else{

                switch ($highlighted_listing + "|" + $featured_listing) {
                  case "1|1":
                    $('#listing-price').text($fl_sign+'3.40');
                    break;
                  case "1|2":
                    $('#listing-price').text($fl_sign+'5.65');
                    break;
                  case "1|3":
                    $('#listing-price').text($fl_sign+'7.90');
                    break;
                  case "1|4":
                    $('#listing-price').text($fl_sign+'10.15');
                    break;
                  case "1|5":
                    $('#listing-price').text($fl_sign+'12.40');
                    break;
                  case "2|1":
                    $('#listing-price').text($fl_sign+'4.90');
                    break;
                  case "2|2":
                    $('#listing-price').text($fl_sign+'6.80');
                    break;
                  case "2|3":
                    $('#listing-price').text($fl_sign+'9.05');
                    break;
                  case "2|4":
                    $('#listing-price').text($fl_sign+'11.30');
                    break;
                  case "2|5":
                    $('#listing-price').text($fl_sign+'13.55');
                    break;
                  case "3|1":
                    $('#listing-price').text($fl_sign+'6.40');
                    break;
                  case "3|2":
                    $('#listing-price').text($fl_sign+'8.30');
                    break;
                  case "3|3":
                    $('#listing-price').text($fl_sign+'10.20');
                    break;
                  case "3|4":
                    $('#listing-price').text($fl_sign+'12.45');
                    break;
                  case "3|5":
                    $('#listing-price').text($fl_sign+'14.70');
                    break;
                  case "4|1":
                    $('#listing-price').text($fl_sign+'7.90');
                    break;
                  case "4|2":
                    $('#listing-price').text($fl_sign+'9.80');
                    break;
                  case "4|3":
                    $('#listing-price').text($fl_sign+'11.70');
                    break;
                  case "4|4":
                    $('#listing-price').text($fl_sign+'13.60');
                    break;
                  case "4|5":
                    $('#listing-price').text($fl_sign+'15.85');
                    break;
                  case "5|1":
                    $('#listing-price').text($fl_sign+'9.40');
                    break;
                  case "5|2":
                    $('#listing-price').text($fl_sign+'11.30');
                    break;
                  case "5|3":
                    $('#listing-price').text($fl_sign+'13.20');
                    break;
                  case "5|4":
                    $('#listing-price').text($fl_sign+'15.10');
                    break;
                  case "5|5":
                    $('#listing-price').text($fl_sign+'17.00');
                    break;
                  default:
                    $('#listing-price').text('Free');
                }

              }

            }else{
              $('#listing-price').text('Free');
            } 

        <?php }else{ ?>

          if($featured_listing != 0 && $highlighted_listing == 0){ 

            if($featured_listing <= <?php echo $info['featured_credits']; ?>){

              if($highlighted_listing != 0){
                $fl_sign = '£';
                $fl_val = 1.00 * $highlighted_listing;
                $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
              }else{
                $('#listing-price').text('Free');
              }

            }else{

              $fl_sign = '£';
              $fl_val = 1.50 * $featured_listing;
              $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

            }

          }else if($featured_listing == 0 && $highlighted_listing != 0){

            $fl_sign = '£';
            $fl_val = 1.00 * $highlighted_listing;
            $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

          }else if($featured_listing != 0 && $highlighted_listing != 0){

            if($featured_listing <= <?php echo $info['featured_credits']; ?>){

              $fl_sign = '£';
              $fl_val = 1.00 * $highlighted_listing;
              $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

            }else{

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

            }

          }else{
            $('#listing-price').text('Free');
          } 

        <?php } ?>

      });
    
      $('#user-featured-listing').change(function(){
        $highlighted_listing  =   $('#user-highlighted').val();
        $featured_listing     =   $('#user-featured-listing').val();
        
        <?php if($country_lang == 'us'){ ?>

            if($featured_listing != 0 && $highlighted_listing == 0){ 

              if($featured_listing <= <?php echo $info['featured_credits']; ?>){

                if($highlighted_listing != 0){
                  $fl_sign = '$';
                  $fl_val = 1.50 * $highlighted_listing;
                  $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                }else{
                  $('#listing-price').text('Free');
                }

              }else{

                $fl_sign = '$';
                $fl_val = 2.25 * $featured_listing;
                $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

              }

            }else if($featured_listing == 0 && $highlighted_listing != 0){

              if($featured_listing == 0 && $highlighted_listing == 0){

                $('#listing-price').text('Free');
              
              }else if($featured_listing == 0 && $highlighted_listing != 0){

                if($featured_listing == 0 && $highlighted_listing == 0){
                  $('#listing-price').text('Free');
                }else if($featured_listing != 0 && $highlighted_listing != 0){
                  $fl_sign = '$';
                  $fl_val = 1.50 * $highlighted_listing;
                  $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

                }else if($highlighted_listing != undefined){
                  $fl_sign = '$';
                  $fl_val = 1.50 * $highlighted_listing;
                  $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                }else{
                  $('#listing-price').text('Free');
                } 

              }else{

                $('#listing-price').text('Free');

              }
              
            }else if($featured_listing != 0 && $highlighted_listing != 0){

              if($featured_listing <= <?php echo $info['featured_credits']; ?>){

                if($featured_listing != 0 && $highlighted_listing == 0){
                  $('#listing-price').text('Free');
                }else if($featured_listing == 0 && $highlighted_listing != 0){
                  $fl_sign = '$';
                  $fl_val = 1.50 * $highlighted_listing;
                  $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

                }else if($featured_listing != 0 && $highlighted_listing != 0){

                  if($featured_listing <= <?php echo $info['featured_credits']; ?>){

                    if($highlighted_listing != undefined){
                      $fl_sign = '$';
                      $fl_val = 1.50 * $highlighted_listing;
                      $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                    }else{
                      $('#listing-price').text('Free');
                    }
                    
                  }else{
                    $fl_sign = '$';
                    $fl_val = 1.50 * $highlighted_listing;
                    $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                  }
                  
                }else{
                  $('#listing-price').text('Free');
                }

              }else{

                switch ($highlighted_listing + "|" + $featured_listing) {
                  case "1|1":
                    $('#listing-price').text($fl_sign+'3.40');
                    break;
                  case "1|2":
                    $('#listing-price').text($fl_sign+'5.65');
                    break;
                  case "1|3":
                    $('#listing-price').text($fl_sign+'7.90');
                    break;
                  case "1|4":
                    $('#listing-price').text($fl_sign+'10.15');
                    break;
                  case "1|5":
                    $('#listing-price').text($fl_sign+'12.40');
                    break;
                  case "2|1":
                    $('#listing-price').text($fl_sign+'4.90');
                    break;
                  case "2|2":
                    $('#listing-price').text($fl_sign+'6.80');
                    break;
                  case "2|3":
                    $('#listing-price').text($fl_sign+'9.05');
                    break;
                  case "2|4":
                    $('#listing-price').text($fl_sign+'11.30');
                    break;
                  case "2|5":
                    $('#listing-price').text($fl_sign+'13.55');
                    break;
                  case "3|1":
                    $('#listing-price').text($fl_sign+'6.40');
                    break;
                  case "3|2":
                    $('#listing-price').text($fl_sign+'8.30');
                    break;
                  case "3|3":
                    $('#listing-price').text($fl_sign+'10.20');
                    break;
                  case "3|4":
                    $('#listing-price').text($fl_sign+'12.45');
                    break;
                  case "3|5":
                    $('#listing-price').text($fl_sign+'14.70');
                    break;
                  case "4|1":
                    $('#listing-price').text($fl_sign+'7.90');
                    break;
                  case "4|2":
                    $('#listing-price').text($fl_sign+'9.80');
                    break;
                  case "4|3":
                    $('#listing-price').text($fl_sign+'11.70');
                    break;
                  case "4|4":
                    $('#listing-price').text($fl_sign+'13.60');
                    break;
                  case "4|5":
                    $('#listing-price').text($fl_sign+'15.85');
                    break;
                  case "5|1":
                    $('#listing-price').text($fl_sign+'9.40');
                    break;
                  case "5|2":
                    $('#listing-price').text($fl_sign+'11.30');
                    break;
                  case "5|3":
                    $('#listing-price').text($fl_sign+'13.20');
                    break;
                  case "5|4":
                    $('#listing-price').text($fl_sign+'15.10');
                    break;
                  case "5|5":
                    $('#listing-price').text($fl_sign+'17.00');
                    break;
                  default:
                    $fl_sign = '£';
                    $fl_val = 2.25 * $featured_listing;
                    $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                }
                
              }
            
            }else{
              $('#listing-price').text('Free');
            } 

        <?php }else{ ?>

          if($featured_listing != 0 && $highlighted_listing == 0){ 

              if($featured_listing <= <?php echo $info['featured_credits']; ?>){

                if($highlighted_listing != 0){
                  $fl_sign = '£';
                  $fl_val = 1.00 * $highlighted_listing;
                  $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                }else{
                  $('#listing-price').text('Free');
                }

              }else{

                $fl_sign = '£';
                $fl_val = 1.50 * $featured_listing;
                $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

              }

            }else if($featured_listing == 0 && $highlighted_listing != 0){

              if($featured_listing == 0 && $highlighted_listing == 0){

                $('#listing-price').text('Free');
              
              }else if($featured_listing == 0 && $highlighted_listing != 0){

                if($featured_listing == 0 && $highlighted_listing == 0){
                  $('#listing-price').text('Free');
                }else if($featured_listing != 0 && $highlighted_listing != 0){
                  $fl_sign = '£';
                  $fl_val = 1.00 * $highlighted_listing;
                  $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

                }else if($highlighted_listing != undefined){
                  $fl_sign = '£';
                  $fl_val = 2.25 * $highlighted_listing;
                  $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                }else{
                  $('#listing-price').text('Free');
                } 

              }else{

                $('#listing-price').text('Free');

              }
              
            }else if($featured_listing != 0 && $highlighted_listing != 0){

              if($featured_listing <= <?php echo $info['featured_credits']; ?>){

                if($featured_listing != 0 && $highlighted_listing == 0){
                  $('#listing-price').text('Free');
                }else if($featured_listing == 0 && $highlighted_listing != 0){
                  $fl_sign = '£';
                  $fl_val = 1.00 * $highlighted_listing;
                  $('#listing-price').text($fl_sign+$fl_val.toFixed(2));

                }else if($featured_listing != 0 && $highlighted_listing != 0){

                  if($featured_listing <= <?php echo $info['featured_credits']; ?>){

                    if($highlighted_listing != undefined){
                      $fl_sign = '£';
                      $fl_val = 1.00 * $highlighted_listing;
                      $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                    }else{
                      $('#listing-price').text('Free');
                    }
                    
                  }else{
                    $fl_sign = '£';
                    $fl_val = 1.00 * $highlighted_listing;
                    $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                  }
                  
                }else{
                  $('#listing-price').text('Free');
                }

              }else{

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
                    $fl_sign = '£';
                    $fl_val = 1.50 * $featured_listing;
                    $('#listing-price').text($fl_sign+$fl_val.toFixed(2));
                }
                
              }
            
            }else{
              $('#listing-price').text('Free');
            } 

        <?php } ?>

      });

    });
  </script>

<?php
  }else{

    if($country_lang == 'us'){
    ?>
      <script src="<?php echo base_url('/assets/js/price-us.js'); ?>"></script>
    <?php
      }else{
    ?>
      <script src="<?php echo base_url('/assets/js/price.js'); ?>"></script>
    <?php 
      }
  }
?>

<?php endforeach; ?>


<div class="modal fade" id="modalwarning" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Error</h4>
        </div>
        <div class="modal-body">
          <p>Please upload images up to 2mb only.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modalfileformat" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Error</h4>
        </div>
        <div class="modal-body text-center">
          <p>Please chanege your image to this file format. <br> ( gif, jpg, png, jpeg )</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
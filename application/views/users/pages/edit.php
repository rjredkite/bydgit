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

    <?php endforeach; ?>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="user-edit-body">
        <?php foreach($userinformations as $info) : ?>
          <?php echo form_open('user/edit'); ?>           
            <h1>Edit your Account</h1>
            <div class="customer-info">
              <form>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-email" <?php if(form_error('user_email')){ echo 'class="txt-has-error"'; } ?>>* Email:</label>
                  </div>
                  <div class="col-md-8">
                    <input type="email" id="user-email" class="textbox <?php if(form_error('user_email')){ echo 'input-has-error'; } ?>" name="user_email" value="<?php echo $info['email']; ?>" autocomplete="false" required>
                    <?php echo form_error('user_email'); ?>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-pass" <?php if(form_error('user_password')){ echo 'class="txt-has-error"'; } ?>>Password:</label>
                  </div>
                  <div class="col-md-8">
                    <input type="password" id="user-pass" class="textbox <?php if(form_error('user_password')){ echo 'input-has-error'; } ?>" name="user_password" autocomplete="false">
                    <?php echo form_error('user_password'); ?>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-pass-con" <?php if(form_error('user_confirmpassword')){ echo 'class="txt-has-error"'; } ?>>Password Confirmation:</label>
                  </div>
                  <div class="col-md-8">
                    <input type="password" id="user-pass-con" class="textbox <?php if(form_error('user_confirmpassword')){ echo 'input-has-error'; } ?>" name="user_confirmpassword" autocomplete="false">
                    <?php echo form_error('user_confirmpassword'); ?>
                  </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-md-4">
                  <label for="user-fname" <?php if(form_error('user_firstname')){ echo 'class="txt-has-error"'; } ?>>* Firstname:</label>
                </div>
                <div class="col-md-8">
                  <input type="text" id="user-fname" class="textbox <?php if(form_error('user_firstname')){ echo 'input-has-error'; } ?>" name="user_firstname" value="<?php echo $info['first_name']; ?>" autocomplete="false" required>
                  <?php echo form_error('user_firstname'); ?>
                </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-lname" <?php if(form_error('user_lastname')){ echo 'class="txt-has-error"'; } ?>>* Lastname:</label>
                  </div>
                  <div class="col-md-8">
                    <input type="text" id="user-lname" class="textbox <?php if(form_error('user_lastname')){ echo 'input-has-error'; } ?>" name="user_lastname" value="<?php echo $info['last_name']; ?>" autocomplete="false" required>
                    <?php echo form_error('user_lastname'); ?>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-phone" <?php if(form_error('user_phone')){ echo 'class="txt-has-error"'; } ?>>* Phone:</label>
                  </div>
                  <div class="col-md-8">
                    <input type="text" id="user-phone" class="textbox <?php if(form_error('user_phone')){ echo 'input-has-error'; } ?>" name="user_phone" value="<?php echo $info['phone']; ?>" autocomplete="false" required>
                    <?php echo form_error('user_phone'); ?>
                  </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-md-4">
                  <label for="user-add" <?php if(form_error('user_address')){ echo 'class="txt-has-error"'; } ?>>* Address:</label>
                </div>
                  <div class="col-md-8">
                    <textarea id="user-add" class="textbox <?php if(form_error('user_address')){ echo 'input-has-error'; } ?>" name="user_address" rows="5" required><?php echo $info['address']; ?></textarea>
                    <?php echo form_error('user_address'); ?>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-post-code" <?php if(form_error('user_post_code')){ echo 'class="txt-has-error"'; } ?>>* Post code:</label>
                  </div>
                  <div class="col-md-8">
                    <input type="text" id="user-post-code" class="textbox <?php if(form_error('user_post_code')){ echo 'input-has-error'; } ?>" name="user_post_code" value="<?php echo $info['post_code']; ?>" autocomplete="false" required>
                    <?php echo form_error('user_post_code'); ?>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-country" <?php if(form_error('user_country')){ echo 'class="txt-has-error"'; } ?>>* Country:</label>
                  </div>
                  <div class="col-md-8">
                    <select id="user-country" <?php if(form_error('user_country')){ echo 'class="input-has-error"'; } ?> name="user_country" required>
                      <option value=""></option>
                      <?php $countries = $this->getdata_model->get_countries(); ?>
                      <?php foreach($countries as $country): ?>
                        <option value="<?php echo $country['id']; ?>" 
                          <?php 
                            if($info['country_id'] == $country['id']){
                              echo 'selected';
                            }
                          ?>
                        ><?php echo $country['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <?php echo form_error('user_country'); ?>
                  </div>
                </div>
                <hr>
                <?php if($plans['link_back'] == 1):?>
                <div class="row">
                  <div class="col-sm-4">
                    <label for="user-website" <?php if(form_error('user_website')){ echo 'class="txt-has-error"'; } ?>>Website</label>
                  </div>
                  <div class="col-sm-8">
                    <div class="input-group">
                      <span class="input-group-addon">http://</span>
                      <input id="user-website" class="textbox <?php if(form_error('user_website')){ echo 'input-has-error'; } ?>" type="text" name="user_website" value="<?php echo $info['website']; ?>">
                      <?php echo form_error('user_website'); ?>
                    </div>
                  </div>
                </div>
                <hr>
                <?php endif; ?>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-plan">* Plan:</label>
                  </div>
                  <div class="col-md-8">
                      <input type="text" id="user-plan" class="textbox"
                      value="<?php
                        echo $plans['name'];
                      ?>" disabled>
                    </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-newsletter">Newsletter</label>
                  </div>
                  <div class="col-md-8">
                    <input id="user-newsletter" class="checkbox" type="checkbox" name="user_newsletter"
                      <?php 
                        if($info['newsletter'] == 1){
                          echo 'checked';
                        }
                      ?>
                    >
                  </div>
                </div>
                <hr>
                <?php if($info['plan_id'] != 1){?>
                <div class="row">
                  <div class="col-md-4">
                    <label for="user-monthly-report">Monthly report</label>
                  </div>
                  <div class="col-md-8">
                    <input id="user-monthly-report" class="checkbox" type="checkbox" name="user_monthly_report"
                      <?php 
                        if($info['monthly_report'] == 1){
                          echo 'checked';
                        }
                      ?>
                    >
                  </div>
                </div>
                <hr>
                <?php } ?>
                <div class="user-button">
                  <button type="submit">Save Changes</button>
                </div>
              <?php echo form_close(); ?>
            </div>
          <?php echo form_close(); ?>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="col-md-4">
      <?php 
        $this->load->view('users/templates/sidebar');
      ?>
    </div>    
  </div>
</div>
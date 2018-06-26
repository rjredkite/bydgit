<?php
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
<footer>
	<div class="footer-top-container">
		<div class="top-border"></div>
		<div class="container">
			<div class="footer-content-container">
				<div class="row">
					<div class="col-md-4 col-lg-4">
						<div class="footer-logo-text">
							<img src="<?php echo base_url() ?>assets/img/footer-logo.png" alt="Footer Logo">
							<h4>Breed Your Dog</h4>
						</div>
						<div class="footer-1stcollumn">
							<p>Welcome to breedyourdog.com – a worldwide site.</p>
						</div>
						<div class="hr"></div>
						<div class="footer-socialmedia">
							<a href="https://www.facebook.com/breedyourdog/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
							<a href="https://twitter.com/breedyourdog/" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
							<a href="https://www.instagram.com/breedyourdog/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
							<a href="https://www.pinterest.com/breedyourdog/" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
						</div>
					</div>
					<div class="col-md-4 col-lg-4">
						<div class="footer-2ndcollumn">
							<h4>Quick Links</h4>
							<div class="hr"></div>
								<div class="row">
									<div class="col-sm-6">
										<div class="footer_ql_byd1">
											<div class="menu-quicklinks-first-container">
												<ul id="menu-quicklinks-first" class="menu">
													<li>
														<a rel="alternate"<?php 
											              if($country_lang == 'us'){
											                echo 'href="'.base_url('us').'"';
											              }else{
											                echo 'href="'.base_url().'"';
											              }
											           ?>>Home</a>
													</li>
													<li>
														<a <?php 
											              if($country_lang == 'us'){
											                echo 'href="'.base_url('us/stud-dogs').'"';
											              }else{
											                echo 'href="'.base_url('stud-dogs').'"';
											              }
											           ?>>Stud Dogs</a>
													</li>
													<li>
														<a <?php 
											              if($country_lang == 'us'){
											                echo 'href="'.base_url('us/puppies').'"';
											              }else{
											                echo 'href="'.base_url('puppies').'"';
											              }
											           ?>>Puppies for Sale</a>
													</li>
													<li>
														<a <?php 
											              if($country_lang == 'us'){
											                echo 'href="'.base_url('us/user/plans').'"';
											              }else{
											                echo 'href="'.base_url('user/plans').'"';
											              }
											           ?>>Join</a>
													</li>
													<li>
														<a <?php 
										                  if($country_lang == 'us'){
										                    $url2 = $this->getdata_model->get_pages_url(14);
										                    echo 'href="'.base_url('us/'.$url2['url']).'"';
										                  }else{
										                    echo 'href="'.base_url($this->getdata_model->get_pages_url(14)).'"';
										                  }
										                ?>>About Us</a>
													</li>
													<li>
														<a <?php 
											              if($country_lang == 'us'){
											                echo 'href="'.base_url('us/privacy-policy').'"';
											              }else{
											                echo 'href="'.base_url('privacy-policy').'"';
											              }
											           ?>>Privacy &amp; Cookies</a>
													</li>
												</ul>
											</div>
										</div>
										
									</div>	
									<div class="col-sm-6">
									
										<div class="footer_ql_byd2">
											<div class="menu-quicklinks-second-container">
												<ul id="menu-quicklinks-second" class="menu">
													<li>
														<a <?php 
											              if($country_lang == 'us'){
											                echo 'href="'.base_url('us/contact').'"';
											              }else{
											                echo 'href="'.base_url('contact').'"';
											              }
											           ?>>Contact Us</a>
													</li>
													<li>
														<a <?php 
										                  if($country_lang == 'us'){
										                    $url2 = $this->getdata_model->get_pages_url(15);
										                    echo 'href="'.base_url('us/'.$url2['url']).'"';
										                  }else{
										                    echo 'href="'.base_url($this->getdata_model->get_pages_url(15)).'"';
										                  }
										                ?>>FAQ</a>
													</li>
													<li>
														<a <?php 
										                  if($country_lang == 'us'){
										                    $url2 = $this->getdata_model->get_pages_url(16);
										                    echo 'href="'.base_url('us/'.$url2['url']).'"';
										                  }else{
										                    echo 'href="'.base_url($this->getdata_model->get_pages_url(16)).'"';
										                  }
										                ?>>Terms &amp; Conditions</a>
													</li>
													<li>
														<a <?php 
										                  if($country_lang == 'us'){
										                    $url2 = $this->getdata_model->get_pages_url(17);
										                    echo 'href="'.base_url('us/'.$url2['url']).'"';
										                  }else{
										                    echo 'href="'.base_url($this->getdata_model->get_pages_url(17)).'"';
										                  }
										                ?>>Links</a>
													</li>
													<li>
														<a <?php 
											              if($country_lang == 'us'){
											                echo 'href="'.base_url('us/memorials').'"';
											              }else{
											                echo 'href="'.base_url('memorials').'"';
											              }
											           ?>>Memorials</a>
													</li>
												</ul>
											</div>
										</div>					

									</div>
								</div>
						</div>
					</div>
					<div class="col-md-4 col-lg-4">
						<?php echo form_open('pages/newsletter_email'); ?>
							<div class="footer-3rdcollumn">
								<h4>Newsletter</h4>
								<div class="hr"></div>
								<p>Subscribe to our newsletter to get the Breedyourdog latest listings:</p>
								<?php if($this->session->flashdata('flashdata_success_newsletter')) : ?>
									<?php echo '
										<div class="alert alert-success alert-dismissable fade in">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
										.$this->session->flashdata('flashdata_success_newsletter').
										'</div>'
									; ?>
								<?php endif; ?>
								<?php if($this->session->flashdata('flashdata_failed_newsletter')) : ?>
									<?php echo '
										<div class="alert alert-danger alert-dismissable fade in">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
										.$this->session->flashdata('flashdata_failed_newsletter').
										'</div>'
									; ?>
								<?php endif; ?>
								<div class="input-group">
									<input class="form-control" type="email" name="email" placeholder="Email Address" autocomplete="off" <?php
										if($this->session->flashdata('flashdata_success_newsletter')){
											echo 'autofocus';
										}else{
											echo '';
										}
									?> required>
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit">
											Subscribe
										</button>
									</div>
								</div>
								<br>
								<div class="input-group">
									<div class="g-recaptcha" data-sitekey="6Lc5N0IUAAAAAEPfz65c0oFHyYMAsawjwh5IBfiR"></div>
								</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom-container">
		<div class="container footer-dogs-container">
			<p>All content © BreedYourDog <?php echo date("Y"); ?> I Powered by: <a href="https://www.page1.digital/" target="_blank">Page1</a></p>
			<img src="<?php echo base_url() ?>assets/img/footer-dogs.png" alt="Footer Image">
		</div>
	</div>
</footer>

<div class="modal login-modal fade" id="modal-login"role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="background-color: #496d37;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times</button>
				<h4 class="modal-title text-white"><i class="fa fa-sign-in-alt"></i> Login</h4>
			</div>
			<div class="modal-body">
				<div class="sidebar-contianer">
					<div class="customer-login">
						<div id="display-error"></div>
						<?php echo form_open('pages/userlogin',array('id' => 'userloginmodal')); ?>
							<h5>Login to your account!</h5>
							<input id="email_login" type="email" name="email" placeholder="Email Address" required>
							<input id="password_login" type="password" name="password" placeholder="Password" required>

							<div class="row">
								<div class="col-md-4">
									<button type="submit">Login</button>
								</div>
								<div class="col-md-8">
									<p>
										<a <?php 
											if($country_lang == 'us'){
							                	echo 'href="'.base_url('us/user/lost').'"';
							             	}else{
							                	echo 'href="'.base_url('user/lost').'"';
							              	}
										?>><span class="forgot">Forgot Password?</span></a> <br>
										<a class="text-white" <?php
											if($country_lang == 'us'){
							                	echo 'href="'.base_url('us/user/plans').'"';
							             	}else{
							                	echo 'href="'.base_url('user/plans').'"';
							              	}
										?>>Create Account</a>
									</p>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default close-button" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	    $("#userloginmodal").on('submit', function(e){
	    	e.preventDefault();

	    	var email_account = $("#email_login").val();
		   	var password_account = $("#password_login").val();

	    	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

		    if (!expr.test(email_account)) {
		        $('#display-error').html('<div class="alert alert-danger alert-dismissable fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Please enter valid email.</div>');
		    }
		    else {

		    	if(password_account == ''){
		    		$('#display-error').html('<div class="alert alert-danger alert-dismissable fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Invallid Email or Password</div>');
		    	}else{
		    		$.ajax({
			            url: "<?php echo base_url('pages/userloginmodal'); ?>",
			            type:'POST',
			            dataType: 'JSON',
			            data: {email:email_account, password:password_account},
			            success: function(response) {
			            	if(response.status=='success'){
			            		$('#display-error').html('<div class="alert alert-success alert-dismissable fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Successfully Login ...</div>');
			            		location.href = response.url;
			            	}else if(response.status=='confirm'){
			            		$('#display-error').html('<div class="alert alert-info alert-dismissable fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your account need to confirmed</div>');
			            		location.href = response.url;
			            	}else{
								$('#display-error').html(response.errordisplay);
			            	}
			            	
			            }
			        });
		    	}
		    	
		    }
	    	
	    });
	});
</script>


<?php 
if(!isset($_COOKIE['dbcookie']))
{ ?>
<script type="text/javascript">
function SetCookie(c_name,value,expiredays)
{
var exdate=new Date()
 exdate.setDate(exdate.getDate()+expiredays)
 document.cookie=c_name+ "=" +escape(value)+";path=/"+((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}
</script>
<style>
.bottom-cookies {
    background: rgba(0,0,0, 0.8);
    color: #F8F8F8;
    padding: 15px 0 15px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 999999999;
    line-height: 1.2;
    font-size: 15px;
    text-align: center;
}
</style>
<?php } ?>
<?php 
if(!isset($_COOKIE['dbcookie']))
{ ?>
<div id="dbcookielaw" >
<div class="bottom-cookies">
<p>This website uses cookies. If you agree to our <a style="color:#fff; text-decoration: underline;" <?php 
											              if($country_lang == 'us'){
											                echo 'href="'.base_url('us/privacy-policy').'"';
											              }else{
											                echo 'href="'.base_url('privacy-policy').'"';
											              }
											           ?>>Privacy &amp; Cookies Policy</a>, please <a style="cursor: pointer; text-decoration: underline;" id="removecookie" class="accept-btn">click here</a>.</p>


</div>
</div>
<script type="text/javascript">
	if( document.cookie.indexOf("dbcookie") ===-1 ){
		$("#dbcookielaw").show();
	}	
    $("#removecookie").click(function () {
		SetCookie('dbcookie','dbcookie',365*10)
      $("#dbcookielaw").remove();
    });
	
</script>
<?php } ?>
<script src="<?php echo base_url() ?>assets/js/scripts.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>
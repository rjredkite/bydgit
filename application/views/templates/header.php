<?php
  /*$users = $this->users_model->users_remove();
  $studdogs = $this->users_model->get_stud_dogs();
  $puppies = $this->users_model->get_puppies();*/

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
<!DOCTYPE html>
<html>
<head>
  <title><?= $metatitle ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<meta name="robots" content="<?= $metarobots ?>">-->
  <meta name="keyword" content="<?= $metakeyword ?>">
  <meta name="description" content="<?= $metadescription ?>">
  <meta name="google-site-verification" content="APZb6nWzUP0W_YZgPw_ZyUf1xcqxI9ynhUF2if-cbCI" />
  <meta content="authenticity_token" name="csrf-param" />
  <meta content="84VjkgKe2cGng9dLhrk3IurXjaYTt31gi7VmgZG3fsk=" name="csrf-token" />
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-10891422-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-10891422-1');
  </script>
 
  <link href="<?php echo base_url('assets/img/logo-icon.png') ?>" rel="shortcut icon" type="image/x-icon" />
  <link href="<?php echo base_url() ?>assets/css/style.min.css" rel="stylesheet" type="text/css">
  <script src="<?php echo base_url() ?>assets/js/jquery-3.2.0.min.js"></script>
  
</head>
<body>
<header>
  <div class="header-top-banner">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-lg-4">
          <a <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us').'"';
              }else{
                echo 'href="'.base_url().'"';
              }
           ?>><img src="<?php echo base_url() ?>assets/img/header_banner_logo.png" alt="Header Logo"></a>
        </div>
        <div class="col-md-6 col-lg-6">
          <?php /*<div class="header-top-contents">
            <p><span class="green">Site Stats:</span> <?php echo number_format($users); ?> Members   I   <?php echo number_format($studdogs) ;?> Stud Dogs   I <?php echo number_format($puppies); ?> Puppies</p>
          </div>*/ ?>
		  <div class="header-top-contents"> Choose your Country : &nbsp; <a href="http://www.breedyourdog.com/"><img src="<?php echo base_url() ?>assets/img/uk.jpg" alt="UK Flag"></a> &nbsp; <a href="http://www.breedyourdog.com/us"><img src="<?php echo base_url() ?>assets/img/usa.jpg" alt="USA Flag"></a></div>
		  
        </div>
        <div class="col-md-2 col-lg-2">
          <div class="header-socialmedia">
            <a href="https://www.facebook.com/breedyourdog/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="https://twitter.com/breedyourdog/" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="https://www.instagram.com/breedyourdog/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a href="https://www.pinterest.com/breedyourdog/" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="navbar-container">
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#byd-id-navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="#"></a>
        </div>
        <div class="collapse navbar-collapse" id="byd-id-navbar">
          <ul class="nav navbar-nav">
            <li><a <?php 

              if($this->uri->segment(1) == 'stud-dogs' || $this->uri->segment(2) == 'stud-dogs'){
                echo 'class="navbar-active"';
              }

            ?> <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/stud-dogs').'"';
              }else{
                echo 'href="'.base_url('stud-dogs').'"';
              }
            ?>>STUD DOGS</a></li>
            <li><a <?php 

              if($this->uri->segment(1) == 'puppies' || $this->uri->segment(2) == 'puppies'){
                echo 'class="navbar-active"';
              }

            ?> <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/puppies').'"';
              }else{
                echo 'href="'.base_url('puppies').'"';
              }
            ?>>PUPPIES FOR SALE</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">RESOURCES <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a <?php 

              if($this->uri->segment(1) == 'breeds' || $this->uri->segment(2) == 'breeds'){
                echo 'class="navbar-active"';
              }

            ?> <?php 
              if($country_lang == 'us'){
                echo 'href="'.base_url('us/breeds').'"';
              }else{
                echo 'href="'.base_url('breeds').'"';
              }
            ?>>Breed Profiles</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(2);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(2);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(2)).'"';
                  }
                ?>>Before your Breed</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(3);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(3);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(3)).'"';
                  }
                ?>>Dog Health</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(4);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(4);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(4)).'"';
                  }
                ?>>Choosing a Puppy</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(5);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(5);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(5)).'"';
                  }
                ?>>Caring for your Puppy</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">BREEDING PROCESS <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(6);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(6);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(6)).'"';
                  }
                ?>>Before Conception</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(7);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(7);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(7)).'"';
                  }
                ?>>The Heat Cycle</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(8);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(8);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(8)).'"';
                  }
                ?>>Conception</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(9);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(9);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(9)).'"';
                  }
                ?>>After Conception</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(10);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(10);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(10)).'"';
                  }
                ?>>Whelping</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(11);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(11);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(11)).'"';
                  }
                ?>>Caring for the Litter</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(12);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(12);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(12)).'"';
                  }
                ?>>Post Labour Care four your Bitch</a></li>
                <li><a <?php 
                $urllink = $this->getdata_model->get_pages_url(13);
              if($this->uri->segment(1) == $urllink['url'] || $this->uri->segment(2) == $urllink['url']){
                echo 'class="navbar-active"';

              }

            ?> <?php 
                  if($country_lang == 'us'){
                    $url2 = $this->getdata_model->get_pages_url(13);
                    echo 'href="'.base_url('us/'.$url2['url']).'"';
                  }else{
                    echo 'href="'.base_url($this->getdata_model->get_pages_url(13)).'"';
                  }
                ?>>Interviewing Potential Owners</a></li>
              </ul>
            </li>
            <?php if($this->session->userdata('userlogged_in')) : ?>
              <li><a <?php 

              if($this->uri->segment(1) == 'user' || $this->uri->segment(2) == 'user' && $this->uri->segment(2) == 'dashboard' || $this->uri->segment(3) == 'dashboard'){
                echo 'class="navbar-active"';
              }

            ?> <?php 
                if($country_lang == 'us'){
                  echo 'href="'.base_url('us/user/dashboard').'"';
                }else{
                  echo 'href="'.base_url('user/dashboard').'"';
                }
              ?>>Account</a></li>
            <?php else : ?>
              <li><a <?php 

              if($this->uri->segment(1) == 'user' || $this->uri->segment(2) == 'user' && $this->uri->segment(2) == 'plans' || $this->uri->segment(3) == 'plans'){
                echo 'class="navbar-active"';
              }

            ?> <?php 
                if($country_lang == 'us'){
                  echo 'href="'.base_url('us/user/plans').'"';
                }else{
                  echo 'href="'.base_url('user/plans').'"';
                }
              ?>>Join</a></li>
            <?php endif; ?>
            <li>
              <?php if($this->session->userdata('userlogged_in')) : ?>
                <a href="<?php echo base_url(); ?>pages/userlogout" type="button">Log Out</a>
              <?php else : ?>
                <a type="button" data-toggle="modal" data-target="#modal-login">Login</a>
              <?php endif; ?>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li>
            <?php echo form_open('listings', array('method' => 'get')); ?>
              <input class="form-control" type="text" name="keywords" placeholder="QUICK SEARCH">
            <?php echo form_close(); ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</header>
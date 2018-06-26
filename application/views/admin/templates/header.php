<!DOCTYPE html>
<html>
<head>
	<title><?= $metatitle ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="<?= $metarobots ?>">
	<meta name="keyword" content="<?= $metakeyword ?>">
	<meta name="description" content="<?= $metadescription ?>">
	<meta content="84VjkgKe2cGng9dLhrk3IurXjaYTt31gi7VmgZG3fsk=" name="csrf-token" />
	<link href="<?php echo base_url('assets/img/logo-icon.png') ?>" rel="shortcut icon" type="image/x-icon" />
	<link href="<?php echo base_url() ?>assets/css/style-admin.min.css" rel="stylesheet" type="text/css">
	<script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
	<script src="<?php echo base_url() ?>assets/js/scripts-admin.min.js"></script>
</head>
<body>
<div class="mobile-black"></div>
<?php $this->load->view('admin/templates/sidenav'); ?>
<div class="admin-body-container">
	<div class="admin-header-container">
		<div class="container-fluid">
			<button id="byd-button-collapse" class="button-collapse"><i class="fa fa-bars" aria-hidden="true"></i></button>
			<div class="headerright">
				<ul>
					<li> 
						<i class="fa fa-user-circle" aria-hidden="true"></i> 
						Welcome <a href="<?php echo base_url('admin/admins/'.$this->session->admin_id_byd.'/edit'); ?>" class="admin-name"><?php echo $this->session->adminusername_byd; ?></a>
					</li>
					<li>
						<a class="visit-site" href="<?php echo base_url(); ?>">
							<i class="fa fa-home" aria-hidden="true"></i>
							Visit Site
						</a>
					</li>
					<li>
						<a class='admin-logout' href="<?php echo base_url(); ?>admin/logout">
							<i class="fa fa-sign-out" aria-hidden="true"></i>
							Log out
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
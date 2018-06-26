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
</head>
<body>
	<div class="container">
		<?php echo form_open('admin/login'); ?>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="admin-login-container">
						<h1 class="text-center">Admin Login</h1>
						<?php if($this->session->flashdata('flashdata_failed')) : ?>
							<?php echo '
					    	<div class="alert alert-danger alert-dismissable fade in">
					    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
					    		.$this->session->flashdata('flashdata_failed').
					 		'</div>'; ?>
					  	<?php endif; ?>
					  	<?php if($this->session->flashdata('flashdata_info')) : ?>
							<?php echo '
					    	<div class="alert alert-info alert-dismissable fade in">
					    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
					    		.$this->session->flashdata('flashdata_info').
					 		'</div>'; ?>
					  	<?php endif; ?>
						<div class="form-group">
							<input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control" placeholder="Enter Password" required autofocus>
						</div>
						<button type="submit">Sign in</button>
					</div>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</body>
<script src="<?php echo base_url() ?>assets/js/scripts-admin.min.js"></script>
</html>
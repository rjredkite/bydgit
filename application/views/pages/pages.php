<div class="pages-container">
	<div class="header-container">
		<div class="container">
			<div class="pages-header">
				<h1><?= $title ?></h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-lg-9">
				<div class="pages-body">
					<?= $content ?>
				</div>
			</div>
			<div class="col-md-3 col-lg-3">
				<?php 
			       $this->load->view('templates/sidebar');
			    ?>
			</div>
		</div>
	</div>
</div>
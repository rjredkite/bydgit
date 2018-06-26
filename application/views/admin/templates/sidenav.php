<div class="admin-sidebar-container">
	<div id="adminsidenav" class="sidenav sidenav-open">
	  	<div class="admin-logo">
	  		<img src="<?php echo base_url(); ?>assets/img/admin-header.jpg" alt="Admin Header Logo">
	  		<i class="fa fa-times-circle-o" aria-hidden="true"></i>
	  	</div>
	  	<ul>
	  		<li>
	  			<a href="<?php echo base_url(); ?>admin/dashboard">
	  				<i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
	  			</a>
	  		</li>
	  		<li>
	  			<a href="#users" data-toggle="collapse">
	  				<i class="fa fa-users" aria-hidden="true"></i> Users
	  				<span><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	  			</a>
	  			<ul id="users" class="panel-collapse collapse">
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/users/search">
	  						Search Users
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/users">
	  						All Users
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/subscriptions">
	  						Subscriptions
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/users/new">
	  						New User
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/users/with-many-listings">
	  						Users with many Listings
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/users/bulk_email">
	  						Send Bulk Email
	  					</a>
	  				</li>
	  			</ul>
	  		</li>
	  		<li>
	  			<a href="#listings" data-toggle="collapse">
	  				<i class="fa fa-list-alt" aria-hidden="true"></i> Listings
	  				<span><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	  			</a>
	  			<ul id="listings" class="panel-collapse collapse">
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/listings/search">
	  						Search Listings
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/listings">
	  						All Listings
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/listings/check">
	  						Check Listings
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/listings/dogs">
	  						Dogs
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/listings/puppies">
	  						Puppies
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/listings/memorials">
	  						Memorials
	  					</a>
	  				</li>
	  			</ul>
	  		</li>
	  		<li>
	  			<a href="#connections" data-toggle="collapse">
	  				<i class="fa fa-exchange" aria-hidden="true"></i> Connections
	  				<span><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	  			</a>
	  			<ul id="connections" class="panel-collapse collapse">
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/connections">
	  						All Connnections
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/connections/search">
	  						Search Connections
	  					</a>
	  				</li>
	  			</ul>
	  		</li>
	  		<li>
	  			<a href="#breeds" data-toggle="collapse">
	  				<i class="fa fa-file" aria-hidden="true"></i> Breeds
	  				<span><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	  			</a>
	  			<ul id="breeds" class="panel-collapse collapse">
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/breeds">
	  						All Breeds
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/breeds/new">
	  						New Breeds
	  					</a>
	  				</li>
	  			</ul>
	  		</li>
	  		<li>
	  			<a href="#pages" data-toggle="collapse">
	  				<i class="fa fa-file" aria-hidden="true"></i> Pages
	  				<span><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	  			</a>
	  			<ul id="pages" class="panel-collapse collapse">
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/pages">
	  						All Pages
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/pages/new">
	  						New Pages
	  					</a>
	  				</li>
	  			</ul>
	  		</li>
	  		<li>
	  			<a href="<?php echo base_url(); ?>admin/orders">
	  				<i class="fa fa-shopping-cart" aria-hidden="true"></i> Orders
	  			</a>
	  		</li>
	  		<li>
	  			<a href="#admins" data-toggle="collapse">
	  				<i class="fa fa-user-circle-o" aria-hidden="true"></i> Admins
	  				<span><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	  			</a>
	  			<ul id="admins" class="panel-collapse collapse">
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/admins">
	  						All Admins
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/admins/new">
	  						New Admin
	  					</a>
	  				</li>
	  			</ul>
	  		</li>
	  		<li>
	  			<a href="#images" data-toggle="collapse">
	  				<i class="fa fa-picture-o" aria-hidden="true"></i> Images
	  				<span><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	  			</a>
	  			<ul id="images" class="panel-collapse collapse">
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/images">
	  						All Images
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/images/search">
	  						Search Image
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/images/homepage">
	  						On Home Page
	  					</a>
	  				</li>
	  			</ul>
	  		</li>
	  		<li>
	  			<a href="#adverts" data-toggle="collapse">
	  				<i class="fa fa-share-alt-square" aria-hidden="true"></i> Adverts
	  				<span><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	  			</a>
	  			<ul id="adverts" class="panel-collapse collapse">
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/adverts">
	  						All Adverts
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/adverts/new">
	  						New Advert
	  					</a>
	  				</li>
	  			</ul>
	  		</li>
	  		<li>
	  			<a href="#advertisers" data-toggle="collapse">
	  				<i class="fa fa-user-secret" aria-hidden="true"></i> Advertisers
	  				<span><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	  			</a>
	  			<ul id="advertisers" class="panel-collapse collapse">
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/advertisers">
	  						All Advertisers
	  					</a>
	  				</li>
	  				<li>
	  					<a href="<?php echo base_url(); ?>admin/advertisers/new">
	  						New Advertiser
	  					</a>
	  				</li>
	  			</ul>
	  		</li>
	  	</ul>
  	</div>
</div>
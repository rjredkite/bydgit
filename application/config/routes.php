<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*=====================================================================
[-- ADMIN / IMAGES ---------------------------------------------------]
=====================================================================*/
$route['admin/images'] = 'admin/images_all';
$route['admin/images/search'] = 'admin/images_search';
$route['admin/images/homepage'] = 'admin/images_on_homepage';

/*=====================================================================
[-- ADMIN / BREEDS ---------------------------------------------------]
=====================================================================*/
$route['admin/breeds/new'] = 'admin/new_breed';
$route['admin/breeds'] = 'admin/all_breeds';
$route['admin/breeds/(:any)/edit'] = 'admin/breed_edit/$1';

/*=====================================================================
[-- ADMIN / ORDERS ---------------------------------------------------]
=====================================================================*/
$route['admin/orders'] = 'admin/all_orders';
$route['admin/orders/(:any)'] = 'admin/order_view/$1';

/*=====================================================================
[-- ADMIN / PAGES ----------------------------------------------------]
=====================================================================*/
$route['admin/pages/new'] = 'admin/pages_new';
$route['admin/pages'] = 'admin/pages_all';
$route['admin/pages/(:any)/edit'] = 'admin/page_edit/$1';

/*=====================================================================
[-- ADMIN / CONNECTIONS ----------------------------------------------]
=====================================================================*/
$route['admin/connections'] = 'admin/connections_all';
$route['admin/connections/search'] = 'admin/connections_search';
$route['admin/connections/(:any)'] = 'admin/connection_view/$1';

/*=====================================================================
[-- ADMIN / LISTINGS -------------------------------------------------]
=====================================================================*/
$route['admin/listings/search'] = 'admin/listings_search';
$route['admin/listings/(:any)/edit'] = 'admin/listing_edit/$1';
$route['admin/listings/(:any)/statistics'] = 'admin/listing_statistics/$1';
$route['admin/listings'] = 'admin/listings_all';
$route['admin/listings/dogs'] = 'admin/listings_dogs';
$route['admin/listings/puppies'] = 'admin/listings_puppies';
$route['admin/listings/memorials'] = 'admin/listings_memorials';
$route['admin/listings/check'] = 'admin/listings_check';

/*=====================================================================
[-- ADMIN / USERS ----------------------------------------------------]
=====================================================================*/
$route['admin/users/search'] = 'admin/users_search';
$route['admin/users'] = 'admin/all_users';
$route['admin/subscriptions'] = 'admin/users_subscription';
$route['admin/users/new'] = 'admin/user_new';
$route['admin/users/with-many-listings'] = 'admin/users_with_many_listings';
$route['admin/users/(:any)/log_in_as'] = 'admin/users_login_as_user/$1';
$route['admin/users/(:any)/edit'] = 'admin/user_edit/$1';
$route['admin/users/bulk_email'] = 'admin/user_bulk_email';
$route['admin/users/send_to'] = 'admin/user_send_to';

/*=====================================================================
[-- ADMINS -----------------------------------------------------------]
=====================================================================*/
$route['admin/admins'] = 'admin/admin_all';
$route['admin/admins/new'] = 'admin/admin_new';
$route['admin/logout'] = 'admin/logout';
$route['admin/admins/(:any)/edit'] = 'admin/admin_edit/$1';

$route['admin'] = 'admin/index'; 

/*=====================================================================
[-- CUSTOMER / USERS ( BACKEND ) -------------------------------------]
=====================================================================*/
$route['user/dashboard'] = 'users/user_dashboard';
$route['us/user/dashboard'] = 'users/user_dashboard';
$route['user/edit'] = 'users/user_edit';
$route['us/user/edit'] = 'users/user_edit';
$route['payment/new'] = 'users/new_payment';
$route['us/payment/new'] = 'users/new_payment';
$route['listings/new/dog'] = 'users/listings_new_dog';
$route['us/listings/new/dog'] = 'users/listings_new_dog';
$route['listings/new/litter'] = 'users/listings_new_litter';
$route['us/listings/new/litter'] = 'users/listings_new_litter';
$route['listings/yours'] = 'users/listings_yours';
$route['us/listings/yours'] = 'users/listings_yours';
$route['listings/(:any)/edit'] = 'users/listings_edit/$1';
$route['us/listings/(:any)/edit'] = 'users/listings_edit/$1';
$route['statistics'] = 'users/statistics';
$route['us/statistics'] = 'users/statistics';
$route['statistics/(:any)'] = 'users/statistics_views/$1';
$route['us/statistics/(:any)'] = 'users/statistics_views/$1';

/*=====================================================================
[-- CUSTOMER / USERS -------------------------------------------------]
=====================================================================*/
$route['user/confirm/(:any)'] = 'pages/user_confirm/$1';
$route['us/user/confirm/(:any)'] = 'pages/user_confirm/$1';

/*=====================================================================
[-- CONNECTIONS ------------------------------------------------------]
=====================================================================*/
$route['listings/(:any)/connections/new'] = 'connections/connection/$1';
$route['us/listings/(:any)/connections/new'] = 'connections/connection/$1';
$route['listings/(:any)/connections'] = 'connections/connection_credits/$1';
$route['us/listings/(:any)/connections'] = 'connections/connection_credits/$1';
$route['connections/(:any)'] = 'connections/connection_info/$1';
$route['us/connections/(:any)'] = 'connections/connection_info/$1';
$route['connections'] = 'connections/user_connection';
$route['us/connections'] = 'connections/user_connection';

/*=====================================================================
[-- LISTINGS SINGLE PAGE ---------------------------------------------]
=====================================================================*/
$route['stud-dogs/(:any)/(:any)'] = 'listings/listing_type/$1/$2';
$route['us/stud-dogs/(:any)/(:any)'] = 'listings/listing_type/$1/$2';
$route['puppies/(:any)/(:any)'] = 'listings/listing_type/$1/$2';
$route['us/puppies/(:any)/(:any)'] = 'listings/listing_type/$1/$2';
$route['memorials/(:any)/(:any)'] = 'listings/listing_type/$1/$2';
$route['us/memorials/(:any)/(:any)'] = 'listings/listing_type/$1/$2';

/*=====================================================================
[-- LISTINGS ---------------------------------------------------------]
=====================================================================*/
$route['listings/(:any)'] = 'listings/index/$1';
$route['us/listings/(:any)'] = 'listings/index/$1';

/*=====================================================================
[-- PAYMENTS ---------------------------------------------------------]
=====================================================================*/
$route['payment'] = 'payment/payment';
$route['us/payment'] = 'payment/us_payment';
$route['payment/cancelled'] = 'payment/cancelled';
$route['us/payment/cancelled'] = 'payment/cancelled';

/*=====================================================================
[-- CREADITS ---------------------------------------------------------]
=====================================================================*/
$route['payment/credits'] = 'payment/payment_credits';
$route['us/payment/credits'] = 'payment/payment_credits';

/*=====================================================================
[-- SUBSCRIPTION -----------------------------------------------------]
=====================================================================*/
$route['subscription/cancelled'] = 'subscription/cancelled';
$route['us/subscription/cancelled'] = 'subscription/cancelled';
$route['subscription/ipn'] = 'subscription/ipn_back';
$route['us/subscription'] = 'subscription/show';
$route['subscription/(:any)/log_in_as'] = 'subscription/subscription_login_as_user/$1';
$route['subscription'] = 'subscription/show';




/*=====================================================================
[-- PAGES ------------------------------------------------------------]
=====================================================================*/
$route['breeds/(:any)'] = 'pages/breeds/$1';
$route['us/breeds/(:any)'] = 'pages/breeds/$1';
$route['stud-dogs/(:any)'] = 'pages/stud_dogs_breed/$1';
$route['us/stud-dogs/(:any)'] = 'pages/stud_dogs_breed/$1';
$route['puppies/(:any)'] = 'pages/puppies_breed/$1';
$route['us/puppies/(:any)'] = 'pages/puppies_breed/$1';

/*=====================================================================
[-- STATIC PAGES -----------------------------------------------------]
=====================================================================*/
$route['user/plans'] = 'pages/user_plans';
$route['us/user/plans'] = 'pages/user_plans';
$route['user/change_plan'] = 'pages/user_change_plan';
$route['us/user/change_plan'] = 'pages/user_change_plan';
$route['user/new'] = 'pages/user_new_plans';
$route['us/user/new'] = 'pages/user_new_plans';
$route['user'] = 'pages/user';
$route['us/user'] = 'pages/user';
$route['user/lost'] = 'pages/user_lost';
$route['us/user/lost'] = 'pages/user_lost';
$route['user/reset'] = 'pages/user_reset';
$route['us/user/reset'] = 'pages/user_reset';
$route['contact'] = 'pages/contact';
$route['us/contact'] = 'pages/contact';

$route['us'] = 'pages/home';
$route['default_controller'] = 'pages/home';

$route['(:any)'] = 'pages/page/$1';
$route['us/(:any)'] = 'pages/page/$1';
$route['404_override'] = 'pages/show_404';
$route['translate_uri_dashes'] = FALSE;


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] 	= 'Home';
$route['home'] 					= 'Home';

/* ADMIN ROUTES */
$route['login_dashboard'] 		= 'auth/login';
$route['login'] 				= 'auth/login_dashboard';
$route['logout'] 				= 'auth/logout';
$route['dashboard'] 			= 'admin/dashboard';
$route['dashboard/save'] 		= 'admin/dashboard/save';
$route['dashboard/get_approval_history'] 		= 'admin/dashboard/get_approval_history';
$route['profile'] 				= 'Home/profile';
$route['profile/do_update'] 	= 'Home/profile_update';
$route['survey/detail_mobile/(:any)'] 	= 'Home/detail_mobile/$1';
$route['survey/entry_mobile/(:any)'] 	= 'Home/entry_mobile/$1';
$route['survey/do_create_mobile'] 	= 'Home/do_create_mobile';

/* MASTER DATA ROUTES */
	$route['dashboard/master/common_code'] 					= 'admin/master/CommonCode';
	$route['dashboard/master/common_code/create'] 			= 'admin/master/CommonCode/create';
	$route['dashboard/master/common_code/do_create'] 		= 'admin/master/CommonCode/do_create';
	$route['dashboard/master/common_code/edit/(:any)'] 		= 'admin/master/CommonCode/edit/$1';
	$route['dashboard/master/common_code/do_update'] 		= 'admin/master/CommonCode/do_update';
	$route['dashboard/master/common_code/delete/(:any)']	= 'admin/master/CommonCode/do_delete/$1';

	$route['dashboard/master/user'] 					= 'admin/master/User';
	$route['dashboard/master/user/create'] 				= 'admin/master/User/create';
	$route['dashboard/master/user/do_create'] 			= 'admin/master/User/do_create';
	$route['dashboard/master/user/edit/(:any)'] 		= 'admin/master/User/edit/$1';
	$route['dashboard/master/user/do_update'] 			= 'admin/master/User/do_update';
	$route['dashboard/master/user/detail/(:any)'] 		= 'admin/master/User/detail/$1';
	$route['dashboard/master/user/delete/(:any)']		= 'admin/master/User/delete/$1';
	$route['dashboard/master/user/duplicate'] 			= 'admin/master/User/duplicate';
	$route['dashboard/master/user/do_duplicate'] 		= 'admin/master/User/do_duplicate';
	$route['dashboard/master/user/excel'] 				= 'admin/master/User/excel';
/* MASTER DATA ROUTES */

$route['dashboard/sales/plan-activity'] 					 = 'admin/Sales/index';
$route['dashboard/sales/actual-activity'] 					 = 'admin/Sales/index_actual';
$route['dashboard/sales/plan-activity/create'] 				 = 'admin/Sales/create_plan';
$route['dashboard/sales/plan-activity/save-plan'] 			 = 'admin/Sales/save_plan';
$route['dashboard/sales/plan-activity/edit/(:any)'] 		 = 'admin/Sales/edit_plan/$1';
$route['dashboard/sales/plan-activity/update'] 				 = 'admin/Sales/update_plan';
$route['dashboard/sales/plan-activity/delete/(:any)']        = 'admin/Sales/delete_plan/$1';

$route['404_override'] 					= '';
$route['translate_uri_dashes'] 			= FALSE;

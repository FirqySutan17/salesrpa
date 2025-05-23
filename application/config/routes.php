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
	
	$route['dashboard/master/plazma'] 					= 'admin/master/Plazma';
/* MASTER DATA ROUTES */

/* ENTRY ROUTES */
	$route['dashboard/order'] 						= 'admin/Order/index';
	$route['dashboard/order/report'] 					= 'admin/Order/report';
	$route['dashboard/order/report_excel'] 					= 'admin/Order/report_excel';
	$route['dashboard/order/entry'] 					= 'admin/Order/entry';
	$route['dashboard/order/do_create'] 				= 'admin/Order/do_create';
	$route['dashboard/order/detail/(:any)'] 			= 'admin/Order/detail/$1';
	$route['dashboard/order/edit/(:any)'] 			= 'admin/Order/edit/$1';
	$route['dashboard/order/do_update'] 				= 'admin/Order/do_update';
	$route['dashboard/order/do_cancel'] 				= 'admin/Order/do_cancel';
	$route['dashboard/order/do_delete'] 				= 'admin/Order/do_delete';

	$route['dashboard/order/pdf/(:any)'] 				= 'admin/Order/generate_pdf/$1';
	$route['dashboard/credit-limit'] 						= 'admin/Order/credit_limit';
/* ENTRY ROUTES */

/* CONFIRM ROUTES */
	$route['dashboard/confirm'] 						= 'admin/Confirm/index';
	$route['dashboard/confirm/direct'] 					= 'admin/Confirm/direct';
	$route['dashboard/confirm/direct/save'] 			= 'admin/Confirm/direct/save';
	$route['dashboard/confirm/report'] 					= 'admin/Confirm/report';
	$route['dashboard/confirm/report_approval'] 		= 'admin/Confirm/report_approval';
	$route['dashboard/confirm/report_excel'] 			= 'admin/Confirm/report_excel';
	$route['dashboard/confirm/entry'] 					= 'admin/Confirm/entry';
	$route['dashboard/confirm/do_create'] 				= 'admin/Confirm/do_create';
	$route['dashboard/confirm/detail/(:any)'] 			= 'admin/Confirm/detail/$1';
	$route['dashboard/confirm/edit/(:any)'] 			= 'admin/Confirm/edit/$1';
	$route['dashboard/confirm/do_update'] 				= 'admin/Confirm/do_update';
	$route['dashboard/confirm/do_cancel'] 				= 'admin/Confirm/do_cancel';
	$route['dashboard/confirm/do_delete'] 				= 'admin/Confirm/do_delete';

	$route['dashboard/confirm/pdf/(:any)'] 				= 'admin/Confirm/generate_pdf/$1';
	$route['dashboard/credit-limit'] 						= 'admin/Confirm/credit_limit';
/* CONFIRM ROUTES */

// REPORT ROUTES

// REPORT ROUTES
$route['dashboard/summary-report'] 					= 'admin/Dashboard/summary_report';
/*ADMIN ROUTES */


$route['dashboard/setting-user-customer'] 						= 'admin/SettingUserCustomer';
$route['dashboard/setting-user-customer/edit/(:any)'] = 'admin/SettingUserCustomer/edit/$1';
$route['dashboard/setting-user-customer/do_update'] 	= 'admin/SettingUserCustomer/do_update';
$route['dashboard/setting-user-customer/area/(:any)'] = 'admin/SettingUserCustomer/area/$1';
$route['dashboard/setting-user-customer/do_area'] 	= 'admin/SettingUserCustomer/do_area';

$route['dashboard/setting-approval-price'] 						= 'admin/SettingUserCustomer/index_approval_price';
$route['dashboard/setting-approval'] 									= 'admin/SettingUserCustomer/index_approval';
$route['dashboard/setting-approval/edit/(:any)'] 			= 'admin/SettingUserCustomer/edit_approval/$1';
$route['dashboard/setting-approval/do_update'] 				= 'admin/SettingUserCustomer/do_update_approval';


$route['dashboard/setting-open-price'] 									= 'admin/SettingUserCustomer/index_open_price';
$route['dashboard/setting-open-price/edit/(:any)'] 			= 'admin/SettingUserCustomer/edit_open_price/$1';
$route['dashboard/setting-open-price/do_update'] 				= 'admin/SettingUserCustomer/do_update_open_price';
$route['dashboard/setting-open-price/upload'] 					= 'admin/SettingUserCustomer/do_upload_open_price';

$route['ajax/load/kota'] 						= 'Home/ajax_load_kota';
$route['ajax/load/customer'] 				= 'Home/ajax_load_customer';
$route['ajax/load/customer-limit'] 				= 'Home/ajax_load_customer_limit';
$route['ajax/load/project-detail'] 	= 'Home/ajax_load_project_detail';

$route['404_override'] 					= '';
$route['translate_uri_dashes'] 			= FALSE;

<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

| -------------------------------------------------------------------------

| URI ROUTING

| -------------------------------------------------------------------------

| This file lets you re-map URI requests to specific controller functions.

|

| Typically there is a one-to-one relationship between a URL string

| and its corresponding controller class/method. The segments in a

| URL normally follow this pattern:

|

|	example.com/class/method/id/

|

| In some instances, however, you may want to remap this relationship

| so that a different class/function is called than the one

| corresponding to the URL.

|

| Please see the user guide for complete details:

|

|	https://codeigniter.com/user_guide/general/routing.html

|

| -------------------------------------------------------------------------

| RESERVED ROUTES

| -------------------------------------------------------------------------

|

| There are three reserved routes:

|

|	$route['default_controller'] = 'welcome';

|

| This route indicates which controller class should be loaded if the

| URI contains no data. In the above example, the "welcome" class

| would be loaded.

|

|	$route['404_override'] = 'errors/page_missing';

|

| This route will tell the Router which controller/method to use if those

| provided in the URL cannot be matched to a valid route.

|

|	$route['translate_uri_dashes'] = FALSE;

|

| This is not exactly a route, but allows you to automatically route

| controller and method names that contain dashes. '-' isn't a valid

| class or method name character, so it requires translation.

| When you set this option to TRUE, it will replace ALL dashes in the

| controller and method URI segments.

|

| Examples:	my-controller/index	-> my_controller/index

|		my-controller/my-method	-> my_controller/my_method

*/

// $route['default_controller'] = 'login';

$route['default_controller'] = 'login/home_page';

/* Admin Start */



$route['admin'] = 'admin/login';

$route['admin/logout'] = 'admin/login/logout';



$route['dashboard'] = 'admin/dashboard';

$route['users'] = 'admin/dashboard/users';

$route['users_list'] = 'admin/dashboard/users_list';



$route['dashboard/provider_request_chart_details'] = 'admin/dashboard/provider_request_chart_details';

$route['forgot-password'] = 'login/forgot_password';



$route['subscriptions'] = 'admin/service/subscriptions';

$route['add-subscription'] = 'admin/service/add_subscription';

$route['service/check_subscription_name'] = 'admin/service/check_subscription_name';

$route['service/save_subscription'] = 'admin/service/save_subscription';

$route['edit-subscription/(:num)'] = 'admin/service/edit_subscription/$1';

$route['delete-subscription/(:num)'] = 'admin/service/delete_subscription/$1';

$route['service/update_subscription'] = 'admin/service/update_subscription';





$route['categories'] = 'admin/categories/categories';

$route['add-category'] = 'admin/categories/add_categories';

$route['categories/check_category_name'] = 'admin/categories/check_category_name';

$route['edit-category/(:num)'] = 'admin/categories/edit_categories/$1';

/////////////////////////////////////////////////////////
$route['adminlist'] = 'admin/adminlist/adminlist';

$route['add-adminlist'] = 'admin/adminlist/add_adminlist';

$route['edit-adminlist/(:num)'] = 'admin/adminlist/edit_adminlist/$1';
/////////////////////////////////////////////////////////////////

$route['ratingstype'] = 'admin/ratingstype/ratingstype';

$route['add-ratingstype'] = 'admin/ratingstype/add_ratingstype';

$route['ratingstype/check_ratingstype_name'] = 'admin/ratingstype/check_ratingstype_name';

$route['edit-ratingstype/(:num)'] = 'admin/ratingstype/edit_ratingstype/$1';





$route['subcategories'] = 'admin/categories/subcategories';

$route['add-subcategory'] = 'admin/categories/add_subcategories';

$route['categories/check_subcategory_name'] = 'admin/categories/check_subcategory_name';

$route['edit-subcategory/(:num)'] = 'admin/categories/edit_subcategories/$1';







$route['service-providers'] = 'admin/service/service_providers';

$route['provider_list'] = 'admin/service/provider_list';

$route['admin/provider_list'] = 'admin/service/provider_list';



$route['service-requests'] = 'admin/service/service_requests';

$route['request_list'] = 'admin/service/request_list';

$route['api/subscription_success'] = 'api/api/subscription_success';

$route['api/request_accept'] = 'api/api/request_accept';

$route['api/push_notifications_ios'] = 'api/api/push_notifications_ios';



$route['admin-profile'] = 'admin/profile';



/* Language Modules */

$route['language/pages'] = 'admin/language/pages';

$route['language/(:any)'] = 'admin/language/language';

$route['language_list'] = 'admin/language/language_list';

$route['add-keyword/(:any)'] = 'admin/language/add_keyword';

//
$route['language-add'] = 'admin/language/language_add';
$route['delete-addlang/(:any)'] = 'admin/language/delete_addlang';
$route['web-keywords'] = 'admin/language/keywords';
$route['language_web_list'] = 'admin/language/language_web_list';
$route['add-web-keyword'] = 'admin/language/add_web_keyword';
/* Colour Modules */

$route['dashboard/colour_settings'] = 'admin/dashboard/colour_settings';





/* Settings*/

$route['admin/emailsettings'] = 'admin/settings/emailsettings';



$route['admin/stripe_payment_gateway'] = 'admin/settings/stripe_payment_gateway';

$route['admin/paypal_payment_gateway'] = 'admin/settings/paypal_payment_gateway';
$route['admin/paytab_payment_gateway'] = 'admin/settings/paytab_payment_gateway';

$route['admin/razor_payment_gateway'] = 'admin/settings/razor_payment_gateway';
$route['admin/offlinepayment'] = 'admin/settings/offline_payment';

$route['admin/offlinepayment_details'] = 'admin/settings/offlinepaymentdetails';



/* Admin End  */


/* User Start */



$route['api/login'] = 'api/api/login';

$route['api/forgot_password'] = 'api/api/forgot_password';

$route['api/change_password'] = 'api/api/change_password';



$route['api/subscription'] = 'api/api/subscription';

$route['api/provide'] = 'api/api/provide';

$route['api/provider_list'] = 'api/api/provider_list';

$route['api/my_provider_list'] = 'api/api/my_provider_list';

$route['api/request'] = 'api/api/request';

$route['api/request_list'] = 'api/api/request_list';

$route['api/my_request_list'] = 'api/api/my_request_list';

$route['api/subscription_success'] = 'api/api/subscription_success';

$route['api/request_accept'] = 'api/api/request_accept';

$route['api/profile'] = 'api/api/profile';

$route['api/profile_image_upload'] = 'api/api/profile_image_upload';

$route['api/update_profile'] = 'api/api/update_profile';

$route['api/signup'] = 'api/api/signup';

$route['api/language'] = 'api/api/language';

$route['api/history_list'] = 'api/api/history_list';

$route['api/colour_settings'] = 'api/api/colour_settings';

$route['api/subscription_success'] = 'api/api/subscription_success';

$route['api/request_accept'] = 'api/api/request_accept';

$route['api/request_complete'] = 'api/api/request_complete';

$route['api/push_notifications'] = 'api/api/push_notifications';

$route['api/chat_history'] = 'api/api/chat_history';

$route['api/chat_history_count'] = 'api/api/chat_history_count';

$route['api/chat'] = 'api/api/chat';

$route['api/stripe_details'] = 'api/api/stripe_details';
$route['api/braintree_paypal'] = 'api/api/braintree_paypal';
$route['api/stripe_razor_payment'] = 'api/api/stripe_razor_payment';

$route['api/chat_history_requester'] = 'api/api/chat_history_requester';

$route['api/chat_requester'] = 'api/api/chat_requester';

$route['api/chat_details_requester'] = 'api/api/chat_details_requester';




$route['api/request_remove'] = 'api/api/request_remove';

$route['api/service_remove'] = 'api/api/service_remove';





$route['api/request_details'] = 'api/api/request_details';

$route['api/request_update'] = 'api/api/request_update';

$route['api/provide_details'] = 'api/api/provide_details';

$route['api/provide_update'] = 'api/api/provide_update';



$route['api/search_request_list'] = 'api/api/search_request_list';

$route['api/provider_search_list'] = 'api/api/provider_search_list';

$route['api/subscription_payment'] = 'api/api/subscription_payment';





$route['api/test'] = 'api/api/test';



$route['api/chat_details'] = 'api/api/chat_details';

$route['api/rate_review'] = 'api/api/rate_review';

$route['api/rate_review_list'] = 'api/api/rate_review_list';

$route['api/ratings_type'] = 'api/api/ratings_type';

$route['api/comments'] = 'api/api/comments';

$route['api/comments_list'] = 'api/api/comments_list';

$route['api/replies'] = 'api/api/replies';

$route['api/replies_list'] = 'api/api/replies_list';

$route['api/message_status'] = 'api/api/message_status';

$route['api/complete_provider'] = 'api/api/complete_provider';

$route['api/logout'] = 'api/api/logout';

// multi language

$route['api/language_list'] = 'api/api/language_list';
$route['api/language'] = 'api/api/language';
$route['api/currency_list'] = 'api/api/currency_list';


$route['api/sub_category'] = 'api/api/sub_category';

/* User End  */







/* User Start */

$route['signin'] = 'login';

$route['signup'] = 'login/signup';

$route['check_forgot_username']          = 'login/check_forgot_username';

$route['change_password/(:any)'] = 'login/change_password/$1';

$route['termscondition'] = 'login/termscondition';

$route['privacypolicy'] = 'login/privacypolicy';

$route['about-us'] = 'login/about_us';

$route['faq'] = 'login/faq';

$route['help'] = 'login/help';

$route['cookie-policy'] = 'login/cookiesPolicy';



$route['home/updatemulticurrency'] = 'user/home/updatemulticurrency';

$route['change_new_password/(:any)'] = 'login/change_new_password/$1';

$route['home/search_request_details'] = 'user/home/search_request_details';
/* User End  */

$route['home'] = 'user/home';

$route['search_service'] = 'user/home/search_service';

$route['user-profile']    = 'user/profile';

$route['user-profile/(:any)']    = 'user/profile/index/$1';

$route['edit-profile']    = 'user/profile';

$route['edit-profile/(:any)']    = 'user/profile/index/$1';

$route['login/crop_profile_img/(:any)'] = 'login/crop_profile_img/$1';

$route['login/crop_request_img/(:any)'] = 'login/crop_request_img/$1';

$route['login/crop_service_img/(:any)'] = 'login/crop_service_img/$1';


$route['login/crop_ic_img/(:any)'] = 'login/crop_ic_img/$1';

$route['profile/update_profile']    = 'user/profile/update_profile';

$route['profile/change_password']    = 'user/profile/change_password';



$route['check_password']          = 'user/profile/check_password';



$route['service'] = 'user/service';

$route['service_categories/(:any)'] = 'user/service/service_categories/$1';

$route['create_service'] = 'user/service/create_service';

$route['load_service'] = 'user/service/load_service';

$route['my-services'] = 'user/service/my_services';

$route['load_myservice'] = 'user/service/load_myservice';

$route['load_my_service_categories'] = 'user/service/load_my_service_categories';


$route['service-view/(:any)'] = 'user/service/service_view/$1';

$route['add-service']  = 'user/service/add_service';

$route['history']  = 'user/service/history';

$route['history-view/(:any)'] = 'user/service/history_view/$1';

$route['load_complete_history'] = 'user/service/load_complete_history';

$route['load_pending_history'] = 'user/service/load_pending_history';



$route['edit-service/(:any)'] = 'user/service/edit_service/$1';

$route['update_service'] = 'user/service/update_service';



$route['service_search_list'] = 'user/service/service_search_list';



$route['request'] = 'user/request';

$route['create_request'] = 'user/request/create_request';

$route['load_request'] = 'user/request/load_request';

$route['my-request'] = 'user/request/myrequest';

$route['load_myrequest'] = 'user/request/load_myrequest';

$route['search_request_load'] = 'user/request/search_request_load';

$route['booking-service'] = 'user/request/bookingservice';
$route['load_mybookservice'] = 'user/request/load_mybookservice';

$route['my-booking'] = 'user/request/mybooking';
$route['load_mybooking'] = 'user/request/load_mybooking';

$route['booking-status/(:any)']='user/request/booking_status/$1';
$route['post-reviews']='user/request/post_reviews';



$route['request-view/(:any)'] = 'user/request/request_view/$1';
$route['add-request'] = 'user/request/add_request';
$route['request_accept'] = 'user/request/request_accept';

$route['edit-request/(:any)'] = 'user/request/edit_request/$1';
$route['update_request'] = 'user/request/update_request';
$route['search_request'] = 'user/home/search_request';


$route['chat/(:any)']  = 'user/chat/index/$1';
$route['chat-history'] = 'user/chat/chat_history';
$route['load-previous-chat'] = 'user/chat/load_previous_chat';
$route['chat-conversation'] = 'user/chat/chat_conversation';
$route['conversationcall'] = 'user/chat/conversationcall';
$route['load_chat_history'] = 'user/chat/load_chat_history';
$route['unread-count'] = 'user/chat/unread_count';
$route['get-chats/(:any)'] = 'user/chat/get_chats';


$route['readchat']= 'user/chat/readchat';


$route['requester-chat/(:any)']  = 'user/requester_chat/index/$1';

$route['get-requester-chats/(:any)'] = 'user/requester_chat/get_requester_chat_history';

$route['requester-chat-history'] = 'user/requester_chat/chat_history';

$route['requester-load-previous-chat'] = 'user/requester_chat/load_previous_chat';

$route['requester-chat-conversation'] = 'user/requester_chat/chat_conversation';

$route['requester-conversationcall'] = 'user/requester_chat/conversationcall';

$route['requester_load_chat_history'] = 'user/requester_chat/load_chat_history';

$route['requester-unread-count'] = 'user/requester_chat/requester_unread_count';

$route['requester-readchat']= 'user/requester_chat/requester_readchat';





/* User Subscription */

$route['subscription-list'] = 'user/subscription/subscription_list';

$route['offline_payment'] = 'user/subscription/offlinepayment/$sub_id';



$route['payment-gateway'] = 'user/subscription/paymeny_gateway';

$route['user/logout'] = 'login/logout';







$route['admin/frontend-settings'] = 'admin/footer_menu/frontendSettings';
$route['admin/footer-settings'] = 'admin/settings/footerSetting';
$route['admin/other-settings'] = 'admin/dashboard/otherSettings';
$route['admin/seo-settings'] = 'admin/settings/seoSetting';
$route['admin/system-settings'] = 'admin/settings/systemSetting';
$route['admin/localization'] = 'admin/settings/localization';
$route['admin/page'] = 'admin/settings/pages';
$route['settings/about-us/(:num)'] = 'admin/settings/aboutus/$1';
$route['settings/cookie-policy/(:num)'] = 'admin/settings/cookie_policy/$1';
$route['settings/faq/(:num)'] = 'admin/settings/faq/$1';
$route['settings/home-page/(:num)'] = 'admin/settings/home_page';
$route['settings/help/(:num)'] = 'admin/settings/help/$1';
$route['settings/privacy-policy/(:num)'] = 'admin/settings/privacy_policy/$1';
$route['settings/terms-service/(:num)'] = 'admin/settings/terms_of_services/$1';
$route['admin/general-settings'] = 'admin/settings/generalSetting';






$route['404_override'] = '';

$route['translate_uri_dashes'] = FALSE;
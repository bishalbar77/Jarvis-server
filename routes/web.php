<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


Route::get('/create-permissions', function () {
    Permission::create(['name' => 'dashboard']);
    Permission::create(['name' => 'users.index']);
    Permission::create(['name' => 'employers.index']);
    Permission::create(['name' => 'employees.index']);
    Permission::create(['name' => 'orders.index']);
    Permission::create(['name' => 'documents.index']);
    Permission::create(['name' => 'employeetype.index']);
    Permission::create(['name' => 'verificationtype.index']);
    Permission::create(['name' => 'severity.index']);
    Permission::create(['name' => 'severitymessage.index']);
    Permission::create(['name' => 'billing.clients']);
    Permission::create(['name' => 'activity.index']);
    Permission::create(['name' => 'apis.index']);
    Permission::create(['name' => 'roles.index']);
    Permission::create(['name' => 'billing.plans.index']);
    Permission::create(['name' => 'schools.index']);
    Permission::create(['name' => 'surveyquestions.index']);
    Permission::create(['name' => 'surveys.index']);
    Permission::create(['name' => 'searches.index']);
    Permission::create(['name' => 'searches.cosmos']);
    Permission::create(['name' => 'searches.vp']);
    Permission::create(['name' => 'searches.fir']);
    Permission::create(['name' => 'searches.webmedia']);

    echo "<pre>"; print_r('permissions created successfully!'); exit();

});

Route::get('/set-user-permission', function (Request $request) {
	// $user = App\User::where('email', 'jalaj@gettruehelp.com')->first();
	// $user = App\User::find(414);
	// $user = App\User::where('email', 'chandan@gettruehelp.com')->first();
	// $user = App\User::where('email', 'viren@gettruehelp.com')->first();

	// if(!$user){
	// 	echo "<pre>"; print_r('User not found!'); exit();
	// }

	// $user->givePermissionTo('dashboard');
	// $user->givePermissionTo('users.index');
	// $user->givePermissionTo('employers.index');
	// $user->givePermissionTo('employees.index');
	// $user->givePermissionTo('orders.index');
	// $user->givePermissionTo('documents.index');
	// $user->givePermissionTo('employeetype.index');
	// $user->givePermissionTo('verificationtype.index');
	// $user->givePermissionTo('severity.index');
	// $user->givePermissionTo('severitymessage.index');
	// $user->givePermissionTo('billing.clients');
	// $user->givePermissionTo('activity.index');
	// $user->givePermissionTo('apis.index');
	// $user->givePermissionTo('roles.index');
	// $user->givePermissionTo('billing.plans.index');
	// $user->givePermissionTo('billing.plans.index');
	// $user->givePermissionTo('schools.index');
	// $user->givePermissionTo('surveyquestions.index');
	// $user->givePermissionTo('surveys.index');
	// $user->givePermissionTo('searches.index');
	// $user->givePermissionTo('searches.cosmos');
	// $user->givePermissionTo('searches.vp');
	// $user->givePermissionTo('searches.fir');
	// $user->givePermissionTo('searches.webmedia');
    
    echo "<pre>"; print_r('permissions set successfully!'); exit();

});



Auth::routes();

Route::middleware(['auth'])->group(function () {

	Route::get('store_cosmos_data', 'EmployeeController@store_cosmos_data');

	// Route url
	Route::get('/', 'DashboardController@dashboardAnalytics');

	Route::group(['middleware' => ['can:users.index']], function () {
		
		// Users
		Route::get('/users', 'UsersController@index');
		Route::get('/users/create', 'UsersController@create');
		Route::post('/users/store', 'UsersController@store');
		Route::get('/users/edit/{id}', 'UsersController@edit');
		Route::post('/users/update/{id}', 'UsersController@update');
		Route::get('/users/delete/{id}', 'UsersController@destroy');
		Route::get('/users/status/{id}/status/{status}', 'UsersController@status');
		Route::get('/users/update-password', 'UsersController@update_password');
		Route::get('/users/update-profile', 'UsersController@update_profile');
		Route::get('/users/update-info', 'UsersController@update_info');
		Route::get('/users/web-profiles', 'UsersController@web_profiles');
		
		Route::get('/b2b', 'UsersController@b2b');
		Route::get('/b2b/create', 'UsersController@b2b_create');
		Route::post('/b2b/store', 'UsersController@b2b_store');
		Route::get('/b2b/edit/{id}', 'UsersController@b2b_edit');
		Route::post('/b2b/update/{id}', 'UsersController@b2b_update');
		Route::get('/b2b/delete/{id}', 'UsersController@b2b_destroy');
	});

	Route::group(['middleware' => ['can:roles.index']], function () {
		// Roles
		Route::get('/roles', 'RoleController@index');
		Route::get('/roles/create', 'RoleController@create');
		Route::post('/roles/store', 'RoleController@store');
		Route::get('/roles/edit/{id}', 'RoleController@edit');
		Route::post('/roles/update/{id}', 'RoleController@update');
		Route::get('/roles/delete/{id}', 'RoleController@destroy');
		Route::get('/roles/status/{id}/status/{status}', 'RoleController@status');
		Route::get('/roles/permissions/{id}', 'RoleController@role_permissions');
	});

	Route::group(['middleware' => ['can:employers.index']], function () {

		// Employers
		Route::get('/employers', 'EmployerController@index');
		Route::get('/employers/create', 'EmployerController@create');
		Route::post('/employers/store', 'EmployerController@store');
		Route::get('/employers/edit/{id}', 'EmployerController@edit');
		Route::post('/employers/update/{id}', 'EmployerController@update');
		Route::get('/employers/delete/{id}', 'EmployerController@destroy');
		Route::get('/employers/status/{id}/status/{status}', 'EmployerController@status');
	});

	Route::group(['middleware' => ['can:schools.index']], function () {

		// Schools
		Route::get('/employers/schools', 'SchoolController@index');
		Route::get('/employers/schools/create', 'SchoolController@create');
		Route::post('/employers/schools/store', 'SchoolController@store');
		Route::get('/employers/schools/edit/{id}', 'SchoolController@edit');
		Route::post('/employers/schools/update/{id}', 'SchoolController@update');
		Route::get('/employers/schools/delete/{id}', 'SchoolController@destroy');
		Route::get('/employers/schools/status/{id}/status/{status}', 'SchoolController@status');
	});

	//Billing
	Route::group(['middleware' => ['can:billing.clients']], function () {
		Route::get('/billing/clients', 'ClientBillingController@index');
	});

	Route::group(['middleware' => ['can:billing.plans.index']], function () {
	
		// Billing Plan
		Route::get('/billing-plans', 'BillingPlanController@index');
		Route::get('/billing-plans/create', 'BillingPlanController@create');
		Route::post('/billing-plans/store', 'BillingPlanController@store');
		Route::get('/billing-plans/edit/{id}', 'BillingPlanController@edit');
		Route::post('/billing-plans/update/{id}', 'BillingPlanController@update');
		Route::get('/billing-plans/delete/{id}', 'BillingPlanController@destroy');
		Route::get('/billing-plans/status/{id}/status/{status}', 'BillingPlanController@status');
	});

	Route::group(['middleware' => ['can:employees.index']], function () {
	
		// Employees
		Route::get('/employees', 'EmployeeController@index');
		Route::get('/employees/create', 'EmployeeController@create');
		Route::post('/employees/store', 'EmployeeController@store');
		Route::get('/employees/edit/{id}', 'EmployeeController@edit');
		Route::post('/employees/update/{id}', 'EmployeeController@update');
		Route::get('/employees/delete/{id}', 'EmployeeController@destroy');
		Route::get('/employees/status/{id}/status/{status}', 'EmployeeController@status');
		Route::post('/employees/get-work-locations', 'EmployeeController@get_work_locations');
		Route::post('/employees/get-tags', 'EmployeeController@get_tags');
		Route::get('/employees/delete-emp/{id}', 'EmployeeController@delete_employee');
		
		Route::get('/employees/upload', 'EmployeeController@upload');
		Route::post('/employees/upload/{employer_id}/{source}', 'EmployeeController@uploadData');
		Route::post('/employees/bulk-upload', 'EmployeeController@upload_bulk');
	});

	Route::group(['middleware' => ['can:documents.index']], function () {

		// Documents Type
		Route::get('/documents', 'DocumentTypeController@index');
		Route::get('/documents/create', 'DocumentTypeController@create');
		Route::post('/documents/store', 'DocumentTypeController@store');
		Route::get('/documents/edit/{id}', 'DocumentTypeController@edit');
		Route::post('/documents/update/{id}', 'DocumentTypeController@update');
		Route::get('/documents/delete/{id}', 'DocumentTypeController@destroy');
		Route::get('/documents/status/{id}/status/{status}', 'DocumentTypeController@status');
	});

	Route::group(['middleware' => ['can:employeetype.index']], function () {

		// Employee Type
		Route::get('/employeetype', 'EmployeeTypeController@index');
		Route::get('/employeetype/create', 'EmployeeTypeController@create');
		Route::post('/employeetype/store', 'EmployeeTypeController@store');
		Route::get('/employeetype/edit/{id}', 'EmployeeTypeController@edit');
		Route::post('/employeetype/update/{id}', 'EmployeeTypeController@update');
		Route::get('/employeetype/delete/{id}', 'EmployeeTypeController@destroy');
		Route::get('/employeetype/status/{id}/status/{status}', 'EmployeeTypeController@status');
	});

	Route::group(['middleware' => ['can:verificationtype.index']], function () {
	
		// Verification Type
		Route::get('/verificationtype', 'VerificationTypeController@index');
		Route::get('/verificationtype/create', 'VerificationTypeController@create');
		Route::post('/verificationtype/store', 'VerificationTypeController@store');
		Route::get('/verificationtype/edit/{id}', 'VerificationTypeController@edit');
		Route::post('/verificationtype/update/{id}', 'VerificationTypeController@update');
		Route::get('/verificationtype/delete/{id}', 'VerificationTypeController@destroy');
		Route::get('/verificationtype/status/{id}/status/{status}', 'VerificationTypeController@status');
	});

	Route::group(['middleware' => ['can:severity.index']], function () {
	
		// Severity
		Route::get('/severity', 'SeverityController@index');
		Route::get('/severity/create', 'SeverityController@create');
		Route::post('/severity/store', 'SeverityController@store');
		Route::get('/severity/edit/{id}', 'SeverityController@edit');
		Route::post('/severity/update/{id}', 'SeverityController@update');
		Route::get('/severity/delete/{id}', 'SeverityController@destroy');

		// Severity Messeges
		Route::get('/severity/messages', 'SeverityController@messages_index');
		Route::get('/severity/messages/create', 'SeverityController@messages_create');
		Route::post('/severity/messages/store', 'SeverityController@messages_store');
		Route::get('/severity/messages/edit/{id}', 'SeverityController@messages_edit');
		Route::post('/severity/messages/update/{id}', 'SeverityController@messages_update');
		Route::get('/severity/messages/delete/{id}', 'SeverityController@messages_destroy');
	});

	Route::group(['middleware' => ['can:surveys.index']], function () {
	
		// Surveys
		Route::get('/surveys', 'SurveyController@index');
		Route::get('/surveys/create', 'SurveyController@create');
		Route::post('/surveys/store', 'SurveyController@store');
		Route::post('/surveys/resend', 'SurveyController@resend');
		Route::get('/surveys/show/{id}', 'SurveyController@show');
	});

	Route::group(['middleware' => ['can:surveyquestions.index']], function () {
	
		// Severity
		Route::get('/surveyquestions', 'SurveyQuestionController@index');
		Route::get('/surveyquestions/create', 'SurveyQuestionController@create');
		Route::post('/surveyquestions/store', 'SurveyQuestionController@store');
		Route::get('/surveyquestions/edit/{id}', 'SurveyQuestionController@edit');
		Route::post('/surveyquestions/update/{id}', 'SurveyQuestionController@update');
		Route::get('/surveyquestions/delete/{id}', 'SurveyQuestionController@destroy');
	});

	Route::group(['middleware' => ['can:searches.index']], function () {
		
		// Search
		Route::get('/searches/cosmos', 'SearchController@cosmos');
		Route::get('/searches/vp', 'SearchController@vp');
		Route::get('/searches/fir', 'SearchController@crc');
		Route::get('/searches/webmedia', 'SearchController@crc');
		Route::get('/searches/get-info', 'SearchController@get_candidate_info');
		Route::get('/searches/get-sections/{id}', 'SearchController@get_section_by_act');
		Route::post('/searches/all-modules', 'SearchController@all_modules');
	});

	Route::group(['middleware' => ['can:apis.index']], function () {
	
		// Apis
		Route::get('/apis', 'APIController@index');
	});

	Route::group(['middleware' => ['can:orders.index']], function () {

		// Orders
		Route::get('/orders', 'OrderController@index');
		Route::get('/orders/tasks', 'OrderController@tasks');
		Route::get('/orders/create', 'OrderController@create');
		Route::post('/orders/store', 'OrderController@store');
		Route::get('/orders/view/{id}', 'OrderController@show');
		Route::get('/orders/edit/{id}', 'OrderController@edit');
		Route::post('/orders/update/{id}', 'OrderController@update');
		Route::get('/orders/delete/{id}', 'OrderController@destroy');
		Route::get('/orders/status/{id}/status/{status}', 'OrderController@status');
		Route::post('/orders/getemployee', 'OrderController@get_employee');
		Route::post('/orders/getallemployee', 'OrderController@get_all_employee');
		Route::get('/orders/task/{id}/{task_id}', 'OrderController@task_details');
		Route::get('/orders/task/{id}/{task_id}', 'OrderController@task_details');
		Route::post('/orders/antecedents-store/{order_id}/{task_id}', 'OrderController@antecedents_store');
		Route::post('/orders/add-comments/{order_id}/{task_id}', 'OrderController@add_task_comment');
		Route::post('/orders/raise-insuff/{order_id}/{task_id}', 'OrderController@raise_insuff');
		Route::post('/orders/escalate/{order_id}/{task_id}', 'OrderController@escalate');
		Route::post('/orders/fileupload/{order_id}/{task_id}', 'OrderController@fileupload');
		Route::post('/orders/sendmessage', 'OrderController@send_message');
		Route::get('/orders/generate/{task_id}', 'OrderController@generate_report');
		Route::post('/orders/view-report/{task_id}', 'OrderController@pdf_view_report');
		Route::get('/orders/report/{task_id}', 'OrderController@view_report');
		Route::get('/orders/delete-doc/{id}/{order_id}/{task_id}', 'OrderController@delete_document');
		Route::get('/orders/generate-postal-otp/{id}', 'OrderController@generate_postal_otp');
		Route::post('/orders/generate-digital-messege/{id}', 'OrderController@generate_digital_messege');
		Route::post('/orders/get-severty', 'OrderController@get_severty');
		Route::get('/orders/vp/{task_id}', 'OrderController@vp');
		
		Route::post('/orders/get-address', 'OrderController@get_address');
		Route::post('/orders/add-address', 'OrderController@add_address');
		Route::post('/orders/add-employment-fields', 'OrderController@create_form');
		Route::post('/orders/add-pan-fields', 'OrderController@create_form_pan');
		Route::post('/orders/add-education-fields', 'OrderController@create_education_form');
		Route::post('/orders/check-aadhar', 'OrderController@check_aadhar');
		Route::post('/orders/crc-ancedents-update/{id}', 'OrderController@update_ancedents_field');
	});

	// Log
	Route::get('/logs', 'LogController@index');

	//Push Notifications
	Route::get('/push-notification', 'PushNotificationController@index');

	// Users Pages
	Route::get('/app-user-list', 'UserPagesController@user_list');
	Route::get('/app-user-view', 'UserPagesController@user_view');
	Route::get('/app-user-edit', 'UserPagesController@user_edit');

	// Route Dashboards
	Route::get('/dashboard-analytics', 'DashboardController@dashboardAnalytics');
	Route::get('/dashboard-ecommerce', 'DashboardController@dashboardEcommerce');
	Route::get('/dashboard-test', 'DashboardController@test_fun');

	// Route Apps
	Route::get('/app-email', 'EmailAppController@emailApp');
	Route::get('/app-chat', 'ChatAppController@chatApp');
	Route::get('/app-todo', 'ToDoAppController@todoApp');
	Route::get('/app-calender', 'CalenderAppController@calenderApp');
	Route::get('/app-ecommerce-shop', 'EcommerceAppController@ecommerce_shop');
	Route::get('/app-ecommerce-details', 'EcommerceAppController@ecommerce_details');
	Route::get('/app-ecommerce-wishlist', 'EcommerceAppController@ecommerce_wishlist');
	Route::get('/app-ecommerce-checkout', 'EcommerceAppController@ecommerce_checkout');

	// Route Data List
	Route::resource('/data-list-view','DataListController');
	Route::resource('/data-thumb-view', 'DataThumbController');


	// Route Content
	Route::get('/content-grid', 'ContentController@grid');
	Route::get('/content-typography', 'ContentController@typography');
	Route::get('/content-text-utilities', 'ContentController@text_utilities');
	Route::get('/content-syntax-highlighter', 'ContentController@syntax_highlighter');
	Route::get('/content-helper-classes', 'ContentController@helper_classes');

	// Route Color
	Route::get('/colors', 'ContentController@colors');

	// Route Icons
	Route::get('/icons-feather', 'IconsController@icons_feather');
	Route::get('/icons-font-awesome', 'IconsController@icons_font_awesome');

	// Route Cards
	Route::get('/card-basic', 'CardsController@card_basic');
	Route::get('/card-advance', 'CardsController@card_advance');
	Route::get('/card-statistics', 'CardsController@card_statistics');
	Route::get('/card-analytics', 'CardsController@card_analytics');
	Route::get('/card-actions', 'CardsController@card_actions');

	// Route Components
	Route::get('/component-alert', 'ComponentsController@alert');
	Route::get('/component-buttons', 'ComponentsController@buttons');
	Route::get('/component-breadcrumbs', 'ComponentsController@breadcrumbs');
	Route::get('/component-carousel', 'ComponentsController@carousel');
	Route::get('/component-collapse', 'ComponentsController@collapse');
	Route::get('/component-dropdowns', 'ComponentsController@dropdowns');
	Route::get('/component-list-group', 'ComponentsController@list_group');
	Route::get('/component-modals', 'ComponentsController@modals');
	Route::get('/component-pagination', 'ComponentsController@pagination');
	Route::get('/component-navs', 'ComponentsController@navs');
	Route::get('/component-navbar', 'ComponentsController@navbar');
	Route::get('/component-tabs', 'ComponentsController@tabs');
	Route::get('/component-pills', 'ComponentsController@pills');
	Route::get('/component-tooltips', 'ComponentsController@tooltips');
	Route::get('/component-popovers', 'ComponentsController@popovers');
	Route::get('/component-badges', 'ComponentsController@badges');
	Route::get('/component-pill-badges', 'ComponentsController@pill_badges');
	Route::get('/component-progress', 'ComponentsController@progress');
	Route::get('/component-media-objects', 'ComponentsController@media_objects');
	Route::get('/component-spinner', 'ComponentsController@spinner');
	Route::get('/component-toast', 'ComponentsController@toast');

	// Route Extra Components
	Route::get('/ex-component-avatar', 'ExtraComponentsController@avatar');
	Route::get('/ex-component-chips', 'ExtraComponentsController@chips');
	Route::get('/ex-component-divider', 'ExtraComponentsController@divider');

	// Route Forms
	Route::get('/form-select', 'FormsController@select');
	Route::get('/form-switch', 'FormsController@switch');
	Route::get('/form-checkbox', 'FormsController@checkbox');
	Route::get('/form-radio', 'FormsController@radio');
	Route::get('/form-input', 'FormsController@input');
	Route::get('/form-input-groups', 'FormsController@input_groups');
	Route::get('/form-number-input', 'FormsController@number_input');
	Route::get('/form-textarea', 'FormsController@textarea');
	Route::get('/form-date-time-picker', 'FormsController@date_time_picker');
	Route::get('/form-layout', 'FormsController@layouts');
	Route::get('/form-wizard', 'FormsController@wizard');
	Route::get('/form-validation', 'FormsController@validation');

	// Route Tables
	Route::get('/table', 'TableController@table');
	Route::get('/table-datatable', 'TableController@datatable');
	Route::get('/table-ag-grid', 'TableController@ag_grid');

	// Route Pages
	Route::get('/page-user-profile', 'PagesController@user_profile');
	Route::get('/page-faq', 'PagesController@faq');
	Route::get('/page-knowledge-base', 'PagesController@knowledge_base');
	Route::get('/page-kb-category', 'PagesController@kb_category');
	Route::get('/page-kb-question', 'PagesController@kb_question');
	Route::get('/page-search', 'PagesController@search');
	Route::get('/page-invoice', 'PagesController@invoice');
	Route::get('/page-account-settings', 'PagesController@account_settings');

	// Route Authentication Pages
	Route::get('/auth-login', 'AuthenticationController@login');
	Route::get('/auth-register', 'AuthenticationController@register');
	Route::get('/auth-forgot-password', 'AuthenticationController@forgot_password');
	Route::get('/auth-reset-password', 'AuthenticationController@reset_password');
	Route::get('/auth-lock-screen', 'AuthenticationController@lock_screen');

	// Route Miscellaneous Pages
	Route::get('/page-coming-soon', 'MiscellaneousController@coming_soon');
	Route::get('/error-404', 'MiscellaneousController@error_404');
	Route::get('/error-500', 'MiscellaneousController@error_500');
	Route::get('/page-not-authorized', 'MiscellaneousController@not_authorized');
	Route::get('/page-maintenance', 'MiscellaneousController@maintenance');

	// Route Charts & Google Maps
	Route::get('/chart-apex', 'ChartsController@apex');
	Route::get('/chart-chartjs', 'ChartsController@chartjs');
	Route::get('/chart-echarts', 'ChartsController@echarts');
	Route::get('/maps-google', 'ChartsController@maps_google');

	// Route Extension Components
	Route::get('/ext-component-sweet-alerts', 'ExtensionController@sweet_alert');
	Route::get('/ext-component-toastr', 'ExtensionController@toastr');
	Route::get('/ext-component-noui-slider', 'ExtensionController@noui_slider');
	Route::get('/ext-component-file-uploader', 'ExtensionController@file_uploader');
	Route::get('/ext-component-quill-editor', 'ExtensionController@quill_editor');
	Route::get('/ext-component-drag-drop', 'ExtensionController@drag_drop');
	Route::get('/ext-component-tour', 'ExtensionController@tour');
	Route::get('/ext-component-clipboard', 'ExtensionController@clipboard');
	Route::get('/ext-component-plyr', 'ExtensionController@plyr');
	Route::get('/ext-component-context-menu', 'ExtensionController@context_menu');
	Route::get('/ext-component-swiper', 'ExtensionController@swiper');
	Route::get('/ext-component-i18n', 'ExtensionController@i18n');

	// Account system
	Route::get('/profile', 'UsersController@account_settings');

	//log activity
    Route::get('/activity/logs', 'ActivityController@index');
    Route::get('/allactivity/logs', 'ActivityController@allactivity');
	Route::get('/activity/logActivity/{logs}', 'ActivityController@show')->name('logActivity.logs');
    Route::get('/allactivity/logs/{logs}', 'ActivityController@details')->name('logs.show');
    Route::get('/activity/users/changestatus/{user}', 'LogActivityController@changestatus')->name('users.changestatus');
    Route::post('/activity/session', 'LogActivityController@session')->name('session.store');
});

Route::post('/login/validate', 'Auth\LoginController@validate_api');
Route::post('/login/process', 'Auth\LoginController@process');
Route::post('/upload-file', 'EmployeeController@upload_profile');
Route::post('/employees/upload-docs/{user_id}', 'EmployeeController@upload_emp_docs');
Route::post('/upload-document', 'OrderController@upload_document');

//my custom routes
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('view:clear');
});
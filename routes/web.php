<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\WorkerControllers;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\VerifyAppointmentController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\AppointmentHistoryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\appointment_PDF;
use App\Http\Controllers\AppointmentExcelController;
use App\Http\Controllers\MailerController;













use App\Http\Controllers\Controller;

use App\Models\user;
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

//page navigigation
// Route::get('/', function () {
//     return view ('/scanner');
// })->middleware('auth');

Route::get('/successfull', [Controller::class, 'index']);

Route::get('/register', function () {
  if (Auth::check()) {
      return redirect()->route('afterlogin');
  }else{
    return view('auth/register');
    } 
})->name('register');

Route::get('/welcome', function () {
  return view('welcome');
})->name('welcom');

Route::get('/login', function () {
  if (Auth::check()) {
    return redirect()->route('afterlogin');
  }else{
    
    return view('auth/login');
}
})->name('login');

// Route::get('/dashboard', 'App\Http\Controllers\VerifyAppointmentController@index')
// ->name('/dashboard');

Route::get('/dashboard','App\Http\Controllers\LoginController@login')->name('dashboard')->middleware('auth');

//after login 
Route::get('/afterlogin','App\Http\Controllers\LoginController@afterlogin')->name('afterlogin')->middleware('auth');


//ADMIN
Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function() {

  //announcement
    Route::get('/announcement', 'App\Http\Controllers\AnnouncementController@announcement')->name('announcement');
    Route::post('/post_announcement', 'App\Http\Controllers\AnnouncementController@post_announcement')->name('post_announcement');
    Route::get('/get_announcement/{id}', 'App\Http\Controllers\AnnouncementController@get_announcement')->name('get_announcement');
    Route::post('/update_announcement', 'App\Http\Controllers\AnnouncementController@update_announcement')->name('update_announcement');
    Route::post('/delete_announcement', 'App\Http\Controllers\AnnouncementController@delete_announcement')->name('delete_announcement');
    
    
    //accounts
    Route::get('/accounts', 'App\Http\Controllers\AccountController@index')->name('accounts');
    Route::post('/add_admin_account', [AccountController::class,'newaccount_admin'])->name('add_admin_account');
    
    
    
    Route::match(['get','post'],'/canceled_appointment','App\Http\Controllers\AppointmentsController@canceled_appointment')->name('canceled_appointment');

    Route::get('/edit_services/{id}',[ServicesController::class, 'edit_services']);

    Route::match(['get','post'],'/update_services',[ServicesController::class,'update_services'])->name('update_services');

    Route::match(['get','post'],'/delete_services','App\Http\Controllers\ServicesController@delete_services');
    
    //services controller  -- vaccine
    Route::get('edit_vaccine/{id}','App\Http\Controllers\ServicesController@edit_vaccine')->name('edit_vaccine');
    Route::match(['get','post'],'/update_vaccine','App\Http\Controllers\ServicesController@update_vaccine')->name('update_vaccine');

    Route::match(['get','post'],'/delete_vaccine','App\Http\Controllers\ServicesController@delete_vaccine')->name('delete_vaccine');

    Route::post('/add_services','App\Http\Controllers\ServicesController@add_services')->name('add_services');


    Route::post('/add_vaccine',  'App\Http\Controllers\ServicesController@add_vaccine')->name('add_vaccine');


    Route::match(['get','post'],'/update_category','App\Http\Controllers\ServicesController@update_category')->name('update_category');

    Route::match(['get','post'],'/edit_category/{id}','App\Http\Controllers\ServicesController@edit_category')->name('edit_category');

    Route::match(['get','post'],'/delete_category','App\Http\Controllers\ServicesController@delete_category')->name('delete_category');

    Route::match(['get','post'],'/select_service/{id}','App\Http\Controllers\ServicesController@select_service')->name('select_service');

    Route::match(['get','post'],'/edit_other_services','App\Http\Controllers\ServicesController@index');
    Route::match(['get','post'],'/edit_other_services/{id}','App\Http\Controllers\ServicesController@edit_other_services')->name('edit_other_services');
    Route::match(['get','post'],'/update_other_services','App\Http\Controllers\ServicesController@update_other_services')->name('update_other_services');
    Route::match(['get','post'],'/delete_other_services','App\Http\Controllers\ServicesController@delete_other_services')->name('delete_other_services');

    


    //page 
    Route::get('/scanner', [VerifyAppointmentController::class, 'index'])->name('scanner');


    

    Route::get('/services', 'App\Http\Controllers\ServicesController@services')->name('services');
   
    //delete appointment calendar

    
  
    
    
    //calendar controller
    //view appointment
  



    //registration controller 
    Route::match(['get','post'],'/approve_registration','App\Http\Controllers\RegistrationController@approve_registration')->name('admin.approve_registration');

    Route::match(['get','post'],'/reject_registration','App\Http\Controllers\RegistrationController@reject_registration')->name('admin.reject_registration');
    
    Route::match(['get','post'],'/delete_registration','App\Http\Controllers\RegistrationController@delete_registration')->name('admin.delete_registration');

 

    


    //services controller  -- add
    Route::get('/registration', 'App\Http\Controllers\RegistrationController@registration')->name('registration');
    Route::get('/workers', 'App\Http\Controllers\WorkersController@workers')->name('workers');



    Route::get('/appointments', 'App\Http\Controllers\AppointmentsController@appointments_admin')->name('appointments');
    
    //view image
    
    Route::get('/view_identification/{id}','App\Http\Controllers\RegistrationController@view_identification')->name('admin.view_identification');

    // Route::post('register', 'App\Http\Controllers\Controller@register')->name('register');
   
    


    //verification
    Route::get('/admin_get_appointment_id/{content}', 'App\Http\Controllers\VerifyAppointmentController@get_appointment_id')->name('admin_get_appointment_id');

    Route::match(['get','post'],'/verify_appointment', 'App\Http\Controllers\VerifyAppointmentController@verify_appointment')->name('verify_appointment');

    // search 
    //ajax search
    Route::get('/live_search', 'App\Http\Controllers\LiveSearch@index');
    Route::get('/live_search/action', 'App\Http\Controllers\LiveSearch@action')->name('live_search.action');
  
    //laravel searcn 
    Route::get('/search', 'App\Http\Controllers\ServicesController@services')->name('search');

    //registation search 
    Route::get('/search_registration', 'App\Http\Controllers\RegistrationController@registration')->name('search_registration');

    //appointments searrch
    Route::get('/search_appointments', 'App\Http\Controllers\AppointmentsController@appointments_admin')->name('search_appointments');
   
    Route::post('/delete_appointment_admin', [AppointmentsController::class,'delete_appointment_admin'])->name('delete_appointment_admin');
    
    Route::post('/delete_workers_account', [RegistrationController::class,'delete_workers_account'])->name('delete_workers_account');
  

      //appointments reschedule
      Route::get('/get_available_slot/{id}', 'App\Http\Controllers\AppointmentsController@get_available_slot')->name('get_available_slot');
      Route::match(['get','post'],'reschedule_appointment','App\Http\Controllers\AppointmentsController@reschedule_appointment');
      
      Route::get('/get_appointmentDate_reschedule', 'App\Http\Controllers\AppointmentsController@get_app');
      Route::get('/get_appointmentDate_reschedule/{id}/{date}', 'App\Http\Controllers\AppointmentsController@get_appointmentDate_reschedule')->name('get_appointmentDate_reschedule');

      Route::get('/calendar', 'App\Http\Controllers\CalendarController@calendar')->name('admin_calendar');

//analytic

        Route::match(['get','post'],'/analytic', 'App\Http\Controllers\AnalyticController@index')->name('analytic');
        Route::match(['get','post'],'/cancel_appointment/{id}','App\Http\Controllers\AppointmentsController@cancel_appointment')->name('cancel_appointment');


  //pdf

  Route::post('/appointment_pdf', [AppointmentsController::class,'appointment_pdf'])->name('appointment_pdf');
  
  Route::get('/appointmentview', [appointment_PDF::class,'index'])->name('appointmentview');

  //excel
  Route::post('/appointment_excel', [AppointmentsController::class,'appointment_excel'])->name('appointment_excel');
  Route::get('/appointment_excel_view', [AppointmentExcelController::class,'index'])->name('appointment_excel_view');

  Route::post('/update_checkup', [AppointmentsController::class,'update_checkup'])->name('update_checkup');
  Route::get('/get_general_checkup/{id}', [AppointmentsController::class,'get_general_checkup'])->name('get_general_checkup');

  
});



//STAFF
Route::prefix('staff')->middleware(['auth','isStaff'])->group(function() {
  Route::match(['get','post'],'/verify_appointment_staff', 'App\Http\Controllers\VerifyAppointmentController@verify_appointment')->name('verify_appointment_staff');

    // Route::get('/scanner', 'App\Http\Controllers\VerifyAppointmentController@index')->name('staff.scanner');
    Route::get('/staff_get_appointment_id/{content}', 'App\Http\Controllers\VerifyAppointmentController@get_appointment_id')->name('staff_get_appointment_id');
    
    Route::get('/appointment_staff', 'App\Http\Controllers\AppointmentsController@appointments_admin')->name('appointment_staff');

    Route::match(['get','post'],'/staff_verify_appointment', 'App\Http\Controllers\StaffController@verify_appointment')->name('staff_verify_appointment');
    Route::get('/staff_scanner', [StaffController::class, 'index'])->name('staff_scanner');
        

  //  Route::get('/staff_get_appointment_id/{content}', 'App\Http\Controllers\StaffController@get_appointment_id')->name('staffget_appointment_id');

});

// Route::get('/dashboard',function(){

// });

//USER
Route::middleware(['auth','isUser'])->group(function() {
  //get appointment date
  Route::match(['get','post'],'/delete_appointment','App\Http\Controllers\CalendarController@delete_appointment')->name('delete_appointment');

  Route::match(['get','post'],'/get_appointment_slot_vaccine','App\Http\Controllers\AppointmentsController@get_app'); 

  Route::match(['get','post'],'/get_appointment_slot_vaccine/{date}/{id}','App\Http\Controllers\AppointmentsController@get_appointment_slot_vaccine')->name('get_appointment_slot_vaccine');
  
  Route::match(['get','post'],'/get_slot_other_vaccine','App\Http\Controllers\AppointmentsController@get_app'); 

  Route::match(['get','post'],'/get_slot_other_vaccine/{date}/{id}','App\Http\Controllers\AppointmentsController@get_slot_other_vaccine')->name('get_slot_other_vaccine');
 
  Route::match(['get','post'],'/get_slot_other_services','App\Http\Controllers\AppointmentsController@get_app'); 

  Route::match(['get','post'],'/get_slot_other_services/{date}/{id}','App\Http\Controllers\AppointmentsController@get_slot_other_services')->name('get_slot_other_services');
  Route::match(['get','post'],'/get_slot_pediattic_slot/{date}/{id}','App\Http\Controllers\AppointmentsController@get_slot_pediattic_slot')->name('get_slot_pediattic_slot');

  
  Route::get('/appointment', 'App\Http\Controllers\AppointmentsController@appointment')->name('appointment');

  Route::match(['get','post'],'/insert_data',  'App\Http\Controllers\AppointmentsController@insert')->name('insert_data');
  Route::get('/calendar', 'App\Http\Controllers\CalendarController@calendar')->name('calendar');

  Route::get('/history', 'App\Http\Controllers\AppointmentHistoryController@index')->name('history');

    //Page

Route::get('/preview_qrcode/{id}', 'App\Http\Controllers\QrCodeController@index')->name('preview_qrcode');
//appointment controller
Route::match(['get','post'],'/delete_scheduled_appointment','App\Http\Controllers\AppointmentsController@delete_scheduled_appointment')->name('delete_scheduled_appointment');

Route::match(['get','post'],'/preview_appointment/{id}','App\Http\Controllers\CalendarController@preview_appointment')->name('preview_appointment');

Route::match(['get','post'],'/get_other_services/{id}','App\Http\Controllers\CalendarController@get_other_services')->name('get_other_services');

Route::get('/get_dose/{id}','App\Http\Controllers\CalendarController@get_dose')->name('get_dose');

  //fetch services
  Route::match(['get','post'],'/get_service/{id}','App\Http\Controllers\CalendarController@get_service')->name('get_service');

});




Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index');

// Route::get('/verify', function () {
//   return view('verify');
// })->name('verify');


// Route::post('/register', 'App\Http\Controllers\AuthController@create')->name('register_action');
// Route::post('/verifys', 'App\Http\Controllers\AuthController@verify')->name('verify_action');


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {




// });


Route::get("/forgot/password", [MailerController::class, "email"])->name("email");


Route::any("/send-email", [MailerController::class, "composeEmail"])->name("send-email");


Route::get("/forgot/password/reset/{token}", [MailerController::class, "showResetForm"])->name("reset.password.form");

Route::any('/password/reset',[MailerController::class, "resetPassword"])->name('reset.password');


// //inputing the code
// // Route::post("/email/confirm-code", [MailerController::class, "retrived_code"])->name("retrived_code");

// Route::post("/confirm_otp", [MailerController::class, "confirm_otp"])->name("confirm_otp");



// Route::get('/email/confirm-code', function () {
//   return view('confirm-email');
// })->name('retrived_code');
















Route::get("/email/confirm-code/new-password", [MailerController::class, "password_reset"])->name("password_reset");

Route::post("/email/confirm-code/password_update", [MailerController::class, "password_update"])->name("password_update");

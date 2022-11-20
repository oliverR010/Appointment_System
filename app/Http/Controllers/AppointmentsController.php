<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Models\Calendar;
use App\Models\appointments;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\CheckUp;

use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
 

    public function appointment()
    {
        if(Auth::User()->account_type=='admin'){
            return view('services');
            }else{
              return redirect()->route('appointment');
            }
        
    }
    

    public function get_app(){

    }
    public function appointments_admin(Request $request)
    {

      // $appointments = appointments::all();
      $user = User::with('appointments')->get();
      $appointments = appointments::with('users')->get();

      if ($request->has('search_appointments')) {
        $appointments = DB::table('users')->join('appointments','users.id',"=",'appointments.user_id')->where('email','LIKE','%'.$request->search_appointments.'%')->orWhere('appointment_services','LIKE','%'.$request->search_appointments.'%')
        ->orWhere('appointment_vaccine_category','LIKE','%'.$request->search_appointments.'%')
        ->orWhere('appointment_vaccine_type','LIKE','%'.$request->search_appointments.'%')
        ->orWhere('appointment_date','LIKE','%'.$request->search_appointments.'%')
        ->orWhere('appointment_expiration_date','LIKE','%'.$request->search_appointments.'%')
        ->orWhere('appointment_status','LIKE','%'.$request->search_appointments.'%')
        ->paginate(10);
      }else{

        $appointments_admin = DB::table('users')
        ->join('appointments','users.id',"=",'appointments.user_id')
        ->paginate(10);
      }

  
        if(Auth::User()->account_type=='admin'){
            return view('appointment',compact('appointments_admin','user'));
        }elseif(Auth::User()->account_type=='staff'){
          // return view('appointment',compact('appointments_admin','user'));
        }else{
            return redirect()->route('appointment');
          }
      
    }
    protected $global_appointmentDate;
    protected $global_today=null;
   
    public function insert(Request $request){

      $request_service = $request ->input ('appointmentservice');
      $service_id =  DB::table('services')->where('id',$request_service)->get();
      if(!$service_id->isEmpty()){

       $appointment = new appointments();
      // $current_id = Auth::User()->id();
        if(Auth::User()->id){
          $current_id = Auth::User()->id;
          $contactnumber = Auth::User()->contactnumber;
         
        }

        $appointment ->user_id = $current_id;
        $appointment ->user_contactnumber= $contactnumber;

        $randomAppointmentId = rand(0,99999999);
       

        $today = \Carbon\Carbon::today()->format('Y/m/d');
        $appointmentDate = \Carbon\Carbon::parse($request ->input ('appointmentdate'))->format('Y/m/d');

        if($appointmentDate < $today){
          return redirect()->back()->with('danger', "Invalid Appointment Date!");
        }else{

          $service_slot=  DB::table('services')
          ->where('id',$request_service)->get();
          $appointment_slot =  DB::table('appointments')
          ->where('appointment_availableslot','<=',0)->get();

          foreach ($appointment_slot as $value) {
            if ($value->service_id == $request_service) {
           
                  if(\Carbon\Carbon::parse($value->appointment_date)->format('Y/m/d') == $appointmentDate ){
                  
                    return redirect()->back()->with('danger', "Service is not available");
                  }
            }
          }
          
          // $appointment_max =  DB::table('appointments');

          $appointment_max=  DB::table('users')
          ->join('appointments','users.id',"=",'appointments.user_id')
          ->where('user_id' ,"=", $current_id)
          ->where('appointment_status',"pending")
          ->get();


          foreach ($appointment_max as $value) {
            if($value->user_id){
              return redirect()->back()->with('danger', "You have an ongoing appointment!");
            }

         
          
          }
       
    
          $request_category = $request ->input ('appointmentCategory');

          $request_dose = $request ->input ('vaccine_dose_select');
        
         
         $categories_id =  DB::table('categories_vaccine')
         ->where('id',$request_category)->get();

       

        
         foreach ($service_id as $value) {
          $service_name = $value->service;
          $service_id = $value->id;
         }
          
          
         foreach ($categories_id as $value) {
          $categories_name = $value->category;
          $categories_id = $value->id;
         
          }
         
          
          if($service_id == 1){
        
            if($request ->input ('appointmentCategory')){
              $appointment ->appointment_services = $service_name;
              $appointment ->appointment_vaccine_category = $categories_name;
      
                if($categories_id == 1){
                  //check if the user has complete vaccination of infant
                  $vaccine_id = $request ->input ('vaccine_type_kids');
                  $appointment ->service_category_id= $vaccine_id;
                  // $appointment ->pediatic_id= $vaccine_id;
                  $slot = $request ->input ('available_slot');
                  $vaccine_service = $request ->input ('appointmentservice');
                  $vaccine_type = $request ->input ('vaccine_type_kids');

                  $vaccine_id =  DB::table('vaccine')->where('id',$vaccine_id)->get();
                  foreach ($vaccine_id as $value) {
                   $vaccine_type = $value->vaccine_type;
                   $vaccine_id = $value->id;
                   }
                  
                 
            
                      $kk = DB::table('vaccine')
                      ->where('service_id',$vaccine_service)
                      ->where('dose',null)
                      ->where('id',$vaccine_id)
                      ->update(['vaccine_slot'=> $slot-1]);

                      $appointment ->appointment_vaccine_type = $vaccine_type;

                }else if ($categories_id == 2){
                  //check if the apointment if the user has success dose 
                  //for first vaccination and 2nd
          
                  $vaccine_id= $request ->input ('vaccine_type_covid');
                
                  $appointment ->service_category_id= $vaccine_id;
                  $request_dose = $request ->input ('vaccine_dose_select');

                  $check_covid_dose = DB::table('appointments')
                  ->where('user_id',$current_id)
                  ->where('appointment_status',"success")
                  ->groupBy('appointment_dose')
                  ->get('appointment_dose');
               

                 
                  // dd($check_covid_dose);
                  $covid_dose =null;
           

          
                
                  if($check_covid_dose->isEmpty()){
                    if($request_dose == "2"){
                   
                      return back()->with(['danger' => "You have to get your 1st dose to be able to make an appointment on the 2nd dose!"]);
                    }elseif($request_dose == "3"){
                   
                      return back()->with(['danger' => "You have to get 1st dose and 2nd dose to be able to make an appointment on Booster!"]);
                    }
                  }else{
                    foreach ($check_covid_dose as $value) {
                      if($value->appointment_dose == $request_dose){
                        if($value->appointment_dose <3){
                       
                          $covid_dose = $value->appointment_dose ;
                          return back()->with(['danger' => "You already had this dose!"]);
                        }
                     
                      }else{

                        if($request_dose == "2"){

                          $check_covid_12 = DB::table('appointments')
                          ->where('user_id',$current_id)
                          ->where('appointment_status',"success")
                          ->where('appointment_dose',1)
                          ->groupBy('appointment_dose')
                          ->get();

                          if($check_covid_12->isEmpty()){
                          return back()->with(['danger' => "You have to get 1st dose before making appointment on 2nd dose!"]);

                          }else{

                          
                          }
                     

                          // return back()->with(['danger' => "You have to get 1st dose and 2nd dose to be able to make an appointment on Booster!"]);
                        }else if ($request_dose == "3"){

                          $check_covid_12 = DB::table('appointments')
                          ->where('user_id',$current_id)
                          ->where('appointment_status',"success")
                          ->where('appointment_dose',2)
                          ->groupBy('appointment_dose')
                          ->get();

                          if($check_covid_12->isEmpty()){
                          return back()->with(['danger' => "You have to get 2st dose before making appointment on booster!"]);

                          }
                        }
                      
                      }
                  
                    }
                  }
                  // dd($check_covid_dose);
                  // dd($covid_dose);
         



                  $vaccine_type_covid = $request ->input ('vaccine_type_covid');
                 
                  $vaccine_service = $request ->input ('appointmentservice');
             
                  //available slot on the vaccine covid category
                    $slot = $request ->input ('available_slot');
             
                      $kk = DB::table('vaccine')
                      ->where('service_id',$vaccine_service)
                      ->where('dose',$request_dose)
                      ->where('id',$vaccine_type_covid)
                      ->update(['vaccine_slot'=> $slot-1]);

                      $vaccine_id =  DB::table('vaccine')->where('id',$vaccine_id)->get();
                      foreach ($vaccine_id as $value) {
                       $vaccine_type = $value->vaccine_type;
                       }
                      $appointment ->appointment_availableslot = $slot-1;
                      $appointment ->appointment_vaccine_type = $vaccine_type;
                      $appointment ->appointment_dose = $request_dose;
              
                  
                }

            }
          }else{

            if($request ->get('appointment_service_others')){
              $id = $request ->get('appointment_service_others');
              $slot = $request ->input ('available_slot');

              if($service_id == "2" ){


                  $checkup = DB::table('appointments')
                  ->where('user_id',$current_id)
                  ->where('service_id',3)
                  ->where('appointment_vaccine_category', 'LIKE','%'."general".'%')
                  ->where('appointment_status',"success")
                  ->get();
            
                  if($checkup->isEmpty()){
                  return redirect()->back()->with('warning', "Make sure you had general check up before making an appointment for free medicine");
                    }

                   
              }
              
              // else if ($service_id == "3" && $id == "1"){

              //   $checkup = new CheckUp();
              //   $checkup->user_id = $current_id;
              //   $checkup->general_checkup = 1;
              //   $checkup->save();
              //   dd("Yes");
      
              // }

              // dd($id);
         
             
              $appointment ->service_category_id= $id;

                DB::table('other_services')
                ->where('id',$id)
                ->update(['other_services_slot'=>$slot-1]);
                $appointment ->appointment_availableslot = $slot-1;

              
              $request_other_service = $request ->get('appointment_service_others');
           
              $appointment ->service_category_id= $request ->get('appointment_service_others');

              $categories_other_service_id =  DB::table('services')
              ->join('other_services','services.id',"=",'other_services.service_id')
              ->where('other_services.id',$request_other_service)->get();
  
             
  
              foreach ($categories_other_service_id as $value) {
               $other_service_name = $value->service;
              
               $other_service_category = $value->other_services;
              }

              $appointment ->appointment_services = $other_service_name;
              $appointment ->appointment_vaccine_category = $other_service_category;

            }
       
        }
    
        // echo $mytime->toDateTimeString();

        $message_schedule = "Service ". $service_name ." has been scheduled!";
        $expire = Carbon::now()->addHours(48);

        $expiration_date = "Reminder! \n your slot will be forfeited if you didn't attend your scheduled appointment.";
        $message_appointment = $message_schedule."\n".$expiration_date;
        
        // temporary disabled text message
        // $this->sendMessage($message_appointment, $contactnumber);
        
        // $appointment_expirationdate = Carbon::now()->addHours(48)->toDateTimeString();
      
        
        // $appointment ->appointment_expiration_date = $appointment_expirationdate;

        //==============================================

      
            $message = $request ->input ('appointmentservice');
          $appointment ->appointment_date = $appointmentDate;

         
          $appointment ->appointment_id = $randomAppointmentId;
          
          $appointment ->service_id = $request_service;
        
              $kk = null;


    
          
              $appointment->save();
          if(Auth::User()->account_type=='admin'){
            return view('services');
            }else{
              return redirect()->route('calendar')->with('success', "Appointment Created");
            }
    
       
        }
      } else {

        if(Auth::User()->account_type=='admin'){
          return view('services');
          }else{
            return redirect()->route('calendar')->with('warning', "Please insert a service");
          }
      }


  }


    public function cancel_appointment($id){
        $user_id = appointments::find($id);
        // $service_id = User::find($id);

        return response()->json([
              'status'=>200,
              'user_id'=> $user_id,
      
        ]);
    }

  public function get_appointment_slot_vaccine($date,$id){



    $empty_date_slot_others = DB::table('vaccine')->where('id',$id)->get('vaccine_slot');
    
    foreach ($empty_date_slot_others as $value) {
      $slot_vaccine = $value->vaccine_slot;
    }

        return response()-> json([
          'vaccine'=>$slot_vaccine,
         
        ]);
  }





  public function get_slot_other_vaccine($date,$id){


// dd($id);
$empty_date_slot_others= DB::table('vaccine')->where('id',$id)->get();
foreach ($empty_date_slot_others as $value) {
  $slot_other_service = $value->vaccine_slot;
}
  
     
  
      return response()-> json([
        'otherservices'=>$slot_other_service,
      
      ]);
  }


//covid function for pediatric vaccination
  public function get_slot_pediattic_slot($date,$id){
  
       $empty_date_slot_others= DB::table('vaccine')->where('id',$id)->get();
       foreach ($empty_date_slot_others as $value) {
         $slot_other_service = $value->vaccine_slot;
       }
     

        return response()-> json([
        'pediatic'=>$slot_other_service,
      
      ]);

  }


  public function get_slot_other_services($date,$id){

       $empty_date_slot_others= DB::table('other_services')->where('id',$id)->get();
       foreach ($empty_date_slot_others as $value) {
         $slot_other_service = $value->other_services_slot;
       }
  

      return response()-> json([
        'otherservices'=>$slot_other_service,
      
      ]);
  }


  public function get_appointmentDate_reschedule($appointment_id,$new_appointment_date){

    $appointment_date = \Carbon\Carbon::parse($new_appointment_date)->format('Y/m/d');

    $today = \Carbon\Carbon::today()->format('Y/m/d');

    $appointment_Nodate_category1 = DB::table('appointments')
    ->join('categories_vaccine','appointments.service_id',"=",'categories_vaccine.service_id')
    ->join('vaccine','appointments.service_id',"=",'vaccine.service_id')
    ->where('appointment_id',$appointment_id)
    ->where('appointment_status',"pending")
    ->where('appointment_date',$new_appointment_date)
    ->groupBy('appointment_id')
    ->get(['appointment_availableslot']);

    $appointment_Nodate_category2= DB::table('appointments')
    ->join('categories_vaccine','appointments.service_id',"=",'categories_vaccine.service_id')
    ->join('vaccine','appointments.service_id',"=",'vaccine.service_id')
    ->where('appointment_id',$appointment_id)
    ->where('appointment_status',"pending")
    ->groupBy('appointment_id')
    ->get(['vaccine_slot']);

    //other services table No date return
    $appointment_Nodate_category3= DB::table('appointments')
    ->join('other_services','appointments.service_id',"=",'other_services.service_id')
    ->where('appointment_id',$appointment_id)
    ->where('appointment_status',"pending")
    ->groupBy('appointment_id')
    ->get(['appointment_id','other_services_slot']);

    //other services table date return
    $appointment_Nodate_category4= DB::table('appointments')
    ->join('other_services','appointments.service_id',"=",'other_services.service_id')
    ->where('appointment_id',$appointment_id)
    ->where('appointment_status',"pending")
    ->where('appointment_date',$new_appointment_date)
    ->groupBy('appointment_id')
    ->get(['appointment_availableslot']);

    if($appointment_Nodate_category1->isNotEmpty()){
        foreach ($appointment_Nodate_category1 as $value) {
          $slot_schedule = $value->appointment_availableslot;
        }
    }else if ($appointment_Nodate_category2->isNotEmpty()){
      foreach ($appointment_Nodate_category2 as $value) {
        $slot_schedule = $value->vaccine_slot;
      }
    }else if ($appointment_Nodate_category3->isNotEmpty()){
      foreach ($appointment_Nodate_category3 as $value) {
        $slot_schedule = $value->other_services_slot;
      }
    }else if($appointment_Nodate_category4->isNotEmpty()){
      foreach ($appointment_Nodate_category4 as $value) {
        $slot_schedule = $value->appointment_availableslot;
      }
    }
   
    // if($appointment_dose->isEmpty()){

    //   $appointment_noDate= DB::table('appointments')
    //   ->where('appointment_id',$appointment_id)
    //   ->where('appointment_status',"pending")
    //   ->get('service_id');

    //  foreach ($appointment_noDate as $value) {
    //     if($value->service_id ){

    //     }
    // } 


    // }else{
    //   //found same day
    //   foreach ($appointment_dose as $value) {
    //     $availableSlot = $value->appointment_availableslot;
    // } 
   
    // }
    // if($appointment_dose->isEmpty()){
    //   foreach ($appointment_dose as $value) {
    //     if($value->service_id == "1"){
    //       dd("yes");
  
    //     }
    //   }
     

    // }else{
    //   foreach ($appointment_dose as $value) {
    //     $appointment_dose = $value->appointment_dose;
       
    //   }

    //   $get_vaccine_dose = DB::table('appointments')->join('vaccine','appointments.appointment_dose',"=",'vaccine.dose')->where('appointment_id',$appointment_id)->where('appointment_status',"pending")->where('dose',$appointment_dose)->get();

    //   // if($appointment_date == ){

    //   // }

    //   // dd($get_vaccine_dose);
    //   // dd($get_vaccine_dose);
    // }
    // // foreach ($service_id as $value) {
    // //   $service_id = $value->service_id;
 
   
    // // }
   
 
   

    if($appointment_date < $today){
      $validDate = "no";
    }else{
      $validDate = "yes";
    }

    // // $date1 = DB::table('appointments')->where('appointment_date',$appointment_date)->where('service_id',$service_id)->where('appointment_status',"pending")->get();

    //   // $allservicesslot = DB::table('services')->sum('availableslot');
    // $individualserviceslot= DB::table('services')->get();
  
      return response()-> json([
        'slotschedule'=> $slot_schedule,
        'validDate'=>$validDate,
       
      ]);
}

  public function get_available_slot($id){

    $today = \Carbon\Carbon::today()->format('Y-m-d');

  
  $date1 = DB::table('appointments')->where('appointment_id',$id)->get();

  // foreach ($date1 as $value) {

  //     $date = $value->appointment_date;
  //     dd($date)
  // }

  
      // $allservicesslot = DB::table('services')->sum('availableslot');
      // $individualserviceslot= DB::table('services')->get();

  
      return response()-> json([
        // 'validDate'=> $validDate,
        // 'servicesslot'=>$allservicesslot,
        'date'=>$date1,
        'today'=>$today,
        // 'individualserviceslot'=> $individualserviceslot,
       
      ]);
}

public function reschedule_appointment(Request $request){

  $appointment_id =$request->input('appointment_id');
  $new_appointment_date =$request->input('new_appointment_date');
  $new_appointment_slot =$request->input('available_slot_reschedule');
  $service_id =$request->input('service_id');

  $old_appointment_date =$request->input('old_appointment_date');
  // $expire = Carbon::now()->addHours(48);
  $today = \Carbon\Carbon::today()->format('Y-m-d');


      if($old_appointment_date < $today){
        appointments::where('appointment_date',$old_appointment_date)->where('service_id',$service_id )->update(['appointment_date' => 0]);

      }else{
        if($new_appointment_date != $old_appointment_date){
  
          $new = appointments::where('appointment_date',$new_appointment_date)->where('appointment_status',"pending")->where('appointment_id',$appointment_id )->get();
          
       
        //walang existing na date
          if($new->isEmpty()){
              appointments::where('appointment_id',$appointment_id)->where('appointment_status',"pending")->where('service_id',$service_id )->update(['appointment_date' => $new_appointment_date, 'appointment_availableslot'=> $new_appointment_slot-1]);
            
          }else{

            appointments::where('appointment_date',$old_appointment_date)->where('appointment_status',"pending")->where('service_id',$service_id )->where('appointment_id',$appointment_id)->update(['appointment_date' => $new_appointment_date,'appointment_availableslot'=> $new_appointment_slot-1] );
            
            appointments::where('appointment_date',$new_appointment_date)->where('appointment_status',"pending")->where('service_id',$service_id )->update(['appointment_availableslot'=> $new_appointment_slot-1]);
          
          }

        }else{
          appointments::where('appointment_date',$new_appointment_date)->where('appointment_status',"pending")->where('service_id',$service_id )->update(['appointment_date' => $old_appointment_date, 'appointment_availableslot'=> $new_appointment_slot-1]);
        }
        
        $message ="Your Appointment has been Rescheduled!";
        $recipient = "+639777850026";

        //temporary disabled message function
          // $this->sendMessage($message, $recipient);

      }

  return redirect()->back()->with('success', 'Appointment sucessfully rescheduled');

}
    
  public function created_appointment(Request $request){
    $id = $request ->input ('calcel_id');
    $canceled_appointment_id = appointments::find($id);
    $service = $request ->input ('service');

  
    if($request ->input ('cancel_message') == null){
      $message ="Your " . $service . " Appointment has been canceled!";
    }else{
      $message = $request->input('cancel_message');
    }
    $canceled_appointment_id ->appointment_message = $message;
    $canceled_appointment_id->update();
  
// ------------------------------------------------------------------------------------
    $recipient = $request->input('user_phoneNo');

    //temporary disabled message function
      // $this->sendMessage($message, $recipient);


    // ------------------------------------------------------------------------------------
    if(Auth::User()->account_type=='admin'){
      return redirect()->back()->with('success', 'Notification Sent!');
    }else{
      return redirect()->route('login');
    }
  
  }  


    public function canceled_appointment(Request $request){
      $id = $request ->input ('calcel_id');
      $canceled_appointment_id = appointments::find($id);
      $service = $request ->input ('service');

    
      if($request ->input ('cancel_message') == null){
        $message ="Your " . $service . " Appointment has been canceled!";
      }else{
        $message = $request->input('cancel_message');
      }
      $canceled_appointment_id ->appointment_message = $message;
      $canceled_appointment_id ->appointment_status = "canceled";
      $canceled_appointment_id->update();
    
// ------------------------------------------------------------------------------------
      $recipient = $request->input('user_phoneNo');

      //temporary disabled function
        // $this->sendMessage($message, $recipient);


      // ------------------------------------------------------------------------------------
      if(Auth::User()->account_type=='admin'){
        return redirect()->back()->with('success', 'Notification Sent!');
      }else{
        return redirect()->route('login');
      }
    
    }  

    public function sendCustomMessage(Request $request)
    {
        // $validatedData = $request->validate([
        //     'users' => 'required|array',
        //     'body' => 'required',
        // ]);

        $recipients = $validatedData["users"];
        // iterate over the array of recipients and send a twilio request for each
        foreach ($recipients as $recipient) {
            $this->sendMessage($validatedData["body"], $recipient);
        }
        return back()->with(['success' => "Notification Sent!"]);
    }
    /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients Number of recipient
     */
    
    private function sendMessage($message, $recipient)
    {
      
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipient, ['from' => $twilio_number, 'body' => $message]);
    }


    public function service_appointment($id){
      $service_id = appointments::find($id);
      // $service_id = User::find($id);

      return response()->json([
            'status'=>200,
            'service_id'=> $service_id,
    
      ]);
  }


  public function delete_scheduled_appointment (Request $request){

    $id = $request ->input ('delete_id');
    $appointment_delete= appointments::find($id);
    
    $appointment_delete->delete();

    if(Auth::User()->account_type=='admin'){
      return redirect()->back()->with('danger', 'Successfully Deleted');
    }else{
    return redirect()->route('calendar');
    }

  }
  
    
}
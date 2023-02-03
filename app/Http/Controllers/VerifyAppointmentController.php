<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Models\services;
use App\Models\Vaccine;
use App\Models\User;
use App\Models\appointments;
use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\VerifyAppointment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VerifyAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::User()->account_type=='admin'){
           
            return view ('scanner');
        }else if(Auth::User()->account_type=='user'){
          
              return redirect()->route('calendar');
        }else if(Auth::User()->account_type=='staff'){
            return view ('scanner');
        }
      
    }

    function get_appointment_id($content){
        // $service_id = User::find($id);
        $current_date=Carbon::today()->format('Y-m-d');
        $data1 = DB::table('appointments')
        ->join('users','appointments.user_id',"=",'users.id')
        ->where('appointment_id',$content)
        ->where('appointment_status',"pending")
        ->first();

        if($data1!=null){

            if($current_date == $data1->appointment_date){
                $valid = 1;

                $data1 = DB::table('appointments')
                ->join('users','appointments.user_id',"=",'users.id')
                ->where('appointment_id',$content)
                ->where('appointment_status',"pending")
                ->get();
            }else{
                $valid =2;
            }
          
        }else{
            
            $valid = 0;
       

        }
       


        return response()->json([
            'valid'=>$valid,
            'data'=> $data1
          ]);

    
     
    }

    function verify_appointment(Request $request){

      $appointment_id = $request ->input ('appointment_id_hidden');
      $appointment_date = $request ->input ('appointment_date_hidden');
      
      $service = $request->input('appointment_services_hidden');
        $new_appointment_date = \Carbon\Carbon::parse($request ->input ('appointment_date_hidden'))->format('Y/m/d');

        
       
    //   $canceled_appointment_id = appointments::find($id);
        // $queue = DB::table('appointments')
        // ->where('appointment_date','=',$new_appointment_date)
        // ->where('appointment_status',"=",'success')
        // ->
        $appointment_que = appointments::where('appointment_id',$appointment_id)->first();

            if($appointment_que->service_id == "1"){
                //covid
                if($appointment_que->appointment_dose != null){

                    $queue = appointments::where('appointment_date',$appointment_que->appointment_date)
                    ->where('appointment_dose',$appointment_que->appointment_dose)
                    ->where('appointment_status',"success")
                    ->count();
                  
                }else{
                    $queue = appointments::where('appointment_date',$appointment_que->appointment_date)
                    ->where('service_category_id',$appointment_que->service_category_id)
                    ->where('appointment_status',"success")
                    ->count();
               
                
              
                }
            }else{
                $queue = appointments::where('appointment_date',$appointment_que->appointment_date)
                ->where('service_category_id',$appointment_que->service_category_id)
                ->where('appointment_status',"success")
                ->count();
                

                
            }

            

    if($queue == null){
        $queue = 0;
    }else{

    }
     


   
        //sendin message 
        $message1 = "Your appointment for ".$service." has been verified!";
        $message2 = "Your Queue # is : ".$queue+1;
       
        $messages = $message1."\n\n".$message2;
    
        $recipient = $appointment_que->user_contactnumber;

        // dd($messages);
        // $this->sendMessage($messages, $recipient);

    

        $dd = appointments::where("appointment_date",$new_appointment_date)
        ->where("appointment_id",$appointment_id)
        ->update(['appointment_status' => "success"]);


        alert()->success('Appointment Verified!','appointment queue has been sent to the resident.')->showConfirmButton()->buttonsStyling(true);
      
        return redirect()->back();

    }
  /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients Number of recipient
     */
    private function sendMessage($messages, $recipient)
    {
        
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipient, ['from' => $twilio_number, 'body' => $messages]);


    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vaccine;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;

class RegistrationController extends Controller
{
    function registration(Request $request){
       

         $workers_table = DB::table('users')->orwhere('account_type',"admin")->orwhere('account_type',"staff")->get();

         if ($request->has('search_registration')) {
          $datas = DB::table('users')->where('id','LIKE','%'.$request->search_registration.'%')
          ->orWhere('firstname','LIKE','%'.$request->search_registration.'%')
          ->orWhere('middlename','LIKE','%'.$request->search_registration.'%')
          ->orWhere('lastname','LIKE','%'.$request->search_registration.'%')
          ->orWhere('gender','LIKE','%'.$request->search_registration.'%')
          ->orWhere('birthdate','LIKE','%'.$request->search_registration.'%')
          ->orWhere('age','LIKE','%'.$request->search_registration.'%')
          ->orWhere('identification','LIKE','%'.$request->search_registration.'%')
          ->orWhere('identificationtype','LIKE','%'.$request->search_registration.'%')
          ->orWhere('contactnumber','LIKE','%'.$request->search_registration.'%')
          ->orWhere('address','LIKE','%'.$request->search_registration.'%')
          ->orWhere('email','LIKE','%'.$request->search_registration.'%')
          ->orWhere('account_type','LIKE','%'.$request->search_registration.'%')
          ->orWhere('status','LIKE','%'.$request->search_registration.'%')
          ->orWhere('contactnumber','LIKE','%'.$request->search_registration.'%')
          ->paginate(10);
          // dd($users_search);
        }else{
          $datas = DB::table('users')
          ->where('account_type',"user")
          ->get();


          $workers_table = DB::table('users')->orwhere('account_type',"admin")->orwhere('account_type',"staff")->get();

        }

        if(Auth::User()->account_type=='admin'){
          
            return view ('registration',compact('datas','workers_table'));
          }else{
              return redirect()->route('calendar');
  }
    }

    

    function approve_registration(Request $request){

        $approve_id = $request ->input ('approve_id');
        $approve = User::find($approve_id);
        $approve ->status = "approved";
        $approve->update();

        $message1 = "Your Registration at Dapitan Health Center has been approved!\n";
        $message2 = "You can now make an appointment.\n";
        $link = "wwww . dapitanhealthcenter . com";
        $message3 = "\nFor more information about our services kindly visit our website ".$link;

        $message = $message1.$message2.$message3;
      
        $recipient= $approve->contactnumber;
    

      // $this->sendMessage($message, $recipient);

        if(Auth::User()->account_type=='admin'){
      alert()->success('Reistration Approved')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);


          
            return redirect()->back();

          }else{
            return redirect()->route('login');
          }
    
    }

    function reject_registration(Request $request){

        $reject_id = $request ->input ('reject_id');
        $reject = User::find($reject_id);
        $reject ->status = "rejected";
        $reject->update();

        if(Auth::User()->account_type=='admin'){

          $message1 = "Your registration on Dapitan Health Center has been Declined!\n\n";
          $link = "wwww . dapitanhealthcenter . com";

        $message2= "For more information kindly visit our website ".$link;
        $message = $message1.$message2;
        $recipient = $reject->contactnumber;
        

           $this->sendMessage($message, $recipient);
           dd($recipient);
      alert()->success('Registration Rejected','The resident will be notified about the status of this registration')->showConfirmButton()->buttonsStyling(true);

      
            return redirect()->back();
          }else{
            return redirect()->route('login');
          }
    
    }

    function delete_registration(Request $request){
        $del_reg_id = $request ->input ('del_id');
        $del_reg = User::find($del_reg_id);
       
 
    
       if($del_reg->identification){

          if(Storage::disk('public')->exists($del_reg->identification)){
              
            
              Storage::disk('public')->delete($del_reg->identification);
            
          }
       }
  



        $del_reg->delete();

      

        if(Auth::User()->account_type=='admin'){

        
          alert()->success('Successfully Deleted')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
            return redirect()->back();
          }else{
            return redirect()->route('login');
          }
     
    
    }

    public function delete_workers_account(Request $request){
      $worker_id = $request ->input ('del_user_id');
      $delete_account = User::find($worker_id);
      $delete_account->delete();

     
      alert()->success('Successfully Deleted')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);

      return redirect()->back();

    }

    
    public function view_identification($id){
      $identification = User::find($id);
     
      return response()->json([
            'status'=>200,
            'identification'=> $identification,
            'identificationtype'=> $identification,

    
      ]);
    
    
    
     }  

     private function sendMessage($messages, $recipient)
     {
         
         $account_sid = getenv("TWILIO_SID");
         $auth_token = getenv("TWILIO_AUTH_TOKEN");
         $twilio_number = getenv("TWILIO_NUMBER");
         $client = new Client($account_sid, $auth_token);
         $client->messages->create($recipient, ['from' => $twilio_number, 'body' => $messages]);
 
 
     }


        
    
   
}

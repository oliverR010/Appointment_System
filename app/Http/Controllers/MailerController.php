<?php

namespace App\Http\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Http\Request;

class MailerController extends Controller
{
     // =============== [ Email ] ===================
    public function email() {
        if (Auth::check()) {
         
            return redirect()->back();
        }else{

            return view("email");
        }

        
    }

    // public function retrived_code(){

    //     return view("confirm-email");

    // }

    // public function password_reset(){
    //     return view ('reset-password');
    // }


    // ========== [ Compose Email ] ================
    public function composeEmail(Request $request) {

        if(! $request->isMethod('POST')){

            return redirect()->back();
            // return abort(404);
          }

        if (!$request->isMethod('post')) {
        
        }else {

      
        if (Auth::check()) {
            return redirect()->back();
        }else{

            
   
        $request->validate([
            'email'=> 'required|email|exists:users,email',
        ]);

 

    $email_recepient =  mb_strtolower( $request->email);
    

        $check = DB::table('users')
        ->where('email',"=",$email_recepient)
        ->where('status','approved')->first();

    
        if($check == null){

   
            // Alert::error('Error', 'Account is still Unverified')->persistent('Dismiss');
            return redirect()->back()->withErrors(['message1'=>'Account is still Unverified']);
        }

        $token = \Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);



        $action_link = route('reset.password.form',['token'=>$token,'email'=>$request->email]);

        $body = "<h1><b>Forget Password</b></h1>We have received a request to reset the password for Dapitan Health Center account with ".$request->email."<br>You can reset your account password with by cliking the link below <br><br>".$action_link;

        // Mail::send('email-forgot',['action_link'=>$action_link,'body'=>$body],function($message) use ($request){
        //     $message->from('noreply@example.com','Your APP Name');
        //     $message->to($request->emailRecipient,'Your name')->subject('Reset Password');

        // }); 

        // return back()->with('success', 'We have e-mailed your password resent link!');
        


        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

       
        $email_recepient = $request->email;

       


        
            try {

    
                // Email server settings
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';             //  smtp host
                $mail->SMTPAuth = true;
                $mail->Username = 'dapitanhealthcenter9@gmail.com';   //  sender username
                $mail->Password = 'dweyxnyjzihfnjqs';       // sender password
                $mail->SMTPSecure = 'ssl';                  // encryption - ssl/tls
                $mail->Port = 465;                          // port - 587/465
    
                $mail->setFrom('dapitanhealthcenter9@gmail.com');
                $mail->addAddress($request->email);
                // $mail->addCC($request->emailCc);
                // $mail->addBCC($request->emailBcc);
    
                // $mail->addReplyTo('jansen@gmail.com', 'jansen');
    
                // if(isset($_FILES['emailAttachments'])) {
                //     for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                //         $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                //     }
                // }
    
    
                $mail->isHTML(true);                // Set email content format to HTML
                
                // $pin = mt_rand(1000000, 9999999);
           

                // $find_email = DB::table('users')
                // ->where('email',$check->email)->update(['otp'=>$pin]);
             
              

                $mail->Subject = "Reset Password - Dapitan Health Center";
                $mail->Body    =  $body;
    
              
                // $mail->AltBody = plain text version of email body;
    
                if( !$mail->send() ) {
                    return back()->with("failed", "Code has been save!")->withErrors($mail->ErrorInfo);
                }
                
                else {
                    return back()->with('success', 'We have e-mailed your password reset link');
                }
    
            } catch (Exception $e) {
                 return back()->with('error',$e);
            }
        
            return back()->with("error", "Email address not found!");

     
        }   

    }
}






    public function confirm_otp(Request $request){

            // $opt = DB::table('users')
            // ->where('otp',$request->confirm_otp)
            // ->first();

            // if($opt != null ){
           
            //     return redirect()->route('password_reset',['id' => 1]);

            // }else{
            //     return redirect()->back()->with('error','Invalid one time pin');
            // }
            

    }


    public function showResetForm(Request $request, $token=null){
        
        $check_token = DB::table('password_resets')->where([
            'token'=>$token

        ])->first();
            
        if($check_token!=null){
            return view('reset-password')
            ->with(['token'=>$token,'email'=>$request->email]);    
        }else{


            return redirect()->route ('login');
        }
       
    }







    public function resetPassword(Request $request){

        if (Auth::check()) {
            

            return redirect()->back();
        }

        if(! $request->isMethod('POST')){
            return redirect()->back();
          }else{

       

            $request->validate([
            'email' =>'required|email|exists:users,email',
            'password'=> 'required|min:8|confirmed',
            'password_confirmation'=>'required'
            ]);




            $check_token = DB::table('password_resets')->where([

                'email' => $request->email,
                'token'=>$request->token

            ])->first();

            if(!$check_token){
                return back()->withInput()->with('fail','Invalid token');
            }else{
                User::where('email',$request->email)->update([
                    'password'=> bcrypt($request->password)
                    ]);

                DB::table('password_resets')->where([
                    'email' => $request->email
                ])->delete();

                Alert::success('Successfully Change')->persistent('Dismiss');
                return redirect()->route('login');
            }

       
    }
 }
}

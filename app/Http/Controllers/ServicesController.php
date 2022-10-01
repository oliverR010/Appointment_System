<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\services;
use App\Models\Vaccine;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{

 
  function sample(){
    return view ('dashboard');
  }

   function services(){
  
    $data = services::all();
    $data1 = vaccine::all();
    if(Auth::User()->account_type=='admin'){
      return view('services',compact('data','data1'));
      }else{
        return redirect()->route('calendar');
      }
   }


   public function add_services(Request $request){

    $request->validate([
      'service'=>'required'  
    ]);
      $appointment = new services();
      $appointment ->service = $request ->input ('service');
      $appointment->save();
  
      if(Auth::User()->account_type=='admin'){
        return redirect()->route('services');
      }else{
        return redirect()->route('calendar');
      }


   
  

 }

 public function edit_services($id){
  $services = services::find($id);
  return response()->json([
        'status'=>200,
        'service'=> $services,

  ]);
 }  

 public function edit_vaccine($id){
  $vaccine = Vaccine::find($id);
  return response()->json([
        'status'=>200,
        'person'=> $person,
        'vaccine_type'=> $vaccine_type,


  ]);
 }  

 public function update_services(Request $request){
      $request->validate([
        'service'=>'required'  
    ]);

    $id = $request ->input ('id');
    $appointment = services::find($id);
    $appointment ->service = $request ->input ('service');
    $appointment->update();

    if(Auth::User()->account_type=='admin'){
      return redirect()->back()->with('success', 'Successfully Edited');
    }else{
      return redirect()->route('login');
    }
    // return redirect()->back()->with('success', 'Successfully Edited');

    // return redirect()->route('services');
    // if(Auth::User()->account_type=='admin'){
    //   return redirect()->back()->with('edit_success', 'Successfully Edited');
    //   return redirect()->route('calendar');
    // }

 }  





 public function delete_services (Request $request){
  $id = $request ->input ('del_id');
  $service_del= services::findOrFail($id);
  $service_del->delete();

  if(Auth::User()->account_type=='admin'){
    return redirect()->back()->with('danger', 'Successfully Deleted');
  }else{
   return redirect()->route('calendar');
  }
  // return redirect()->back()->with('danger', 'Successfully Deleted');

  

 }


   
}

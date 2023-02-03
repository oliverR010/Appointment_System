<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\services;
use App\Models\Vaccine;
use App\Models\User;
use App\Models\Category;
// use App\Models\Medicine;
use App\Models\Other_Services;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{

 
  function index(){
    return view ('services');
  }

   function services(Request $request){
  
    $services = services::all();
    // $vaccine = vaccine::all();

    if($request->has('search')){
      // $other_services = Other_Services::where('id','LIKE','%'.$request->search.'%')->paginate(5);
      $other_services = DB::table('services')->join('other_services','services.id',"=",'other_services.service_id')->where('services.service','LIKE','%'.$request->search.'%')
      ->orWhere('other_services','LIKE','%'.$request->search.'%')
      ->orWhere('other_services','LIKE','%'.$request->search.'%')
      ->orWhere('other_services','LIKE','%'.$request->search.'%')
      ->paginate(5);
    }else{
      $other_services = DB::table('services')->join('other_services','services.id',"=",'other_services.service_id')->get();
    }

    $vaccines_kids = DB::table('categories_vaccine')
    ->join('vaccine','categories_vaccine.id',"=",'vaccine.category_id')
    ->get();

    $vaccines_covid = DB::table('categories_vaccine')
    ->join('vaccine','categories_vaccine.id',"=",'vaccine.category_id')
    ->where('category_id',2)
    ->orderBy('dose') 
    ->paginate(5);
 
    

    
    $vaccines_others = DB::table('categories_vaccine')
    ->join('vaccine','categories_vaccine.id',"=",'vaccine.category_id')
    ->where('category_id',">",2)
    ->paginate(5);


    $categories = Category::paginate(5);
    // $medicine = Medicine::all();
   
    //update availability
   $check_availability_vaccine =DB::table('vaccine')
   ->where('vaccine_slot',"0")
   ->update(['vaccine_availability'=>"No"]);


   $check_availability_other_services =DB::table('other_services')
   ->where('other_services_slot',"0")
   ->update(['other_services_availability'=>"No"]);


    
    if(Auth::User()->account_type=='admin'){
      return view('services',compact('services','vaccines_covid','vaccines_others','vaccines_kids','categories','other_services'));
      }else{
        return redirect()->route('calendar');
      }
   }



// add 
   public function add_services(Request $request){


      $services_add = new services();
      $service = $request->input('add_service');
    
      $validate_service = services::where('service',"=",$service )->get();
      

      if($validate_service->isEmpty()){
        $services_add ->service = $request->input('add_service');
        $services_add ->availability = "No";
        // $services_add ->availableslot = $request ->input ('add_available_slot');
        $services_add->save();

      }else{
        alert()->error('Service already Exist')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
        return redirect()->back();

      }

     
  
      if(Auth::User()->account_type=='admin'){
        alert()->success('Successfully Added')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
        return redirect()->back();
      }else{
        return redirect()->route('calendar');
      }

 }

 public function add_vaccine(Request $request){


      if($request ->input ('add_vaccine_input_id') != null && $request ->input ('add_vaccine_input') != null){
        $vaccine_add = new vaccine();

        // $validate_vaccine = vaccine::where('vaccine_type',"=",$request ->input ('covid_select'))->get();

        // if($validate_vaccine->isEmpty()){
              $vaccine_add ->service_id = $request ->input ('service_select_id');
              $vaccine_add ->category_id = $request ->input ('add_vaccine_input_id');
              $vaccine_add ->vaccine_type = $request ->input ('add_vaccine_input');
            
              $vaccine_add ->vaccine_slot = $request ->input ('add_vaccine_slot');
        
              if($request ->input ('vaccine_select') == 2){

                $validate_vaccine = DB::table('vaccine')
                ->where('dose',$request ->input ('covid_select') )
                ->where('vaccine_type',"=",$request ->input ('add_vaccine_input'))
                ->get();
            
                if($validate_vaccine->isNotEmpty()){

                  alert()->error('Vaccine Already Exist!')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
                  return redirect()->back();

                }else{
                  $vaccine_add ->dose = $request ->input ('covid_select');
                  $vaccine_add ->vaccine_availability = "No";
                  $vaccine_add->save();
                }
               
              }else{

                  $validate_other_vaccine = DB::table('vaccine')
                  ->where('vaccine_type',"=",$request ->input ('add_vaccine_input'))
                  ->get();

                  if( $validate_other_vaccine->isNotEmpty()){
                    alert()->error('Vaccine Already Exist!')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
                    return redirect()->back();
                  }else{
                    $vaccine_add ->vaccine_availability = "No";
                    $vaccine_add->save();
                  }
               

              }

            
              alert()->success('Successfully Added')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
        // }
      //   else{
      //       return redirect()->back()->with('danger', 'Vaccine already Exist');

      //   }
       
      }


      if ($request ->input ('add_vaccine_category_input') != null){
          
        $validate_categories_vaccine = DB::table('categories_vaccine')->where('category',"=",$request ->input ('add_vaccine_category_input'))->get();

        
       if($validate_categories_vaccine->isNotEmpty()){
          alert()->error('Category already Exist!')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);

          return redirect()->back();

       }else{
          $count_categories_vaccine = DB::table('categories_vaccine')
          ->count();

        
            if ($count_categories_vaccine <3){
              $vaccine_category_add = new Category();
            
              $vaccine_category_add ->category_availability = "";
              $vaccine_category_add ->service_id = $request ->input ('service_select_id');
              $vaccine_category_add ->category = $request ->input ('add_vaccine_category_input');
              $vaccine_category_add->save();
              alert()->success('Successfully Added')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
            }else{
              alert()->error('Error!','You can add vaccine to "OTHERS Category"')->showConfirmButton()->buttonsStyling(true);
              return redirect()->back();
            }
       }

        
       
      }
    
      if ($request ->input ('add_other_services_input') != null){

        $validate_other_services = DB::table('other_services')
        ->where('other_services',$request ->input ('add_other_services_input'))
        ->get();

        
        if($validate_other_services->isNotEmpty()){
          alert()->error('Already Exist!')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
          return redirect()->back();

        }else{
          $add_other_services = new Other_Services();
          $add_other_services ->other_services_availability = "No";
          $add_other_services ->service_id = $request ->input ('add_other_services_input_id');
          $add_other_services ->other_services_slot = $request ->input ('add_others_service_slot');
          $add_other_services ->other_services = $request ->input ('add_other_services_input');
          $add_other_services->save();
          alert()->success('Successfule Added')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
        }

    
    }


      if(Auth::User()->account_type=='admin'){
        return redirect()->route('services');
      }else{
        return redirect()->route('calendar');
      }

 }




 //edit 

 public function edit_services($id){
  $services_id = services::find($id);
  return response()->json([
        'status'=>200,
        'service'=> $services_id,

  ]);
 }  
 public function select_service($id){
  $service_id = services::find($id);
  return response()->json([
        'status'=>200,
        'service_id'=> $service_id,

  ]);
 } 
 

 public function edit_vaccine($id){
  $vaccine_id = Vaccine::find($id);
  return response()->json([
        'status'=>200,
        'vaccine_id'=> $vaccine_id,

  ]);
 }  

 public function edit_other_services($id){
  $other_services = Other_Services::find($id);
  return response()->json([
        'status'=>200,
        'other_services'=> $other_services,

  ]);
 }  

 public function edit_category($id){
  $category_id = Category::find($id);
  return response()->json([
        'status'=>200,
        'category_id'=> $category_id,

  ]);
 }  



 //update
 public function update_other_services(Request $request){
 
  $id = $request ->input ('edit_other_services_id');
  
  $other_services = Other_Services::find($id);
 


  $check_others_service_availability = DB::table('services')
  ->join('other_services', 'services.id',"=",'other_services.service_id')
  ->where('other_services.id', $id )->get();

foreach ($check_others_service_availability as $value) {
    $check_others_service_availability = $value->availability;
}




if($check_others_service_availability == "Yes"){
  $other_services ->other_services = $request ->input ('edit_other_services_input');
  $other_services ->other_services_slot = $request ->input ('update_other_services_slot');
  $other_services ->other_services_availability = $request ->input ('choice_other_services');
  $other_services->update();
}else{
  $other_services->update();
  alert()->warning('Successfully Updated','Turn on the service availability to edit this availability.')->showConfirmButton()->buttonsStyling(True);
  return redirect()->back();
}
  if(Auth::User()->account_type=='admin'){
    alert()->success('Successfully Updated')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
    return redirect()->back();
  }else{
    return redirect()->route('login');

  }

}  

 public function update_category(Request $request){

  $old_id = $request->input('old_id');
  $id = $request ->input ('category_update_id');
  $service_id = $request ->input ('service_update_id');
  $category = Category::find($id);


 if($old_id == $id){
 

 }else{
    $check_id = DB::table('categories_vaccine')
    ->where('id',$id)
    ->get();
    if($check_id->isNotEmpty()){

        alert()->Error('Error','Category ID Exist!')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
        return redirect()->back();
    }
 }

 if($category == null){
  DB::table('categories_vaccine')->where('id',$old_id)->update(['id'=>$id]);
  $category = Category::find($id);

       //  Category::where('id', $id)->exists();

       
       // dd($category);
     
     }


     $category ->category = $request ->input ('category_update');
     // if($request->input('available_vaccinecategory_slot')){
     //   // $category ->category_vaccine_slot = $request ->input ('available_vaccinecategory_slot');
     // }
       //update availability of vaccine table
       


     
     $check_service_availability = DB::table('services')->where('id', $service_id)->get();

   foreach ($check_service_availability as $value) {
       $check_service_availability = $value->availability;
   }

   if($check_service_availability == "Yes"){
     $others = DB::table('categories_vaccine')->join('vaccine','categories_vaccine.id',"=",'vaccine.category_id')->where('category_id',$request ->input ('category_update_id') )->update(['vaccine_availability' => $request ->input ('choice_category')]);
     $category ->category_availability = $request ->input ('choice_category');
     $category->update();


   }else{
     $category->update();
     alert()->warning('Successfully Updated','Turn on the service availability to edit this availability.')->showConfirmButton()->buttonsStyling(true);
     return redirect()->back();
   }

 




  if(Auth::User()->account_type=='admin'){
     alert()->success('Successfully Updated')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);

    return redirect()->back();
  }else{
    return redirect()->route('login');
  }

}  





 public function update_services(Request $request){
 
  $id = $request ->input ('id');
  $appointment = services::find($id);
  $appointment ->id = $request ->input ('service_id');
  $appointment ->service = $request ->input ('service');
  $appointment ->availability = $request ->input ('choice_service');
  // $appointment ->availableslot = $request ->input ('available_slot');


if($request ->input ('id') == $request ->input ('service_id')){
          
  if($id == 1){
    $update_vaccine_availability = DB::table('services')->join('vaccine','services.id',"=",'vaccine.service_id')->join('categories_vaccine','services.id',"=",'categories_vaccine.service_id')->where('services.id', $id)->get();
    

    if($update_vaccine_availability->isEmpty()){
     $check =  DB::table('services')->join('categories_vaccine','services.id',"=",'categories_vaccine.service_id')->where('services.id', $id)->get();

      if($check->isEmpty()){

      }else{
        DB::table('services')->join('categories_vaccine','services.id',"=",'categories_vaccine.service_id')->where('services.id', $id)->update(['category_availability'=>$request ->input ('choice_service')]);
        alert()->success('Successfully Updated')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
      }
    }else{
      $update_vaccine_availability = DB::table('services')->join('vaccine','services.id',"=",'vaccine.service_id')->join('categories_vaccine','services.id',"=",'categories_vaccine.service_id')->where('services.id', $id)->update(['vaccine_availability'=> $request ->input ('choice_service'),'category_availability'=>$request ->input ('choice_service')]);
      alert()->success('Successfully Updated')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
      $appointment->update();
    }

  }else{
    $update_other_services_availability = DB::table('services')->Join('other_services','services.id',"=",'other_services.service_id')->where('service_id',  $id)->update(['other_services_availability'=> $request ->input ('choice_service')]);

 
  }
  $appointment->update();
}else{

  $check_existing = DB::table('services')
  ->where('id',$request ->input ('service_id'))
  ->get();

  if( $check_existing->isNotEmpty()){
    alert()->error('Service ID already Exist')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
    return redirect()->back();
  }else{

   
    $appointment->update();
  }
  

}






  if(Auth::User()->account_type=='admin'){
    alert()->success('Successfully Upated')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
    return redirect()->back();
  }else{
    return redirect()->route('login');
  }

}  

public function update_vaccine(Request $request){

  $vaccine_id = $request ->input ('vaccine_del_id');

  $check_availability = DB::table('categories_vaccine')->join('vaccine','categories_vaccine.id',"=",'vaccine.category_id')->where('vaccine.id',$vaccine_id)->get();

 
  $vaccine = Vaccine::find($vaccine_id);
  $vaccine ->vaccine_type = $request ->input ('vaccine');
  $vaccine ->vaccine_slot = $request ->input ('update_vaccine_slot');


  foreach ($check_availability as $value) {
    if ($value->category_availability == "Yes"){
      $vaccine ->vaccine_availability = $request ->input ('choice_vaccine');
      $vaccine->update();
    }else{
      $vaccine->update();
      alert()->warning('Updated Successfully','Turn the category availability to edit this availability.')->showConfirmButton()->buttonsStyling(true);
      return redirect()->back();
     
    }
 

  }

  
  

  if(Auth::User()->account_type=='admin'){
    alert()->success('Successfully Updated')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
    return redirect()->back();
  }else{
    return redirect()->route('login');
  }

} 

//delete services

 public function delete_services (Request $request){
  $id = $request ->input ('service_del_id');
  $service_del= services::find($id);
  $service_del->delete();

  if(Auth::User()->account_type=='admin'){
    alert()->success('Successfully Deleted')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
    return redirect()->back();
  }else{
   return redirect()->route('calendar');
  }


 }

//delete vaccine
 public function delete_vaccine (Request $request){
  $id = $request ->input ('delete_vaccine_id');
  $service_del= vaccine::find($id);
  $service_del->delete();

  if(Auth::User()->account_type=='admin'){
    alert()->success('Successfully Deleted')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
    return redirect()->back();
  }else{
   return redirect()->route('calendar');
  }

 }

 
 public function delete_category (Request $request){
  $id = $request ->input ('category_del_id');
  $category_del= vaccine::find($id);
  $category_del= Category::find($id);

  $category_del->delete();

  if(Auth::User()->account_type=='admin'){
    alert()->success('Successfully Deleted')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
    return redirect()->back();
  }else{
   return redirect()->route('calendar');
  }

 }

 public function delete_other_services (Request $request){
  $id = $request ->input ('delete_other_services_id');
  $other_services_delete= Other_Services::find($id);
  $other_services_delete->delete();

  if(Auth::User()->account_type=='admin'){
    alert()->success('Successfully Deleted')->showConfirmButton(false)->buttonsStyling(false)->autoClose(1500);
    return redirect()->back();
  }else{
   return redirect()->route('calendar');
  }

 }
   
}

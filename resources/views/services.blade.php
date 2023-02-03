<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('css/customize.css') }}" >

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

    
    <title>Document</title>
<style>
  .red-color {
        color:red;
    }
    .green-color {
        color:green;
    }
</style>
</head>
<body>
    


    

{{-- Add  Services modal--}}

<div class="modal fade" id="add_services_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

             <form action=" {{ route ('add_services') }} " method="POST"  class="m-2">
                @csrf
                {{ csrf_field() }}
                    <div class="form-group">
                        <label for="service" class="col-form-label">Service</label>
                        <input type="text" class="form-control" name="add_service" id="add_service" required>
                    </div>
                
                    {{-- <div class="form-group">
                        <label for="service" class="col-form-label">Available Slot</label>
                        <input type="number" class="form-control" name="add_available_slot" id="add_available_slot" min="0" required>
                    </div> --}}
             
               
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm w-25">Save</button>
                        <button type="button" class="btn btn-danger btn-sm w-25" data-dismiss="modal">cancel</button>
                        
                    </div>
            </form>
        </div>
       
        </div>
    </div>
    </div>

    {{-- Add vaccine modal--}}


<div class="modal fade" id="add_vaccine_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Service Categories</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route ('add_vaccine') }}" method="POST">
                @csrf
                {{ csrf_field() }}
                <div class="">
                    <x-jet-label for="service" value="{{ __('Select Service') }}"/>
                        <input type="text" id="service_select_id" name="service_select_id" hidden>
                        <select name="service_select" id="service_select" class ="mb-3 block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            
                            @foreach ($services as $value)
                              
                                    <option value="{{ $value->id }}"> 
                                        {{ $value->service }} 
                                    </option>
                          
                        
                          @endforeach  
                    
                    
                        </select>
                        <div id="other_services_field">
                            <div class="form-group">
                                <label for="" id="add_sub_of_service" name="add_sub_of_service"> Add </label>
                                <input type="text" class="form-control" name="add_other_services_input_id" id="add_other_services_input_id" hidden>
                                <input type="text" class="form-control" name="add_other_services_input" id="add_other_services_input"  >
                            </div>
                            

                            <div class="form-group">
                               <label for="">Available Slot</label>
                                <input type="number" class="form-control" name="add_others_service_slot" id="add_others_service_slot"  min="1" >
                            </div>
                        </div>

                   
                        
                    <div id="vaccine_field_whole" >
                        <x-jet-label for="service" value="{{ __('Select Column') }}"/>

                        <select name="column_select" id="column_select" class ="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="category">Add Category</option>
                                <option value="vaccine_type">Add Vaccine </option>  

                        
                        </select>

            
                        <div id="category_field">
                            <div class="form-group">
                                <x-jet-label for="service" class="mt-3" value="{{ __('Category') }}" />
                                <input type="text" class="form-control" name="add_vaccine_category_input_id" id="add_vaccine_category_input_id" hidden >
                          
                                
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="add_vaccine_category_input" id="add_vaccine_category_input"  >
                            </div>
                            
                       
                        </div>
                       
                        <div id="vaccine_field">
                          
                            <x-jet-label for="service" class="mt-3" value="{{ __('Select Category') }}" />
                                
                                <select name="vaccine_select" id="vaccine_select" class ="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" >
                    
                                    @if($categories->isEmpty())
                                            <td colspan="3">
                                                No Data
                                            </td>
                                    @else
                                    @endif
                                    @foreach ($categories as $value)
                                    <option value="{{ $value->id }}"> 
                                    {{ $value->category }} 
                               
                                   
                                </option>
                               
                                 @endforeach  
                                
                                
                              </select>
                              
                              <div id="covid_field" class="covid_field" style="display: none">
                                <x-jet-label for="service" class="mt-3" value="{{ __('Dose') }}" />
                                <select name="covid_select" id="covid_select" class ="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" >
                        
                                    @if($categories->isEmpty())
                                            <td colspan="3">
                                                No Data
                                            </td>
                                        @else
                                    @endif
                                  
                                    <option value="1"> 1st Dose</option> 
                                    <option value="2"> 2nd Dose</option> 
                                    <option value="3"> Booster</option> 
             
                                
                                
                              </select>
    
                            </div>
                            <div class="form-group">
                                <x-jet-label for="service" class="mt-3" value="{{ __('Vaccine Type') }}" />
                                <input type="text" class="form-control" name="add_vaccine_input_id" id="add_vaccine_input_id" hidden >
                                <input type="text" class="form-control" name="add_vaccine_input" id="add_vaccine_input" >
                                

                            </div>
                            <div class="form-group">
                                <x-jet-label for="service" class="mt-3" value="{{ __('Available Slot') }}" />
                                <input type="number" class="form-control" name="add_vaccine_slot" id="add_vaccine_slot" min="1" >
                            </div>
                        
                        </div>

                   
                    </div>   
                 

                
                </div>
                <div class="modal-footer">
                    
                        <button type="submit" id="btn_add_vaccine_medicine" class="btn btn-sm w-25 btn-primary btn-sm text-align-center">Add</button>
                    
                    <button type="button" class="btn btn-danger btn-sm w-25" data-dismiss="modal">cancel</button>
                    
                </div>
                </form>
        </div>
       
        </div>
    </div>
    </div>
{{-- Edit modal Services--}}

    <div class="modal fade" id="edit_service_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <form action=" {{ route('update_services') }} " method="POST" class="m-2">
                @csrf
                {{ csrf_field() }}
                <input type="text" id="id" name="id" hidden>
                <div class="form-group ">
                    <label for="service" class="col-form-label">Service ID</label>
                    <input type="text" class="form-control " name="service_id" id="service_id" required>
                </div>
            <div class="form-group ">
                <label for="service" class="col-form-label">Service</label>
                <input type="text" class="form-control " name="service" id="service" required>
            </div>

            <div class="form-group" id="yesandno_service" name="yesandno_service">
                <label for="service" class="col-form-label">Availability</label>
                    <div class="form-check ">
                        <input class="form-check-input" type="radio" name="choice_service"  value="Yes">
                        <label class="form-check-label" for="Yes" >
                        Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="choice_service" value="No">
                        <label class="form-check-label" for="No" >
                        No
                        </label>
                  </div>    
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-sm w-25">Save</button>
                <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">cancel</button>
                
            </div>
            </form>
        </div>
       
        </div>
        </div>
    </div>

    {{-- Edit mmedicine modal--}}

    <div class="modal fade" id="edit_other_services_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="other_services_modal_title" name="other_services_modal_title">Edit Other Services</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <form action=" {{ route('update_other_services') }} " method="POST"  class="m-2">
                @csrf
                {{ csrf_field() }}
                <input type="text" id="edit_other_services_id" name="edit_other_services_id" hidden>
            <div class="form-group">
                <label for="service" class="col-form-label">Service</label>
                <input type="text" class="form-control" name="edit_other_services_input" id="edit_other_services_input" required>
            </div>
            <div class="form-group">
                <label for="service" class="col-form-label">Available Slot</label>
                <input type="number" class="form-control" name="update_other_services_slot" id="update_other_services_slot" min="1" required>
            </div>
            <div class="form-group" id="yesandno_other_services" name="yesandno_other_services">
                <label for="other_services" class="col-form-label">Availability</label>
                    <div class="form-check ">
                        <input class="form-check-input" type="radio" name="choice_other_services"  value="Yes">
                        <label class="form-check-label" for="Yes" >
                        Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="choice_other_services" value="No">
                        <label class="form-check-label" for="No" >
                        No
                        </label>
                  </div>    
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm w-25">Save</button>
                <button type="button" class="btn btn-secondary btn-sm w-25" data-dismiss="modal">cancel</button>
                
            </div>
            </form>
        </div>
       
        </div>
        </div>
    </div>
{{-- Edit modal vaccine --}}
<div class="modal fade" id="edit_vaccine_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Vaccine</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <form action=" {{ route('update_vaccine') }} " method="POST"  class="m-2">
                @csrf
                {{ csrf_field() }}
                <input type="text" id="vaccine_del_id" name="vaccine_del_id" hidden >
            <div class="form-group">
                <label for="service" class="col-form-label">Vaccine</label>
                <input type="text" class="form-control" name="vaccine" id="vaccine" required>
            </div>
            <div class="form-group">
                <label for="vaccine" class="col-form-label">Available Slot</label>
                <input type="number" class="form-control" name="update_vaccine_slot" id="update_vaccine_slot" required min="1">
            </div>
            <div class="form-group" id="yesandno_vaccine" name="yesandno_vaccine">
                <label for="vaccine" class="col-form-label">Availability</label>
                    <div class="form-check ">
                        <input class="form-check-input" type="radio" name="choice_vaccine"  value="Yes">
                        <label class="form-check-label" for="Yes" >
                        Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="choice_vaccine" value="No">
                        <label class="form-check-label" for="No" >
                        No
                        </label>
                  </div>    
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-sm w-25">Save</button>
                <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">cancel</button>
                
            </div>
            </form>
        </div>
       
        </div>
    </div>
</div>

{{-- Edit category modal --}}
<div class="modal fade" id="edit_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <form action=" {{ route('update_category') }} " method="POST"  class="m-2">
                @csrf
                {{ csrf_field() }}
                
                <input type="text" id="service_update_id" name="service_update_id" hidden >
                <input type="text" id="old_id" name="old_id" hidden>

                
                <div class="form-group">
                <label for="service" class="col-form-label">Category ID</label>

                <input type="text" id="category_update_id" class="form-control" required name="category_update_id">

                </div>

            <div class="form-group">
                <label for="service" class="col-form-label">Vaccine</label>
           

                <input type="text" class="form-control" name="category_update" id="category_update" required >
            </div>
            {{-- <div class="form-group" style="display:none" id="div_available_vaccinecategory_slot" class="div_available_vaccinecategory_slot">
                <label for="available_slot" class="col-form-label">Available Slot</label>
                <input type="number" class="form-control" name="available_vaccinecategory_slot" id="available_vaccinecategory_slot"  min="0" required>
            </div> --}}
            <div class="form-group" id="yesandno_category" name="yesandno_category">
                <label for="category" class="col-form-label">Availability</label>
                    <div class="form-check ">
                        <input class="form-check-input" type="radio" name="choice_category"  value="Yes">
                        <label class="form-check-label" for="Yes" >
                        Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="choice_category" value="No">
                        <label class="form-check-label" for="No" >
                        No
                        </label>
                  </div>    
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-sm w-25">Save</button>
                <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">cancel</button>
                
            </div>
            </form>
        </div>
       
        </div>
    </div>
</div>

 <!-- delete category / confimation -->

 <div class="modal fade" id="delete_category_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route ('delete_category') }} " method="POST"  class="m-2">
            @csrf
         
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text"  id="category_del_id" name="category_del_id" hidden>
          Are you sure you want to delete this Category?
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-danger delete_btn btn-sm w-25">Yes</button>
          <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">No</button>
        </div>
         </form>

      </div>
    </div>
  </div>
   <!-- delete service / confimation -->

<div class="modal fade" id="delete_service_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ url ('admin/delete_services') }} " method="POST"  class="m-2">
            @csrf
         
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text"  id="service_del_id" name="service_del_id" hidden>
          Are you sure you want to delete this Service?
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-danger delete_btn btn-sm w-25">Yes</button>
          <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">No</button>
        </div>
         </form>

      </div>
    </div>
  </div>
 <!-- delete medicine / confimation -->
  <div class="modal fade" id="delete_other_services_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route('delete_other_services') }} " method="POST"  class="m-2">
            @csrf
         
        <div class="modal-header">
    
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text" id="delete_other_services_id" name="delete_other_services_id" hidden>
          Are you sure you want to delete this?
        </div>
        
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-danger delete_other_service btn-sm w-25">Yes</button>
          <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">No</button>
        </div>
         </form>

      </div>
    </div>
  </div>


 <!-- delete Vaccine / confimation -->

 <div class="modal fade" id="delete_vaccine_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route('delete_vaccine') }} " method="POST"  class="m-2">
            @csrf
         
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text"  id="delete_vaccine_id" name="delete_vaccine_id" hidden>
          Are you sure you want to delete this Vaccine?
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-danger delete_btn btn-sm w-25">Yes</button>
          <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">No</button>
        </div>
         </form>

      </div>
    </div>
  </div>
  <div class="container-fluid text-center pt-5  pb-3 p-lg-5 mt-4 mb-4 ">
    <h3 class="fw-bolder bg-dark text-light p-4">SERVICES</h3>
    <div class=""></div>
</div>
    <div class="container mb-5 bg-semi-white" >
      
        <div>
            @if (session('success'))
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
            @elseif (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('danger') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
           @elseif (session('warning'))
           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
           @endif
        </div>
        <div class="container">
            <div class="row justify-content-end">
                <button class="col col-12 col-lg-2 btn btn-sm add_service_btn btn-primary mt-2 mb-2  bi bi-plus-circle" style="width:120px;"> Add Service</button>
        </div>
        </div>
     
        <div class="row">
            <div class=" col col-lg-12 col-12">
                <div class="card shadow-sm">
                    <div class=" card-header text-center p-3 font-weight-bold bg-semi-grey ">
                        Service Table
                      </div>
                    <div class="card-body table-responsive mb-4 ">
                        <table class="table table-hover table-striped" id="service_table"  >
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-center" >View Fields</th>
                                    <th scope="col" class="text-center" >ID</th>
                                    <th scope="col" class="text-center" >Service</th>
                                    <th scope="col" class="text-center" >Availability</th>
                                    <th scope="col" class="text-center ">Action</th>
                                </tr>
                            </thead>
                        
                            <tbody class="text-center">
                            
                                @foreach($services as $service)
                                <div >
                                    <tr class="text-center ">

                                    
                                    <td class="" > 
                                        {{-- <button class="btn btn-sm btn-warning mt-2 mt-lg-0  w-100 edit_service_field" value="{{$service->id}}">Edit</button> --}}
                                        <button class="btn btn-info btn-sm max-width:200px mt-2  edit_service_field bi bi-eye" value="{{$service->id}}">
                                        
                                        </button>
                                        
                                    </td>
                                    <td >{{$service->id}}</td>
                                    <td >{{$service->service}}</td>
                                    <td class="">
                                        <div class="">
                                            @if($service->availability == "Yes")
                                                <button class="btn btn-sm mt-3 mt-lg-0 bi bi-circle-fill green-color" style="pointer-events: none;"></button>
                                            @else
                                                <button class="btn btn-sm  mt-3 mt-lg-0 bi bi-circle-fill red-color" style="pointer-events: none;"></button>
                                                
                                            @endif
                                        </div>

                                    </td>


                                    <td scope="row" class="d-sm-flex justify-content-center">
                                        
                                        {{-- <button class="btn btn-sm btn-warning mt-2 mt-lg-0 ml-lg-1 w-100 edit_btn" value="{{$service->id}}">Edit</button> --}}
                                        <button class="btn btn-sm btn-success mt-2 edit_btn" value="{{$service->id}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </button>
                                    {{-- <button class="btn btn-sm btn-danger mt-2 mt-lg-0 ml-lg-1 w-100 delete_service" value="{{$service->id}}">Delete</button> --}}
                                    <button class="btn btn-sm btn-danger mt-2 mt-lg-2 ml-lg-1 delete_service" value="{{$service->id}}">
                                    
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                                </svg>
                                    </button>
                                    </td>
                                    </tr>
                                  
                            </div>
                            @endforeach

                          


                            
                             
                                 
                            </tbody>
                            <div>
                                <tr >
                                    
                                </tr>
                            </div>
                         
                        </table>
                    </div>
                </div>
                <div id="add_btn_all" style="display: none" class="container">
                    <div class="row justify-content-end">
                        <button class="col col-12 col-lg-2 btn btn-sm add_vaccine_btn mt-5 mb-2  btn-primary bi bi-plus-circle" style="width:170px;"> Add Service Categories</button>
                    </div>
                </div>   
        
                <div class="card shadow-sm" id="vaccine_category_div" style="display: none">
                    <div class=" card-header text-center p-3 font-weight-bold  bg-semi-grey">
                        Vaccine Table
                        
                    </div>
                    <div class="card-body ">
                        <div id="vaccine_table" style="display: " class="">
                            <div class="table-responsive mb-4">
                                
                                <table class="table table-hover table-striped" id="vaccine_table_data">
                                    <thead class="" >
                                    <tr >
                                    <th scope="col"  class="text-center col-3" >Vaccine ID</th>
                                    <th scope="col"  class="text-center col-3" >List of Category</th>
                            
                                    <th scope="col"  class="text-center col-3" >Availability</th>
                                    <th scope="col" class="text-center col-3" >Action</th>
            
                                    </tr>
                                </thead>
                                <tbody class="text-center" >
                            
                                @foreach($categories as $category)
                                    <tr class="text-center">
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->category}}</td>
                                    <td class="">
                                        <div class="">
                                            @if($category->category_availability == "Yes")
                                                <button class="btn btn-sm mt-3 mt-lg-0 bi bi-circle-fill green-color" style="pointer-events: none;"></button>
                                                
                                            

                                            @else
                                                <button class="btn btn-sm  mt-3 mt-lg-0 bi bi-circle-fill red-color" style="pointer-events: none;"></button>
                                                
                                            @endif
                                        </div>
                                       
                                    
                                    </td>
                                    <td scope="row" class="d-sm-flex justify-content-center">
                                                
                                        {{-- <button class="btn btn-sm btn-warning mt-2 mt-lg-0 ml-lg-1 w-100 edit_category" value="{{$category->id}}">Edit</button> --}}
                                            <button class="btn btn-sm btn-success mt-2 mt-lg-0 ml-lg-1 edit_category bi bi-pencil-square" value="{{$category->id}}">
                                               
                                            </button>
                                        
                                    {{-- <button class="btn btn-sm btn-danger mt-2 mt-lg-0 ml-lg-1 w-100 delete_category " value="{{$category->id}}">Delete</button> --}}
                                    <button class="btn btn-sm btn-danger mt-2 mt-lg-0 ml-lg-1 delete_category bi bi-trash3" value="{{$category->id}}"></button>

                                    </td>
                                        
                                    </tr>
                            @endforeach
                                </tbody>
                            </table> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mt-5" id="vaccine_div" style="display: none">
                    <div class=" card-header text-center p-3 font-weight-bold  bg-semi-grey">
                         Vaccine Table

                    </div>
                    <div class="card-body table-responsive">
                        <div id="vaccine_table" style="display: " class="table-responsive">
                            <div class="table-responsive mb-4">
            
                                <table class="table table-hover table-striped  mt-5" id="vaccine_table_sub_categories">
                                
                                    <thead class=" mt-5 " >
                                        <tr >
                                        
                                            <th scope="col"  class="text-center">Category</th> 
                                            <th scope="col"  class="text-center" style="">Vaccine</th> 
                                            <th scope="col"  class="text-center" style="">Available Slot</th> 
                                            <th scope="col"  class="text-center" style="">Availability</th> 
                                            <th scope="col" class="text-center " style="">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-center" >
                                   
                                        @foreach($vaccines_kids as $vaccine)
                                        <tr class="text-center">
                                        <td>{{$vaccine->category}}</td>
                                        <td>
                                            @if($vaccine->dose !== null)

                                                @if($vaccine->dose == 1)
                                                    1st dose ,
                                                @elseif($vaccine->dose == 2 )
                                                    2nd dose , 
                                                @elseif ($vaccine->dose == 3)
                                                    Booster , 
                                                @endif
                                            @endif
                                            {{$vaccine->vaccine_type}}</td>
                                        <td>{{$vaccine->vaccine_slot}}</td>

                                        <td class="">
                                            <div class="">
                                                @if($vaccine->vaccine_availability == "Yes")
                                                    <button class="btn btn-sm mt-3 mt-lg-0 bi bi-circle-fill green-color" style="pointer-events: none;"></button>
                                                    
                                                

                                                @else
                                                    <button class="btn btn-sm  mt-3 mt-lg-0 bi bi-circle-fill red-color" style="pointer-events: none;"></button>
                                                    
                                                @endif
                                            </div>
                                        
                                        
                                        </td>
                                        <td scope="row" class="d-sm-flex justify-content-center">
                                                    
                                            <button class="btn btn-sm btn-success mt-2 mt-lg-0 edit_vaccine bi bi-pencil-square" value="{{$vaccine->id}}"></button>
                                        <button class="btn btn-sm btn-danger mt-2 mt-lg-0 ml-lg-1 delete_vaccine bi bi-trash3" value="{{$vaccine->id}}"> </button>
                                        </td>
                                        
                                        </tr>
                                    @endforeach

                          
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
               
              
                <div class="card mt-5 shadow-sm mt-5" id="other_service_div" style="display:none;">
                    <div class=" card-header text-center p-3 font-weight-bold  bg-semi-grey ">
                        Other Services Table
                    </div>
                    <div class="card-body table-responsive mb-4">
                        <div id="others_table" class=" " style="">
                            <div class="" >
                            <div class="panel panel-default" >
                                <div class="panel-body">
                                </div>
                            </div> 
                            
                            <table class="table table-hover table-striped" id="others_table_data">
                                    <thead class="" >
                                    <tr >
                            
                                    <th scope="col" class="text-center" style="">Service They Belong</th>
                                    <th scope="col"  class="text-center" style=""><label id="other_services_title" name="other_services_title"></label>Other Serives</th>
                                    <th scope="col"  class="text-center" style=""><label id="other_services_title" name="other_services_title"></label>Available Slot</th>

                                    <th scope="col"  class="text-center" style=""><label id="" name="other_services_title"></label>Availability</th>
                                    <th scope="col" class="text-center" style="">Action</th>
            
                                    </tr>
                                </thead>
                                <tbody class="text-center" id="table_other_services" name="table_other_services">
                                    
                                    
                            


                                    @foreach($other_services as $value)
                                    <tr class="text-center">
                                 
                                    <td>{{$value->service}}</td>
                                    <td>{{$value->other_services}}</td>
                                    <td>{{$value->other_services_slot}}</td>

                                    <td class="">
                                        <div class="">
                                            @if($value->other_services_availability == "Yes")
                                                <button class="btn btn-sm mt-3 mt-lg-0 bi bi-circle-fill green-color" style="pointer-events: none;"></button>   
                                            @else
                                                <button class="btn btn-sm  mt-3 mt-lg-0 bi bi-circle-fill red-color" style="pointer-events: none;"></button>
                                                
                                            @endif
                                        </div>
                                       
                                    
                                    </td>
                                    <td scope="row" class="d-sm-flex justify-content-center">
                                            
                                        <button class="btn btn-sm btn-success mt-2 mt-lg-0 ml-lg-1
                                        edit_other_services bi bi-pencil-square" value="{{$value->id}}">
                                           
                                        </button>
                        
                                    <button class="btn btn-sm btn-danger mt-2 mt-lg-0 ml-lg-1 delete_other_services bi bi-trash3" value="{{$value->id}}">
                                    
                                          
                                        </button>
                                    </td>
                                        
                                    </tr>
                                    
                                @endforeach
                                 
                           
                                </tbody>
                            
                            </table>                 
                 
                            </div>
                        </div>
                    </div>	
                </div>
            
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> 

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>





</body>
</html>



<script>
    $(document).ready(function () {


        $(document).ready( function () {
            
            $('#service_table').DataTable();
        });

    $(document).ready( function () {
            $('#vaccine_table_data').DataTable();
        });

    $(document).ready( function () {
        $('#vaccine_table_sub_categories').DataTable();
    });

    $(document).ready( function () {
        
        $('#others_table_data').DataTable();
    });

    //     $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    //     });
        
    //     fetch_customer_data();

    //     function fetch_customer_data(query = ''){
    //         $.ajax({
    //             url: "{{route('live_search.action') }}",
    //             method: 'GET',
    //             data: {query:query},
    //             dataType: 'json',
    //             success: function (data) {
    //                 console.log(data);
    //                 $('#table_other_services').html(data.table_data);
    //                 $('#total_records').text(data.tota_data)
                    
    //             }
    //         });
    //     }

    //    $(document).on('keyup', '#search', function(){
    //     var query = $(this).val();
    //     fetch_customer_data(query);
    
      
    //     });
        
        $(document).on('click', '.edit_btn',function (e) {
            e.preventDefault();
            var service = $(this).val();
            console.log(service);
            // alert(service); 
            $('#edit_service_modal').modal('show');
            
            $.ajax({
                
                type: "GET",
                url: "/admin/edit_services/"+service,
                success: function (response) {
                    console.log(response);
                    $('#service_id').val(response.service.id)
                    $('#service').val(response.service.service)
                    $('#id').val(response.service.id)
            
                    // $('#radio').val(response.service.availability)
                     if(response.service.availability == "Yes"){
                   
                        $('#yesandno_service').find(':radio[name=choice_service][value="Yes"]').prop('checked', true);
                     }else{
                        $('#yesandno_service').find(':radio[name=choice_service][value="No"]').prop('checked', true);

                     }


                }
            });
        });

        
        //update - edit vaccine

        //field
        $(document).on('click', '.edit_service_field',function (e) {
            e.preventDefault();
            var  vaccine_table = document.getElementById("vaccine_table");
            var add_btn_all = document.getElementById("add_btn_all");

            var vaccine_category_div = document.getElementById("vaccine_category_div");
            var vaccine_div = document.getElementById("vaccine_div");
            var other_service_div = document.getElementById("other_service_div");

            var service = $(this).val();
            console.log(service);
            // others_table.style.display = "none";
            // alert(service); 
            if(service == "1" ){
                other_service_div.style.display = "none";
                vaccine_div.style.display = "block";
                vaccine_category_div.style.display="block";
                add_btn_all.style.display ="block";
                // var target_div = service;
              
                scrolldiv();

                function scrolldiv() {
                    window.scroll(0,findPosition(document.getElementById("add_btn_all")));
                }

                
            }
            else{
                add_btn_all.style.display ="block";
                other_service_div.style.display = "block";
                vaccine_div.style.display = "none";
                vaccine_category_div.style.display="none";
                
                scrolldiv();
                function scrolldiv() {
                    window.scroll(0,findPosition(document.getElementById("others_table")));
                }

            }
            
           
        });

     
        function findPosition(obj) {
            var currenttop = 0;
            if (obj.offsetParent) {
                do {
                currenttop += obj.offsetTop;
                } while ((obj = obj.offsetParent));
                return [currenttop];
            }
        }
     

        //name
        $(document).on('click', '.edit_vaccine',function (e) {
            e.preventDefault();
            var vaccine = $(this).val();
                // console.log(vaccine);
            // alert(service); 
            $('#edit_vaccine_modal').modal('show');
                $.ajax({

                    type: "GET",
                    url: "/admin/edit_vaccine/"+vaccine,
                    success: function (response) {
                       
                        // $('#id').val(response.vaccine.id)
                        $('#vaccine_del_id').val(response.vaccine_id.id);
                        $('#vaccine').val(response.vaccine_id.vaccine_type);
                        $('#update_vaccine_slot').val(response.vaccine_id.vaccine_slot);



                        if(response.vaccine_id.vaccine_availability == "Yes"){
        
                        $('#yesandno_vaccine').find(':radio[name=choice_vaccine][value="Yes"]').prop('checked', true);
                        }else{
                        $('#yesandno_vaccine').find(':radio[name=choice_vaccine][value="No"]').prop('checked', true);

                        }


                    }
                });
        });
        $(document).on('click', '.edit_other_services',function (e) {
            e.preventDefault();
            var other_services = $(this).val();
            console.log(other_services);
            // alert(service); 
            $('#edit_other_services_modal').modal('show');
            
            $.ajax({
                
                type: "GET",
                url: "/admin/edit_other_services/"+other_services,
                success: function (response) {
                    // console.log(response.service.service);
                    console.log(response);
                    $('#edit_other_services_input').val(response.other_services.other_services);
                    $('#edit_other_services_id').val(response.other_services.id);
                    $('#update_other_services_slot').val(response.other_services.other_services_slot);

                   
                    if(response.other_services.other_services_availability == "Yes"){
                        console.log("loggg");
                        $('#yesandno_other_services').find(':radio[name=choice_other_services][value="Yes"]').prop('checked', true);
                    }else{

                        $('#yesandno_other_services').find(':radio[name=choice_other_services][value="No"]').prop('checked', true);

                    }

                }
            });
        });

        //delete service
        $(document).on('click', '.delete_service',function (e) {
        e.preventDefault(); 
        var delete_service = $(this).val();
        $('#service_del_id').val(delete_service);
        $('#delete_service_modal').modal('show');
        
        });

        //delete vaccine
        $(document).on('click', '.delete_vaccine',function (e) {
        e.preventDefault(); 
        var delete_vaccine = $(this).val();
        $('#delete_vaccine_id').val(delete_vaccine);
        
         console.log(delete_vaccine);
        // alert(service); 
        $('#delete_vaccine_modal').modal('show');
        
        });

        $(document).on('click', '.delete_other_services',function (e) {
        e.preventDefault(); 
        var other_services = $(this).val();
        $('#delete_other_services_id').val(other_services);
        // alert(service); 
        $('#delete_other_services_modal').modal('show');
        
        });

        //add service
        $(document).on('click', '.add_service_btn',function (e) {
        e.preventDefault(); 
        $('#add_services_modal').modal('show');

        });

        //add service
        $(document).on('click', '.add_vaccine_btn',function (e) {
        e.preventDefault(); 
        $('#add_vaccine_modal').modal('show');

        });
       
        $("#vaccine_select").on('change',function(e){ 
            e.preventDefault(); 
            $("#add_vaccine_input").val(null);
            $("#add_others_service_slot").val(null);
            $("#add_vaccine_slot").val(null);
           
            var selected_vaccine = $(this).val();
      
            $('#add_vaccine_input_id').val(selected_vaccine);
            if( $(this).val() == 2 ){
                (document).getElementById("covid_field").style.display="block";
            }else{
                (document).getElementById("covid_field").style.display="none";
            }
            
        
        }).change();

       
        $("#service_select").on('change',function(e){ 
            e.preventDefault(); 
            $("#add_vaccine_category_input").val(null);
                $("#add_vaccine_input").val(null);
                $("#add_vaccine_slot").val(null);
                $("#add_other_services_input").val(null);
                $("#add_others_service_slot").val(null);

            var service_select_id = $(this).val();
           
            $('#service_select_id').val(service_select_id);
            var btn_add_vaccine_medicine = document.getElementById("btn_add_vaccine_medicine");
           
            $.ajax({

                type: "GET",
                url: "/admin/select_service/"+service_select_id,
                success: function (response) {
                    // $('#id').val(response.vaccine.id)
                    $('#vaccine_field_whole').show();
                    $('#other_services_field').show();
                    // $("#add_vaccine_category_input").prop('required',true);
                            $("#add_vaccine_category_input").prop('required',false);
                            $("#add_vaccine_input").prop('required',false);
                            $("#add_vaccine_slot").prop('required',false);
                            $("#add_other_services_input").prop('required',false);
                            $("#add_others_service_slot").prop('required',false);

                    if(response.service_id != null){
                        if (response.service_id.id =="1") {
                            $('#vaccine_field_whole').show();
                            $('#other_services_field').hide();

                            btn_add_vaccine_medicine.style.display="block";

                            $("#add_vaccine_category_input").prop('required',true);
                            $("#add_vaccine_input").prop('required',false);
                            $("#add_vaccine_slot").prop('required',false);
                            $("#add_other_services_input").prop('required',false);
                            $("#add_others_service_slot").prop('required',false);

                        }else if(response.service_id.id =="2"){

                                     //required
                            $("#add_vaccine_category_input").prop('required',false);
                            $("#add_vaccine_input").prop('required',false);
                            $("#add_vaccine_slot").prop('required',false);
                            $("#add_other_services_input").prop('required',true);
                            $("#add_others_service_slot").prop('required',true);


                            $('#add_other_services_input_id').val(response.service_id.id);
                            $('#other_services_field').show();
                            $('#add_sub_of_service').text("Add "+response.service_id.service);
                            $('#vaccine_field_whole').hide();
                            $('#vaccine_field_whole').hide();
                            
                            btn_add_vaccine_medicine.style.display="block";

                            console.log("kk");
                   
                            
                        }
                        else if(response.service_id.id =="3"){

                                                        //required

                              $('#add_sub_of_service').text("Add "+response.service_id.service);
                            $("#add_vaccine_category_input").prop('required',false);
                            $("#add_vaccine_input").prop('required',false);
                            $("#add_vaccine_slot").prop('required',false);
                            $("#add_other_services_input").prop('required',true);
                            $("#add_others_service_slot").prop('required',true);


                            $('#add_other_services_input_id').val(response.service_id.id);
                            $('#vaccine_field_whole').hide();
                            $('#other_services_field').show();

                            
                            
                        }else{
                             //required
                             $("#add_vaccine_category_input").prop('required',false);
                            $("#add_vaccine_input").prop('required',false);
                            $("#add_vaccine_slot").prop('required',false);
                            $("#add_other_services_input").prop('required',true);
                            $("#add_others_service_slot").prop('required',true);


                            $('#add_other_services_input_id').val(response.service_id.id);
                            $('#vaccine_field_whole').hide();

                            $('#other_services_field').show();
                            $('#add_sub_of_service').text("Add "+response.service_id.service);

                           
                            

                        }
                    }else{
                        $('#vaccine_field_whole').hide();
                        $('#other_services_field').hide();

                    }
                    
                  
                }
                });
     
        }).change();

        $("#column_select").on('change',function(e){ 
            e.preventDefault(); 
            var selected_column = $(this).val();

            
                $("#add_vaccine_category_input").val(null);
                $("#add_vaccine_input").val(null);
                $("#add_vaccine_slot").val(null);
                $("#add_other_services_input").val(null);
                $("#add_others_service_slot").val(null);

            if (selected_column == "category"){
                $('#vaccine_field').hide();
                $('#category_field').show();
                 $("#add_vaccine_category_input").prop('required',true);
                 $("#add_vaccine_input").prop('required',false);
                 $("#add_vaccine_slot").prop('required',false);
                 $("#add_other_services_input").prop('required',false);
                 $("#add_others_service_slot").prop('required',false);
            

            }else if (selected_column == "vaccine_type"){
                $('#vaccine_field').show();
                $('#category_field').hide();
                $("#add_vaccine_category_input").prop('required',false);
                 $("#add_vaccine_input").prop('required',true);
                 $("#add_vaccine_slot").prop('required',true);
                 $("#add_other_services_input").prop('required',false);
                 $("#add_others_service_slot").prop('required',false);
            }else{
                $('#vaccine_field').hide();
                $('#category_field').hide();
            }
        }).change();
        

        //edit category
        $(document).on('click', '.edit_category',function (e) {
        e.preventDefault(); 
    
            var edit_category = $(this).val();
          
            
        $('#edit_category_modal').modal('show')

            $.ajax({

                type: "GET",
                url: "/admin/edit_category/"+edit_category,
                success: function (response) {
                    // $('#id').val(response.vaccine.id)
                    console.log(response);
                    $('#category_update_id').val(response.category_id.id);
                    $('#old_id').val(response.category_id.id);
                    $('#category_update').val(response.category_id.category);
                    $('#service_update_id').val(response.category_id.service_id);
           

                    if(response.category_id.category_availability == "Yes"){
                        $('#yesandno_category').find(':radio[name=choice_category][value="Yes"]').prop('checked', true);
                    }else{
                        $('#yesandno_category').find(':radio[name=choice_category][value="No"]').prop('checked', true);
                    }
                }
            });
        });
      
        $(document).on('click', '.delete_category',function (e) {
            e.preventDefault();
            var delete_category_id =$(this).val();
            $('#delete_category_modal').modal('show');
            $('#category_del_id').val(delete_category_id);
        });

        $("#yesandno").on('change',function(e){ 
            e.preventDefault(); 
           
           console.log($('#radio:checked').val());
        }).change();

    });
</script>
</x-app-layout>
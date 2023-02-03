<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <title>Document</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/customize.css') }}" >
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
      </head>
    <body>
    
      
      <div class="container-fluid text-center  pt-5  pb-3 p-lg-5 mt-4 mb-4 ">
        <h3 class="fw-bolder bg-dark bg-opacity-10 text-light p-4">APPOINTMENT HISTORY</h3>
    </div>
      
      <div class="container-fluid col-12 col-lg-8" style="height:100%;">
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
            @endif
          </div> 
          
            <div class="container-fluid shadow mb-5" style="">
                 <div class="card-body col-12 table-responsive ">
                    <table class="table table-hover w-100" id="history_table_data" >
                    
                      <thead>
                          <tr class="text-center">
                            <th class="text-center">Service</th>
                            <th scope="col" class="text-center"> Category</th>
                            <th scope="col" class="text-center">Vaccine</th>
                            <th scope="col" class="text-center">Apointment Date</th>
                            <th scope="col" class="text-center">Status</th>
                      
                          </tr>
                      </thead>
                      <tbody>
                  
                          
                                  @foreach($appointmentss as $value)
                                    <tr class="text-center ">
                                    <td >{{$value->appointment_services}}</td>
                                    <td >{{$value->appointment_vaccine_category}}</td>
                                  
                                      @if($value->appointment_dose !== null)
                                         
                                      @endif
                                    
                                    <td >
                                      @if($value->appointment_dose !== null)
                                         @if($value->appointment_dose == "1")
                                          1st dose,
                                          @elseif($value->appointment_dose == "2")
                                          2nd dose,
                                          @elseif($value->appointment_dose == "3")
                                          Booster,
                                           @endif
                                      @endif

                                      {{$value->appointment_vaccine_type}}</td>
                                    <td >{{$value->appointment_date}}</td>
                                    <td >
                                      @if($value->appointment_status == "success")
                                      <small class="bg-success p-1 rounded text-white">   {{$value->appointment_status}}</small>
                                      @elseif($value->appointment_status == "expired")
                                      <small class="color-orange p-1 rounded text-white">   {{$value->appointment_status}}</small>
                                      @elseif($value->appointment_status == "pending")
                                      <small class="bg-warning p-1 rounded text-white">   {{$value->appointment_status}}</small>
                                      @elseif($value->appointment_status == "canceled")
                                      <small class="bg-danger p-1 rounded text-white">   {{$value->appointment_status}}</small>

                                      @endif
                                    
                                    </td>
                                    </tr>
                                 @endforeach
                       
                      </tbody>
              </table> 
            </div>
            
         
          </div>
      </div>
    
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
  </body>
    </html>
    
    
    
    <script>
        $(document).ready(function () {
          // var id = null;
          //   $(document).on('change','#sortby_history',function(e){
          //     e.preventDefault();
             
          //     id = $(this).val();
          //    console.log(id);
          //    var_dump():
          //     $.ajax({
          //         type: "GET",
          //         url: "/history/"+id,
          //         success: function (response) {
          //             // console.log(response);  
          //             // console.log(response.vaccine);
          //             // $('#available_slot').val(response.pediatic);
          //             // $('#availableslot').text(response.pediatic);
          //         }
          //     });
          //   });

          
        $(document).ready( function () {
            $('#history_table_data').DataTable();
        });
  });
    </script>
    </x-app-layout>
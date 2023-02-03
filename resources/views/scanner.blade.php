<x-app-layout> 
    <!DOCTYPE html>
    <html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <title>Document</title>

        {{-- <script type="text/javascript" src="{{ asset('instascan.min.js') }}" ></script> --}}

    </head>
    <body>
    
      <!-- modal view-->
    
    
    <!-- Modal -->
    <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header mb-2 mt-4" >
            <p class="text-center">
              <h5>
               <small class="font-weight-light ">IDENTIFICATION CARD</small>
              </h5>
             
              
            </p>
          </div>
          <div class="modal-body">
            <div class="container">
             
              <div class="row">
                <input type="text" id="image_id" name="image_id" hidden>
                {{-- <input type="text" id="image" name="image"> --}}
                <img id="view_image" src="" alt=".." class="w-100 h-75" >
                {{-- <img src="storage/images/dsgLLgapwjZkOGRWmspJX9t2vIbnnv2kJaYWvEYq.jpg" alt=".." > --}}
              </div>
              <div class="row d-flex justify-content-center mt-4 mb-2">
                <div class="text-center">
                  <div class="row">
                    ID type:<p id="id_type" class="text-center ml-2 font-weight-bold text-lowercase h5"></p></p>
                  </div>
        
    
                </div>
              </div>
              
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
      <!-- modal delete-->
      <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
    
            <form action="{{ route ('admin.delete_registration') }} " method="POST">
                @csrf
               
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="text"  id="del_id" name="del_id" >
              Are you sure you want to delete this registration?
            </div>
            <div class="modal-footer">
             
              <button type="submit" class="btn btn-primary delete_btn btn-sm w-25">Yes</button>
              <button type="button" class="btn btn-secondary btn-sm w-25" data-dismiss="modal">No</button>
            </div>
             </form>
    
          </div>
        </div>
      </div>
    <!-- reject modal -->
    
      <div class="modal fade" id="reject_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
    
            <form action="{{ route ('admin.reject_registration') }} " method="POST">
                @csrf
              
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="text"  id="reject_id" name="reject_id" hidden>
            
              Are you sure you want to reject this registration?
            </div>
            <div class="modal-footer">
             
              <button type="submit" class="btn btn-primary reject_btn btn-sm w-25">Yes</button>
              <button type="button" class="btn btn-secondary btn-sm w-25" data-dismiss="modal">No</button>
            </div>
             </form>
    
          </div>
        </div>
      </div>
    
    
         <!-- approve modal -->
    
    <div class="modal fade" id="approve_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
    
            <form action="{{ route('admin.approve_registration') }} " method="POST">
                @csrf
               
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="text"  id="approve_id" name="approve_id" hidden>
            
              Are you sure you want to approve this registration?
            </div>
            <div class="modal-footer">
             
              <button type="submit" class="btn btn-primary approve_btn btn-sm w-25">Yes</button>
              <button type="button" class="btn btn-secondary btn-sm w-25" data-dismiss="modal">No</button>
            </div>
             </form>
    
          </div>
        </div>
      </div>
      

   

      
{{--     
        <div class="container-fluid mt-5 mb-5 table-responsive w-100" >
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
        </div> --}}

    
          <div class="container mt-5" >
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
          <div class="card w-70" style="margin-top: 100px 150px;" >
            
                {{-- <h4>Verify Appointment</h4> --}}
            
                    
              <div class="card-body rounded">
                <div class="row">
                  <div class="col col-12 d-flex justify-content-center mt-4">
                    <h5>Scan QR Code</h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 mb-1 mt-2">
                    <div class="row justify-content-center">
                      <div class="mr-1">
                        <button type="button" onclick="initQrCodeScanner()" class="btn btn-primary btn-sm scan1 bi bi-camera-video" style="width:50px"></button>
                      </div>
                      <div class="">
                        <button type="button" class="btn btn-danger btn-sm  cancel bi bi-camera-video-off " style="width:50px" id="cancel"></button>  
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col col-12 col-lg-4 mt-4">
                    <video id="preview" class="w-100 border " style="height: 250px;">
                    </video>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                  <label class="btn btn-primary btn-sm active">
                    <input type="radio" name="options"  value="1" autocomplete="off" checked> Front Camera
                  </label>
                  <label class="btn btn-secondary btn-sm">
                    <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
                  </label>
                </div>
              </div>
              


  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">
 
    </script>


                <div class="row" id="display_verification" style="display:none" name="">
                  <div class="col col-12 col-lg-5 mx-auto  d-flex justify-content-center mt-5">
                    {{-- <input type="text" id="appointment_id_hidden" name="appointment_id_hidden" hidden >
                    <input type="text" id="user_id" name="user_id_hidden"  hidden> --}}
                  
                    @if(Auth::User()->account_type=='admin')
                      <form action="{{route('verify_appointment') }}" method="POST" class="w-100  mb-5 border  rounded mx-3 ">
                    @else
                    <form action="{{route('verify_appointment_staff') }}" method="POST" class="w-100  mb-5 border  rounded mx-3 ">
                    @endif 
                        @csrf
                        {{ csrf_field() }}
                        <input type="text" id="user_contactnumber" name="user_contactnumber" hidden > 
                        <input type="text" id="appointment_id_hidden" name="appointment_id_hidden" hidden> 
                        <input type="text" id="appointment_date_hidden" name="appointment_date_hidden" hidden> 
                        <input type="text" id="user_contactnumber_hidden" name="user_contactnumber_hidden" hidden> 
                        <input type="text" id="appointment_services_hidden" name="appointment_services_hidden" hidden> 
                        <input type="text" id="appointment_services_id_hidden" name="appointment_services_id_hidden" hidden> 
                        <input type="text" id="user_email_hidden" name="user_email_hidden" hidden> 

                        <div class="row justify-content-center">
                      
                        </div>
                        <fieldset disabled class=" p-5 ">
                         
                          {{-- <div class="form-group">
                            <label for="appointment_id">User ID</label>
                            <input type="text" id="user_id" name="user_id" class="form-control">
                          </div> --}}
                          <div class="form-group">
                            <label for="appointment_id" class="font-weight-bold">Email: </label>
                            {{-- <p id="user_email" name="user_email">oliver@gmail.vom</p> --}}
                            <input type="text" id="user_email" name="user_email" class="form-control">
                          </div>
                          {{-- <div class="form-group">
                            <label for="appointment_id">Appointment ID</label>
                            <input type="text" id="appointment_id" name="appointment_id" class="form-control">
                          </div> --}}
                          <div class="form-group">
                            <label for="disabledTextInput" class="font-weight-bold">Service: </label>
                            {{-- <p id="appointment_services" name="appointment_services">oliver@gmail.vom</p> --}}

                            <input type="text" id="appointment_services" name="appointment_services" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="disabledTextInput" class="font-weight-bold">Appointment Date: </label>
                            {{-- <p id="appointment_date" name="appointment_date">oliver@gmail.vom</p> --}}
                            
                            <input type="text" id="appointment_date" name="appointment_date" class="form-control">
                          </div>
                        </fieldset>
                            <div class="row d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary btn-sm w-25 mb-4 bi bi-check2-circle"> Verify</button>
                            </div>
                      </form>
                  </div>
                </div>
              </div>
          </div>
     
    
    
     {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>  --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
    </html>
    
    
    @if(Auth::User()->account_type=='admin')
      <script>
            //  const Instascan = require('instascan');

            
            // $(document).ready(function () {

          

            //   let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            //   scanner.addListener('scan', function (content) {
            //     console.log(content);
            //   });
            //   Instascan.Camera.getCameras().then(function (cameras) {
            //     if (cameras.length > 0) {
            //       scanner.start(cameras[0]);
            //     } else {
            //       console.error('No cameras found.');
            //     }
            //   }).catch(function (e) {
            //     console.error(e);
            //   }); 



            //     $(document).on('click', '.approve',function (e) {
            //         e.preventDefault(); 
            //         var approve = $(this).val();
            //         var btn_type = "approved";
                    
                    
            //         $('#btn_type').val(btn_type);
            //         $('#approve_id').val(approve);
                  
            //         // console.log(approve);
            //         // alert(service); 
            //         $('#approve_modal').modal('show');
                    
            //         });
        
            //         $(document).on('click', '.rejected',function (e) {
            //         e.preventDefault(); 
            //         var rejected = $(this).val();
            //         var btn_type = "rejected";
                    
                    
                
            //         $('#reject_id').val(rejected);
        
            //         // $('#email').val(btn_type);
        
                    
            //         // $('#approve_id').val(approve);
                  
            //         // console.log(btn_type);
            //         // alert(service); 
            //         $('#reject_modal').modal('show');
                    
            //         });
        
            //         $(document).on('click', '.delete',function (e) {
            //         e.preventDefault(); 
            //         var del = $(this).val();
            //         // var btn_type = "rejected";
                    
                    
            
            //         $('#del_id').val(del);
        
            //         // $('#email').val(btn_type);
        
                    
            //         // $('#approve_id').val(approve);
                  
            //         // console.log(btn_type);
            //         // alert(service); 
            //         $('#delete_modal').modal('show');
                    
            //         });
        
            //         $(document).on('click', '.view',function (e) {
            //           e.preventDefault();
            //           var identification = $(this).val();
        
            //           $('#view_modal').modal('show');
            //           //  $('#image_id').val(identification);
        
            //             $.ajax({
                        
            //             type: "GET",
            //             url: "/view_identification/"+identification,
            //              success: function (response) {
            //                 // console.log(response);
            //                 $('#image').val(response.identification.identification)
            //           cyan      $('#image_id').val(response.identification.id)
            //                 $('#id_type').text(response.identification.identificationtype);
            //                 $('#view_image').attr('src', 'storage/'+response.identification.identification);
            //             }, error: function(error) {
            //                console.log(error);
                        
            //     }
            //         });
                      
            //         });
                
            // });
        

                    function initQrCodeScanner(){

                          var cancel = document.getElementById('cancel');
                          var x = document.getElementById("preview");
                          var display_verification = document.getElementById("display_verification");


                          if (x.style.display == "none") {
                            x.style.display = "block";
                          }
                          
                          let opts = {
                            video: document.getElementById('preview'),
                           
                          }
                          
                          let scanner = new Instascan.Scanner(opts);

                        
                          
                          Instascan.Camera.getCameras().then(function (cameras){
                        if(cameras.length>0){
                            scanner.start(cameras[0]);
                            $('[name="options"]').on('change',function(){
                                if($(this).val()==1){
                                    if(cameras[0]!=""){
                                        scanner.start(cameras[0]);
                                    }else{
                                        alert('No Front camera found!');
                                    }
                                }else if($(this).val()==2){
                                    if(cameras[1]!=""){
                                        scanner.start(cameras[1]);
                                    }else{
                                        alert('No Back camera found!');
                                    }
                                }
                            });
                        }else{
                            console.error('No cameras found.');
                            alert('No cameras found.');
                        }
                    }).catch(function(e){
                        console.error(e);
                        alert(e);
                    });

          

                          scanner.addListener('scan', content => {
                            // scanner.stop();
                            console.log(content);

                                $.ajax({
                                  type: "GET",
                                  url: "/admin/admin_get_appointment_id/"+content,
                                  success: function (response) {
                                      console.log(response);
                                
                                      console.log(response.valid);
                                      if(response.valid == "1"){
                                          var len = 0;
                                          if(response['data'] != null){
                                        
                                              
                                              len = response['data'].length;
                                              
                                              if(len > 0){
                                                for(var i=0; i<1; i++){
                                                      display_verification.style.display = "block";
                                                      $('#appointment_id').val(response['data'][i].appointment_id);
                                                      $('#appointment_id_hidden').val(response['data'][i].appointment_id);
                                                      $('#appointment_id_hidden').val(response['data'][i].appointment_id);
                                                      $('#appointment_services').val(response['data'][i].appointment_services);
                                                      $('#appointment_services_hidden').val(response['data'][i].appointment_services);
                                                      $('#appointment_services_id_hidden').val(response['data'][i].service_id);


                                                      $('#appointment_date').val(response['data'][i].appointment_date);
                                                      $('#appointment_date_hidden').val(response['data'][i].appointment_date);

                                                      $('#user_id').val(response['data'][i].user_id);
                                                      // $('#user_contactnumber').val(response['data'][i].user_contactnumber);
                                                      // $('#user_contactnumber_hidden').val(response['data'][i].user_contactnumber);
                                                      $('#user_email').val(response['data'][i].email);
                                                      $('#user_email_hidden').val(response['data'][i].email);

                                                        console.log(response['data'][i].email);
                                                          Swal.fire({
                                                          icon: 'success',
                                                          title: 'Appointment Found!',
                                                          showConfirmButton: false,
                                                          timer: 1500
                                                        })
                                                        scanner.stop();
                                                        
                                                      }
                                                    // x.style.display = "none";
                                                  }else{
                                                    Swal.fire({
                                                      icon: 'error',
                                                      title: 'Appointment Not Found',
                                                      text: 'no existing record.',
                                                      showConfirmButton: false,
                                                      timer: 1500
                                                
                                                    })

                                                        scanner.stop();
                                                      display_verification.style.display = "none";
                                                    console.log("dito");
                                                  }
                                              
                                          }
                                      }else if(response.valid == "2"){
                                        Swal.fire({
                                                    icon: 'error',
                                                    title: 'Appointment Not Found',
                                                    text: 'appointment is not today.',
                                              
                                                  })

                                                  scanner.stop();
                                              display_verification.style.display = "none";

                                      }else if(response.valid == "0"){
                                        Swal.fire({
                                                    icon: 'error',
                                                    title: 'Appointment Not Found',
                                                    text: 'no existing record.',
                                              
                                                  })

                                                  scanner.stop();
                                              display_verification.style.display = "none";
                                      }


                                      
                                      
                                    
                                  }, error: function(error) {
                                    console.log(error);
                                    }
                                });


                          
                        
                        });
                      
                          cancel.addEventListener('click', function () {
                            scanner.stop();
                            display_verification.style.display = "none";

                          });
                
                  };  
            
                
            
        
      </script>
    @elseif(Auth::User()->account_type=='staff')
      <script>
        
        function initQrCodeScanner(){

var cancel = document.getElementById('cancel');
var x = document.getElementById("preview");
var display_verification = document.getElementById("display_verification");


if (x.style.display == "none") {
  x.style.display = "block";
}

let opts = {
  video: document.getElementById('preview'),
 
}

let scanner = new Instascan.Scanner(opts);



Instascan.Camera.getCameras().then(function (cameras){
if(cameras.length>0){
  scanner.start(cameras[0]);
  $('[name="options"]').on('change',function(){
      if($(this).val()==1){
          if(cameras[0]!=""){
              scanner.start(cameras[0]);
          }else{
              alert('No Front camera found!');
          }
      }else if($(this).val()==2){
          if(cameras[1]!=""){
              scanner.start(cameras[1]);
          }else{
              alert('No Back camera found!');
          }
      }
  });
}else{
  console.error('No cameras found.');
  alert('No cameras found.');
}
}).catch(function(e){
console.error(e);
alert(e);
});



scanner.addListener('scan', content => {
  // scanner.stop();
  console.log(content);

      $.ajax({
        type: "GET",
        url: "/staff/staff_get_appointment_id/"+content,
        success: function (response) {
            console.log(response);
      
            console.log(response.valid);
            if(response.valid == "1"){
                var len = 0;
                if(response['data'] != null){
              
                    
                    len = response['data'].length;
                    
                    if(len > 0){
                      for(var i=0; i<1; i++){
                            display_verification.style.display = "block";
                            $('#appointment_id').val(response['data'][i].appointment_id);
                            $('#appointment_id_hidden').val(response['data'][i].appointment_id);
                            $('#appointment_id_hidden').val(response['data'][i].appointment_id);
                            $('#appointment_services').val(response['data'][i].appointment_services);
                            $('#appointment_services_hidden').val(response['data'][i].appointment_services);
                            $('#appointment_services_id_hidden').val(response['data'][i].service_id);


                            $('#appointment_date').val(response['data'][i].appointment_date);
                            $('#appointment_date_hidden').val(response['data'][i].appointment_date);

                            $('#user_id').val(response['data'][i].user_id);
                            // $('#user_contactnumber').val(response['data'][i].user_contactnumber);
                            // $('#user_contactnumber_hidden').val(response['data'][i].user_contactnumber);
                            $('#user_email').val(response['data'][i].email);
                            $('#user_email_hidden').val(response['data'][i].email);

                              console.log(response['data'][i].email);
                                Swal.fire({
                                icon: 'success',
                                title: 'Appointment Found!',
                                showConfirmButton: false,
                                timer: 1500
                              })
                              scanner.stop();
                              
                            }
                          // x.style.display = "none";
                        }else{
                          Swal.fire({
                            icon: 'error',
                            title: 'Appointment Not Found',
                            text: 'no existing record.',
                            showConfirmButton: false,
                            timer: 1500
                      
                          })

                              scanner.stop();
                            display_verification.style.display = "none";
                          console.log("dito");
                        }
                    
                }
            }else if(response.valid == "2"){
              Swal.fire({
                          icon: 'error',
                          title: 'Appointment Not Found',
                          text: 'appointment is not today.',
                    
                        })

                        scanner.stop();
                    display_verification.style.display = "none";

            }else if(response.valid == "0"){
              Swal.fire({
                          icon: 'error',
                          title: 'Appointment Not Found',
                          text: 'no existing record.',
                    
                        })

                        scanner.stop();
                    display_verification.style.display = "none";
            }


            
            
          
        }, error: function(error) {
          console.log(error);
          }
      });




});

cancel.addEventListener('click', function () {
  scanner.stop();
  display_verification.style.display = "none";

});

};  
            
        
    
      </script>
    @endif
</x-app-layout>
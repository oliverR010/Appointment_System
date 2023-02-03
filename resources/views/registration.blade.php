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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
      
      <title>Document</title>
      <link rel="stylesheet" type="text/css" href="{{ asset('css/customize.css') }}" >
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
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
            <img id="view_image" src="" alt="Image" class="w-100 h-50" >
            {{-- <img src="{{ asset('/storage/')}}" > --}}
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
          {{ csrf_field() }}
           
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text"  id="del_id" name="del_id" hidden>
          Are you sure you want to delete this registration?
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-danger delete_btn btn-sm w-25">Yes</button>
          <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">No</button>
        </div>
         </form>

      </div>
    </div>
  </div>

  <!-- Modal delete workers -->
  <div class="modal fade" id="delete_workers_account_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route ('delete_workers_account') }} " method="POST">
          @csrf
          {{ csrf_field() }}
           
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text"  id="del_user_id" name="del_user_id" hidden>
          Are you sure you want to delete this Account?
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
            {{ csrf_field() }}
          
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text"  id="reject_id" name="reject_id" hidden>
        
          Are you sure you want to reject this registration?
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-danger reject_btn btn-sm w-25">Yes</button>
          <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">No</button>
        </div>
         </form>

      </div>
    </div>
  </div>


     <!-- approve modal -->

<div class="modal fade" id="approve_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route ('admin.approve_registration') }} " method="POST">
          @csrf
          {{ csrf_field() }}
           
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text"  id="approve_id" name="approve_id" hidden>
        
          Are you sure you want to approve this registration?
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-danger approve_btn btn-sm w-25">Yes</button>
          <button type="button" class="btn btn-primary btn-sm w-25" data-dismiss="modal">No</button>
        </div>
         </form>

      </div>
    </div>
  </div>
  <div class="container-fluid text-center  pt-5  pb-3 p-lg-5 mt-4 mb-4 ">
    <h3 class="fw-bolder bg-dark bg-opacity-10 text-light p-4
    ">RESIDENTS</h3>
  </div>
  
  <div class="container-fluid col-12 col-lg-10" style="height:100%;">
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
      <div class="container-fluid">

        <div class="row">
          {{-- accounts table --}}
          <div class="col col-12 col-lg-12">
              <div class="card shadow-sm mb-5" style="">
                <div class=" card-header text-center p-3 font-weight-bold bg-semi-grey">
                  Residents Table
                </div>
       
                <div class="card-body table-responsive">
                  <table class="table table-hover w-100"  id="reistration_data" >
                    <thead>
                        <tr class="text-center">
                          <th scope="col" style="width:5%" class="text-center">Email</th>
                          <th scope="col" style="width:10%"  class="text-center" >Fullname</th>
                          <th scope="col"  style="width:10%" class="text-center" >Age</th>
                          <th scope="col"  style="width:10%" class="text-center" >Gender</th>
                          <th scope="col"  style="width:10%" class="text-center" >Birthdate</th>
                          <th scope="col"  style="width:10%" class="text-center" >Address</th>
                          <th scope="col"  style="width:10%" class="text-center">Contact No</th>
                          <th scope="col"  style="width:10%" class="text-center" >ID</th>
                          <th scope="col"  style="width:10%" class="text-center" >Status</th>
                          <th scope="col"  style="width:10%" class="text-center" style="width: 200px" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                        @if ($data->account_type!="admin" )
                        <tr class="text-center">
                        <td>{{$data->email}}</td>
                        <td>{{$data->lastname}},{{$data->firstname}} {{$data->middlename}}</td>
                        <td>{{$data->age}}</td>
                        <td>{{$data->gender}}</td>
                        <td>{{$data->birthdate}}</td>
                        <td>{{$data->address}}, Barangay{{$data->barangay}}</td>
                        <td>{{$data->contactnumber}}</td>
                        <td> <button class="btn btn-sm btn-info view bi bi-eye" value="{{$data->id}}">
                          </button>
                        </td>
                        
                        <td>
                          @if($data->status == "approved")
                          <small class="bg-success px-1 rounded text-white">   {{$data->status}}</small>
                          @elseif($data->status == "pending")
                          <small class="bg-warning px-1 rounded text-dark">   {{$data->status}}</small>
                          @elseif($data->status == "rejected")
                          <small class="bg-danger  px-1 rounded text-white">   {{$data->status}}</small>

                          @endif
                       
                        
                        </td>
                        <td>
                            @if ($data->status !="approved" && $data->status !="rejected" )
                                <div class="d-flex justify-content-center"> 
                                  <button class="btn btn-sm btn-primary approve bi bi-check" value="{{$data->id}}" style="">
                                </button>
                                  <button class="btn btn-sm btn-warning  ml-2 rejected bi bi-x-circle text-white" style="" value="{{$data->id}}">
                        
                              
                                </button>
                            @endif
                        <button class="btn btn-sm btn-danger ml-2 delete bi bi-trash3" value="{{$data->id}}"></button>
                      </div>
                      </td>
                        
                        </tr>
                        @endif
                        @endforeach
                    
                    </tbody>
                  </table> 
                </div>
            
              </div>
          </div>


           {{-- form to add account --}}
         
        </div>
        <div class="row">
      
          {{-- form Account --}}
          <div class="col col-12 col-lg-8">
            <div class="card shadow-sm mb-5" style="">
              <div class=" card-header text-center p-3 font-weight-bold bg-semi-grey">
                Workers Account
              </div>
      
              <div class="card-body table-responsive">
                <table class="table table-hover "  id="workers_account">
                  <thead>
                      <tr class="text-center">
                        <th scope="col" class="text-center" style="width: 10%">Email</th>
                        <th scope="col" class="text-center" style="width: 10%">Fullname</th>
                        <th scope="col" class="text-center" style="width: 10%">Account Type</th>
                        <th scope="col" class="text-center" style="width: 10%">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($workers_table as $value)

                        <tr class="text-center">
                          <td>{{$value->email}}</td>
                          <td>{{$value->firstname}}</td>
      
                          <td> {{$value->account_type}}</td>
                          
                            <td><button class="btn btn-sm btn-danger ml-2 delete_workers_account bi bi-trash3" value="{{$value->id}}"></button></td>
                        </tr>
                        
                      @endforeach
                  
                  </tbody>
                </table> 
              </div>

          
            </div>
          </div>
          <div class="col col-12 col-lg-4 mb-5">
            <div class="card shadow-sm" style="">
              <div class=" card-header text-center p-3 font-weight-bold bg-semi-grey">
               Add Account
              </div>
              <div class="m-2">
                <div class="alert alert-danger print-error-msg" style="display:none">
                  <ul></ul>
                </div>
              </div>
              {{-- <form action="{{route('add_admin_account')}}" method="POST">
                 --}}
              <form class="p-4">

                @csrf
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="exampleFormControlInput1">Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Email address</label>
                  <input type="email" class="form-control" id="emailaddress" name="emailaddress" placeholder="name@gmail.com">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Confirm Password</label>
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Account Type</label>
                  <select class="form-control" id="account_type" name="account_type">
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                  </select>
              </div>

              <div class="form-group text-center">
                <button type="button" id="" name="" class="btn btn-sm btn-primary w-25 mt-2 btn-addaccount">Submit</button>
              </div>

              </form>

              @if($errors->any())
                <div class="w-4/8 m-auto text-center">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500 list-none">
                          {{$error}}
                        </li>
                    @endforeach
                </div>
              @endif
            </div>
          </div>
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

      $(document).ready( function () {
            $('#reistration_data').DataTable();
        });
        $(document).ready( function () {
            $('#workers_account').DataTable();
        });
        

        $(document).on('click','.delete_workers_account',function (e){
          e.preventDefault();
            console.log($(this).val());

            $('#delete_workers_account_modal').modal('show');

            $('#del_user_id').val($(this).val());
        });
        
          $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
        
        },
        complete: function(){
        
        },
      });
        $(document).on('click', '.approve',function (e) {
            e.preventDefault(); 
            var approve = $(this).val();
            var btn_type = "approved";
            $('#btn_type').val(btn_type);
            $('#approve_id').val(approve);
            $('#approve_modal').modal('show');
            
            });

            $(document).on('click', '.rejected',function (e) {
            e.preventDefault(); 
            var rejected = $(this).val();
            var btn_type = "rejected";
            $('#reject_id').val(rejected);
            $('#reject_modal').modal('show');
            
            });

            $(document).on('click', '.delete',function (e) {
            e.preventDefault(); 
            var del = $(this).val();
            $('#del_id').val(del);
            $('#delete_modal').modal('show');
            
            });

            $(document).on('click', '.view',function (e) {
              e.preventDefault();
              var identification = $(this).val();

              $('#view_modal').modal('show');
              //  $('#image_id').val(identification);

                $.ajax({
                  type: "GET",
                  url: "/admin/view_identification/"+identification,
                  success: function (response) {
                      console.log(response);
                      if(response!=null){
                        $('#image').val(response.identification.identification)
                      $('#image_id').val(response.identification.id)
                      $('#id_type').text(response.identification.identificationtype);
                      $('#view_image').attr('src', '/storage/'+response.identification.identification);
                      }
                    
                      // console.log(response.identification.identification);
                  }, error: function(error) {
                    console.log(error);
                  
                    }
                  });
              
            });

            $(document).on('click', '.btn-addaccount',function (e) {
              e.preventDefault();
              var identification = $(this).val();
                
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                    var _token = $("input[name='_token']").val();
                    var name = $("input[name='name']").val();
                    var emailaddress = $("input[name='emailaddress']").val();
                    var password = $("input[name='password']").val();
                    var password_confirmation = $("input[name='password_confirmation']").val();
                    var account_type= $("#account_type").val();

                    console.log(account_type);
                      $.ajax({
                        url: "{{ route('add_admin_account') }}",
                        type: 'POST',
                        data: { _token:_token, name:name, password_confirmation:password_confirmation, emailaddress:emailaddress, password:password, account_type:account_type},
                        success: function(data) {

                        
                          if($.isEmptyObject(data.error)){
                            $('#add_announcement_modal').modal('hide');
                            // $("input[name='title']").val(null);
                            // $("textarea[name='announcement']").val(null);
                            // $("input[name='publish_date']").val(null);
                            // $("input[name='unpublish_date']").val(null);

                              if(data.valid == "yes"){
                                Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Successfully Added',
                                text: 'account has been save.',
                                showConfirmButton: false,
                                timer: 1500
                            
                              })
                              setInterval('location.reload()', 1600);
                            }else{
                              Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Invalid Date!',
                                text: 'enter a valid publish and unpublish date.',
                                showConfirmButton: false,
                                timer: 1500
                              })
                            
                            }
                          }else{
                              printErrorMsg(data.error);
                          }
                      },
                          error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("some error");
                      }
                  });
                  
                  function printErrorMsg (msg) {
                  $(".print-error-msg").find("ul").html('');
                  $(".print-error-msg").css('display','block');
                  $.each( msg, function( key, value ) {
                      $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                  });
                }
              
            });
        
    });
</script>
</x-app-layout>
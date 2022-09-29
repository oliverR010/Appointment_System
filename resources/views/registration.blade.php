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
    <title>Document</title>
</head>
<body>


     <!-- approve modal -->

<div class="modal fade" id="approve_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ url ('approve_registration') }} " method="POST">
            @csrf
           
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text"  id="del_id" name="del_id" hidden>
          Are you sure you want to delete this Service?
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-primary delete_btn btn-sm w-25">Yes</button>
          <button type="button" class="btn btn-secondary btn-sm w-25" data-dismiss="modal">No</button>
        </div>
         </form>

      </div>
    </div>
  </div>

    <div class="container-fluid mt-5 mb-5 table-responsive w-100" >
                <table class="  table text-align-center table-hover">
                    <thead>
                        <tr class="text-center">
                        <th scope="col">Email</th>

                        <th scope="col">Fullname</th>
                        <th scope="col">Age</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Birthdate</th>
                        <th scope="col">Address</th>
                        <th scope="col">Contact No</th>
                        <th scope="col">ID</th>
                        <th scope="col">ID Type</th>
                        <th scope="col">View</th>
                        <th scope="col">Status</th>


                        <th scope="col" colspan="2" class="text-center">Status</th>



                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $data)
                        @if ($data->account_type!="admin" )
                        <tr class="text-center">
                        <td>{{$data->email}}</td>
                        <td>{{$data->lastname}},{{$data->firstname}} {{$data->middlename}}</td>
                        <td>{{$data->age}}</td>
                        <td>{{$data->gender}}</td>
                        <td>{{$data->birthdate}}</td>
                        <td>{{$data->address}}</td>
                        <td>{{$data->contactnumber}}</td>
                        <td>{{$data->identification}}</td>
                        <td>{{$data->identificationtype}}</td>
                        <td> <button class="btn btn-sm btn-primary">View</button></td>
                        <td>{{$data->status}}</td>
                        <td scope="row" colspan=2 class="d-sm-flex">
                            <button class="btn btn-sm btn-primary w-100 ml-lg-2 approve" value="{{$data->id}}" >Approved</button>
                        <button class="btn btn-sm btn-warning mt-2 mt-lg-0 ml-lg-2 w-100">Reject</button>
                        <button class="btn btn-sm btn-danger mt-2 mt-lg-0 ml-lg-2 w-100">Delete</button>
                        </td>
                 
                        </tr>
                        @endif
                        @endforeach
                   
                    </tbody>
                </table>
          
    </div>


{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>



<script>
    $(document).ready(function () {
        $(document).on('click', '.approve',function (e) {
            e.preventDefault(); 
            var approve = $(this).val();
            
            // $('#del_id').val(delete_service);
           
            console.log(approve);
            // alert(service); 
            $('#approve_modal').modal('show');
            
            });
    });
</script>
</x-app-layout>
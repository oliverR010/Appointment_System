<!doctype html>
<html lang="en">
  <head>
    <title>Send Email Using PHPMailer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container-fluid  " style="background-color:#EEEEEE">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-sm-12 col-12 mx-auto" style="margin-bottom: 100px">
                <form action="{{route('reset.password')}}" method="POST" enctype="multipart/form-data" class="" style="margin-top: 100px">
                    @csrf
                    <div class="card shadow" style="border-radius: 15px ">


                        <div class="card-header py-3">
                            <h4 class="card-title">Reset Password</h4>
                        </div>

                        <div class="card-body p-4">
                            @if(Session::has("success"))
                            <div class="alert alert-success alert-dismissible">{{Session::get('success')}}</div>
                        @elseif(Session::has("failed"))
                            <div class="">{{Session::get('failed')}}</div>
                        @elseif(Session::has("error"))
                        <div class="text-danger">
                             <li>{{Session::get('error')}}</li></div>
                    
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input type="hidden" name="token" id="token" class="form-control" value="{{$token}}">

                            <div class="form-group">
                                <label for="emailRecipient">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="" value="{{$email}}">
                            </div>
                            <div class="form-group">
                                <label for="emailRecipient">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="" >
                            </div>
                            <div class="form-group">
                                <label for="emailRecipient">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="" >
                            </div>


         
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right btn-sm w-25">Send </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      
      <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
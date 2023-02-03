<!doctype html>
<html lang="en">
  <head>
    <title>Send Email Using PHPMailer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body class="" style="background-color:#EEEEEE">
      <div class="container-fluid pt-5 pb-5 " >
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-sm-12 col-12 m-auto">
                <form action="{{route('send-email')}}" method="POST" enctype="multipart/form-data" class="" style="margin-top: 100px">
                    @csrf
                    <div class="card shadow" style="border-radius: 15px ">


                        <div class="card-header py-3">
                            <h4 class="card-title">Forgot Password?</h4>
                        </div>

                        <div class="card-body">
                            @if(Session::has("success"))
                            <div class="alert alert-success alert-dismissible">{{Session::get('success')}}</div>
                        @elseif(Session::has("failed"))
                            <div class="">{{Session::get('failed')}}</div>
                        @elseif(Session::has("error"))
                        <div class="text-danger">
                             <li>{{Session::get('error')}}</li></div>
                    
                        @endif
                        @if ($errors->any())
                        <div class="text-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                            <div class="form-group p-2">
                                <small class="">No problem. Just let us know your email address and we will email you with a reset link.</small>
                            </div>
                            <div class="form-group">
                                <label for="emailRecipient">Enter Email</label>
                                <input type="email" name="email" id="emailRecipient" class="form-control" placeholder="" >
                            </div>

                            {{-- <div class="form-group">
                                <label for="emailAttachments">Attachment(s) </label>
                                <input type="file" name="emailAttachments[]" multiple="multiple" id="emailAttachments" class="form-control">
                            </div> --}}
                      
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right btn-sm w-25">Send </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      @include('sweetalert::alert')
      
      <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
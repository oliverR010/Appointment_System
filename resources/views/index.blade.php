<x-guest-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{-- <link rel="stylesheet" href="/css/style.css"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet"> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
        
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" /> --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script> --}}
        
        <title>DapitanHealthCenter</title>
        
        <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" >
    </head>

    <style>
        @media only screen and (min-width: 601px) {
        div.example {
            font-size: 80px;
        }
        }

        /* If the screen size is 600px or less, set the font-size of <div> to 30px */
        @media only screen and (max-width: 600px) {
       
            .sm-text-center{
                text-align: center;
            }
       
        }

        #map {
        height: 400px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
        }

        .bg-sky-white{
            background-color: #F0F0F0  ;
            border-radius: 20px;
        }
            </style>
    <body >
        <header>
            <nav>
                <div id="logo">
                    <img class="logo" src=""/>
                </div>
            </nav> 
            <section class="banner">
                <div class="container">
                    <p class="h1">Welcome!</p>
                    <p id="" class="text-white h4 mb-4"> Dapitan Health Center Online Appointment</p>
                    @if (Route::has('login'))
                
                        @auth
                            <button class="submit tow"  onclick="window.location='{{ route('afterlogin') }}'" type="button">Dashboard</button>

                            
                        @else
                          
                         <button class="submit tow" onclick="window.location='{{ url("/login") }}'" type="submit">Schedule Now   >></button>
                         @endauth

                    @endif
                    
                </div>
            </section>
        </header>

        
        <section class="container-fluid " class="">

            <div class=" col-12 col-lg-10 mx-lg-auto bg-sky-white p-5" style="margin-top: 100px;">
                <div class="mb-3 sm-text-center " style="border-bottom:5px solid black;"> <h2 class="font-weight-bold">ANNOUNCEMENT</h2></div>
                <div class=" rounded p-2 overflow-auto" style="height: 300px">
              
                    @if($announcement->isEmpty())
                        <div>
                            <label class="btn-sm btn-danger  mt-5 col-12 text-center">No Announcement Yet!</label> 

                    
                        </div>
                
                    @endif
           
                    @foreach($announcement as $value)
                    <div class="">
                        <div class="card mb-3 col col-12 shadow-sm " style="margin-left: auto; margin-right:auto; border-left:10px solid green;">
                            <div class="card-header border-dark">
                                <div class="row">
                                    <div class="col col-12 col-lg-9">
                                    <b>Publish Date : </b>{{$value->publish_date}}
                                    </div>
                                
                                </div>
                            </div>
                            <div class="card-body text-dark ">
                                <h5 class="card-title font-weight-bold">Title: {{$value->title}}</h5>
                                <p class="card-text ">{{$value->body}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                 </div>
            </div>
            <div class=" col-12 col-lg-10 mx-lg-auto bg-sky-white p-5 mt-5" style="margin-top: 0px;">
                <div class="mb-3 sm-text-center" style="border-bottom:5px solid black;"> <h2 class="font-weight-bold">SERVICES</h2></div>
                <div class=" rounded pt-5 overflow-auto" style="height: 300px">

                        

                        @if($vaccine->isEmpty())
                        <ul>
                            <li class="btn-sm btn-danger  col-12 text-center mt-5">No Available Vaccine!</li>

                        </ul>
                        @else
                            <h5 class="font-weight-bold  mb-3 border-bottom border-dark p-1 text-center">Vaccine</h5>

                            @if($pediatric->isNotEmpty())
                                <label for="" class="font-weight-bold p-2" style="border-left: solid 5px green;">Pediatric Vaccination</label>
                                @foreach($pediatric as $value)
                                <li class="pl-5">{{$value->vaccine_type}}</li>
                                @endforeach
                            @endif
                                
                            @if($covid->isNotEmpty())
                                <label for="" class="font-weight-bold p-2" style="border-left: solid 5px green;">Covid</label>
                                @foreach($covid as $value)
                                <li class="pl-5">
                                    @if($value->dose == "1")
                                    1st dose
                                    @elseif ($value->dose == "2")
                                    2nd dose
                                    @elseif ($value->dose == "3")
                                    Booster
                                    @endif
                            - {{$value->vaccine_type}}</li>
                            @endforeach
                            @endif
                    
                            @if($other_vaccine->isNotEmpty())

                                <label for="" class="font-weight-bold p-2" style="border-left: solid 5px green;">Others</label>
                                @foreach($other_vaccine as $value)
                                <li class="pl-5">{{$value->vaccine_type}}</li>
                                @endforeach

                            @endif
                     

                        @endif  
                     
                   

                    @if($medicine->isNotEmpty())
                        <h5 class="font-weight-bold mb-3 mt-3 border-bottom border-dark p-1 text-center"> Free Medicine</h5>
                        @foreach($medicine as $value)
                                
                        <li class="pl-5">{{$value->other_services}}</li>
                        
                    
                        @endforeach
                    @endif

                        
                 

                    @if($checkup->isNotEmpty())
                        <h5 class="font-weight-bold  mt-3 border-bottom mb-3 border-dark p-1 text-center">Check Up</h5>
                        @foreach($checkup as $value)
                            <li class="pl-5">{{$value->other_services}}</li>
                        @endforeach
                    @endif
                        
                        @if($sevices->count()>2)
                        <h5 class="font-weight-bold mb-3 border-bottom border-dark p-2 mt-5 ">Other Services </h5>
                            @foreach($sevices as $value)
                            <ul>                    
                                <li class="list-group-item">{{$value->service}}</li>

                            </ul>
                            @endforeach

                        
                       @endif
                
                </div>
            </div>
            <div class="col-12 col-lg-10 mx-lg-auto bg-sky-white p-5 mt-5" style="margin-top: 100px; margin-bottom:70px">
                <div class="  sm-text-center" style="border-bottom:5px solid black ;p-2"> <h2 class="font-weight-bold">ABOUT US</h2></div>

                <p class="text-justify mt-4 ">
                    The Dapitan Health Center is a medical center located in the Metropolitan Manila area. The Dapitan Health Center is conveniently located next to Barangay 520, the Dapitan Public Library, and the Zone 51 Hall.To better serve the public citizens, we offer medical care. The following are Vaccine, Free Medicine, Checkup and more.
                </p>
                <p class="mt-4 sm-text-center"  style=" ">
                   <b class="mb-5"> Contact# : +63 2 741 2078</b>
                </p >
            </div>
            <!--- FIRST ROW --->
            
        

            
        </section>
      



        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
     
    </body>



    </html>
    
</x-guest-layout>
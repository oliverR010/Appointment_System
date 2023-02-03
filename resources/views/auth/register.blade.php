<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
     {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> --}}
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
     {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
</head>
<style>
.first-row{

}
.col{
    margin-bottom: 10px;
}

.wrapper{
width:200px;
padding:20px;
height: 150px;
}


.second-row{

}
.reg-textlogo{
    font-size: 24px;
    text-align: center;
}
</style>
<body >
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
            <div class="reg-textlogo">
               </div>
               <div class="text-center d-block">
            
                <b><h5 class="text-color"> Dapitan Health Center</h5></b>
                
            </div> 
        </x-slot> 
    <x-jet-validation-errors class="mb-4" />
        <div class="alert alert-warning alert-dismissible fade show m-4" role="alert">
            <strong>Reminder: </strong> After you register, We will verify first your account before you can access the system.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="mt-5">
            @csrf
            <div class="container">
            <div class="row">
                    <div class="col col-12 col-lg-4">
                        <x-jet-label for="firstname" class="mt-2" value="{{ __('First Name') }}" />
                        <x-jet-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                    </div>
                    <div class="col-12 col-lg-4">
                        <x-jet-label for="middlename" class="mt-2" value="{{ __('Middle Name') }}" />
                        <x-jet-input id="middlename" class="block mt-1 w-full" type="text" name="middlename" :value="old('middlename')" required autofocus autocomplete="middlename" />
                </div>
                    <div class="col-12 col-lg-4 ">
                        <x-jet-label for="lastname" class="mt-2" value="{{ __('Last Name') }}" />
                        <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
                    </div>
                </div>
                <div class="row">
                <div class="col-12 col-lg-4 second-row">
                    <x-jet-label for="age"  class="mt-2" value="{{ __('Age') }}" />
                    <x-jet-input id="age" class="block mt-1 w-full" type="text" name="age" :value="old('age')" required autofocus autocomplete="age" />
                </div>
                <div class="col-12 col-lg-4 mt-2">
                    <x-jet-label for="gender" class="" value="{{ __('Gender') }}" />
                    <select name="gender" id="gender" class ="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="col-12 col-lg-4">
                    <x-jet-label for="birthdate" class="mt-2" value="{{ __('Birthdate') }}" />

                    <input type="date" id="birthdate" max="{{\Carbon\Carbon::today()->format('Y-m-d')}}" name="birthdate" :value="old('birthdate')" required autofocus autocomplete="birthdate" class ="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </div>
            
                </div>

        
                <div class="mb-2 mt-3">
                    <x-jet-label for="contactnumber" class="mt-3 " value="{{ __('CellPhone No') }}" />
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        +63
                        </span>
                        <input type="text" id="contactnumber" name="contactnumber" :value="old('contactnumber')" required autofocus autocomplete="contactnumber" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:ring-indigo-200 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-opacity-50 dark:focus:ring-indigo-200" placeholder="">
                    </div>
                    
                </div>

                
                <div class="row">
                    {{-- <div class="col-12 col-lg-6">
                        <x-jet-label for="contactnumber" class="mt-3 " value="{{ __('Contact Number') }}" />
                        <x-jet-input id="contactnumber" class="block mt-1 w-full" type="text" name="contactnumber" :value="old('contactnumber')" required autofocus autocomplete="contactnumber" />
                    </div> --}}
                     <div class="col-12 col-lg-8">
                        <x-jet-label for="address" class="mt-3" value="{{ __('Address') }}" />
                        <x-jet-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
                    </div>
                    <div class="col-12 col-lg-4">
                        <x-jet-label for="barangay" class="ml-1 mt-3" value="{{ __('Barangay') }}" />
                        <x-jet-input id="barangay" class="block mt-1 w-full" type="text" name="barangay" :value="old('barangay')" required autofocus autocomplete="barangay" />
                    </div>
                </div>
                <div class="row">
                 
                </div>
                <div class="row mt-2">
                    <div class="col col-12">
                        <x-jet-label for="email" class="mt-2" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>
                </div>
            
                <div class="row ">
                <div class="col">
                    <x-jet-label for="password" class="mt-2" value="{{ __('Password') }}" />
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div> 
            </div>
            <div class="row">
                <div class="col">
                    <x-jet-label for="password_confirmation" class="mt-2" value="{{ __('Confirm Password') }}" />
                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>
            </div>
                <div class="row mt-2">
                    <div class="col  " style="">
                        <x-jet-label for="identificationtype" class="" value="{{ __('Identification Type') }}" />
                        <select name="identificationtype" id="identificationtype" class ="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :value="old('identificationtype')"  autofocus autocomplete="identificationtype">
                            <option value="">Select Identification.. </option>
                            <option value="drivers license">Driver’s License </option>
                            <option value="Passport">Passport </option>
                            <option value="PhilHealth Card">PhilHealth Card </option>
                            <option value="PRC ID">PRC ID </option>
                            <option value="SSS ID">SSS ID</option>
                            <option value="UMID">UMID</option>
                            <option value="Voter’s ID">Voter’s ID</option>
                            <option value="PSA">PSA</option>
                            <option value="1">Others</option>

                        </select>
              
                    
                    </div>
                  
                               
                                
                </div> 
                <div class="row  mb-4" id="others">
                    <div class="col  " style="" >
                        <x-jet-label for="identificationtype" class="" value="{{ __('Enter Identification') }}" />
                        <x-jet-input id="identificationtypeothers" class="block mt-1 w-full" type="text" name="identificationtypeothers"  :value="old('identificationtypeothers')"   />
                    </div>
                </div>
                        
                <script>
 $(document).ready(function () {
    $("#others").hide();

    

            $(document).on('change', '#identificationtype',function (e) {
                    e.preventDefault();

                    console.log($(this).val());
                   
                    if($(this).val() == "1"){
                        $("#others").show();
                        
                        $("#identificationtype").prop('required',false);

                        $("#identificationtypeothers").prop('required',true);
                        
                    }else{
                        $("#others").hide();
                        $("#identificationtypeothers").val("");
                        $("#identificationtypeothers").prop('required',false);
                        $("#identificationtype").prop('required',true);

                    }


                });

    });


                </script>
                                    
                <div class="row mt-4">
                    <div class="col">
                        
                    <input type="file" id="identification" name="identification" class="" required>
                    </div>
                </div> 
            </div>
    

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms"/>

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-jet-button class="ml-4">
                        {{ __('Register') }}
                    </x-jet-button>
                </div>
            </div>
        </form> 


        {{-- <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Register') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register_action') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contactnumber" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                                    <div class="col-md-6">
                                        <input id="contactnumber" type="tel" class="form-control @error('contactnumber') is-invalid @enderror" name="contactnumber" value="{{ old('contactnumber') }}" required>
                                        @error('contactnumber')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </x-jet-authentication-card>
</x-guest-layout>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
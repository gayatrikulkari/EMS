<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title> Reset Password </title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            height: 100%;
            }
    </style>
</head>

<body class="d-flex flex-column h-100 row align-items-center">
    <x-header/>

    <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Forgot Password ? We got you Covered</h5>
            <p class="card-text">
                Enter following details to reset your secret password
            </p>
          </div>
    </div>

    <div class= "mx-auto align-items items-center">
        <form action="update" method="POST">
        @csrf


        <div class="form-group d-flex flex-column">
            <label for="username">Enter Employee-ID:</label>

                <input type="text" name="username" placeholder="Enter emp_id" class="form-control"/>
                <span style = "color:red">
                    @error('username')
                    {{$message}}
                    @enderror
                </span>


                @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
                @endif


        </div>

        <div class="form-outline d-flex flex-column mb-4">
            <label class="form-label" for="new_password">Enter new password:</label>

                <input type="password" name="new_password" placeholder="Enter new password" class="form-control"/>

                <span style = "color:red">
                    @error('new_password')
                    {{$message}}
                    @enderror
                </span>

                <input type="password" name="confirm_password" placeholder="Confirm password" class="form-control"/>

                <span style = "color:red">
                    @error('confirm_password')
                    {{$message}}
                    @enderror
                </span>

        </div>

       <div class="d-flex flex-column">
       <button class="btn btn-primary"type = "submit">Reset Password</button>
       </div>

    </form>
    </div>


<x-footer/>

</body>
</html>

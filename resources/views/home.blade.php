<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TURBO | Login</title>

    <link href="{{URL('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href = "{{URL::asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href = "{{URL::asset('css/animate.css')}}" rel="stylesheet">
    <link href = "{{URL::asset('css/style.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <p>Login in. To see it in action.</p>
            <form class="m-t" role="form" method="post" action="{{URL::route('login')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Customer Code" required name="customer_code">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required name="password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

            </form>
        
                @if($errors->has())
            <div class="has-error" >
                <p>
                  {{$errors->first('customer_code',':message')}} </p>
                  <p>  {{$errors->first('password',':message')}} </p>
              </div>

                  @endif

                @if(Session::has('message'))
            <div class="form-group has-error" >
                <label class = "control-label"> 
                  {{Session::get('message')}} </label>
              </div>

                  @endif

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src = "{{URL::asset('js/jquery-2.1.1.js')}}"></script>
    <script src = "{{URL::asset('js/bootstrap.min.js')}}"></script>

</body>

</html>

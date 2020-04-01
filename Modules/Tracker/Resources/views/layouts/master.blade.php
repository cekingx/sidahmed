<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
    <link href="{{asset('semantic/semantic.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/Tracker.css')}}" rel="stylesheet" type="text/css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="root-url"   content="{{ env('ROOT_URL') }}">

    @stack('head')
</head>
<body>
    <div class="pusher">
        <div style="min-height:95vh">
            <div class="ui navigation container">
                <div class="ui fluid secondary inverted pointing menu">
                    <div class="ui icon top right pointing dropdown toc item button">
                        <i class="sidebar icon"></i>
                        <div class="menu">
                            <div class="item">Home</div>
                            <div class="item">About Us</div>
                            <div class="item">Order Status</div>
                        </div>
                    </div>

                    <div class="right item">
                        <a class="item">Home</a>
                        <a class="item">About Us</a>
                        <a class="item">Order Status</a>
                    </div>
                </div>
            </div>

            @yield('content')
        </div>

        @include('layouts.components.footer')
    </div>

    <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('semantic/semantic.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/Tracker.js')}}"></script>

    <script>
        $(function(){
            $(".ui.dropdown").dropdown();
        })
    </script>
</body>
</html>
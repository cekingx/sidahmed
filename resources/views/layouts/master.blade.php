<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="{{asset('semantic/semantic.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('toastr/toastr.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="root-url"   content="{{ env('ROOT_URL') }}">

        @stack('head')
    </head>
    
    <body>
        @if(!isset($distraction_free))
            @if(isset($masthead))
            <!-- Following Menu -->
            @include('layouts.components.navigation.following')
            @endif

            <!-- Sidebar Menu -->
            @include('layouts.components.navigation.mobile')
        @endif

        <!-- Page Contents -->
        <div class="pusher">
            @if(!isset($distraction_free) || (isset($distraction_free) && !isset($header)))
            <div class="ui inverted vertical {{!isset($masthead) ? 'small' : ''}} masthead center aligned segment">
                @include('layouts.components.navigation.main')
                @yield('masthead')
            </div>
            @endif

            @yield('content')
        </div>

        @if(!isset($distraction_free))
            @include('layouts.components.footer')
        @endif

        @include('layouts.components.loading')
    </body>

    <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('semantic/semantic.min.js')}}"></script>
    <script src="{{asset('toastr/toastr.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>

    <script>
        $(document).ready(function() {

            @if(isset($masthead))
            // fix menu when passed
            $('.masthead').visibility({
                once: false,
                onBottomPassed: function() {
                    $('.fixed.menu').transition('fade in');
                },
                onBottomPassedReverse: function() {
                    $('.fixed.menu').transition('fade out');
                }
            });
            @endif
        
            // create sidebar and attach to menu open
            $('.ui.sidebar').sidebar('attach events', '.toc.item');
        });
    </script>

    <script>
        $(document).ajaxError(function( event, jqxhr ) {
            if(jqxhr.status == 408) {
                toastr.error("Oops! Check your internet connection.");
            }
            else if(jqxhr.status == 401) {
                window.location.reload();
            }
            else {
                @if((Auth::check() && Auth::user()->isAdmin()))
                toastr.warning(jqxhr.responseJSON.message+'<br/>'+jqxhr.responseJSON.file);
                console.log(jqxhr.responseJSON);
                console.log(event);
                @else
                toastr.warning("Oops! We encountered an error while fetching the request. ("+ jqxhr.status +")");
                @endif
            }
        });

        $(document).ready(function(){
            toastr.options = {
              "progressBar": true,
              "timeOut": "8000",
            }
            @if(!empty($message))
            toastr.info("{{$message}}");
            @endif
            @if(!empty(session('message')))
            toastr.info("{{session('message')}}");
            @endif

            @if(!empty($error))
            toastr.error("{{$error}}");
            @endif
            @if(!empty(session('error')))
            toastr.error("{{session('error')}}");
            @endif

            @if(!empty($success))
            toastr.success("{{$success}}");
            @endif
            @if(!empty(session('success')))
            toastr.success("{{session('success')}}");
            @endif
        });
    </script>

    @stack('javascript')
</html>
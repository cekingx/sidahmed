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
        <link href="{{asset('css/Admin.css')}}" rel="stylesheet" type="text/css">

        <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('semantic/semantic.min.js')}}"></script>
    <script src="{{asset('toastr/toastr.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/Admin.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('public/DataTables/css/dataTables.semanticui.min.css')}}"/>
 
<script src="{{asset('public/DataTables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('public/DataTables/js/dataTables.semanticui.min.js')}}"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="root-url"   content="{{ env('ROOT_URL') }}">

        @stack('head')
    </head>
    
    <body>
        <!-- Page Contents -->
        <div class="pusher">
            <div class="ui basic content segment">
                <div class="ui grid">
                    <div class="six wide column">
                        <h1 class="ui header">@yield('title')</h1>
                    </div>

                    <div class="ten wide column" style="text-align:right; padding-right:5rem;">
                        @yield('options')
                        @include('admin::layouts.components.navigation')
                    </div>
                </div>

                <div class="ui divider"></div>

                @yield('content')
            </div>
        </div>
    </body>

    



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

            try {
                if(jqxhr.responseJSON.error) {
                    toastr.warning(jqxhr.responseJSON.error);
                }
            }
            catch(e){}
        });
        
        $(document).ready(function(){
            $(".ui.dropdown").dropdown();
            
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
    @stack('component_javascript')
</html>
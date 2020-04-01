@extends('layouts.master')

@section('content')
<div class="ui text container" style="margin-top:8rem;">
    <div class="ui segment" style="width:50%; margin: 0 auto">
        <form method="POST" action="{{ route('login') }}" class="ui form">
            @csrf

            <div class="field">
                <label for="email">{{ __('E-Mail Address') }}</label>

                <div class="ui input">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="field">
                <label for="password">{{ __('Password') }}</label>

                <div class="ui input">
                    <input id="password" type="password" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="field">
                <button type="submit" class="ui primary button">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="ui secondary button" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">
                  {{ session('success') }}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger" role="alert">
                  {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h2>{{ __('Login') }}</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login.attempt') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="alert">
                            Please enter your email address below and we will email you a unique login link right away.
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(session('message'))
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Get Login Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

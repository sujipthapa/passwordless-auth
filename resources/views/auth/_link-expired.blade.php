@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('Error') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger text-center text-muted">
                            Your URL seems to be expired, please try generating a new one and try again.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

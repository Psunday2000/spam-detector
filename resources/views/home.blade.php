@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            @auth
                <div class="d-flex flex-column justify-content-center">
                    <div class="p-2 text-center">
                        <img src="{{ asset('assets/images/bug.png') }}" alt="Logo" style="width: 50px; height: 50px;">
                        <h5><strong>{{ config('app.name', 'Laravel') }}</strong></h5><br>
                    </div>
                    <div class="p-2">
                        @include('profile.update-profile-information-form')
                    </div>
                </div>
            @else
                @include('auth.login')
            @endauth
        </div>
    </div>
</div>
@endsection

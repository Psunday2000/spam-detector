@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column justify-content-center" style="min-height: 100vh;">
    <div class="p-2">
        <a style="text-decoration: none; color:black;" href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
    <div class="card">
        <div class="card-header"><h5 style="text-align: center;">{{ $email->subject }}</h5></div>
        <div class="card-body">
            <p><strong>Sender:</strong> {{ $email->sender_email }}</p>
            <p><strong>Receiver:</strong> {{ $email->receiver_email }}</p>
            <p><strong><hr></strong></p>
            <p class="email-body">{{ $email->body }}</p>
        </div>
    </div>
</div>
@endsection

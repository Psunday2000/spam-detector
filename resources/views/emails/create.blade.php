@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add New Email</h2>
    <form id="email-form" action="{{ route('emails.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <input type="hidden" name="sender_email" value="{{ auth()->user()->email }}">
        <div class="mb-3">
            <label for="receiver_email" class="form-label">Receiver Email</label>
            <select class="form-control select2" id="receiver_email" name="receiver_email" required>
                <option value="" disabled selected>Select a user</option>
                @foreach($users as $user)
                    @if($user->email != auth()->user()->email)
                        <option value="{{ $user->email }}">{{ $user->email }}</option>
                    @endif
                @endforeach
            </select>            
        </div>        
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
        </div>
        <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Send">
    </form>
</div>
@endsection

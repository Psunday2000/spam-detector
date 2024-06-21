@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3 p-2" id="email-nav-mobile">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" hidden>&times;</span>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-row justify-content-between">
                <div class="p-2">
                    <h5>Emails</h5>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{route('emails.create')}}">New Email</a>
                </div>
            </div>
            <div id="email-nav">
                <a href="{{ route('emails.index') }}" class="list-group-div {{ request()->routeIs('emails.index') ? 'active' : '' }}" aria-current="page">
                    <div class="p-2">
                        <span>Inbox</span>
                    </div>
                    <div class="p-2">
                        <span class="count-badge">{{$inbox_count}}</span>
                    </div>
                </a>
                <a href="{{ route('emails.sent') }}" class="list-group-div {{ request()->routeIs('emails.sent') ? 'active' : '' }}">
                    <div class="p-2">
                        <span>Sent</span>
                    </div>
                    <div class="p-2">
                        <span class="count-badge">{{$sent_count}}</span>
                    </div>
                </a>
                <a href="{{ route('emails.spam') }}" class="list-group-div {{ request()->routeIs('emails.spam') ? 'active' : '' }}">
                    <div class="p-2">
                        <span>Spam</span>
                    </div>
                    <div class="p-2">
                        <span class="count-badge">{{$spam_count}}</span>
                    </div>
                </a>
                <a href="{{ route('emails.trash') }}" class="list-group-div {{ request()->routeIs('emails.trash') ? 'active' : '' }}">
                    <div class="p-2">
                        <span>Trash</span>
                    </div>
                    <div class="p-2">
                        <span class="count-badge">{{$trash_count}}</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 p-2" id="email-navi-desktop">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" hidden>
                        <span aria-hidden="true" hidden>&times;</span>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-row justify-content-between">
                <div class="p-2">
                    <h5>Emails</h5>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{route('emails.create')}}">New Email</a>
                </div>
            </div>
            <div class="list-group" id="email-nav-desktop">
                <a href="{{ route('emails.index') }}" class="list-group-div {{ request()->routeIs('emails.index') ? 'active' : '' }}" aria-current="page">
                    <div class="p-2">
                        <span>Inbox</span>
                    </div>
                    <div class="p-2">
                        <span class="count-badge">{{$inbox_count}}</span>
                    </div>
                </a>
                <a href="{{ route('emails.sent') }}" class="list-group-div {{ request()->routeIs('emails.sent') ? 'active' : '' }}">
                    <div class="p-2">
                        <span>Sent</span>
                    </div>
                    <div class="p-2">
                        <span class="count-badge">{{$sent_count}}</span>
                    </div>
                </a>
                <a href="{{ route('emails.spam') }}" class="list-group-div {{ request()->routeIs('emails.spam') ? 'active' : '' }}">
                    <div class="p-2">
                        <span>Spam</span>
                    </div>
                    <div class="p-2">
                        <span class="count-badge">{{$spam_count}}</span>
                    </div>
                </a>
                <a href="{{ route('emails.trash') }}" class="list-group-div {{ request()->routeIs('emails.trash') ? 'active' : '' }}">
                    <div class="p-2">
                        <span>Trash</span>
                    </div>
                    <div class="p-2">
                        <span class="count-badge">{{$trash_count}}</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-9 p-2 email-bar">
            @if($emails->count() > 0)
            <div class="table-responsive">
                @if($emails->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            @if(Route::currentRouteName() !== 'emails.sent')
                                <th scope="col">Sender</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Action</th>
                            @endif
                            @if(Route::currentRouteName() == 'emails.sent')
                                <th scope="col">Receiver</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emails as $email)
                            <tr>
                                @if(Route::currentRouteName() !== 'emails.sent')
                                <td>{{ $email->sender_email }}</td>
                                <td>{{ $email->subject }}</td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">                                            
                                        @if(Route::currentRouteName() !== 'emails.trash')
                                        <div class="p-2">
                                            <a href="{{ route('emails.show', $email->id) }}"><i class="action-btn fa-solid fa-desktop"></i></a>
                                        </div>
                                        <div class="p-2">
                                            <form id="delete-form-{{ $email->id }}" action="{{ route('emails.softDelete', $email->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this email?')) { document.getElementById('delete-form-{{ $email->id }}').submit(); }"><i style="color: #e80721;" class="action-btn fa-solid fa-trash"></i></a>
                                        </div>
                                        @endif
                                        @if(Route::currentRouteName() == 'emails.trash')
                                            <div class="p-2">
                                                <form id="restore-form-{{ $email->id }}" action="{{ route('emails.restore', $email->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                                <a href="" onclick="event.preventDefault(); if (confirm('Are you sure you want to restore this email?')) { document.getElementById('restore-form-{{ $email->id }}').submit(); }"><i class="action-btn fa-solid fa-trash-can-arrow-up"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            @endif
                            @if(Route::currentRouteName() == 'emails.sent')
                            <td>{{ $email->receiver_email }}</td>
                            <td>{{ $email->subject }}</td>
                            <td>
                                <div class="d-flex flex-row justify-content-center">                                            
                                    @if(Route::currentRouteName() !== 'emails.trash')
                                    <div class="p-2">
                                        <a href="{{ route('emails.show', $email->id) }}"><i class="action-btn fa-solid fa-desktop"></i></a>
                                    </div>
                                    <div class="p-2">
                                        <form id="delete-form-{{ $email->id }}" action="{{ route('emails.softDelete', $email->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="" onclick="event.preventDefault(); if (confirm('Are you sure you want to delete this email?')) { document.getElementById('delete-form-{{ $email->id }}').submit(); }"><i style="color: #e80721;" class="action-btn fa-solid fa-trash"></i></a>
                                    </div>
                                    @endif
                                    @if(Route::currentRouteName() == 'emails.trash')
                                        <div class="p-2">
                                            <form id="restore-form-{{ $email->id }}" action="{{ route('emails.restore', $email->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                            <a href="" onclick="event.preventDefault(); if (confirm('Are you sure you want to restore this email?')) { document.getElementById('restore-form-{{ $email->id }}').submit(); }"><i class="action-btn fa-solid fa-trash-can-arrow-up"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            @endif
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            @else
            <h5 style="text-align:center; font-size: 50pt;">
                <i id="sad-tear" class="fa-solid fa-face-sad-tear"></i>
            </h5>
            <h5 style="text-align:center;">Sorry no emails here!</h5>
            @endif
        </div>
    </div>
</div>
@endsection
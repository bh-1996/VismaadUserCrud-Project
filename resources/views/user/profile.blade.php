@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>User Details</h1>
        <p><strong>Name:</strong> {{ capitalizedString($user->name) }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Phone:</strong> {{ $user->phone }}</p>
        <p><strong>Address:</strong> {{ capitalizedString($user->address) }}</p>
        @if($user->image)
            <p><strong>Image:</strong></p>
            <img src="{{ asset('images/' . $user->image) }}" width="200" alt="User Image">
        @endif
        <a href="{{ route('users') }}" class="btn btn-primary">Back to Users</a>
    </div>
@endsection

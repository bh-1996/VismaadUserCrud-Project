@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Users</h1>
        <a href="{{ route('showRegistrationForm') }}" class="btn btn-primary">Create User</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Image</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ ucfirst($user->name) }}</td> <!-- Used ucfirst helper function -->
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ ucfirst($user->address) }}</td> <!-- Used ucfirst helper function -->
                        <td>
                            @if($user->image)
                                <img src="{{ asset('images/' . $user->image) }}" width="100" alt="User Image">
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td> <!-- Used format method -->
                        <td>
                            <a href="{{ route('profile', ['id' => Crypt::encryptString($user->id)]) }}" class="btn btn-info">View</a>
                            <a href="{{ route('editProfile', ['id' => Crypt::encryptString($user->id)]) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('user.destroy', ['id' => Crypt::encryptString($user->id)]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

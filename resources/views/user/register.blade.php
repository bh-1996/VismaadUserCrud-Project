@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create User</h1>
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
                <span class="error-message" id="nameError"></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
                <span class="error-message" id="emailError"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <span class="error-message" id="passwordError"></span>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                <span class="error-message" id="passwordConfirmationError"></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control">
                <span class="error-message" id="phoneError"></span>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" class="form-control"></textarea>
                <span class="error-message" id="addressError"></span>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
                <span class="error-message" id="imageError"></span>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>

            <div class="form-group">
                <a href="{{ route('showLoginForm') }}">Login here?</a>
            </div>
        </form>
    </div>
@endsection

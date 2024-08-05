@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Login</h1>
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
                <span id="emailError" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <span id="passwordError" class="error-message"></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="form-group">
                <a href="{{ route('showRegistrationForm') }}">Register here?</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            let valid = true;

            // Clear previous error messages
            document.getElementById('emailError').textContent = '';
            document.getElementById('passwordError').textContent = '';

            // Get form values
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            // Validate email
            if (email === '') {
                document.getElementById('emailError').textContent = 'Email is required.';
                valid = false;
            } else if (!validateEmail(email)) {
                document.getElementById('emailError').textContent = 'Please enter a valid email address.';
                valid = false;
            }

            // Validate password
            if (password === '') {
                document.getElementById('passwordError').textContent = 'Password is required.';
                valid = false;
            }

            // If invalid, prevent form submission
            if (!valid) {
                event.preventDefault();
            }
        });

        function validateEmail(email) {
            // Simple email validation regex
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
    </script>

    <style>
        .error-message {
            color: red;
            font-size: 0.875em;
            display: block;
            margin-top: 0.25em;
        }
    </style>
@endsection

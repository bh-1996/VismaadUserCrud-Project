
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="{{ url('/') }}">Vismaad MediaTech</a>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('users') }}">Users</a></li>

                    @guest
                        <li><a href="{{ route('showLoginForm') }}">Login</a></li>
                        <li><a href="{{ route('showRegistrationForm') }}">Register</a></li>
                    @else
                        <li><a href="{{ route('profile', ['id' => Crypt::encryptString($user->id)]) }}">Profile</a></li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="border: none; color: #fff; cursor: pointer; text-decoration:none">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </nav>
        </div>
    </header>
    

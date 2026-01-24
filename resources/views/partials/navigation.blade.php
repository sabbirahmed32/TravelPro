<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="bi bi-globe-americas me-2"></i>TravelPro
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/about') }}">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Services
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/visa-services') }}">
                            <i class="bi bi-passport me-2"></i>Visa Services
                        </a></li>
                        <li><a class="dropdown-item" href="{{ url('/student-admission') }}">
                            <i class="bi bi-mortarboard me-2"></i>Student Admission
                        </a></li>
                        <li><a class="dropdown-item" href="{{ url('/tours-holidays') }}">
                            <i class="bi bi-airplane me-2"></i>Tours & Holidays
                        </a></li>
                        <li><a class="dropdown-item" href="{{ url('/consultation') }}">
                            <i class="bi bi-telephone me-2"></i>Consultation
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Resources
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/blog') }}">
                            <i class="bi bi-newspaper me-2"></i>Blog
                        </a></li>
                        <li><a class="dropdown-item" href="{{ url('/faq') }}">
                            <i class="bi bi-question-circle me-2"></i>FAQ
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
                </li>
            </ul>
            
            <div class="ms-lg-3">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                @else
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="{{ url('/profile') }}">
                                <i class="bi bi-person me-2"></i>Profile
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
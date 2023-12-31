<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">{{ Auth::user() !=null ? Auth::user()->name : "guest" }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
          </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('register')}}">Register</a>
                  </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard.index')}}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logout')}}">Logout</a>
                    </li>
                @endauth
      </div>
    </div>
  </nav>

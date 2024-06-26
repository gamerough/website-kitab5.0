<section class="header">
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
        <div class="container">
        <a class="navbar-brand" href="{{ url('/landingPage') }}">Kitab<span style="color: #33D8D8; font-weight:600">Suci</span></a>
        <div class="collapse navbar-collapse navText" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto login justify-content-end">
                <div class="menu d-flex mx-5">
                  <a class="nav-link" id="home-link" href="{{ url('/landingPage') }}">Home</a>
                  <a class="nav-link" id="scripture-link" href="{{ url('/scripture') }}">Scripture</a>
                  <a class="nav-link" id="favorite-link" href="{{ url('/favorite') }}">Favorite</a>
                  <a class="nav-link" id="contact-link" href="{{ url('/contact') }}">Contact</a>
                </div>
                <input class="form-control search w-25 mx-2" type="text" name="search" id="search" placeholder="Search">
                @if (session()->has('access_token'))
                <?php $buttonText = explode(' ', session()->get('user.name'))[0]; ?>
                <a class="border buttonLgn btn btn-primary" style="color: #FFFFFF">{{ $buttonText }}</a>
                @else
                <a class="border buttonLgn btn btn-primary" style="color: #FFFFFF" href="{{ url('/login') }}">Login</a>
                @endif
            </div>
        </div>
        </div>
    </nav> 
</section>
<header class="header_area" id="header">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 h-100">
                    <nav class="h-100 navbar navbar-expand-lg align-items-center">
                        <a class="navbar-brand" href="{{ url('/') }}">Gourmet Tamale</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#caviarNav" aria-controls="caviarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="fa fa-bars"></span></button>
                        <div class="collapse navbar-collapse" id="caviarNav">
                            <ul class="navbar-nav ml-auto" id="caviarMenu">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#home">Home <span class="sr-only">(current)</span></a>
                                </li><!--
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ url('/') }}">Home</a>
                                        <a class="dropdown-item" href="{{ url('/menu') }}">Menu</a>
                                        <a class="dropdown-item" href="{{ url('/page') }}">Regular Page</a>
                                        <a class="dropdown-item" href="{{ url('/contact') }}">Contacto</a>
                                    </div>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/') }}#about">Nosotros</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/') }}#menu">Menu</a>
                                </li>

                                <!--
                                <li class="nav-item">
                                    <a class="nav-link" href="#awards">Awards</a>
                                </li>
                                -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/') }}#testimonial">Opiniones</a>
                                </li>
                               
                                <!--
                                <li class="nav-item">
                                    <a class="nav-link" href="#reservation">Reservation</a>
                                </li>
                                -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/contact') }}">Contacto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('messages.Login') }}</a>
                                </li>
                                 
                            </ul>
                            <!-- Search Btn 
                            <div class="caviar-search-btn">
                                <a id="search-btn" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                            </div> -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
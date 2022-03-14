<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

     <!-- Title -->
    <title>Gourmet Tamale - Contacto</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">

    <!-- Core Stylesheet -->
    <link href="{{ asset('/style.css') }}" rel="stylesheet">

    <!-- Responsive CSS -->
    <link href="{{ asset('css/responsive/responsive.css') }}" rel="stylesheet">

</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="caviar-load"></div>
        <div class="preload-icons">
            <img class="preload-1" src="img/core-img/preload-1.png" alt="">
            <img class="preload-2" src="img/core-img/preload-2.png" alt="">
            <img class="preload-3" src="img/core-img/preload-3.png" alt="">
        </div>
    </div>

    <!-- ***** Search Form Area ***** -->
    <div class="caviar-search-form d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-close-btn" id="closeBtn">
                        <i class="pe-7s-close-circle" aria-hidden="true"></i>
                    </div>
                    <form action="#" method="get">
                        <input type="search" name="caviarSearch" id="search" placeholder="Search Your Favourite Dish ...">
                        <input type="submit" class="d-none" value="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ***** Header Area Start ***** -->
    @include('home.common.encabezado')
    <!-- ***** Header Area End ***** -->

    <!-- ***** Breadcumb Area Start ***** -->
    <div class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/hero-4.jpg)">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h2>Contact</h2>
                        <p><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:+1234567890">+1 234 567 890</a> <a href="tel:+1234567890">+1 234 567 890</a></p>
                        <p><i class="fa fa-map-marker" aria-hidden="true"></i> 14 Soho Square, London, United Kingdom</p>
                        <p><i class="fa fa-envelope-o" aria-hidden="true"></i> <a href="mailto:someone@yoursite.com">lorem.ipsum@dolor.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Breadcumb Area End ***** -->

    <!-- ***** Contact Area Start ***** -->
    <div class="caviar-contact-area d-md-flex align-items-center" id="contact">
        <div class="contact-form-area d-flex justify-content-end">
            <div class="contact-form">
                <div class="contact-form-title">
                    <p>get in touch</p>
                </div>
                <form action="#">
                    <div class="row">
                        <div class="col-12">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="col-12">
                            <input type="email" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="col-12">
                            <textarea name="message" class="form-control" id="Message" cols="30" rows="10" placeholder="Your Message"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn caviar-btn"><span></span> Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="caviar-map-area wow fadeInRightBig" data-wow-delay="0.5s">
            <div id="googleMap"></div>
        </div>
    </div>
    <!-- ***** Contact Area End ***** -->

    <!-- ****** Footer Area Start ****** -->
    @include('home.common.pie')
    <!-- ****** Footer Area End ****** -->
   
    <!-- Google Maps js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDk9KNSL1jTv4MY9Pza6w8DJkpI_nHyCnk"></script>
    <script src="js/google-map/map-active.js"></script>
   
</body>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

     <!-- Title -->
    <title>Gourmet Tamale - Blog</title>

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
    <div class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/hero-5.jpg)">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Breadcumb Area End ***** -->

    <!-- ***** Regular Page Area Start ***** -->
    <section class="caviar-regular-page section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="regular-page-content">
                        <div class="post-title">
                            <h2>Proin et sem cursus, placerat odio quis, consectetur turpis</h2>
                            <a href="#">Maecenas sit amet quam magna</a>
                        </div>
                        <div class="post-content">
                            <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor. Integer molestie rhoncus nisi a euismod. Etiam scelerisque eu enim et vestibulum. Mauris finibus, eros a faucibus varius, dui risus mattis massa, sed lobortis ante ante eget justo. Nam eu dolor lorem. Praesent blandit leo sit amet velit accumsan ultrices. Vestibulum nec libero vel sapien dictum euismod eu ac justo.</p>
                            <blockquote>
                                <img src="img/icons/quotation-mark.svg" alt="">
                                <div class="blockquote-content">
                                    <h6>Quisque sagittis non ex eget vestibulum. Sed nec ultrices dui. Cras et sagittis erat. Maecenas pulvinar, turpis in dictum tincidunt, dolor nibh lacinia lacus, quis.</h6>
                                    <p>Liam Neeson</p>
                                </div>
                            </blockquote>
                            <p>Nulla mattis massa eu turpis aliquet accumsan. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas laoreet nunc sed felis vestibulum pulvinar. Nunc odio est, blandit ut faucibus non, congue nec augue. Duis vitae vulputate nunc. Sed mi lectus, ultricies ut volutpat luctus, vestibulum ut nunc. Vestibulum sed lorem malesuada, dapibus ante pharetra, pretium mauris. Sed eleifend sit amet felis id fringilla. Suspendisse nec erat vel lacus commodo imperdiet non quis risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed ac interdum elit, ac pellentesque felis. Curabitur aliquet at sapien dapibus laoreet. Sed in justo eu sem pellentesque lobortis. In hac habitasse platea dictumst. Nam pellentesque eros ut auctor fermentum. Vestibulum ut risus pharetra.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Regular Page Area End ***** -->

    <!-- ****** Footer Area Start ****** -->
    @include('home.common.pie')
    <!-- ****** Footer Area End ****** -->
  
</body>
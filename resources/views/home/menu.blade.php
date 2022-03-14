<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

     <!-- Title -->
    <title>Gourmet Tamale - Menu</title>

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
    <div class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/hero-2.jpg)">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h2>Menu</h2>
                        <a href="#menu" id="menubtn" class="btn caviar-btn"><span></span> Special</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Breadcumb Area End ***** -->

    <!-- ***** Menu Area Start ***** -->
    <div class="caviar-food-menu section-padding-150 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <div class="food-menu-title">
                        <h2>Menu</h2>
                    </div>
                </div>

                <div class="col-10">
                    <div class="caviar-projects-menu">
                        <div class="text-center portfolio-menu">
                            <button class="active" data-filter="*">All</button>
                            <button data-filter=".breakfast">breakfast</button>
                            <button data-filter=".lunch">lunch</button>
                            <button data-filter=".dinner">dinner</button>
                        </div>
                    </div>

                    <div class="caviar-menu-slides owl-carousel clearfix">

                        <div class="caviar-portfolio clearfix">
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item breakfast wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-1.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item breakfast dinner wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-2.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item lunch wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-3.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item lunch wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-1.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item dinner wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-2.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="caviar-portfolio clearfix">
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item breakfast wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-1.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item breakfast dinner wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-2.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item lunch wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-3.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item lunch wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-1.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item dinner wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-2.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="caviar-portfolio clearfix">
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item breakfast wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-1.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item breakfast dinner wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-2.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item lunch wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-3.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item lunch wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-1.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Gallery Item -->
                            <div class="single_menu_item dinner wow fadeInUp">
                                <div class="d-sm-flex align-items-center">
                                    <div class="dish-thumb">
                                        <img src="img/menu-img/dish-2.png" alt="">
                                    </div>
                                    <div class="dish-description">
                                        <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                        <p>Sed commodo augue eu diam tincidunt, sit amet auctor lectus semper. Mauris porttitor diam at fringilla tempor.</p>
                                    </div>
                                    <div class="dish-value">
                                        <h3>$45</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ***** Menu Area End ***** -->

    <!-- ***** Special Menu Area Start ***** -->
    <section class="caviar-dish-menu clearfix" id="menu">
        <div class="container">
            <div class="row">
                <div class="col-12 menu-heading">
                    <div class="section-heading text-center">
                        <h2>Special</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="caviar-single-dish wow fadeInUp" data-wow-delay="0.5s">
                        <img src="img/menu-img/dish-1.png" alt="">
                        <div class="dish-info">
                            <h6 class="dish-name">Lorem Ipsum Dolor Sit Amet</h6>
                            <p class="dish-price">$45</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="caviar-single-dish wow fadeInUp" data-wow-delay="1s">
                        <img src="img/menu-img/dish-2.png" alt="">
                        <div class="dish-info">
                            <h6 class="dish-name">Lorem Ipsum</h6>
                            <p class="dish-price">$45</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="caviar-single-dish wow fadeInUp" data-wow-delay="1.5s">
                        <img src="img/menu-img/dish-3.png" alt="">
                        <div class="dish-info">
                            <h6 class="dish-name">Lorem Ipsum Dolor Sit Amet</h6>
                            <p class="dish-price">$45</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Special Menu Area End ***** -->

    <!-- ****** Footer Area Start ****** -->
    @include('home.common.pie')
    <!-- ****** Footer Area End ****** -->

  
</body>
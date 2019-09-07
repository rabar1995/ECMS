<!DOCTYPE html>
<html lang="en">

<head>
    <title>ECMS</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="fontawesome-free-5.7.2-web/css/all.css">

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>


<body class="row justify-content-center" style='background-image:url("bg.jpg")'>
    <header class="header col-md-12 shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark main-nav">
            <a class="navbar-brand nav-title m-2" href="#"><img src="img/paradigm-logo.png" class="ml-3" alt="ECMS" id='header-logo'></a>
            <button class="navbar-toggler mr-1" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars nav-bars" style="font-size:2em;"></span>
            </button>
    </header>

    <div class="intro-banner jumbotron bg-dark text-light row justify-content-center shadow-none">
        <div class="col-md-12">
        <h1 class="display-3">Electronic Counting Managment</h1>
        <p class="lead">Make your career easier, faster and work on it everywhere</p>
        <a href="login.php" class="btn btn-primary btn-lg">Try It</a>
    </div>
    </div>

    <div class="content" style="width:100%;">


        <section class="service-top-area padding-100-50 mt-5 p-5" id="features" style="background-color:white; width:100%;">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <div class="single-service text-center wow fadeIn">
                            <div class="service-icon">
                                <span class="fas fa-shopping-cart" style="font-size:3em;"></span>
                            </div>
                            <h3>Buy and Sell</h3>
                            <p>You can buy and sell products, and improve your career</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <div class="single-service text-center wow fadeIn">
                            <div class="service-icon">
                                <span class="fa fa-users" style="font-size:3em;"></span>
                            </div>
                            <h3>Employ Salary</h3>
                            <p>Manage your employs and thier salary.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                        <div class="single-service text-center wow fadeIn">
                            <div class="service-icon">
                            <span class="fa fa-cash-register" style="font-size:3em;"></span>
                            </div>
                            <h3>Loans</h3>
                            <p>Keep track of your loans and your financial assets.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--SERVICE TOP AREA END-->

    </div>

    <?php
        include "footer.php"
    ?>
</body>

</html>

<!doctype html>
<html>

<head>
    <title>ECMS</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="fontawesome-free-5.7.2-web/css/all.css">

    <link rel="icon" type="image/png" href="img/paradigm_logo_min_TtB_icon.ico">

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/util.js"></script>

    <!--PHP CODE-->
    <?php
    session_start();
    
    include 'database_connection.php';
       
    
    if(!empty($_POST['username'] == "admin" and $_POST['password'] == "adminXhemn")){
        $_SESSION["username"] = "aryan";
    } else if(!empty($_POST['username'])){
        $fail = "true"; 
    }
    if($_SESSION["username"] == "aryan"){
        header("Location: ./index.php");
    }
    if($_GET["logout"] == "true"){
        session_destroy();
    }
    
    ?>
</head>

<body class="row justify-content-center">
    <header class="header col-md-12">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark main-nav">
            <a class="navbar-brand nav-title m-auto" href="#"><img src="img/paradigm-logo.png" class="ml-3" alt="ECMS" style="height:150px !important;"></a>
        </nav>
    </header>
    <div class="content justify-content-center row col-md-12">
        <div class="title col-md-12">
            Log in
        </div>
        <div class="items col-md-6 p-5 justify-content-center">
            <form method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">User Name</label>
                    <input name="username" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary p-2">Login</button>
            </form>
        </div>
    </div>
    <div class="toast mr-5 mb-5 p-3" style="position:fixed;bottom:0; right:0;z-index:2;" data-delay="9000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">info</strong>
            <small>Now</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="toast-body text-wight-bold">
           Login failed, try again!
        </div>
        <script>
            if ('<?php echo $fail;?>' == 'true') {
                $(".toast").toast("show");
            }

        </script>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

    </script>
</body>

</html>

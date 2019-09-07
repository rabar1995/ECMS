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
    
    if($_SESSION["username"] != "aryan"){
        header("Location: ./login.php");
    }
       
    if(!empty($_GET["delete"])){
    $db -> query("DELETE FROM `charity` WHERE id=".$_GET["delete"]);
        unset($_GET["delete"]);
        $success == "true"?:$success="delete";
    }
    
    if(!empty($_POST['name'])){
        $db -> query("INSERT INTO `charity` (`name`, `phone`, `address`) VALUES ('".$_POST['name']."','".$_POST["phone"]."','".$_POST['address']."')");
        $success = "true";
    }
    
    
    try{
        if($_POST["search"]){
            $result = $db -> query("select * from charity where name LIKE '%".$_POST["search"]."%'");
            $res = $result->fetchAll();
        }else{
            
            $avg_amount = $db -> query("select count(id) from charity where 1");
            $avg_amount_res = $avg_amount->fetchAll(); 

            $sum_all = $db -> query("select sum(amount) from charity_payment where 1");
            $sum_all_res = $sum_all->fetchAll(); 
            
            if(empty($_GET["page"])){
                $page = 0;
            }else{
                $page = $_GET["page"];
            }
            if($page != 0 ){
                $page *= 10;
            }
            
            $number_of_results = $avg_amount_res[0][1];
            $results_per_page = 10;
            $number_of_pages=ceil($number_of_results/$results_per_page);
            $start_number=($page-1)*$results_per_page;
            
            $result = $db -> query("select * from charity order by id desc limit ".$page.",10");
            $res = $result->fetchAll();
            
        }
        
    }catch(Exception $e){
        echo 'database not working';
    }
    
    ?>
</head>

<body class="row justify-content-center">
    <header class="header col-md-12">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark main-nav">
            <a class="navbar-brand nav-title m-2" href="#"><img src="img/paradigm-logo.png" class="ml-3"
                    alt="ECMS" id='header-logo'></a>
            <button class="navbar-toggler mr-1" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars nav-bars" style="font-size:2em;"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav mr-3">
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="login.php?logout=true">Log out<span
                                class="fa fa-lg fa-power-off ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="spend_counting.php">Expenditure<span
                                class="fa fa-lg fa-dollar-sign ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-light" href="charity.php">خێرەکان<span
                                class="fa fa-lg fa-coins ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="order.php">Order<span
                                class="fa fa-lg fa-truck ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="loans-info.php">Loans<span
                                class="fa fa-lg fa-cash-register ml-1"></span></a>
                    </li>
                    <li class="nav-item dropdown p-2">
                        <a href="#" class="nav-link dropdown-toggle text-warning" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">
                            Parts<span class="fa fa-lg fa-sitemap ml-1"></span>
                        </a>
                        <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">
                            <a href="part.php?part=1" class="dropdown-item text-warning">Mechanic<span
                                    class="fa fa-lg fa-cogs ml-1" style="font-size:0.8em;"></span></a>
                            <a href="part.php?part=2" class="dropdown-item text-warning">Electronic<span
                                    class="fa fa-lg fa-bolt ml-1" style="font-size:0.8em;"></span></a>
                            <a href="part.php?part=3" class="dropdown-item text-warning">Civil<span
                                    class="fa fa-lg fa-users-cog ml-1" style="font-size:0.8em;"></span></a>
                            <a href="part.php?part=4" class="dropdown-item text-warning">Architecture<span
                                    class="fa fa-lg fa-hotel ml-1" style="font-size:0.8em;"></span></a>
                        </div>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="index.php">Home<span
                                class="fa fa-lg fa-home ml-1"></span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="content justify-content-center row col-md-12">
        <div class="col-md-6">
            <form method="post" class="mt-4 row"><input type="text" class="form-control col-md-4" name="search"><button
                    type="submit" class="btn btn-success ml-2 col-md-2">Search <span
                        class="fa fa-search"></span></button></form>
        </div>
        <div class="row col-md-6 justify-content-end">
            <a class="plus-button" href="#" data-toggle="modal" data-target="#exampleModal">زیادکردنی&nbsp;خێر<span
                    class="fa fa-lg fa-plus ml-1"></span></a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">زیادکردنی&nbsp;خێر</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="row">
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">ناوی&nbsp;کەسەکە</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="name" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">ژمارەی&nbsp;تەلەفۆن</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="phone" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">Address</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="address" required>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary mt-4">زیادکردن <span
                                            class="fa fa-lg fa-plus ml-1"></span></button>
                                </div>
                            </form>
                            <script>
                                $("#exampleInputEmail11").keypress(function (e) {
                                    if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e
                                            .which > 57)) {
                                        return false;
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <a class="plus-button" href="#" dir="rtl">کۆی&nbsp;خێر:<?php echo number_format($sum_all_res[0][0], 2); ?>&nbsp;$</a>
            <a class="plus-button" href="#">ژمارەی خێر:<?php echo $avg_amount_res[0][0]; ?></a>
        </div>

        <div class="title col-md-12">
            بەشـی&nbsp;خــێـرەکان
        </div>
        <div class="items col-md-10 justify-content-center">
            <div class="table-list table-responsive-sm col-md-12">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" id="c1">ناوی کەس</th>
                            <th scope="col" id="c2">Phone number</th>
                            <th scope="col" id="c3">Address</th>
                            <th scope="col" id="c4"> کۆی خێر</th>
                            <th scope="col" id="c6">Edit</th>
                            <th scope="col" id="c6">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i<sizeof($res);$i=$i+1){ ?>
                        <tr scope="row">
                            <td id="c1"><?php echo $res[$i][1]?></td>
                            <td id="c1"><?php echo $res[$i][2]?></td>
                            <td id="c1"><?php echo $res[$i][3]?></td>
                            <?php 
                            $sum = $db -> query("select sum(amount) from charity_payment where cid = {$res[$i][0]}");
                            $sum_res = $sum->fetchAll(); ?>

                            <td id="c1"><?php echo number_format($sum_res[0][0], 2)?> $</td>
                            <td id="c5"><a href="charity_payment.php?charity=<?php echo $res[$i][0] ?>"><span class="fa fa-edit"></span></a></td>
                            <td id="c6">
                                <a onclick="deleteRow(<?php echo $res[$i][0];?>)"><span class="fa fa-times"></span></a>
                            </td>
                        </tr>
                        <?php } ?>
                        <script type="text/javascript">
                            function deleteRow(rowId) {
                                if (confirm("دڵنیایت لە Deleteی داتاکەت؟")) {
                                    window.location.href = "charity.php?delete=" + rowId
                                }
                            }
                        </script>
                    </tbody>
                </table>
            </div>
            <div class="row justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php for($i=1;$i<=$number_of_pages;$i=$i+1){?>
                        <li><a class="text-dark page-link <?php if(($i-1)==($page/10)){echo "bg-warning";}?>"
                                <?php echo 'href="charity.php?page='.($i-1).'"';?>>
                                <?php echo $i;?></a></li>
                        <?php }?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="toast mr-5 mb-5 p-3" style="position:fixed;bottom:0; right:0;z-index:2;" data-delay="9000" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">زانیاری</strong>
            <small>Now</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="toast-body text-wight-bold">
            <?php
            if($success == "true"){
                echo "خێر بە سەرکەوتویی زیادکرا";
            }else if($success == "delete"){
                echo "خێر بەسەرکەوتویی سڕایەوە";
            }
            ?>

        </div>
        <script>
            if ('<?php echo $success?>' == 'true' || '<?php echo $success?>' == 'delete') {
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
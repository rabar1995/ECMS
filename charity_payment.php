<!doctype html>
<html>

<head>
    <title>ECMS</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="fontawesome-free-5.7.2-web/css/all.css">

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>

    <!--PHP CODE-->
    <?php
    session_start();
    
    include 'database_connection.php';
    
    if($_SESSION["username"] != "aryan"){
        header("Location: ./login.php");
    }
    
    if(!empty($_GET["delete"])){
    $db -> query("DELETE FROM `charity_payment` WHERE id = {$_GET["delete"]}");
    }
    if(!empty($_POST["amount"])){
        $db -> query("INSERT INTO `charity_payment`(`cid`, `amount`, `date`, `note`) VALUES ({$_GET["charity"]},{$_POST["amount"]},'{$_POST["date"]}','{$_POST["note"]}')");
    }
      try{
        $result = $db -> query("select * from charity where id = {$_GET["charity"]}");
        $res = $result->fetchAll();

        $pay = $db -> query("select * from charity_payment where cid = {$_GET["charity"]}");
        $pay_res = $pay->fetchAll();
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
                        <a class="nav-link text-warning" href="charity.php">خێرەکان<span
                                class="fa fa-lg fa-coins ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="order.php">Order<span
                                class="fa fa-lg fa-truck ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-light" href="loans-info.php">Loans<span
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
        <div class="title col-md-12">
            <?php
                if($_GET["type"]=="get"){
                    echo "بەشی وەرگرتنی قەرز";
                }else if($_GET["type"]=="spend"){
                    echo "بەشی پێدانی قەرز";
                }
            ?>
        </div>
        <div class="items col-md-10 row justify-content-center">
            <form method="post">
                <label>زانیاری کەسی خێرپێکراو</label>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label>ناوی&nbsp;کەسەکە</label>
                        <input name="name" readonly type="text"
                            class="form-control form-control-lg form-control form-control-lg-lg"
                            value="<?php echo $res[0][1]; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Phone number</label>
                        <input name="address" readonly type="text" class="form-control form-control-lg"
                            value="<?php echo $res[0][2]; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Address</label>
                        <input name="note" readonly type="text" class="form-control form-control-lg"
                            value="<?php echo $res[0][3]; ?>">
                    </div>
                </div>
            </form>
        </div>

        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="col-md-12">
                <form method="post">
                    <label>پێدانی پارە</label>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <label>بری پارە</label>
                            <input type="text" required name="amount" class="form-control form-control-lg">
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <input type="date" required name="date" class="form-control form-control-lg">
                        </div>

                        <div class="col-md-3">
                            <label>Note</label>
                            <input type="text" required name="note" class="form-control form-control-lg">
                        </div>
                        <input type="submit" value="پێدانی خێر"
                            class="form-control form-control-lg btn btn-primary col-md-2"
                            style="background-color:#2d3561; margin-top:30px;">
                    </div>
                    <script>
                        $("#loan-spend").keypress(function (e) {
                            if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which >
                                57)) {
                                return false;
                            }
                        });
                    </script>
                </form>
            </div>
        </div>

        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="table-list table-responsive-sm col-md-8">
                <label>لیستی خێرەکان</label>
                <hr>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr style="background-color: #f99d1d; ">
                            <th scope="col" class="p-2">#</th>
                            <th scope="col" class="p-2">بڕی پارە</th>
                            <th scope="col" class="p-2">Date</th>
                            <th scope="col" class="p-2">Note</th>
                            <th scope="col" class="p-2">Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        for($i = 0; $i<sizeof($pay_res);$i=$i+1){
                        ?>
                        <tr scope="row">
                            <td id="c1"><?php echo $i ?></td>
                            <td id="c1"><?php echo number_format($pay_res[$i][2], 2);?> $</td>
                            <td id="c1"><?php echo $pay_res[$i][3];?></td>
                            <td id="c1" style="max-width:150px;;"><?php echo $pay_res[$i][4];?></td>
                        <td id="c6">
                                <a onclick="deleteRow(<?php echo $pay_res[$i][0];?>)"><span class="fa fa-times"></span></a>
                            </td>
                        </tr>
                        <?php } ?>
                        <script type="text/javascript">
                            function deleteRow(rowId) {
                                if (confirm("دڵنیایت لە Deleteی داتاکەت؟")) {
                                    window.location.href = "charity_payment.php?charity=<?php echo $_GET["charity"]; ?>&delete=" + rowId
                                }
                            }

                        </script>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 row">
                <a class="nav-link btn btn-dark col-md-3 mt-2 p-3 m-auto ml-4"
                    href="charity_payment_print.php?charity=<?php echo $_GET["charity"] ?>" target="_blank"
                    rel="noopener noreferrer">چاپکردنی خێرەکان<span class="fas fa-lg fa-print ml-1"></span> <span
                        class="sr-only">(current)</span></a>
            </div>
        </div>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>
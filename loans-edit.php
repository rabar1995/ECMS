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
    
      try{
          $result = $db -> query("select * from loans where id=".$_GET['id']);
        $res = $result->fetchAll();
          $sum = $db -> query("select sum(amount) from loan_list where lid=".$_GET['id']);
        $sum_res = $sum->fetchAll();

        if(!empty($_GET["delete"])){
        $db -> query("DELETE FROM `loan_list` WHERE id = {$_GET["delete"]}");
        }

        if(!empty($_POST[name])){
        $db -> query("UPDATE `loans` SET `name`='{$_POST["name"]}',`phone`='{$_POST["phone"]}',`address`='{$_POST["address"]}',`email`='{$_POST["email"]}',`type`='{$_GET["type"]}',`date`='{$_POST["date"]}',`note`='{$_POST["note"]}' WHERE id = {$_GET["id"]}");
        }
          
          if(!empty($_POST['loans_spend']) and $res[0][5]-($sum_res[0][0]+$_POST['loans_spend'])>=0){
              
        $result = $db -> query("select * from loans where id=".$_GET['id']);
        $res = $result->fetchAll();
        
        $db -> query("INSERT INTO `loan_list` (`lid`, `amount`, `date`) VALUES (".$_GET['id'].", ".$_POST['loans_spend'].", '".date('Y-m-d')."')");
        
        $toast = "success";
        
    }else if(!empty($_POST['loans_spend'])){
              $toast="fail";
          }
        $result = $db -> query("select * from loans where id=".$_GET['id']);
        $res = $result->fetchAll();
          
        $spend = $db -> query("select * from loan_list where lid=".$_GET['id']);
        $spend_res = $spend->fetchAll();
        
        $sum = $db -> query("select sum(amount) from loan_list where lid=".$_GET['id']);
        $sum_res = $sum->fetchAll();
          
        $edit="disabled";
    
    }catch(Exception $e){
        echo 'database not working';
    }
  
    
    ?>
</head>

<body class="row justify-content-center">
    <header class="header col-md-12">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark main-nav">
            <a class="navbar-brand nav-title m-2" href="#"><img src="img/paradigm-logo.png" class="ml-3" alt="ECMS" id='header-logo'></a>
            <button class="navbar-toggler mr-1" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars nav-bars" style="font-size:2em;"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav mr-3">
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="login.php?logout=true">Log out<span class="fa fa-lg fa-power-off ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="spend_counting.php">Expenditure<span class="fa fa-lg fa-dollar-sign ml-1"></span></a>
                    </li>
                    
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="order.php">Order<span class="fa fa-lg fa-truck ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-light" href="loans-info.php">Loans<span class="fa fa-lg fa-cash-register ml-1"></span></a>
                    </li>
                    <li class="nav-item dropdown p-2">
                        <a href="#" class="nav-link dropdown-toggle text-warning" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">
                            Parts<span class="fa fa-lg fa-sitemap ml-1"></span>
                        </a>
                        <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">
                            <a href="part.php?part=1" class="dropdown-item text-warning">Mechanic<span class="fa fa-lg fa-cogs ml-1" style="font-size:0.8em;"></span></a>
                            <a href="part.php?part=2" class="dropdown-item text-warning">Electronic<span class="fa fa-lg fa-bolt ml-1" style="font-size:0.8em;"></span></a>
                            <a href="part.php?part=3" class="dropdown-item text-warning">Civil<span class="fa fa-lg fa-users-cog ml-1" style="font-size:0.8em;"></span></a>
                            <a href="part.php?part=4" class="dropdown-item text-warning">Architecture<span class="fa fa-lg fa-hotel ml-1" style="font-size:0.8em;"></span></a>
                        </div>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="index.php">Home<span class="fa fa-lg fa-home ml-1"></span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="content justify-content-center row col-md-12">
        <div class="title col-md-12">
            <?php
                if($_GET["type"]=="get"){
                    echo "Borrowing Part";
                }else if($_GET["type"]=="spend"){
                    echo "Lending Part";
                }
            ?>
        </div>
        <div class="items col-md-10 row">
            <form method="post">
                <label>Payment info</label>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <label>Person name/label>
                        <input name="name" required  type="text" class="form-control form-control-lg form-control form-control-lg-lg" value="<?php echo $res[0][1]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Phone number</label>
                        <input name="phone" required  type="text" class="form-control form-control-lg" value="<?php echo $res[0][2]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Address</label>
                        <input name="address" required type="text" class="form-control form-control-lg" value="<?php echo $res[0][3]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Email</label>
                        <input name="email" required type="text" class="form-control form-control-lg" value="<?php echo $res[0][4]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Date</label>
                        <input name="date" required type="date" class="form-control form-control-lg" value="<?php echo $res[0][7]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Note</label>
                        <input name="note" required type="text" class="form-control form-control-lg" value="<?php echo $res[0][8]; ?>">
                    </div>
                    <input type="submit" value="Save info" class="form-control form-control-lg btn btn-primary col-md-2 mt-4" style="background-color:#2d3561;">
                </div>
            </form>
        </div>

        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="col-md-12">
                <form method="post">
                    <label>Decrese loan</label>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <label>Amount</label>
                            <input type="text" class="form-control form-control-lg" value="<?php echo number_format($res[0][5], 2) ?> $" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Spend Amount</label>
                            <input type="text" class="form-control form-control-lg" value="<?php echo number_format($sum_res[0][0], 2) ?> $" disabled>
                        </div>

                        <div class="col-md-3">
                            <label>Remaining Amount</label>
                            <input type="text" class="form-control form-control-lg" value="<?php echo number_format($res[0][5]-$sum_res[0][0], 2 )?> $" disabled>
                        </div>

                        <div class="col-md-3">
                            <label>Decrease amount</label>
                            <input id="loan-spend" name="loans_spend" required type="text" class="form-control form-control-lg">
                        </div>
                        <input type="submit" value="Decrease loan" class="form-control form-control-lg btn btn-primary col-md-2 mt-4" style="background-color:#2d3561;">
                    </div>
                    <script>
                        $("#loan-spend").keypress(function(e) {
                            if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                                return false;
                            }
                        });

                    </script>
                </form>
            </div>
        </div>

        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="table-list table-responsive-sm col-md-8">
                <label>loan giving back list</label>
                <hr>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr style="background-color: #f99d1d; ">
                            <th scope="col" class="p-2">#</th>
                            <th scope="col" class="p-2">Amount</th>
                            <th scope="col" class="p-2">Remaining</th>
                            <th scope="col" class="p-2">Date</th>
                            <th scope="col" class="p-2"><?php
                                            if($_GET["type"]=="get"){
                                            echo "Give";
                                        }else if($_GET["type"]=="spend"){
                                            echo "get";
                                        }
                                    ?></th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $temp = 0;
                        for($i = 0; $i<sizeof($spend_res);$i=$i+1){
                            $temp += $spend_res[$i][2];
                        ?>
                        <tr scope="row">
                            <td id="c1"><?php echo $i ?></td>
                            <td id="c1"><?php echo number_format($spend_res[$i][2], 2);?> $</td>
                            <td id="c1"><?php echo number_format($res[0][5]-$temp, 2);?> $</td>
                            <td id="c1"><?php echo $spend_res[$i][3]?></td>
                            <td><?php
                                    if($_GET["type"]=="get"){
                                        echo "Payed";
                                    }else if($_GET["type"]=="spend"){
                                        echo "payed";
                                    }
                                ?></td>
                        <td id="c6">
                                <a onclick="deleteRow(<?php echo $spend_res[$i][0];?>)"><span class="fa fa-times"></span></a>
                            </td>
                        </tr>
                        <?php } ?>
                        <script type="text/javascript">
                            function deleteRow(rowId) {
                                if (confirm("Are you sure you want to delete this data?")) {
                                    window.location.href = "loans-edit.php?id=<?php echo $_GET["id"]; ?>&type=<?php echo $_GET["type"]; ?>&delete=" + rowId
                                }
                            }

                        </script>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 row">
                <a class="nav-link btn btn-dark col-md-3 mt-2 p-3 m-auto ml-4" href="loans-print.php?id=<?php echo $_GET["id"] ?>&type=<?php echo $_GET["type"] ?>" target="_blank" rel="noopener noreferrer">Print Loans<span class="fas fa-lg fa-print ml-1"></span> <span class="sr-only">(current)</span></a>
            </div>
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
        <div class="toast-body font-weight-bold">
            <?php if($toast=="success"){?>
            Loan has successfuly decreased
            <?php }else if($toast=="fail"){?>
            Not enough money remain
            <?php }?>
        </div>
        <script>
            if ('<?php echo $toast;?>' == 'success' || '<?php echo $toast;?>' == 'fail') {
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

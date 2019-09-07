<!doctype html>
<html>

<head>
    <title>ECMS</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="fontawesome-free-5.7.2-web/css/all.css">

    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/js/util.js"></script>

    <!--PHP CODE-->
    <?php
    session_start();
    
    include 'database_connection.php';
    
    if($_SESSION["username"] != "aryan"){
        header("Location: ./login.php");
    }
    
     
    try{
        $sum = $db -> query("select sum(amount) from order_pay_list where oid=".$_GET['order']);
        $sum_res = $sum->fetchAll();
        
        $result = $db -> query("select * from oreders where id=".$_GET['order']);
        $res = $result->fetchAll();
        
        $sections = $db -> query("select * from order_section where oid=".$_GET['order']);
        $sections_res = $sections->fetchAll();
        
        $amount = $db -> query("select sum(yaka_avg) from order_section where oid=".$_GET['order']);
        $amount_res = $amount->fetchAll();
        
        $money_avg = number_format($amount_res[0][0], 2);
        
        if($res[0][11]==1){
            $panalty=round((strtotime($res[0][5])-strtotime($res[0][4]))/(24*60*60))-$res[0][6];
            $amount_res[0][0] -= abs($panalty)*$res[0][7];
        }
        
        if(!empty($res[0][2])){
            $edit = "disabled";
        }else{
            $edit="required";
        }
    }catch(Exception $e){
        echo 'database not working';
    }
    
    if(!empty($_POST['loans_spend']) and $amount_res[0][0]-($_POST['loans_spend']+$sum_res[0][0])>=0){
        
        $db -> query("INSERT INTO `order_pay_list` (`oid`, `amount`,  `date`) VALUES (".$_GET['order'].", ".$_POST['loans_spend'].", '".$_POST["spend_date"]."')");
        
        $toast="success"; 
    }else if(!empty($_POST['loans_spend'])){
        $toast="fail";
    }
    if(!empty($_POST['arrive'])){
         if($_POST['arrive']=="arrived"){
            $db -> query("UPDATE oreders SET finish_date='{$_POST["finish_date"]}', arrived = 1 where id=".$_GET['order']);
            $db -> query("UPDATE oreders SET panalty = 0 where id=".$_GET['order']);
            $toast="arrive";
        }
        else if($_POST['arrive']=="not-arrived"){
            $db -> query("UPDATE oreders SET finish_date='{$_POST["finish_date"]}', arrived = 0 where id=".$_GET['order']);
            $db -> query("UPDATE oreders SET panalty = 0 where id=".$_GET['order']);
            $toast="arrive";
        }
    }
    if(!empty($_POST['panalty'])){
        if($_POST['panalty']=="count"){
         $db -> query("UPDATE oreders SET panalty = 1 where id=".$_GET['order']);
         $toast="arrive";
        }
        else if($_POST['panalty']=="not-count"){
            $db -> query("UPDATE oreders SET panalty = 0 where id=".$_GET['order']);
            $toast="arrive";
           }
         
     }
        $sum = $db -> query("select sum(amount) from order_pay_list where oid=".$_GET['order']);
        $sum_res = $sum->fetchAll();
        
        $result = $db -> query("select * from oreders where id=".$_GET['order']);
        $res = $result->fetchAll();
        $loan = $db -> query("select * from order_pay_list where oid=".$_GET['order']);
        $loan_res = $loan->fetchAll();

    
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
                        <a class="nav-link text-light" href="order.php">Order<span
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
        <div class="title col-md-12">
            Order Payment
        </div>
        <?php if(!empty($res[0][2])){?>
        <div class="items col-md-10 row">
            <form method="post">
                <div class="row">
                    <div class="col-md-3">
                        <label>Item name</label>
                        <input name="item-name" disabled type="text"
                            class="form-control form-control-lg form-control form-control-lg-lg"
                            placeholder="<?php echo $res[0][1]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Company name</label>
                        <input <?php echo $edit; ?> type="text" class="form-control form-control-lg"
                            placeholder="<?php echo $res[0][2]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Country name</label>
                        <input <?php echo $edit; ?> type="text" class="form-control form-control-lg"
                            placeholder="<?php echo $res[0][3]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Money Average</label>
                        <div class="input-group">
                            <input <?php echo $edit; ?> type="text" class="form-control form-control-lg"
                                placeholder="<?php echo $money_avg; ?> $">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Order date</label>
                        <div class="input-gorup">
                            <input type="text" <?php echo $edit; ?> class="form-control form-control-lg"
                                value="<?php echo $res[0][4]; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">item is:</label>
                            <select name="arrive" class="form-control form-control-lg" id="exampleFormControlSelect1">
                                <option value="not-arrived" <?php if($res[0][10]=="0"){echo "selected";}?>>not-arrived
                                </option>
                                <option value="arrived" <?php if($res[0][10]=="1"){echo "selected";}?>>arrived</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Arrive date</label>
                        <div class="input-gorup">
                            <input type="date" name="finish_date" class="form-control form-control-lg"
                                value="<?php echo $res[0][5]; ?>">
                        </div>
                    </div>
                    <input type="submit" value="Item is Arrived"
                        class="form-control form-control-lg btn btn-primary col-md-2" style="margin-top:31px;">
                </div>

            </form>
        </div>

        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="col-md-12 mt-3 row justify-content-center">
                <div class="col-md-12 mt-3">Sections
                    <hr>
                </div>
                <table class="table col-md-10 m-auto">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item</th>
                            <th scope="col">Unit type</th>
                            <th scope="col">Unit price</th>
                            <th scope="col">Unit Quantity</th>
                            <th scope="col">Payment type</th>
                            <th scope="col">Average</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0 ; $i < sizeof($sections_res); $i = $i + 1){ ?>
                        <tr>
                            <th scope="row"><?php echo $i+1;?></th>
                            <td><?php echo $sections_res[$i][2];?></td>
                            <td><?php 
                                            if($sections_res[$i][3]=="m"){
                                                echo "M";
                                            }else if($sections_res[$i][3]=="m2"){
                                                echo "M<sup>2</sup>";
                                            }else if($sections_res[$i][3]=="m3"){
                                                echo "M<sup>3</sup>";
                                            }else if($sections_res[$i][3]=="q"){
                                                echo "Quantity";
                                            }
                                        ?>
                            </td>
                            <td><?php echo number_format($sections_res[$i][4], 2);?> $</td>
                            <td><?php echo $sections_res[$i][5];?></td>
                            <td><?php 
                                            if($sections_res[$i][6]=="naqd"){
                                                echo "Cash";
                                            }else if($sections_res[$i][6]=="qontarat"){
                                                echo "Loan";
                                            }
                                        ?>
                            </td>
                            <td><?php echo number_format($sections_res[$i][4]*$sections_res[$i][5], 2);?> $</td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <div class="row col-md-12 justify-content-center text-center">
                    <div class="border border-dark col-md-4 p-3">
                        Average of money : <?php echo $money_avg; ?> $
                    </div>
                </div>
            </div>
        </div>
        <?php if($res[0][10]=="1"){ ?>
        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="col-md-12">
                <form method="post">
                    <label>Panalty section</label>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <label>Arrive date</label>
                            <input type="text" name="finish_date" class="form-control form-control-lg"
                                placeholder="<?php echo $res[0][5] ?>" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>panalty time</label>
                            <div class="input-gorup">
                                <input type="text" <?php echo $edit; ?> name="p_time"
                                    class="form-control form-control-lg" placeholder="<?php echo $res[0][6]; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Panalty cost per day</label>
                            <div class="input-gorup">
                                <input type="text" <?php echo $edit; ?> name="p_cost"
                                    class="form-control form-control-lg"
                                    placeholder="<?php echo number_format($res[0][7], 2); ?> $">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Number of order Days</label>
                            <input type="text" name="finish_date"
                                value="<?php echo round((strtotime($res[0][5])-strtotime($res[0][4]))/(24*60*60)); ?>"
                                class="form-control form-control-lg" placeholder="<?php echo $res[0][4] ?>" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Panalty days</label>
                            <input type="text" name="finish_date" value="<?php
                            
                            $panalty=round((strtotime($res[0][5])-strtotime($res[0][4]))/(24*60*60))-$res[0][6];
                            if($panalty <= 0){
                                $panalty = 0;
                            }
                            echo $panalty;   
                            ?>" class="form-control form-control-lg" placeholder="<?php echo $res[0][5] ?>" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Panalty cost</label>
                            <input type="text" class="form-control form-control-lg"
                                placeholder="<?php echo number_format(abs($panalty)*$res[0][7], 2); ?> $" disabled>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">The item</label>
                                <select name="panalty" class="form-control form-control-lg"
                                    id="exampleFormControlSelect1" <?php if($panalty==0) echo "disabled" ?>>
                                    <option value="count" <?php if($res[0][11]=="1"){echo "selected";}?>>Panalty counted
                                    </option>
                                    <option value="not-count" <?php if($res[0][11]=="0"){echo "selected";}?>>Panalty not-counted
                                    </option>
                                </select>
                            </div>
                        </div>
                        <input type="submit" value="Counting panalty"
                            class="form-control form-control-lg btn btn-primary col-md-2" style="margin-top:31px;" <?php if($panalty==0) echo "hidden"?>>
                    </div>
                </form>
            </div>
        </div>
        <?php } ?>
        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="col-md-12">
                <form method="post">
                    <label>Payment</label>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <label>Remaining loan</label>
                            <input type="text" name="remain"
                                value="<?php echo number_format($amount_res[0][0]-$sum_res[0][0], 2); ?> $"
                                class="form-control form-control-lg" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>payed loan</label>
                            <input type="text" class="form-control form-control-lg"
                                placeholder="<?php echo number_format($sum_res[0][0], 2) ?> $" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Decrease amount</label>
                            <input id="spend" name="loans_spend" type="text" class="form-control form-control-lg"
                                required>
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <input id="spend_date" name="spend_date" type="date" class="form-control form-control-lg"
                                required>
                        </div>
                        <input type="submit" value="Decrease Loan"
                            class="form-control form-control-lg btn btn-primary col-md-2"
                            style="margin-top:31px;background-color: #2d3561;">
                    </div>
                </form>
                <script>
                    $("#spend").keypress(function (e) {
                        if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });
                </script>
            </div>
        </div>
        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="table-list table-responsive-sm col-md-8">
                <label>Loan payment list</label>
                <hr>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" id="c1">#</th>
                            <th scope="col" id="c2">amount</th>
                            <th scope="col" id="c2">remain</th>
                            <th scope="col" id="c3">Date</th>
                            <th scope="col" id="c3">give</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $temp = 0;  
                            for($i = 0; $i<sizeof($loan_res);$i=$i+1){
                            $temp += $loan_res[$i][2];
                        ?>
                        <tr scope="row">
                            <td id="c1"><?php echo $i ?></td>
                            <td id="c1"><?php echo number_format($loan_res[$i][2], 2);?> $</td>
                            <td id="c1"><?php echo number_format($amount_res[0][0]-$temp, 2);?> $</td>
                            <td id="c1"><?php echo $loan_res[$i][3]?></td>
                            <td id="c1">given</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 row">
                <a class="nav-link btn btn-dark col-md-3 mt-2 p-3 m-auto ml-4"
                    href="order-payment-print.php?order=<?php echo $_GET["order"] ?>" target="_blank"
                    rel="noopener noreferrer">Print Loans<span class="fas fa-lg fa-print ml-1"></span> <span
                        class="sr-only">(current)</span></a>
            </div>
        </div>
    </div>
    <div class="toast mr-5 mb-5 p-3" style="position:fixed;bottom:0; right:0;z-index:2;" data-delay="9000" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">info</strong>
            <small>Now</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="toast-body text-wight-bold">
            <?php if($toast=="success"){?>
            Payment has successfuly been done
            <?php }else if($toast=="fail"){?>
            Payment fails, there are not enough money
            <?php }?>
        </div>
        <script>
            if ('<?php echo $toast;?>' == 'success' || '<?php echo $toast;?>' == 'fail') {
                $(".toast").toast("show");
            }
        </script>
    </div>
    <?php } else{echo "<div class='title col-md-12 mt-5'><div class='items col-md-10 justify-content-center mt-5'>
             Please fill the Order contract first
        </div></div>";}?>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>
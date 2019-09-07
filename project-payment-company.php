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
        
        $sum = $db -> query("select sum(amount) from payment_get where cid=".$_GET['project']);
        $sum_res = $sum->fetchAll();
        
        
        $result = $db -> query("select * from company_contract where cid=".$_GET['project']);
        $res = $result->fetchAll();
        
        $amount = $db -> query("select sum(yaka_avg) from company_contract_section where pid=".$_GET['project']);
        $amount_res = $amount->fetchAll();

        if(!empty($res[0][2])){
            $edit = "disabled";
        }else{
            $edit="";
        }
    }catch(Exception $e){
        echo 'database not working';
    }
    
    if(!empty($_POST['amount']) and ($amount_res[0][0]-($sum_res[0][0]+$_POST["amount"])>=0)){
            $avg = $_POST["amount"] * $_POST["yaka_amount"];
            $db -> query("INSERT INTO `payment_get`(`cid`, `amount`, `yaka_amount`, `yaka_type`, `date`, `avg`, `title`) VALUES ({$_GET["project"]},{$_POST["amount"]},{$_POST["yaka_amount"]},'{$_POST["yaka_type"]}','{$_POST["date"]}', {$avg}, '{$_POST["title"]}')");
            $toast = "success";
    }else if(!empty($_POST['amount'])){
        $toast = "fail";
    }
        $pay_list = $db -> query("select * from payment_get where cid=".$_GET['project']);
        $pay_res = $pay_list->fetchAll();
    
        $sum = $db -> query("select sum(avg) from payment_get where cid=".$_GET['project']);
        $sum_res = $sum->fetchAll();
        
        $sections = $db -> query("select * from company_contract_section where pid=".$_GET['project']);
        $sections_res = $sections->fetchAll();
        
        $amount = $db -> query("select sum(yaka_avg) from company_contract_section where pid=".$_GET['project']);
        $amount_res = $amount->fetchAll();
    
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
                        <a class="nav-link text-warning" href="order.php">Order<span
                                class="fa fa-lg fa-truck ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="loans-info.php">Loans<span
                                class="fa fa-lg fa-cash-register ml-1"></span></a>
                    </li>
                    <li class="nav-item dropdown p-2">
                        <a href="#" class="nav-link dropdown-toggle text-light" id="navbarDropdownMenuLink"
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

        <?php if(!empty($res[0][1])){ ?>
        <div class="title col-md-12">
            Company payment
        </div>
        <div class="items col-md-10 row">
            <div class="col-md-12">Company info
                <hr>
            </div>
            <div class="col-md-3">
                <label>Company name</label>
                <input name="name" <?php echo $edit; ?> type="text"
                    class="form-control form-control-lg form-control form-control-lg-lg"
                    placeholder="<?php echo $res[0][1]; ?>">
            </div>
            <div class="col-md-3">
                <label>Phone number</label>
                <input name="phone" <?php echo $edit; ?> type="text" class="form-control form-control-lg"
                    placeholder="<?php echo $res[0][2]; ?>">
            </div>
            <div class="col-md-3">
                <label>Email</label>
                <input name="email" <?php echo $edit; ?> type="email" class="form-control form-control-lg"
                    placeholder="<?php echo $res[0][3]; ?>">
            </div>
            <div class="col-md-3">
                <label>Address</label>
                <input name="address" <?php echo $edit; ?> type="text" class="form-control form-control-lg"
                    placeholder="<?php echo $res[0][4]; ?>">
            </div>
            <div class="col-md-3">
                <label>Note</label>
                <input name="note" <?php echo $edit; ?> type="text" class="form-control form-control-lg"
                    placeholder="<?php echo $res[0][5]; ?>">
            </div>
            <div class="col-md-3">
                <label>Date</label>
                <input readonly type="text"
                    <?php if(empty($res[0][10])){echo "value='".date('Y-m-d')."'";}else{echo "value='".$res[0][10]."'";} ?>
                    class="form-control form-control-lg">
            </div>
            <div class="col-md-12 mt-3 row justify-content-center">
                <div class="col-md-12 mt-3">Sections
                    <hr>
                </div>
                <table class="table col-md-10 m-auto">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item type</th>
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
                            <td><?php echo $sections_res[$i][4];?></td>
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
                    <div class="border border-dark col-md-4 p-3 m-3">
                        Average of money: <?php echo number_format($amount_res[0][0], 2); ?> $
                    </div>
                </div>
            </div>
        </div>
        <div class="items col-md-10 justify-content-center mt-5">
            <form class="col-md-12" method="post">
                <label>Payment info</label>
                <hr>
                <div class="row justify-content-center">
                    <div class="row col-md-12 justify-content-center mb-3">
                        <div class="col-md-3">
                            <label>Acquired Money</label>
                            <input name="name" <?php echo $edit; ?> type="text"
                                class="form-control form-control-lg form-control form-control-lg-lg"
                                placeholder="<?php echo number_format($sum_res[0][0], 2); ?> $">
                        </div>
                        <div class="col-md-3">
                            <label>Left money</label>
                            <input name="name" <?php echo $edit; ?> type="text"
                                class="form-control form-control-lg form-control form-control-lg-lg"
                                placeholder="<?php echo number_format($amount_res[0][0]-$sum_res[0][0], 2); ?> $">
                        </div>
                    </div>
                    <div class="row col-md-12">
                    <div class="col-md-3">
                            <label>Item name</label>
                            <input name="title" type="text" class="form-control form-control-lg">
                        </div>
                        <div class="col-md-2">
                            <label>Unit Quantity</label>
                            <input name="yaka_amount" type="text" class="form-control form-control-lg"
                                placeholder="<?php echo '0'; ?>">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Unit type</label>
                                <select name="yaka_type" class="form-control form-control-lg"
                                    id="exampleFormControlSelect1">
                                    <option value="m">M</option>
                                    <option value="m2">M<sup>2</sup></option>
                                    <option value="m3">M<sup>3</sup></option>
                                    <option value="q">Quantity</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Unit price</label>
                            <input id="amount" name="amount" type="text" class="form-control form-control-lg"
                                placeholder="<?php echo '0'; ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <input name="date" type="date" class="form-control form-control-lg">
                        </div>
                        <div class="row col-md-12 justify-content-center">
                        <div class="m-auto">
                            <button type="submit" class="btn btn-primary p-3">Acquire</button>
                        </div>
                        </div>
                    </div>
                </div>
                <script>
                    $("#amount").keypress(function (e) {
                        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });
                </script>
            </form>
        </div>

        <div class="items col-md-10 mt-5">
            <div class="table-list table-striped table-responsive-sm col-md-12">
                <label>List of acquired money</label>
                <hr>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" id="c1">#</th>
                            <th scope="col" id="c2">Item name</th>
                            <th scope="col" id="c2">Unit Quantity</th>
                            <th scope="col" id="c2">Unit type</th>
                            <th scope="col" id="c3">Unit price</th>
                            <th scope="col" id="c3">Average</th>
                            <th scope="col" id="c3">remain money</th>
                            <th scope="col" id="c3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sum = 0;         
                            for($i = 0; $i<sizeof($pay_res);$i=$i+1){
                            $sum = $sum + $pay_res[$i][2];
                        ?>
                        <tr scope="row">
                            <td id="c1"><?php echo $i;?></td>
                            <td id="c1"><?php echo $pay_res[$i][7];?></td>
                            <td id="c1"><?php echo $pay_res[$i][3];?></td>
                            <td><?php 
                                            if($pay_res[$i][4]=="m"){
                                                echo "M";
                                            }else if($pay_res[$i][4]=="m2"){
                                                echo "M<sup>2</sup>";
                                            }else if($pay_res[$i][4]=="m3"){
                                                echo "M<sup>3</sup>";
                                            }else if($pay_res[$i][4]=="q"){
                                                echo "Quantity";
                                            }
                                        ?>
                                </td>
                            <td id="c1"><?php echo number_format($pay_res[$i][2], 2);?> $</td>
                            <td id="c1"><?php echo number_format($pay_res[$i][2] * $pay_res[$i][3], 2);?> $</td>
                            <td id="c4"><?php echo number_format($amount_res[0][0]-($pay_res[$i][2] * $pay_res[$i][3]), 2);?> $</td>
                            <td id="c4"><?php echo $pay_res[$i][5]?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="col-md-12 row">
                    <a class="nav-link btn btn-dark col-md-3 mt-2 p-3 m-auto ml-4"
                        href="project-payment-company-print.php?part=<?php echo $_GET["part"] ?>&project=<?php echo $_GET["project"] ?>"
                        target="_blank" rel="noopener noreferrer">Print<span
                            class="fas fa-lg fa-print ml-1"></span> <span class="sr-only">(current)</span></a>
                </div>
            </div>
        </div>
        <?php } else{echo "<div class='title col-md-12 mt-5'><div class='items col-md-10 justify-content-center mt-5'>
             Please fill the company contract first
        </div></div>";}?>
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
            payment has been succeed
            <?php }else if($toast=="fail"){?>
            payment fail, there are not enough money
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
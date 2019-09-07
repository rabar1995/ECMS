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
    
    if (isset($_FILES["attachment"])){
            $random=rand(1,10000000);
            $file_name = $random."".$_FILES["attachment"]["name"];
            move_uploaded_file($_FILES["attachment"]["tmp_name"],__DIR__.'\\attachments\\order_contract\\'.$file_name);
            $db -> query("UPDATE oreders set attachment='".$file_name."' where id=".$_GET['order']);
        }
    if(!empty($_POST['company_name'])){
            $db -> query("UPDATE `oreders` SET `item_name`='{$_POST["item_name"]}',`company_name`='{$_POST["company_name"]}',`country_name`='{$_POST["country_name"]}',`order_date`='{$_POST[date]}',`panalty_time`='{$_POST["p_time"]}',`panalty_cost`='{$_POST["p_cost"]}',`note`='{$_POST["note"]}' WHERE id = ".$_GET['order']);
            $success="true";
    }
    
    if(!empty($_POST['item_type'])){
        
            $db -> query("INSERT INTO order_section (oid, item_type, yaka_type, yaka_cost, yaka_amount, payment_type, yaka_avg) values('".$_GET['order']."','".$_POST['item_type']."','".$_POST['yaka_type']."',".$_POST['yaka_cost'].",".$_POST['yaka_amount'].",'".$_POST['payment_type']."', ".$_POST['yaka_cost']*$_POST['yaka_amount'].")");
    }
        $band = $db -> query("select * from order_band where oid=".$_GET['order']);
        $band_res = $band->fetchAll();
    
    if(!empty($band_res[0][2]) and !empty($_POST["first"])){
        $db -> query("UPDATE `order_band` SET `first`='{$_POST["first"]}',`second`='{$_POST["second"]}',`third`='{$_POST["third"]}',`forth`='{$_POST["forth"]}',`fifth`='{$_POST["fifth"]}',`sixth`='{$_POST["sixth"]}' WHERE oid = {$_GET["order"]}");

    }
    
    if(!empty($_POST["first"]) and empty($band_res[0][2])){
        $db -> query("INSERT INTO order_band (oid, first, second, third, forth, fifth, sixth) values ({$_GET["order"]}, '{$_POST["first"]}', '{$_POST["second"]}', '{$_POST["third"]}', '{$_POST["forth"]}', '{$_POST["fifth"]}', '{$_POST["sixth"]}')");

    }
    
    if(!empty($_GET["delete"])){
        $db -> query("DELETE FROM `order_section` WHERE id = {$_GET["delete"]}");
    }
    
    
    try{
        $result = $db -> query("select * from oreders where id=".$_GET['order']);
        $res = $result->fetchAll();
        
        $sections = $db -> query("select * from order_section where oid=".$_GET['order']);
        $sections_res = $sections->fetchAll();
        
        $amount = $db -> query("select sum(yaka_avg) from order_section where oid=".$_GET['order']);
        $amount_res = $amount->fetchAll();
        
        $band = $db -> query("select * from order_band where oid=".$_GET['order']);
        $band_res = $band->fetchAll();
        
        if(!empty($res[0][2])){
            $edit = "disabled";
        }else{
            $edit="required";
        }
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
                        <a class="nav-link text-light" href="order.php">Order<span class="fa fa-lg fa-truck ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="loans-info.php">Loans<span class="fa fa-lg fa-cash-register ml-1"></span></a>
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
            Order contract
        </div>
        <div class="items col-md-10 row">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">Order info
                        <hr>
                    </div>
                    <div class="col-md-3">
                        <label>Order title</label>
                        <input name="item_name" type="text" class="form-control form-control-lg" value="<?php echo $res[0][1]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Company name</label>
                        <input name="company_name" type="text" class="form-control form-control-lg" value="<?php echo $res[0][2]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Country name</label>
                        <input name="country_name" type="text" class="form-control form-control-lg" value="<?php echo $res[0][3]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Panalty Price</label>
                        <input id="p_cost" name="p_cost" type="text" class="form-control form-control-lg" value="<?php echo $res[0][7]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Panalty period</label>
                        <input id="p_time" name="p_time" type="text" class="form-control form-control-lg" value="<?php echo $res[0][6]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Note</label>
                        <input name="note" type="text" class="form-control form-control-lg" value="<?php echo $res[0][8]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Date</label>
                        <input type="date" name="date" <?php echo "value='".$res[0][4]."'"; ?> class="form-control form-control-lg" required>
                    </div>
                    <script>
                        $("#p_cost").keypress(function(e) {
                            if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                                return false;
                            }
                        });
                        $("#p_time").keypress(function(e) {
                            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                return false;
                            }
                        });

                    </script>

                </div>
                <div class="row justify-content-center col-md-12 mt-4">
                    <button type="submit" class="btn btn-primary col-md-3 p-3">Save info</button>
                </div>
            </form>
            <form method="post">
                <div class="row">
                    <div id="sections" class="col-md-12 row mt-3">
                        <div class="col-md-12">Sections
                            <hr>
                        </div>
                        <div class="col-md-4">
                            <label>Item type</label>
                            <input name="item_type" type="text" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Unit type</label>
                                <select name="yaka_type" class="form-control form-control-lg" id="exampleFormControlSelect1">
                                    <option value="m">M</option>
                                    <option value="m2">M<sup>2</sup></option>
                                    <option value="m3">M<sup>2</sup></option>
                                    <option value="q">Quantity</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Unit type</label>
                            <input id="cost" name="yaka_cost" type="text" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-2">
                            <label>Unit Amount</label>
                            <input id="amount" name="yaka_amount" type="text" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Payment type</label>
                                <select name="payment_type" class="form-control form-control-lg" id="exampleFormControlSelect1">
                                    <option value="naqd">Cash</option>
                                    <option value="qontarat">Loan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center col-md-12 mt-4">
                        <button type="submit" class="btn btn-primary col-md-3 p-3">Save Sections</button>
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
                                    <th scope="col">Delete</th>
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
                                    <td><?php echo number_format($sections_res[$i][4],2);?> $</td>
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
                                    <td id="c6" style="text-align:center;"><a onclick="deleteRow(<?php echo $sections_res[$i][0];?>)"><span class="fa fa-times"></span></a></td>
                                </tr>
                                <?php } ?>
                                <script type="text/javascript">
                                    function deleteRow(rowId) {
                                        if (confirm("Are you sure you want to delete this data?")) {
                                            window.location.href = "order-contract.php?order=<?php echo $_GET["order"]; ?>&delete=" + rowId
                                        }
                                    }

                                </script>
                            </tbody>
                        </table>
                        <div class="row col-md-12 justify-content-center text-center">
                            <div class="border border-dark col-md-4 p-3">
                                Average of money: <?php echo number_format($amount_res[0][0], 2); ?> $
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"><input type="text" hidden name='date' value="<?php echo date('Y-m-d'); ?>"></div>
                </div>
                <script>
                    $("#cost").keypress(function(e) {
                        if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });
                    $("#amount").keypress(function(e) {
                        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });

                </script>
            </form>
            <form class="row col-md-12" method="post" enctype="multipart/form-data">
                <div class="col-md-12 row">
                    <label class="col-md-12">
                        Attachment
                        <hr></label>
                    <?php if(empty($res[0][9])){ ?>
                    <div class="custom-file col-md-4 m-auto">
                        <input name="attachment" type="file" class="custom-file-input" id="inputGroupFile04">
                        <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                    </div>
                    <div class="row col-md-3 m-auto">
                        <button type="submit" class="btn btn-primary col-md-12 p-3">Upload attachment<span class="fa fa-upload"></span></button>
                    </div>
                    <?php } else{?>

                    <a class="nav-link btn btn-dark col-md-4 p-3 m-auto" href="attachments/order_contract/<?php echo $res[0][9]; ?>" download>Download attachment<span class="fa fa-lg fa-download ml-1"></span> <span class="sr-only">(current)</span></a>
                    <?php }?>
                    <a class="nav-link btn btn-dark col-md-3 p-3 m-auto" href="order-print.php?order=<?php echo $_GET["order"] ?>" target="_blank" rel="noopener noreferrer">Print contract<span class="fas fa-lg fa-print ml-1"></span> <span class="sr-only">(current)</span></a>
                </div>
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
            Contract has successfuly been updated
        </div>
        <script>
            if ('<?php echo $success?>' == 'true') {
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

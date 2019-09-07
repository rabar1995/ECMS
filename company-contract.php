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
    
        $result = $db -> query("select * from company_contract where cid=".$_GET['project']);
        $res = $result->fetchAll();
    
    if (isset($_FILES["attachment"])){
            $random=rand(1,10000000);
            $file_name = $random."".$_FILES["attachment"]["name"];
            move_uploaded_file($_FILES["attachment"]["tmp_name"],__DIR__.'\\attachments\\company_contract\\'.$file_name);
            $db -> query("UPDATE company_contract set attachment='".$file_name."' where cid=".$_GET['project']);
        }
    if(!empty($_POST["name"] and !empty($res[0][1]))){
        $db -> query("UPDATE `company_contract` SET `name`='{$_POST["name"]}',`phone`='{$_POST["phone"]}',`email`='{$_POST["email"]}',`address`='{$_POST["address"]}',`date`='{$_POST["date"]}',`note`='{$_POST["note"]}' WHERE cid = {$_GET["project"]}");
    }
    
    else if(!empty($_POST['name'])){
            $db -> query("INSERT INTO `company_contract` (`cid`, `name`, `phone`, `email`, `address`, `date`, `note`, `attachment`) VALUES ('".$_GET['project']."', '".$_POST['name']."', '".$_POST['phone']."', '".$_POST['email']."', '".$_POST['address']."', '".$_POST['date']."', '".$_POST['note']."', '".$file_name."')");
            $success = "true";
        }
    if(!empty($_POST['job_type'])){ 
        $db -> query("INSERT INTO company_contract_section (pid, job_type, yaka_type, yaka_cost, yaka_amount, payment_type, yaka_avg) values('".$_GET['project']."','".$_POST['job_type']."','".$_POST['yaka_type']."','".$_POST['yaka_cost']."','".$_POST['yaka_amount']."','".$_POST['payment_type']."', ".$_POST['yaka_cost']*$_POST['yaka_amount'].")");
    }
    if(!empty($_GET["delete"])){
        $db -> query("DELETE FROM `company_contract_section` WHERE id = {$_GET["delete"]}");
    }

    $band = $db -> query("select * from company_band where cid=".$_GET['project']);
    $band_res = $band->fetchAll();
    
    if(!empty($band_res[0][2]) and !empty($_POST["first"])){
        $db -> query("UPDATE `company_band` SET `first`='{$_POST["first"]}',`second`='{$_POST["second"]}',`third`='{$_POST["third"]}',`forth`='{$_POST["forth"]}',`fifth`='{$_POST["fifth"]}',`sixth`='{$_POST["sixth"]}' WHERE cid = {$_GET["project"]}");
        
    }
    
    if(!empty($_POST["first"]) and empty($band_res[0][2])){
        $db -> query("INSERT INTO company_band (cid, first, second, third, forth, fifth, sixth) values ({$_GET["project"]}, '{$_POST["first"]}', '{$_POST["second"]}', '{$_POST["third"]}', '{$_POST["forth"]}', '{$_POST["fifth"]}', '{$_POST["sixth"]}')");
        
    }
    
    try{
        $result = $db -> query("select * from company_contract where cid=".$_GET['project']);
        $res = $result->fetchAll();
        
        $sections = $db -> query("select * from company_contract_section where pid=".$_GET['project']);
        $sections_res = $sections->fetchAll();
        
        $amount = $db -> query("select sum(yaka_avg) from company_contract_section where pid=".$_GET['project']);
        $amount_res = $amount->fetchAll();

        $band = $db -> query("select * from company_band where cid=".$_GET['project']);
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
                        <a class="nav-link text-warning" href="order.php">Order<span class="fa fa-lg fa-truck ml-1"></span></a>
                    </li>
                    <li class="nav-item active p-2">
                        <a class="nav-link text-warning" href="loans-info.php">Loans<span class="fa fa-lg fa-cash-register ml-1"></span></a>
                    </li>
                    <li class="nav-item dropdown p-2">
                        <a href="#" class="nav-link dropdown-toggle text-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">
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
            Company contract
        </div>
        <div class="items col-md-10 row">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">Company info
                        <hr>
                    </div>
                    <div class="col-md-3">
                        <label>Company name</label>
                        <input name="name" type="text" class="form-control form-control-lg form-control form-control-lg-lg" value="<?php echo $res[0][1]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Phone number</label>
                        <input name="phone" type="text" class="form-control form-control-lg" value="<?php echo $res[0][2]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control form-control-lg" value="<?php echo $res[0][3]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Address</label>
                        <input name="address" type="text" class="form-control form-control-lg" value="<?php echo $res[0][4]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Note</label>
                        <input name="note" type="text" class="form-control form-control-lg" value="<?php echo $res[0][6]; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Date</label>
                        <input type="date" <?php echo "value='".$res[0][5]."'"; ?> class="form-control form-control-lg" name="date" required>
                    </div>
                    <div class="row justify-content-center col-md-12">
                        <button type="submit" class="btn btn-primary col-md-3 p-3 mt-5">Save info</button>
                    </div>
                </div>
            </form>

            <form method="post">
                <div class="row">
                    <div id="sections0" class="col-md-12 row mt-3">
                        <div class="col-md-12">Sections
                            <hr>
                        </div>
                        <div class="col-md-4">
                            <label>Item type</label>
                            <input name="job_type" type="text" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Unit type</label>
                                <select name="yaka_type" class="form-control form-control-lg" id="exampleFormControlSelect1">
                                    <option value="m">M</option>
                                    <option value="m2">M<sup>2</sup></option>
                                    <option value="m3">M<sup>3</sup></option>
                                    <option value="q">Quantity</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Unit price</label>
                            <input id="cost" name="yaka_cost" type="text" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-2">
                            <label>Unit quantity</label>
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
                        <button type="submit" class="btn btn-primary col-md-3 p-3">Save section</button>
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
                                    
                                    <td><?php echo number_format($sections_res[$i][4], 2);?> $</td>
                                    <td><?php echo $sections_res[$i][5];?></td>
                                    <td><?php 
                                            if($sections_res[$i][6]=="naqd"){
                                                echo "cash";
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
                                            window.location.href = "company-contract.php?part=<?php echo $_GET["part"]; ?>&project=<?php echo $_GET["project"]; ?>&delete=" + rowId
                                        }
                                    }

                                </script>
                            </tbody>
                        </table>
                        <div class="row col-md-12 justify-content-center text-center">
                            <div class="border border-dark col-md-4 p-3">
                                Average of Money: <?php echo number_format($amount_res[0][0], 2); ?> $
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    jsupdate();

                    function jsupdate() {
                        $("#cost, #amount").keypress(function(e) {
                            if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                                return false;
                            }
                        });
                    }

                </script>
            </form>
            <form class="row col-md-12" method="post" enctype="multipart/form-data">
                <div class="col-md-12 row">
                    <label class="col-md-12 m-auto">
                        Attachment
                        <hr></label>
                    <?php if(empty($res[0][7])){ ?>
                        <div class="custom-file col-md-4 mt-3 m-auto">
                        <input name="attachment" type="file" class="custom-file-input" id="inputGroupFile04" required>
                        <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                    </div>
                    <div class="row col-md-3 m-auto">
                        <button type="submit" class="btn btn-primary col-md-12 mb-2 p-3">Upload attachment <span class="fa fa-upload"></span></button>
                    </div>
                    <?php } else{?>

                    <a class="nav-link btn btn-dark col-md-4 mt-3 p-3 m-auto mr-3" href="attachments/company_contract/<?php echo $res[0][7]; ?>" download>Download attachment<span class="fa fa-lg fa-download ml-1"></span> <span class="sr-only">(current)</span></a>
                    <?php }?>
                    <a class="nav-link btn btn-dark col-md-3 mt-2 p-3 mr-auto ml-4" href="company-contract-print.php?part=<?php echo $_GET["part"] ?>&project=<?php echo $_GET["project"] ?>" target="_blank" rel="noopener noreferrer">Print Contract <span class="fas fa-lg fa-print ml-1"></span> <span class="sr-only">(current)</span></a>
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
            Company contract has successfully Updated
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

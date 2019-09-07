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
        $result = $db -> query("select * from employ_salary where id=".$_GET['employ']);
        $res = $result->fetchAll();
        
        $save_list = $db -> query("select * from employ_salary_list where eid=".$_GET['employ']." and type='save' order by id desc");
        $save_res = $save_list->fetchAll();
        
        $spend_list = $db -> query("select * from employ_salary_list where eid=".$_GET['employ']." and type='spend' order by id desc");
        $spend_res = $spend_list->fetchAll();
          
        $save_avg = $db -> query("select sum(amount) from employ_salary_list where eid=".$_GET['employ']." and type='save'");
        $save_avg_res = $save_avg->fetchAll();
        
        $spend_avg = $db -> query("select sum(amount) from employ_salary_list where eid=".$_GET['employ']." and type='spend'");
        $spend_avg_res = $spend_avg->fetchAll();
        
        if(!empty($res[0][3])){
            $edit = "disabled";
        }else{
            $edit="required";
        }
    }catch(Exception $e){
        echo 'database not working';
    }
    
    
    if(!empty($_POST['job_type'])){
            $db -> query("UPDATE `employ_salary` SET `name`='".$_POST['name']."' , `job_type`='".$_POST['job_type']."' , `salary_type`='".$_POST['salary_type']."' , `salary_amount`=".$_POST['salary_amount']." , `salary_avg`=".$_POST['salary_avg']." WHERE id=".$_GET['employ']);
    }
    else if(!empty($_POST['salary_spend'])){
        
        $spend_avg_temp =$_POST["pireod"] * $_POST["salary_spend"];

        $db -> query("INSERT INTO `employ_salary_list`(`eid`, `amount`, `type`, `pay_type`, `pireod`, `date`) VALUES ({$_GET["employ"]},{$_POST["salary_spend"]},'spend','{$_POST["pay_type"]}',{$_POST["pireod"]},'{$_POST["date"]}')");
        
        $db -> query("UPDATE `employ_salary` SET `salary_avg`=".($res[0][6]-$spend_avg_temp)." WHERE id = ".$_GET["employ"]);
        
        
        $toast = "spend";
        
    }else if(!empty($_POST['salary_save'])){

        $save_avg_temp =$_POST["pireod"] * $_POST["salary_save"];

        $db -> query("INSERT INTO `employ_salary_list`(`eid`, `amount`, `type`, `pay_type`, `pireod`, `date`) VALUES ({$_GET["employ"]},{$_POST["salary_save"]},'save','{$_POST["pay_type"]}',{$_POST["pireod"]},'{$_POST["date"]}')");
        
        $db -> query("UPDATE `employ_salary` SET `salary_avg`=".($res[0][6]+$save_avg_temp)." WHERE id = ".$_GET["employ"]);
        
        $toast = "save";
        
    }
        $result = $db -> query("select * from employ_salary where id=".$_GET['employ']);
        $res = $result->fetchAll();
    
        if($_POST["search"]){
            $originalDate = $_POST["search"];
            $newDate = date("Y-m", strtotime($originalDate));
            
            $save_list = $db -> query("select * from employ_salary_list where eid=".$_GET['employ']." and type='save' and date like '%".$newDate."%' order by id desc");
            $save_res = $save_list->fetchAll();
        }else{
            $save_list = $db -> query("select * from employ_salary_list where eid=".$_GET['employ']." and type='save' order by id desc");
            $save_res = $save_list->fetchAll();
        }
        $spend_list = $db -> query("select * from employ_salary_list where eid=".$_GET['employ']." and type='spend' order by id desc");
        $spend_res = $spend_list->fetchAll();
    
        $save_avg = $db -> query("select sum(amount) from employ_salary_list where eid=".$_GET['employ']." and type='save'");
        $save_avg_res = $save_avg->fetchAll();
        
        $spend_avg = $db -> query("select sum(amount) from employ_salary_list where eid=".$_GET['employ']." and type='spend'");
        $spend_avg_res = $spend_avg->fetchAll();
    
  
    
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
        <div class="title col-md-12">
            موچەی کارمەند
        </div>
        <div class="items col-md-10 row">
            <form method="post">
                <label>زانیاری&nbsp;پارە&nbsp;وەرگرتن</label>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <label>ناوی&nbsp;کارمەند</label>
                        <input name="name" required type="text"
                            class="form-control form-control-lg form-control form-control-lg-lg"
                            value="<?php echo $res[0][2]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>جۆری&nbsp;ئیشکردن</label>
                        <input name="job_type" required type="text" class="form-control form-control-lg"
                            value="<?php echo $res[0][3]; ?>">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">شێوازی&nbsp;پارە وەرگرتن</label>
                            <select required name="salary_type" class="form-control form-control-lg"
                                id="exampleFormControlSelect1">
                                <option value="monthly" <?php if($res[0][4]=="monthly"){echo "selected";}?>>مانگانە
                                </option>
                                <option value="weekly" <?php if($res[0][4]=="weekly"){echo "selected";}?>>هەفتانە
                                </option>
                                <option value="daily" <?php if($res[0][4]=="daily"){echo "selected";}?>>ڕۆژانە</option>
                                <option value="hourly" <?php if($res[0][4]=="hourly"){echo "selected";}?>>کاتژمێر
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>مــوچــە</label>
                        <input name="salary_amount" required type="text"
                            class="form-control form-control-lg" value="<?php echo $res[0][5]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>تێکڕای&nbsp;مــوچــە</label>
                        <input readonly name="salary_avg" required type="text" class="form-control form-control-lg"
                            value="<?php echo number_format($res[0][6], 2); ?> $">
                    </div>
                </div>
                <div class="row justify-content-center col-md-12">
                    <button type="submit"
                        class="btn btn-primary col-md-3 target-button p-3">Save infoەکان</button>
                </div>
            </form>
        </div>

        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="col-md-12">
                <form method="post" id="form1">
                    <label>زیادکردنی پارە</label>
                    <hr>
                    <div class="row justify-content-center col">
                        <div class="col-md-3">
                            <label>
                            ماوەی کارکردن
                            </label>
                            <input id="pireod" required name="pireod" type="text" class="form-control form-control-lg"
                                placeholder="<?php echo '0'; ?>">
                        </div>
                        <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">شێوازی&nbsp;پارە وەرگرتن</label>
                            <select required name="pay_type" class="form-control form-control-lg"
                                id="exampleFormControlSelect1">
                                <option value="monthly" <?php if($res[0][4]=="monthly"){echo "selected";}?>>مانگانە
                                </option>
                                <option value="weekly" <?php if($res[0][4]=="weekly"){echo "selected";}?>>هەفتانە
                                </option>
                                <option value="daily" <?php if($res[0][4]=="daily"){echo "selected";}?>>ڕۆژانە</option>
                                <option value="hourly" <?php if($res[0][4]=="hourly"){echo "selected";}?>>کاتژمێر
                                </option>
                            </select>
                        </div>
                    </div>
                        <div class="col-md-3">
                            <label>بڕی موچە</label>
                            <input id="save_amount" required name="salary_save" type="text" class="form-control form-control-lg"
                                value="<?php echo $res[0][5]; ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <input id="save" required name="date" type="date" class="form-control form-control-lg">
                        </div>
                        <button type="submit" class="btn btn-primary col-md-2 mt-4 p-3">
                            زیادکردن
                        </button>
                    </div>
                </form>
                <script>
                    $(#save_amount").keypress(function (e) {
                        if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });
                    $("#pireod").keypress(function (e) {
                        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });
                </script>
            </div>
        </div>
        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="table-list table-responsive-sm col-md-6">
                <label>زیادکردنی پارە</label>
                <hr>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" id="c1">#</th>
                            <th scope="col" id="c2">ماوەی کارکردن</th>
                            <th scope="col" id="c2">Item typeکردن</th>
                            <th scope="col" id="c2">بڕی پارە</th>
                            <th scope="col" id="c2">Average</th>
                            <th scope="col" id="c3"> Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i<sizeof($save_res);$i=$i+1){ ?>
                        <tr scope="row">
                            <td id="c1"><?php echo $i ?></td>
                            <td id="c1"><?php echo $save_res[$i][5]?></td>
                            <td id="c1"><?php 
                                if($save_res[$i][4]=="daily"){
                                    echo "رۆژ";
                                }else if($save_res[$i][4]=="monthly"){
                                    echo "مانگ";
                                }else if($save_res[$i][4]=="hourly"){
                                    echo "کاتژمێر";
                                }else if($save_res[$i][4]=="weekly"){
                                    echo "هەفتە";
                                }
                            ?></td>
                            <td id="c1"><?php echo number_format($save_res[$i][2], 2)?> $</td>
                            <td id="c1"><?php echo number_format($save_res[$i][5]*$save_res[$i][2], 2);?> $</td>
                            <td id="c1"><?php echo $save_res[$i][6]?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <form method="post" class="col-md-12 row justify-content-center">
                <input id="save_amount" required name="search" type="month" class="form-control form-control-lg col-md-3 m-3">
                <button type="submit" class="btn btn-primary col-md-2 p-3">Search <span
                        class="fa fa-search"></span></button>

            </form>

        </div>

        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="col-md-12">
                <form method="post" id="form1">
                    <label>پێدانی پارە</label>
                    <hr>
                    <div class="row justify-content-center col">
                        <div class="col-md-3">
                            <label>
                            ماوەی کارکردن
                            </label>
                            <input id="pireod1" required name="pireod" type="text" class="form-control form-control-lg"
                                placeholder="<?php echo '0'; ?>">
                        </div>
                        <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">شێوازی&nbsp;پارە وەرگرتن</label>
                            <select required name="pay_type" class="form-control form-control-lg"
                                id="exampleFormControlSelect1">
                                <option value="monthly" <?php if($res[0][4]=="monthly"){echo "selected";}?>>مانگانە
                                </option>
                                <option value="weekly" <?php if($res[0][4]=="weekly"){echo "selected";}?>>هەفتانە
                                </option>
                                <option value="daily" <?php if($res[0][4]=="daily"){echo "selected";}?>>ڕۆژانە</option>
                                <option value="hourly" <?php if($res[0][4]=="hourly"){echo "selected";}?>>کاتژمێر
                                </option>
                            </select>
                        </div>
                    </div>
                        <div class="col-md-3">
                            <label>بڕی موچە</label>
                            <input id="spend_amount" required name="salary_spend" type="text" class="form-control form-control-lg"
                                value="<?php echo $res[0][5]; ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <input id="save" required name="date" type="date" class="form-control form-control-lg">
                        </div>
                        <button type="submit" class="btn btn-primary col-md-2 mt-4 p-3">
                            زیادکردن
                        </button>
                    </div>
                </form>
                <script>
                    $("#spend_amount").keypress(function (e) {
                        if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });
                    $("#pireod1").keypress(function (e) {
                        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });
                </script>
            </div>
        </div>
        <div class="items col-md-10 justify-content-center mt-5 row">
            <div class="table-list table-responsive-sm col-md-6">
                <label>پێدانی پارە</label>
                <hr>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col" id="c1">#</th>
                            <th scope="col" id="c2">ماوەی کارکردن</th>
                            <th scope="col" id="c2">Item typeکردن</th>
                            <th scope="col" id="c2">بڕی پارە</th>
                            <th scope="col" id="c2">Average</th>
                            <th scope="col" id="c3"> Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i<sizeof($spend_res);$i=$i+1){ ?>
                        <tr scope="row">
                        <td id="c1"><?php echo $i ?></td>
                            <td id="c1"><?php echo $spend_res[$i][5]?></td>
                            <td id="c1"><?php 
                                if($spend_res[$i][4]=="daily"){
                                    echo "رۆژ";
                                }else if($spend_res[$i][4]=="monthly"){
                                    echo "مانگ";
                                }else if($spend_res[$i][4]=="hourly"){
                                    echo "کاتژمێر";
                                }else if($spend_res[$i][4]=="weekly"){
                                    echo "هەفتە";
                                }
                            ?></td>
                            <td id="c1"><?php echo number_format($spend_res[$i][2], 2)?> $</td>
                            <td id="c1"><?php echo number_format($spend_res[$i][5]*$spend_res[$i][2], 2);?> $</td>
                            <td id="c1"><?php echo $spend_res[$i][6]?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-8 row justify-content-center">
                <a class="nav-link btn btn-dark col-md-6 mt-2 p-3 m-auto ml-4"
                    href="employ_salary_edit_print.php?part=<?php echo $_GET["part"] ?>&employ=<?php echo $_GET["employ"];if(!empty($_POST["search"])){echo "&search=".$_POST["search"];} ?>"
                    target="_blank" rel="noopener noreferrer">چاپکردن<span class="fas fa-lg fa-print ml-1"></span> <span
                        class="sr-only">(current)</span></a>
            </div>
        </div>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
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
            <?php if($toast=="spend"){?>
            پێدانی پارە بەسەرکەوتویی ئەنجامدرا
            <?php }else if($toast=="save"){?>
            زیادکردنی پارە بە سەرکەوتویی ئەنجامدرا
            <?php } else if($toast=="fail"){?>
            پێدانی پارە سەرکەوتو نەبوو، بڕی پێویست پارەی هەڵگیراو نیە
            <?php }?>
        </div>
        <script>
            if ('<?php echo $toast;?>' == 'spend' || '<?php echo $toast;?>' == 'save' || '<?php echo $toast;?>' ==
                'fail') {
                $(".toast").toast("show");
            }
        </script>
    </div>
</body>

</html>
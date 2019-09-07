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
    
//    if($_SESSION["username"] != "aryan"){
// header("Location: ./login.php");
// }
       
    $part_number = $_GET['part'];
    if($part_number == 1){
        $part = "Mechanic";
    }else if($part_number == 2){
        $part = "Electronic";
    }else if($part_number == 3){
        $part = "Civil";
    }else if($part_number == 4){
        $part = "Architecture";
    }else{
        header("Location:employ_salary.php?id=1");
    }
    
    if(!empty($_POST['ename'])){
       $db -> query("INSERT INTO `employ_salary`(`pid`, `name`, `job_type`, `salary_type`, `salary_amount`, `salary_avg`) VALUES ('".$part_number."','".$_POST["ename"]."','".$_POST["job_type"]."','".$_POST["salary_type"]."',".$_POST["salary_amount"].",0)");
        $success = "true";
    }
    
            $avg_amount = $db -> query("select count(id) from employ_salary where pid = ".$part_number);
            $avg_amount_res = $avg_amount->fetchAll(); 
            
            if(empty($_GET["page"])){
                $page = 0;
            }else{
                $page = $_GET["page"];
            }
            if($page != 0 ){
                $page *= $results;
            }
            
            $number_of_results = $avg_amount_res[0][0];
            $results_per_page = $results;
            $number_of_pages=ceil($number_of_results/$results_per_page);
            $start_number=($page-1)*$results_per_page;
    
    try{
        if(!empty($_GET["delete"])){
        $db -> query("DELETE FROM `employ_salary` WHERE id=".$_GET["delete"]);
        $success="delete";
        }
        if(!empty($_POST["search"])){
            $result = $db -> query("select * from employ_salary where pid=".$part_number." and name LIKE '%".$_POST["search"]."%' order by id desc");
            $res = $result->fetchAll();
        }else{
            $result = $db -> query("select * from employ_salary where pid=".$part_number." order by id desc limit {$page},{$results}");
            $res = $result->fetchAll();
        }
        
        $count = $db -> query("select count(pid) from employ_salary where pid=".$part_number);
        $count_res = $count->fetchAll();
        
        $salary_avg = $db -> query("select sum(salary_amount) from employ_salary where pid=".$part_number);
        $salary_avg_res = $salary_avg->fetchAll();
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
        <div class="col-md-6">
            <form method="post" class="mt-4 row ml-4"><input type="text" class="form-control col-md-4" name="search"><button type="submit" class="btn btn-success ml-2 col-md-2">Search <span class="fa fa-search"></span></button></form>
        </div>
        <div class="row col-md-6 justify-content-end">
            <a class="plus-button" href="#" data-toggle="modal" data-target="#exampleModal">زیادکردنی&nbsp;کارمەند<span class="fa fa-lg fa-plus ml-1"></span></a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">زیادکردنی&nbsp;کارمەندان</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">ناوی&nbsp;کارمەند</label>
                                        <input type="text" required class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" name="ename">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">جۆری&nbsp;ئیشکردن</label>
                                        <input type="text" required class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" name="job_type">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">شێوازی&nbsp;پارە وەرگرتن</label>
                                            <select <?php echo $edit; ?> name="salary_type" class="form-control form-control-lg" id="exampleFormControlSelect1">
                                                <option value="monthly">مانگانە</option>
                                                <option value="weekly">هەفتانە</option>
                                                <option value="daily">ڕۆژانە</option>
                                                <option value="hourly">کاتژمێر</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputEmail1">موچە</label>
                                        <input type="text" required class="form-control form-control-lg salary" id="exampleInputEmail1" aria-describedby="emailHelp" name="salary_amount">
                                    </div>
                                    <div class="form-group col-md-4 mt-4">
                                        <button type="submit" class="btn btn-primary form-control form-control-lg">زیادکردن <span class="fa fa-lg fa-plus ml-1"></span></button>
                                    </div>
                                    <script>
                                        $(".salary").keypress(function(e) {
                                            if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                                                return false;
                                            }
                                        });

                                    </script>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a class="plus-button" href="#">ژمارەی کارمەندان:<?php echo $count_res[0][0]; ?></a>
        </div>

        <div class="title col-md-12">
            موچەی کارمەندانی بەشـی&nbsp;<?php echo $part; ?>
        </div>
        <div class="items col-md-10 justify-content-center">
            <div class="table-list table-responsive-sm col-md-12">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" id="c1">ناوی کارمەند</th>
                            <th scope="col" id="c2"> Item type</th>
                            <th scope="col" id="c3">شێوازی کارکردن</th>
                            <th scope="col" id="c5">مووچە</th>
                            <th scope="col" id="c5">Edit</th>
                            <th scope="col" id="c6">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i<sizeof($res);$i=$i+1){ ?>
                        <tr scope="row">
                            <td id="c1"><?php echo $res[$i][2]?></td>
                            <td id="c1"><?php echo $res[$i][3]?></td>
                            <td id="c1"><?php 
                                if($res[$i][4]=="daily"){
                                    echo "ڕۆژانە";
                                }else if($res[$i][4]=="monthly"){
                                    echo "مانگانە";
                                }else if($res[$i][4]=="hourly"){
                                    echo "کاتژمێر";
                                }else if($res[$i][4]=="weekly"){
                                    echo "هەفتانە";
                                }
                            ?></td>
                            <td id="c1"><?php echo number_format($res[$i][5], 2)?> $</td>
                            <td id="c5"><a href="employ_salary_edit.php?part=<?php echo $part_number ?>&employ=<?php echo $res[$i][0] ?>"><span class="fa fa-edit"></span></a></td>
                            <td id="c6">
                                <a onclick="deleteRow(<?php echo $res[$i][0];?>)"><span class="fa fa-times"></span></a>
                            </td>
                        </tr>
                        <?php } ?>
                        <script type="text/javascript">
                            function deleteRow(rowId) {
                                if (confirm("دڵنیایت لە Deleteی داتاکەت؟")) {
                                    window.location.href = "employ_salary.php?part=<?php echo $_GET["part"]; ?>&delete=" + rowId
                                }
                            }

                        </script>
                    </tbody>
                </table>
            </div>
            <?php if(empty($_POST["search"])){?>
            <div class="row justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php for($i=1;$i<=$number_of_pages;$i=$i+1){?>
                        <li><a class="text-dark page-link <?php if(($i-1)==($page/$results)){echo "bg-warning";}?>" <?php echo 'href="employ_salary.php?part='.$_GET["part"].'&page='.($i-1).'"';?>>
                                <?php echo $i;?></a></li>
                        <?php }?>
                    </ul>
                </nav>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="toast mr-5 mb-5 p-3" style="position:fixed;bottom:0; right:0;z-index:2;" data-delay="9000" role="alert" aria-live="assertive" aria-atomic="true">
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
                echo "کارمەند بە سەرکەوتویی زیادکرا";
            }else if($success == "delete"){
                echo "کارمەند بەسەرکەوتویی سڕایەوە";
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

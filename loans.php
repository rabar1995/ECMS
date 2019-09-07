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
    
 if(!empty($_POST['name'])){
 $db -> query("INSERT INTO `loans`(`name`, `phone`, `address`, `email`, `avg`, `type`, `note`, `date`) VALUES ('".$_POST["name"]."','".$_POST["phone"]."','".$_POST["address"]."','".$_POST["email"]."',".$_POST["avg"].",'".$_GET["type"]."', '".$_POST["note"]."', '".date('Y-m-d')."')");
 $success = "true";
 }
            $avg_amount = $db -> query("select count(id) from loans where type = '".$_GET['type']."'");
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
    
    if(!empty($_GET["delete"])){
        $db -> query("DELETE FROM `loans` WHERE id=".$_GET["delete"]);
        $success == "true"?:$success="delete";
        }
 try{
     if(!empty($_POST["search"])){
         $result = $db -> query("select * from loans where type='".$_GET["type"]."' and name LIKE '%".$_POST["search"]."%'");
        $res = $result->fetchAll();
         
     }else{
        $result = $db -> query("select * from loans where type='".$_GET["type"]."' order by id desc limit {$page}, {$results}");
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
        <div class="col-md-6">
            <form method="post" class="mt-4 row">
                <input type="text" class="form-control col-md-4" name="search">
                <button type="submit" class="btn btn-success ml-2 col-md-2"><span class="fa fa-search"></span> Search</button>
            </form>
        </div>
        <div class="row col-md-6 justify-content-end">
            <a class="plus-button" href="#" data-toggle="modal" data-target="#exampleModal">Add loan<span class="fa fa-lg fa-plus ml-1"></span></a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adding loans</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Person name</label>
                                        <input type="text" required class="form-control mb-4" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Phone number</label>
                                        <input type="text" required class="form-control mb-4" id="exampleInputEmail1" aria-describedby="emailHelp" name="phone">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" required class="form-control mb-4" id="exampleInputEmail1" aria-describedby="emailHelp" name="address">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" required class="form-control mb-4" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">loan amount</label>
                                        <input id="loan-avg" required type="text" class="form-control mb-4" id="exampleInputEmail1" aria-describedby="emailHelp" name="avg">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Note</label>
                                        <input type="text" required class="form-control mb-4" id="exampleInputEmail1" aria-describedby="emailHelp" name="note">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary ml-3 mb-3">Add <span class="fa fa-lg fa-plus ml-1"></span></button>
                                <script>
                                    $("#loan-avg").keypress(function(e) {
                                        if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                                            return false;
                                        }
                                    });

                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="title col-md-12">
            <?php
                if($_GET["type"]=="get"){
                    echo "Borrwing Part";
                }else if($_GET["type"]=="spend"){
                    echo "Lending Part";
                }
            ?>
        </div>
        <div class="items col-md-10 justify-content-center">
            <div class="table-list table-responsive-sm col-md-12">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" id="c1">Preson name</th>
                            <th scope="col" id="c2">Phone number</th>
                            <th scope="col" id="c3">Address</th>
                            <th scope="col" id="c4">email</th>
                            <th scope="col" id="c5">amount</th>
                            <th scope="col" id="c5">Remaining</th>
                            <th scope="col" id="c5">Edit</th>
                            <th scope="col" id="c6">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i<sizeof($res);$i=$i+1){ ?>
                        <tr scope="row">
                            <td id="c1"><?php echo $res[$i][1]?></td>
                            <td id="c1"><?php echo $res[$i][2]?></td>
                            <td id="c1"><?php echo $res[$i][3]?></td>
                            <td id="c1"><?php echo $res[$i][4]?></td>
                            <td id="c1"><?php echo number_format($res[$i][5], 2);?> $</td>
                            <?php
                                $remain = $db -> query("select sum(amount) from loan_list where lid=".$res[$i][0]);
                                $remain_res = $remain->fetchAll();
                            ?>
                            <td id="c1"><?php echo number_format($res[$i][5]-$remain_res[0][0], 2);?> $</td>
                            <td id="c5"><a href="loans-edit.php?id=<?php echo $res[$i][0] ?>&type=<?php echo $_GET["type"] ?>"><span class="fa fa-edit"></span></a></td>
                            <td id="c6">
                                <a onclick="deleteRow(<?php echo $res[$i][0];?>)"><span class="fa fa-times"></span></a>
                            </td>
                        </tr>
                        <?php } ?>
                        <script type="text/javascript">
                            function deleteRow(rowId) {
                                if (confirm("Are you sure you want to delete this data?")) {
                                    window.location.href = "loans.php?type=<?php echo $_GET["type"]; ?>&delete=" + rowId
                                }
                            }

                        </script>
                    </tbody>
                </table>
            </div>
            <?php if(empty($_POST["search"])){ ?>
            <div class="row justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php for($i=1;$i<=$number_of_pages;$i=$i+1){?>
                        <li><a class="text-dark page-link <?php if(($i-1)==($page/$results)){echo "bg-warning";}?>" <?php echo 'href="loans.php?type='.$_GET["type"].'&page='.($i-1).'"';?>>
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
            <strong class="mr-auto">info</strong>
            <small>Now</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="toast-body text-wight-bold">
            <?php
            if($success == "true"){
                echo "Loan has successfuly been added";
            }else if($success == "delete"){
                echo "Loan has successfuly been deleted";
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

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
        header("Location:projects.php?part=1");
    }
    
    
    if(!empty($_POST['pname'])){
       $db -> query("INSERT INTO `projects` (`part`, `project_name`, `date`) VALUES ('".$part_number."', '".$_POST['pname']."','".date('Y-m-d')."' )");
        $success="true";
    }
    if(!empty($_GET["delete"])){
    $db -> query("DELETE FROM `projects` WHERE pid=".$_GET["delete"]);
    $success == "true"?:$success="delete";
    }
    
            $avg_amount = $db -> query("select count(pid) from projects where part = ".$part_number);
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
        if(!empty($_POST["search"])){
            $result = $db -> query("select * from projects where part=".$part_number." and project_name LIKE '%".$_POST["search"]."%' order by pid desc");
            $res = $result->fetchAll();
        }else{
            $result = $db -> query("select * from projects where part=".$part_number." order by pid desc limit ".$page.", {$results}");
            $res = $result->fetchAll();
        }
        $count = $db -> query("select count(part) from projects where part=".$part_number);
        $count_res = $count->fetchAll();
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
        <div class="col-md-7">
            <form method="post" class="mt-4 row"><input type="text" class="form-control col-md-4" name="search"><button type="submit" class="btn btn-success ml-2 col-md-2">Search <span class="fa fa-search"></span></button></form>
        </div>
        <div class="row col-md-5 justify-content-end">
            <a class="plus-button" href="#" data-toggle="modal" data-target="#exampleModal">Add new project <span class="fa fa-lg fa-plus ml-1"></span></a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adding Project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="projects.php?part=<?php echo $part_number; ?>">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Project name</label>
                                    <input type="text" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="pname">
                                    <small id="emailHelp" class="form-text text-muted">Add new project to <?php echo $part?> part</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Add <span class="fa fa-lg fa-plus ml-1"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a class="plus-button" href="#">Number of projects : <?php echo $count_res[0][0]; ?></a>
        </div>

        <div class="title col-md-12">
            Projects of <?php echo $part; ?> part
        </div>
        <div class="items col-md-10 justify-content-center">
            <div class="table-list table-responsive-sm col-md-12">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" id="c1">Project name</th>
                            <th scope="col" id="c2">Company name</th>
                            <th scope="col" id="c3">Staff name</th>
                            <th scope="col" id="c5">Edit</th>
                            <th scope="col" id="c6">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i<sizeof($res);$i=$i+1){ ?>
                        <tr scope="row">
                            <td id="c1"><?php echo $res[$i][2]?></td>
                            <td id="c2">
                                <?php
                                    $comp_name = $db -> query("select name from company_contract where cid=".$res[$i][0]);
                                    $name_res = $comp_name->fetchAll();
                                    echo $name_res[0][0]
                                ?>
                            </td>
                            <td id="c3">
                                <?php
                                    $staff_name = $db -> query("select name from staff_contract where cid=".$res[$i][0]);
                                    $staff_res = $staff_name->fetchAll();
                                    echo $staff_res[0][0]
                                ?>
                            </td>
                            <td id="c5"><a href="project-info.php?part=<?php echo $part_number ?>&project=<?php echo $res[$i][0] ?>"><span class="fa fa-edit"></span></a></td>
                            <td id="c6"><a onclick="deleteRow(<?php echo $res[$i][0];?>)"><span class="fa fa-times"></span></a></td>
                        </tr>
                        <?php } ?>
                        <script type="text/javascript">
                            function deleteRow(rowId) {
                                if (confirm("are you sure you want to delete this data?")) {
                                    window.location.href = "projects.php?part=<?php echo $_GET["part"]; ?>&delete=" + rowId
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
                        <li><a class="text-dark page-link <?php if(($i-1)==($page/$results)){echo "bg-warning";}?>" <?php echo 'href="projects.php?part='.$_GET["part"].'&page='.($i-1).'"';?>>
                                <?php echo $i;?></a></li>
                        <?php }?>
                    </ul>
                </nav>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="toast mr-5 mb-5 p-3" style="position:fixed;bottom:0; right:0;z-index:2;" data-delay="9000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">Info</strong>
            <small>Now</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="toast-body text-wight-bold">
            <?php if($success=="true"){ ?>
            Project has succesfully added
            <?php } else if($success=="delete"){ ?>
            Project has succesfully deleted
            <?php }?>
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

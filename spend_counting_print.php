<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free-5.7.2-web/css/all.css">
    <style>
        td {
            padding: 10px;
        }

    </style>
    <?php
        session_start();
    
        include 'database_connection.php';
    if($_SESSION["username"] != "aryan"){
        header("Location: ./login.php");
    }
    
        if($_GET["search"]){
            $originalDate = $_GET["search"];
            $newDate = date("Y-m", strtotime($originalDate));
            
            $result = $db -> query("SELECT spend_count.id, name, buy, amount, date FROM spend_count, spend_person WHERE spend_count.pid = spend_person.id and date LIKE '%".$newDate."%' order by id desc");
            $sections_res = $result->fetchAll();
            
            $person = $db -> query("select * from spend_person where 1");
            $person_res = $person->fetchAll();
        }
    ?>
</head>

<body>

    <div class="page-header" style="text-align: center">
        <div class="row">
            <img src="img/header.jpg" alt="header" class="col-md-12">
        </div>
    </div>
    <div class="page-header" style="text-align: center; z-index:-1;">
        <div class="row">
            <img src="img/watermark.jpg" alt="header" class="col-md-12">
        </div>
    </div>

    <div class="page-footer">
        <div class="row">
            <img src="img/footer.jpg" alt="footer" class="col-md-12 border-top: 200px solid red;">
        </div>
    </div>


    <table>

        <thead>
            <tr>
                <td>
                    <!--place holder for the fixed-position header-->
                    <div class="page-header-space"></div>
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <!--*** CONTENT GOES HERE ***-->
                    <div class="col-md-12">
                        <div class="col-md-12" style="text-align:center;">
                            <div style="text-align:center;" class="<mt-5></mt-5>">Average of Expenditure for : <?= $_GET["search"] ?>
                                <hr>
                            </div>
                            <?php for($i = 0 ; $i < sizeof($person_res) ; $i += 1){ 
                                $amount= $db -> query("SELECT SUM(amount) FROM spend_count WHERE spend_count.pid = {$person_res[$i][0]} and date LIKE '%{$newDate}%'");
                                    $amount_res = $amount->fetchAll(); 
                                    if($amount_res[0][0] == 0){continue;}
                                    if($i > 0 and $i%4==0){echo "<br>";}
                                ?>
                            <span class="pt-3 pb-3 mt-3 mb-3"><?= $person_res[$i][1] ?>&nbsp;:&nbsp;<?= "$".number_format($amount_res[0][0], 2)?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php } ?>
                        </div>
                    </div>

                    <div style="text-align:center;" class="mt-5">Expenditure info
                        <hr>
                    </div>
                    <div class="con-info col-md-12 row justify-content-center mb-5 m-auto" style="max-width:90%;">
                        <table class="faqara col-md-10 p-5" style="text-align:right">
                            <thead>
                                <tr style="background-color: #f99d1d; ">
                                    <th scope="col" class="p-2">#</th>
                                    <th scope="col" class="p-2">Person name</th>
                                    <th scope="col" class="p-2">buying type</th>
                                    <th scope="col" class="p-2">buying cost</th>
                                    <th scope="col" class="p-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i = 0 ; $i < sizeof($sections_res); $i = $i + 1){ 
                                if($i%2==0)echo '<tr style="background: rgba(255, 212, 128, 0.6);">';
                                else if($i%2==1)echo '<tr style="background:rgba(255, 238, 204, 0.6);">';
                                    ?>
                                <th scope="row"><?php echo $i+1; ?></th>
                                <td><?php echo $sections_res[$i][1]; ?></td>
                                <td><?php echo $sections_res[$i][2]; ?></td>
                                <td><?php echo number_format($sections_res[$i][3], 2); ?> $</td>
                                <td><?php echo $sections_res[$i][4]; ?></td>
            </tr>
            <?php }?>

        </tbody>
        </div>
        <div class="page" style="line-height: 3; visibility: hidden;">
            PAGE 3 - Long Content
            <br /> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tincidunt metus eu consectetur rutrum. Praesent tempor facilisis dapibus. Aliquam cursus diam ac vehicula pulvinar. Integer lacinia non odio et condimentum. Aenean faucibus cursus
            mi, sed interdum turpis sagittis a. Quisque quis pellentesque mi. Ut erat eros, posuere sed scelerisque ut, pharetra vitae tellus. Suspendisse ligula sapien, laoreet ac hendrerit sit amet, viverra vel mi. Pellentesque faucibus nisl et dolor
            pharetra, vel mattis massa venenatis. Integer congue condimentum nisi, sed tincidunt velit tincidunt non. Nulla sagittis sed lorem pretium aliquam. Praesent consectetur volutpat nibh, quis pulvinar est volutpat id. Cras maximus odio posuere
            suscipit venenatis. Donec rhoncus scelerisque metus, in tempus erat rhoncus sed. Morbi massa sapien, porttitor id urna vel, volutpat blandit velit. Cras sit amet sem eros. Quisque commodo facilisis tristique. Proin pellentesque sodales rutrum.
        </div>
        </td>
        </tr>
        </tbody>

        <tfoot>
            <tr>
                <td>
                    <!--place holder for the fixed-position footer-->
                    <div class="page-footer-space"></div>
                </td>
            </tr>
        </tfoot>

    </table>
    <script type="text/javascript">
        window.print();

    </script>
</body>

</html>

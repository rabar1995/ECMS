<!DOCTYPE html>
<html >

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
    
        $result = $db -> query("select * from oreders where id=".$_GET['order']);
        $res = $result->fetchAll();

        $sections = $db -> query("select * from order_section where oid=".$_GET['order']);
        $sections_res = $sections->fetchAll();
        
        $amount = $db -> query("select sum(yaka_avg) from order_section where oid=".$_GET['order']);
        $amount_res = $amount->fetchAll();
    
        $pay_list = $db -> query("select * from order_pay_list where oid=".$_GET['order']);
        $pay_res = $pay_list->fetchAll();

        $sum = $db -> query("select sum(amount) from order_pay_list where oid=".$_GET['order']);
        $sum_res = $sum->fetchAll();
        
        $money_avg = $amount_res[0][0];
    
        if($res[0][11]==1){
            $panalty=round((strtotime($res[0][5])-strtotime($res[0][4]))/(24*60*60))-$res[0][6];
            $amount_res[0][0] -= abs($panalty)*$res[0][7];
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
                    <div style="" class="mr-3">Order Payment :
                        <hr>
                    </div>
                    <div class="info" style="">
                        <br> <b class='mr-3'>First party</b> : Project owner
                        <br> <b class='mr-3'>Second party</b> : <?php echo $res[0][2] ?>
                    </div>
                    <div style="text-align:center;">List of Prices
                        <hr>
                    </div>
                    <div class="con-info col-md-12 row justify-content-center mb-5">
                        <table class="faqara col-md-10 p-5">
                            <thead>
                                <tr style="background-color: #f99d1d; ">
                                    <th scope="col" class="p-2">#</th>
                                    <th scope="col" class="p-2">Item</th>
                                    <th scope="col" class="p-2">Unit type</th>
                                    <th scope="col" class="p-2">Unit price</th>
                                    <th scope="col" class="p-2">Unit Quantity</th>
                                    <th scope="col" class="p-2">Payment type</th>
                                    <th scope="col" class="p-2">Average</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i = 0 ; $i < sizeof($sections_res); $i = $i + 1){ 
                                if($i%2==0)echo '<tr style="background: rgba(255, 212, 128, 0.6);">';
                                else if($i%2==1)echo '<tr style="background:rgba(255, 238, 204, 0.6);">';
                                    ?>
                                <th scope="row"><?php echo $i+1; ?></th>
                                <td><?php echo $sections_res[$i][2]; ?></td>
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
                                <td><?php echo number_format($sections_res[$i][4], 2); ?> $</td>
                                <td><?php echo $sections_res[$i][5]; ?></td>
                                <td><?php 
                                            if($sections_res[$i][6]=="naqd"){
                                                echo "Cash";
                                            }else if($sections_res[$i][6]=="qontarat"){
                                                echo "Loan";
                                            }
                                        ?>
                                </td>
                                <td><?php echo number_format($sections_res[$i][4]*$sections_res[$i][5], 2); ?> $</td>
            </tr>
            <?php }?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Average:</td>
                <td><?php echo number_format($money_avg, 2);?> $</td>
            </tr>

        </tbody>
    </table>
    </div>
    <?php if($res[0][11]==1){ ?>
    <table style="width: 90%; margin:auto;" >
        <thead style="border-bottom: 1px solid gray;">
            <tr>
            <td>Arrive date</td>
            <td>order time</td>
            <td>panalty per daty </td>
            <td>number of days</td>
            <td>panalty days</td>
            <td>panalty cost</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $res[0][5]; ?></td>
                <td><?php echo $res[0][6]; ?></td>
                <td><?php echo number_format($res[0][7], 2); ?> $</td>
                <td><?php echo round((strtotime($res[0][5])-strtotime($res[0][4]))/(24*60*60)); ?></td>
                <td><?php 
            $panalty=round((strtotime($res[0][5])-strtotime($res[0][4]))/(24*60*60))-$res[0][6];
                            if($panalty <= 0){
                                $panalty = 0;
                            }
                            echo $panalty;
            ?></td>
                <td> <?php echo number_format(abs($panalty)*$res[0][7], 2); ?> $</td>
            </tr>
        </tbody>
    </table>
    <?php } ?>

    <div style="text-align:center; mt-3">List of Payments
        <hr>
    </div>
    <div class="con-info col-md-12 row justify-content-center mb-5">
        <table class="faqara col-md-10 p-5">
            <thead>
                <tr style="background-color: #f99d1d; ">
                    <th scope="col" class="p-2">#</th>
                    <th scope="col" class="p-2">Average</th>
                    <th scope="col" class="p-2">Remain</th>
                    <th scope="col" class="p-2">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sum = 0;
                    for($i = 0 ; $i < sizeof($pay_res); $i = $i + 1){ 
                        $sum = $sum + $pay_res[$i][2];
                        if($i%2==0)echo '<tr style="background: rgba(255, 212, 128, 0.6);">';
                        else if($i%2==1)echo '<tr style="background:rgba(255, 238, 204, 0.6);">';
                ?>
                <td id="c1"><?php echo $i+1;?></td>
                <td id="c1"><?php echo number_format($pay_res[$i][2], 2);?> $</td>
                <td id="c4"><?php echo number_format($amount_res[0][0]-$sum, 2);?> $</td>
                <td id="c4"><?php echo $pay_res[$i][3]?></td>
                </tr>
                <?php }?>

            </tbody>
        </table>
    </div>

    <table class="faqara col-md-10" style="text-align:center;">
        <thead>
            <tr>
                <th scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding-top:150px;">
                    Signiture of First party:
                    <br> <b>Project owner</b>
                    <br>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/

                </td>
                <td style="padding-top:150px;">
                    Signiture of Second party:
                    <br> <b><?= $res[0][2] ?></b>
                    <br>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                </td>
            </tr>
        </tbody>
    </table>
    <div class="page" style="line-height: 3; visibility: hidden;">
        PAGE 3 - Long Content
        <br /> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tincidunt metus eu consectetur rutrum.
        Praesent tempor facilisis dapibus. Aliquam cursus diam ac vehicula pulvinar. Integer lacinia non odio et
        condimentum. Aenean faucibus cursus
        mi, sed interdum turpis sagittis a. Quisque quis pellentesque mi. Ut erat eros, posuere sed scelerisque ut,
        pharetra vitae tellus. Suspendisse ligula sapien, laoreet ac hendrerit sit amet, viverra vel mi. Pellentesque
        faucibus nisl et dolor
        pharetra, vel mattis massa venenatis. Integer congue condimentum nisi, sed tincidunt velit tincidunt non. Nulla
        sagittis sed lorem pretium aliquam. Praesent consectetur volutpat nibh, quis pulvinar est volutpat id. Cras
        maximus odio posuere
        suscipit venenatis. Donec rhoncus scelerisque metus, in tempus erat rhoncus sed. Morbi massa sapien, porttitor
        id urna vel, volutpat blandit velit. Cras sit amet sem eros. Quisque commodo facilisis tristique. Proin
        pellentesque sodales rutrum.
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
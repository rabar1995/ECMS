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
    
        $result = $db -> query("select * from company_contract where cid=".$_GET['project']);
        $res = $result->fetchAll();

        $sections = $db -> query("select * from company_contract_section where pid=".$_GET['project']);
        $sections_res = $sections->fetchAll();
        
        $amount = $db -> query("select sum(yaka_avg) from company_contract_section where pid=".$_GET['project']);
        $amount_res = $amount->fetchAll();

        $band = $db -> query("select * from company_band where cid=".$_GET['project']);
        $band_res = $band->fetchAll();
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
                    <div>Contract
                            <hr>
                        </div>
                        <div class="info">
                            this contract had been signed between this to parties in : <?php echo $res[0][5]; ?>
                            <br> <b>First partie</b> : Project owner
                            <br> <b>Second Party</b> : <?php echo $res[0][1] ?>
                        </div>
                        <table class="mb-2" style="width: 90%;">
                            <thead style="border-bottom: 1px solid gray;">
                                <tr>
                                    <td><b>List of items and prices : </b></td>
                                </tr>
                            </thead>
                        </table>
                    <div class="con-info col-md-12 row justify-content-center mb-5">
                        <table class="faqara col-md-10 p-5">
                            <thead>
                                <tr style="background-color: #f99d1d; ">
                                    <th scope="col" class="p-2">#</th>
                                    <th scope="col" class="p-2">Item type</th>
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
                <td><?php echo number_format($amount_res[0][0], 2); ?> $</td>
            </tr>
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
                                        First partie signiture:
                                        <br> <b>Project owner</b>
                                        <br>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/

                                    </td>
                                    <td style="padding-top:150px;">
                                        Second partie signiture:
                                        <br> <b><?= $res[0][1] ?></b>
                                        <br>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

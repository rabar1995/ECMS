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
    
        $result = $db -> query("select * from employ_salary where id=".$_GET['employ']);
        $res = $result->fetchAll();
    
        if($_GET["search"]){
            $originalDate = $_GET["search"];
            $newDate = date("Y-m", strtotime($originalDate));
            
            $sections = $db -> query("select * from employ_salary_list where eid=".$_GET['employ']." and type = 'save' and date like '%".$newDate."%'");
            $sections_res = $sections->fetchAll();
        }else{
            $sections = $db -> query("select * from employ_salary_list where eid=".$_GET['employ']." and type = 'save'");
            $sections_res = $sections->fetchAll();
        }
        $sections1 = $db -> query("select * from employ_salary_list where eid=".$_GET['employ']." and type = 'spend'");
        $sections_res1 = $sections1->fetchAll();
        
        
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
                    <div style="text-align:right;"><b>پێدانی مووچەی کارمەند:</b>
                        <hr>
                    </div>
                    <div class="info" style="text-align:right;">
                        <b>ناوی کارمەند</b> : <?= $res[0][2] ?>
                        <br> <b>بابەت</b> : پێشکەشکردنی ئۆفەر
                    </div>
                    <table style="text-align: right;width: 90%;">
                            <thead style="border-bottom: 1px solid gray;">
                                <tr>
                                    <td><b>خشتەی کارکردن</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= " "; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <div class="con-info col-md-12 row justify-content-center mb-5">
                        <table class="faqara col-md-10 p-5">
                            <thead>
                                <tr style="background-color: #f99d1d; ">
                                    <th scope="col" class="p-2">#</th>
                                    <th scope="col" class="p-2">ماوەی کارکردن</th>
                                    <th scope="col" class="p-2">Item typeکردن</th>
                                    <th scope="col" class="p-2">بڕی پارە</th>
                                    <th scope="col" class="p-2">Average</th>
                                    <th scope="col" class="p-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $temp = 0; for($i = 0 ; $i < sizeof($sections_res); $i = $i + 1){
                                if($i%2==0)echo '<tr style="background: rgba(255, 212, 128, 0.6);">';
                                else if($i%2==1)echo '<tr style="background:rgba(255, 238, 204, 0.6);">';
                                    ?>
                                <th scope="row"><?php echo $i+1; ?></th>
                                <td><?php echo $sections_res[$i][5]; ?></td>
                                <td id="c1"><?php 
                                if($sections_res[$i][4]=="daily"){
                                    echo "رۆژ";
                                }else if($sections_res[$i][4]=="monthly"){
                                    echo "مانگ";
                                }else if($sections_res[$i][4]=="hourly"){
                                    echo "کاتژمێر";
                                }else if($sections_res[$i][4]=="weekly"){
                                    echo "هەفتە";
                                }
                            ?></td>
                                <td><?php echo number_format($sections_res[$i][2], 2); ?> $</td>
                                <td><?php $av = $sections_res[$i][5]*$sections_res[$i][2]; $temp += $av; echo number_format($av, 2); ?> $</td>
                                <td><?php echo $sections_res[$i][6]; ?></td>
            </tr>
            <?php }?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>کۆ</td>
                <td><?= number_format($temp, 2); ?> $</td>
                <td></td>
            </tr>

        </tbody>
    </table>
    </div>
    <table style="text-align: right;width: 90%;">
                            <thead style="border-bottom: 1px solid gray;">
                                <tr>
                                    <td><b>خشتەی پارە وەرگرتن</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= nl2br(" "); ?></td>
                                </tr>
                            </tbody>
                        </table>
    <div class="con-info col-md-12 row justify-content-center mb-5">
        <table class="faqara col-md-10 p-5">
            <thead>
                <tr style="background-color: #f99d1d; ">
                    <th scope="col" class="p-2">#</th>
                    <th scope="col" class="p-2">ماوەی کارکردن</th>
                    <th scope="col" class="p-2">Item typeکردن</th>
                    <th scope="col" class="p-2">بڕی پارە</th>
                    <th scope="col" class="p-2">Average</th>
                    <th scope="col" class="p-2">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $temp1=0; for($i = 0 ; $i < sizeof($sections_res1); $i = $i + 1){ 
                                if($i%2==0)echo '<tr style="background: rgba(255, 212, 128, 0.6);">';
                                else if($i%2==1)echo '<tr style="background:rgba(255, 238, 204, 0.6);">';
                                    ?>
                <th scope="row"><?php echo $i+1; ?></th>
                <td><?php echo $sections_res1[$i][5]; ?></td>
                <td id="c1"><?php 
                                if($sections_res1[$i][4]=="daily"){
                                    echo "رۆژ";
                                }else if($sections_res1[$i][4]=="monthly"){
                                    echo "مانگ";
                                }else if($sections_res1[$i][4]=="hourly"){
                                    echo "کاتژمێر";
                                }else if($sections_res1[$i][4]=="weekly"){
                                    echo "هەفتە";
                                }
                            ?></td>
                <td><?php echo number_format($sections_res1[$i][2], 2); ?> $</td>
                <td><?php $av1 =$sections_res1[$i][5]*$sections_res[$i][2]; $temp1+=$av1; echo number_format($av1, 2); ?> $</td>
                <td><?php echo $sections_res1[$i][6]; ?></td>
                </tr>
                <?php }?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>کۆ</td>
                    <td><?= number_format($temp1, 2); ?> $</td>
                    <td></td>
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
                    واژۆ و مۆری First party:
                    <br> <b>ECMS</b>
                    <br>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/

                </td>
                <td style="padding-top:150px;">
                    واژۆی Second party:
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
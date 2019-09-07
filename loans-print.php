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
        $result = $db -> query("select * from loans where id=".$_GET['id']);
        $res = $result->fetchAll();

        $loan_list = $db -> query("select * from loan_list where lid=".$_GET['id']);
        $loan_list_res = $loan_list->fetchAll();
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
                    <div style="text-align:right;" class="mr-3">پارەدانی قەرز 
                        <hr>
                    </div>
                    <div class="info" style="text-align:right;">
                        <br> <b class='mr-3'>لایەنی <?php
                if($_GET["type"]=="get"){
                    echo "قەرزدار";
                }else if($_GET["type"]=="spend"){
                    echo "قەرزدەر";
                }
            ?></b> : ECMS
                        <br> <b class='mr-3'>لایەنی <?php
                if($_GET["type"]=="get"){
                    echo "قەرزدەر";
                }else if($_GET["type"]=="spend"){
                    echo "قەرزدار";
                }
            ?></b> : <?php echo $res[0][3] ?>
                    </div>
                    <div style="text-align:center;">خشتەی <?php
                if($_GET["type"]=="get"){
                    echo "دانەوەی قەرز";
                }else if($_GET["type"]=="spend"){
                    echo "وەرگرتنەوەی قەرز";
                }
            ?>
                        <hr>
                    </div>
                    <div class="row col-md-12 justify-content-center text-center">
                        <div class="col-md-4 p-3 mb-3 font-weight-bold">
                            بڕی قەرزی <?php
                            if($_GET["type"]=="get"){
                                echo "کراو";
                            }else if($_GET["type"]=="spend"){
                                echo "دراو";
                            }
                        ?>: <?php echo number_format($res[0][5], 2); ?> $
                        </div>
                    </div>
                    <div class="con-info col-md-12 row justify-content-center mb-5">
                        <table class="faqara col-md-10 p-5">
                            <thead>
                                <tr style="background-color: #f99d1d; ">
                                    <th scope="col" class="p-2">#</th>
                                    <th scope="col" class="p-2">بڕی پارە</th>
                                    <th scope="col" class="p-2">بڕی ماوە</th>
                                    <th scope="col" class="p-2">Date</th>
                                    <th scope="col" class="p-2"><?php
                                            if($_GET["type"]=="get"){
                                            echo "پیدان";
                                        }else if($_GET["type"]=="spend"){
                                            echo "وەرگرتن";
                                        }
                                    ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $temp = 0;
                                for($i = 0 ; $i < sizeof($loan_list_res); $i = $i + 1){ 
                                    $temp += $loan_list_res[$i][2];
                                if($i%2==0)echo '<tr style="background: rgba(255, 212, 128, 0.6);">';
                                else if($i%2==1)echo '<tr style="background:rgba(255, 238, 204, 0.6);">';
                                    ?>
                                <th scope="row"><?php echo $i+1; ?></th>
                                <td><?php echo number_format($loan_list_res[$i][2], 2); ?> $</td>
                                <td><?php echo number_format($res[0][5]-$temp, 2);?> $</td>
                                <td><?php echo $loan_list_res[$i][3]; ?></td>
                                <td><?php
                                    if($i == sizeof($loan_list_res)-1){}
                                    else if($_GET["type"]=="get"){
                                        echo "دراوەتەوە";
                                    }else if($_GET["type"]=="spend"){
                                        echo "وەرگیراوە";
                                    }
                                ?></td>
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
                    واژۆ و مۆری لایەنی قەرزدەر:
                    <br>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/

                </td>
                <td style="padding-top:150px;">
                    واژۆ و مۆری لایەنی قەرزدار:
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

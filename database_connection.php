<link rel="icon" type="image/png" href="img/square-connec.png">
<?php
    
     try{ 
         $db = new PDO("mysql:host=localhost;dbname=counting_database;port=3306","root",""); 
     }catch(Exception $e){ 
         echo "<div class='alert alert-danger'>Ooops Connection to the database failed, please check and try again</div>"; 
     }
$results = 10;
?>

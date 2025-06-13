<?php

    include "credentials.php";
    
    $connection = new mysqli('localhost', $user, $pw, $db);
    
    $AllRecords = $connection->prepare("select * from scp");
    $AllRecords->execute();
    $result = $AllRecords->get_result();
        
    ?>
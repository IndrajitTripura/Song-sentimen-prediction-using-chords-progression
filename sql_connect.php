<?php
    $con = mysqli_connect("localhost","root","","sentiment");

    if(!$con){
        echo "Connection Failed" . mysqli_connect_error();
    }
?>
<?php

    session_start();
    if($_SESSION['id']!='admin')
    {
        session_unset();
        session_destroy();
        header("Location: adminLogin.php");
    }
    include("php/connection.php");
    $pid=$_GET['id'];

    
    $sql = "SELECT * FROM userauthentication WHERE id=$pid";
    $result = mysqli_query($conn,$sql);
    $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($tdata))
    {
        header("Location: afteradminLogin.php");
    }
 
    
    $sqla="DELETE FROM userauthentication WHERE id=$pid";
   
    $resulta = mysqli_query($conn,$sqla);
    if( $resulta)
    {
       // echo "succesful";
       header("Location: afteradminLogin.php");
    }

?>
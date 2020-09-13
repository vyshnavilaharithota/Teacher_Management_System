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

    
    $sql = "SELECT * FROM teacherprofile WHERE id=$pid";
    $result = mysqli_query($conn,$sql);
    $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($tdata))
    {
        header("Location: viewinfo.php");
    }
    $pid='t'.$pid;
    $sql="DROP TABLE $pid";
    $pid=$_GET['id'];
    $sqlr="DELETE FROM teacherprofile WHERE id=$pid";
    $sqla="DELETE FROM userauthentication WHERE id=$pid";
    $result = mysqli_query($conn,$sql);
    $resultr = mysqli_query($conn,$sqlr);
    $resulta = mysqli_query($conn,$sqla);
    if($result && $resultr && $resulta)
    {
        echo "succesful";
       header("Location: viewinfo.php");
    }

?>
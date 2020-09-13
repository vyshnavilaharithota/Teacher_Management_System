<?php

    session_start();
    if(!$_SESSION['id'])
    {
        session_unset();
        session_destroy();
        header("Location: teacherLogin.php");
    }
    include("php/connection.php");
    $pid=$_SESSION['id'];
    $tid='t'.$pid;
    $fr=$_GET['fromDate'];
    $sql = "SELECT * FROM $tid WHERE fromDate='$fr'";
    $result = mysqli_query($conn,$sql);
    $ldata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($ldata))
    {
        header("Location: afterlogin.php");
    }
    $noofdays=$ldata[0]['noofDays'];
    
    $sql="DELETE FROM $tid WHERE fromDate='$fr'";
    
    $result = mysqli_query($conn,$sql);
    
    if($result)
    {
        $sql = "SELECT leavesLeft FROM teacherprofile WHERE id=$pid ";
        $result = mysqli_query($conn,$sql);
        $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $leaves=floatval($tdata[0]['leavesLeft'])+floatval($noofdays);
        $sql = "UPDATE teacherprofile SET leavesLeft=$leaves WHERE id=$pid";
        $result = mysqli_query($conn,$sql);
        if (mysqli_query($conn, $sql)) {
            echo "Record changed successfully";
            
            header("Location: futureLeaveCancel.php");
        } else {
            echo "Error changing record: " . mysqli_error($conn);
        }
        echo "succesful";
        
      
    }


?>
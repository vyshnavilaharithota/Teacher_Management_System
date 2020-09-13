<?php
session_start();
    if(!$_SESSION['id'])
    {
        session_unset();
        session_destroy();
        header("Location: adminLogin.php");

    }
    echo "In reset";
    include('php/connection.php');
    $sqlt = "SELECT * FROM teacherprofile";
    $resultt = mysqli_query($conn,$sqlt);
    $tdata=mysqli_fetch_all($resultt, MYSQLI_ASSOC);
    if(empty($tdata))
    {
        header("Location: afteradminLogin.php");
    }
    $lea=0;
    foreach($tdata as $tdatas)
    {
            $tt=$tdatas['id'];
            $tn='t'.$tt;
            $sqld="TRUNCATE TABLE $tn";
            if (mysqli_query($conn, $sqld)) {
            echo "Record emptied successfully";
        } else {
            echo "Error emptying record: " . mysqli_error($conn);
        }
        $gender=$tdatas['gender'];
        if($gender=="male")
        {
            $lea=22;
        }
        else
        {
            $lea=27;
        }
        echo $tt;
        $sqlu = "UPDATE teacherprofile SET leavesLeft=$lea WHERE id=$tt";
            
            if (mysqli_query($conn, $sqlu)) {
                echo "Record changed successfully ";
                
                
            } else {
                echo "Error changing record: " . mysqli_error($conn);
            }

    }
    header("Location: afteradminLogin.php");


?>
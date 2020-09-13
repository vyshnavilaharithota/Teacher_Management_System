<?php
    session_start();
    $leaves=0;
    if($_SESSION['id']!='admin')
    {
        session_unset();
        session_destroy();
        header("Location: adminLogin.php");
    }
    include("php/connection.php");
    $pid=$_GET['id'];
    $dsp=$_GET['name'];
    
    $sql = "SELECT * FROM teacherprofile WHERE id=$pid";
    $result = mysqli_query($conn,$sql);
    $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($tdata))
    {
        //echo "error";
        header("Location: viewinfo.php");
    }
    $pid='t'.$pid;
    $sql = "SELECT * FROM $pid";
    $result = mysqli_query($conn,$sql);
    $ldata=mysqli_fetch_all($result, MYSQLI_ASSOC);
    $pid=$_GET['id'];
    $sql = "SELECT leavesLeft FROM teacherprofile WHERE id=$pid";
    $result = mysqli_query($conn,$sql);
    $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $leaves = $tdata[0]['leavesLeft'];



?>


<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher Management System</title>
        
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet"></link> -->
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"></link>
    
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> -->

  </head>
  <body >
  <?php include('about.php'); ?>
 <?php include('contact.php'); ?>

<nav class="purple">
            <div class="nav-wrapper container">
                <a href="" class="center">Teacher Management System</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                <!-- <li><a href="afteradminLogin.php" class="hoverable purple ">Admin Home</a></li>  -->
                <li><a href="afteradminLogin.php" class="hoverable purple ">Authenticate a User</a></li> 
                <li><a href="leavelist.php" class="hoverable purple">Teachers on Leave</a></li>  
            <li><a href="viewinfo.php" class="hoverable purple ">View Users</a></li>

            <li><a href="#about" class=" hoverable modal-trigger purple ">About</a></li> 
            <li><a href="#contact" class="hoverable modal-trigger purple">Contact</a></li>
            <li><a href="logout.php" class="hoverable purple ">Sign Out</a></li>
                    
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
        <li><a href="afteradminLogin.php" class="hoverable  ">Admin Home</a></li> 
                    
            <li><a href="afteradminLogin.php" class="hoverable ">Authenticate a User</a></li> 
            <li><a href="leavelist.php" class="hoverable ">Teachers on Leave</a></li>  
            <li><a href="viewinfo.php" class="hoverable ">View Users</a></li>

            <li><a href="#about" class=" hoverable modal-trigger ">About</a></li> 
            <li><a href="#contact" class="hoverable modal-trigger ">Contact</a></li>
            <li><a href="logout.php" class="hoverable ">Sign Out</a></li>
            
        </ul>

        <br>
        <br>
    

    <div class="container center ">
    <div class="container center ">
    <div class="container center ">
    <br>
    <!-- <h5> </h5><br> -->
    <h5 class="purple-text"><?php echo $dsp; ?>'s Leave Information</h5>
    <h6 >Leaves Left : <?php echo $leaves ?> </h6><br>
    <table class="striped bordered centered" style="width:100%" id="example">
    
    <thead class="purple lighten-2">
    <tr>
    <th>From Date</th>
    <th>To Date</th>
    <th>No of Days</th>
    <th>Time Stamp</th>
    </tr></thead>
    <tbody>
    <?php foreach($ldata as $ldatas){ ?>
    <tr>
        <td> <?php echo $ldatas['fromDate']; ?> </td>
        <td> <?php echo $ldatas['toDate']; ?> </td>
        <td> <?php echo $ldatas['noofDays']; ?> </td>
        <td> <?php echo $ldatas['reg_date']; ?> </td>
    </tr>
    <?php } ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
    
            
   
            $(document).ready(function(){
                $('.modal').modal(); 
                $('.sidenav').sidenav();
            });
        </script>  
        
        
        
</body>
</html>


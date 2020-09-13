<?php

session_start();
if($_SESSION['id']!='admin')
{
    session_unset();
    session_destroy();
    header("Location: adminLogin.php");
}
    include('php/connection.php');
    $sql = 'SELECT * FROM teacherprofile';
    $result = mysqli_query($conn,$sql);
    $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
        
?>    



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"></link>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet"></link> -->
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"></link>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"></link>
    
 
</head>
<body>
<?php include('about.php'); ?>
 <?php include('contact.php'); ?>

<nav class="purple">

            <div class="nav-wrapper container">
                <a href="" class="center">Teacher Management System</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    
                <li><a href="afteradminLogin.php" class="hoverable purple">Admin Home</a></li> 
                    <li><a href="afteradminLogin.php" class="hoverable purple">Authenticate a User</a></li>  
                    <li><a href="#about" class=" hoverable modal-trigger purple">About</a></li> 
<li><a href="#contact" class="hoverable modal-trigger purple">Contact</a></li>

                    <li><a href="logout.php" class="hoverable purple">Sign Out</a></li>
                    
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
        <li><a href="afteradminLogin.php" class="hoverable ">Admin Home</a></li> 
        <li><a href="afteradminLogin.php" class="hoverable ">Authenticate a User</a></li>  
                    <li><a href="#about" class=" hoverable modal-trigger ">About</a></li> 
<li><a href="#contact" class="hoverable modal-trigger ">Contact</a></li>

                    <li><a href="logout.php" class="hoverable ">Sign Out</a></li>
            
        </ul>
        <br>
        <br>
        <br>
    <div class="container ">
    <h5 class="purple-text center">Teachers on Leave</h5>
    <h6 class=" center"><?php echo date('d-m-Y'); ?></h6>
    <br>
    <table id="example" class="striped bordered centered" >
        <thead class="purple lighten-2">
            <tr>
                <th>Name</th>
                <th>ID</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>School</th>
                <th>View User</th>
            </tr>
        </thead>
        <tbody>
        <?php
                foreach( $tdata as $tdatas)
                {
                    $t='t'.$tdatas['id'];
                    
                    $sql = "SELECT * FROM $t";
                    $result = mysqli_query($conn,$sql);
                    $ldata = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    foreach($ldata as $ldatas)
                    {?>
                        
                   <?php    if(strtotime($ldatas['fromDate'])<=strtotime(date('Y-m-d')) && strtotime($ldatas['toDate'])>=strtotime(date('Y-m-d')))
                        { ?>
                            <tr>
                            <td><?php echo $tdatas['name'];?></td>
                            <td><?php echo $tdatas['id'];?></td>
                            <td><?php echo $ldatas['fromDate'];?></td>
                            <td><?php echo $ldatas['toDate'];?></td>
                            <td><?php echo $tdatas['school'];?></td>
                            <td>
                        <a href="viewrecord.php?id=<?php echo $tdatas['id'].'&name='. $tdatas['name'];?>" ><i class="material-icons purple-text">view_array</i></a>
                        
                        </td>
                        </tr>
                        <?php } ?>
                        
                      <?php
                    }
                    
                }
                ?>

        
                
               
        </tbody>
        
    </table>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
     
        <script>
             $(document).ready(function(){
                $('.modal').modal(); 
                $('.sidenav').sidenav();
            });
        </script>   
</body>
</html>
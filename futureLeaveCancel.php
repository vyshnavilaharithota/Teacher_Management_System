<?php

session_start();
if(!$_SESSION['id'])
{
    session_unset();
    session_destroy();
    header("Location: teacherLogin.php");
}

$t=$_SESSION['id'];
$tid='t'.$t;
    include('php/connection.php');
    $sql = "SELECT * FROM $tid";
    $result = mysqli_query($conn,$sql);
    $ldata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($ldata))
    {
        header("Location: afterlogin.php");
    }
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
                    
                <li><a href="afterlogin.php" class="hoverable purple">User Home</a></li>
                      
                    <li><a href="#about" class=" hoverable modal-trigger purple">About</a></li> 
<li><a href="#contact" class="hoverable modal-trigger purple">Contact</a></li>

                    <li><a href="logout.php" class="hoverable purple">Sign Out</a></li>
                    
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
        <li><a href="afterlogin.php" class="hoverable ">User Home</a></li> 
       
         
                    <li><a href="#about" class=" hoverable modal-trigger ">About</a></li> 
<li><a href="#contact" class="hoverable modal-trigger ">Contact</a></li>

                    <li><a href="logout.php" class="hoverable ">Sign Out</a></li>
            
        </ul>
        <br>
        <br>
        <br>
    <div class="container ">
    <h6 class="purple-text center">Future Leaves List</h6>
    <table id="example" class="striped bordered centered" >
        <thead class="purple lighten-2">
            <tr>
                <th>From</th>
                <th>To</th>
                
                <th>Leave Period</th>
                <th> Delete </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ldata as $ldatas){?>
               
                <?php if(strtotime($ldatas['fromDate'])>strtotime(date('Y-m-d')))
                { ?>
                 <tr>
                    <td><?php echo $ldatas['fromDate'];?></td>
                    <td><?php echo $ldatas['toDate'];?></td>
                    <td><?php echo $ldatas['noofDays'];?></td>
                    <td>
                        
                        <a href="deleteLeaveRecord.php?fromDate=<?php echo $ldatas['fromDate'];?>" onClick="return confirm('Do you want to cancel your applied leave <?php echo $ldatas['fromDate'].' to '. $ldatas['toDate'];?>')"><i class="material-icons purple-text" id >delete</i></a>
                        
                            
                    </td>
                </tr>
                 <?php }?>
            <?php }?>
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
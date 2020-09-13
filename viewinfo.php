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
                    <li><a href="leavelist.php" class="hoverable purple">Teachers on Leave</a></li>  
                    <li><a href="#about" class=" hoverable modal-trigger purple">About</a></li> 
<li><a href="#contact" class="hoverable modal-trigger purple">Contact</a></li>

                    <li><a href="logout.php" class="hoverable purple">Sign Out</a></li>
                    
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
        <li><a href="afteradminLogin.php" class="hoverable ">Admin Home</a></li> 
       
        <li><a href="afteradminLogin.php" class="hoverable ">Authenticate a User</a></li> 
        <li><a href="leavelist.php" class="hoverable ">Teachers on Leave</a></li>  
                    <li><a href="#about" class=" hoverable modal-trigger ">About</a></li> 
<li><a href="#contact" class="hoverable modal-trigger ">Contact</a></li>

                    <li><a href="logout.php" class="hoverable ">Sign Out</a></li>
            
        </ul>
        <br>
        <br>
        <br>
    <div class="container ">
    <h6 class="purple-text center">Registered Teachers List</h6>
    <table id="example" class="striped bordered centered" >
        <thead class="purple lighten-2">
            <tr>
                <th>Name</th>
                <th>ID</th>
                <th>Phone</th>
                <th>DOB</th>
                <th>School</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Password</th>
                <th>Leaves left</th>
                <th> View/Edit/Delete </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tdata as $tdatas){?>
                <tr>
                    <td><?php echo $tdatas['name'];?></td>
                    <td><?php echo $tdatas['id'];?></td>
                    <td><?php echo $tdatas['phoneno'];?></td>
                    <td><?php echo $tdatas['dob'];?></td>
                    <td><?php echo $tdatas['school'];?></td>
                    <td><?php echo $tdatas['gender'];?></td>
                    <td><?php echo $tdatas['email'];?></td>
                    <td><?php echo $tdatas['password'];?></td>
                    <td><?php echo $tdatas['leavesLeft'];?></td>
                    <td>
                        <a href="viewrecord.php?id=<?php echo $tdatas['id'].'&name='. $tdatas['name'];?>" ><i class="material-icons purple-text">view_array</i></a>
                        <a href="editrecord.php?id=<?php echo $tdatas['id'].'&name='. $tdatas['name'];?>" ><i class="material-icons purple-text">create</i></a>
                        <a href="deleterecord.php?id=<?php echo $tdatas['id'].'&name='. $tdatas['name'];?>" onClick="return confirm('Do you want to delete record of <?php echo $tdatas['id'].'name: '.$tdatas['name'];?>')" ><i class="material-icons purple-text" >delete</i></a>
                       
                    </td>
                </tr>
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
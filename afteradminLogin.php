<?php

session_start();
if($_SESSION['id']!='admin')
{
    session_unset();
    session_destroy();
    header("Location: adminLogin.php");
}
    $name='';
    $tid='';
    $school='';
    $checkid='';
    include("php/connection.php");
    $sqlt = "SELECT id FROM teacherprofile";
    $resultt = mysqli_query($conn,$sqlt);

    $tdata=mysqli_fetch_all($resultt, MYSQLI_ASSOC);
    $sql = "SELECT * FROM userauthentication";
    $result = mysqli_query($conn,$sql);

    $adata=mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(isset($_POST['submit']))
    {
        $flag=0;
        $flag6=0;
        $name=$_POST['name'];
        $tid=$_POST['tid'];
        $school=$_POST['school'];
        foreach($tdata as $tdatas)
        {
            if($tdatas['id']==$tid)
            {
                $flag6=1;
                break;
            }
        }
        if($flag6==1)
        {
            $checkid="ID already exists";
        }
        else{
        $sql = "SELECT * FROM userauthentication";
        $result = mysqli_query($conn,$sql);
        $adata=mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach($adata as $adatas)
        {
            if($adatas['id']==$tid)
            {
                $flag=1;
                break;
            }
        }
        if($flag)
        {
            $checkid="Id already Exists";
        }
        else{
            $sql = "INSERT INTO userauthentication(name, id, school) VALUES('$name', '$tid', '$school') ";
            $result = mysqli_query($conn,$sql);
            header("Location: afteradminLogin.php");
        }
    }
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher Management System</title>
        
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"></link>
        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet"></link> -->
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"></link>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"></link>
    <script>
        function passwdcheck()
            {
                
               
               
                var tid=document.frm.tid.value;
               

                if(tid.length!==7)
                {
                    alert("Enter a valid ID of size 7");
                    return false;
                }
                
                return true;
                 

            }
        </script>
   

  </head>
  <body>
  <?php include('about.php'); ?>
 <?php include('contact.php'); ?>
  <nav class="purple">
            <div class="nav-wrapper container">
                <a href="" class="center">Teacher Management System</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="leavelist.php" class="hoverable purple">Teachers on Leave</a></li>
                    <li><a href="viewinfo.php" class="hoverable purple">View Users</a></li>
                    <li><a href="#about" class=" hoverable modal-trigger purple">About</a></li> 
                    <li><a href="#contact" class="hoverable modal-trigger purple">Contact</a></li>

                    <li><a href="logout.php" class="hoverable purple">Sign Out</a></li>
                    
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
                    
        <li><a href="leavelist.php" class="hoverable">Teachers on Leave</a></li>
        <li><a href="viewinfo.php" class="hoverable">View Users</a></li>
        <li><a href="#about" class=" hoverable modal-trigger">About</a></li> 
        <li><a href="#contact" class="hoverable modal-trigger ">Contact</a></li>

            <li><a href="logout.php" class="hoverable">Sign Out</a></li>
            
        </ul>
        <br>
        <br>
        <br>
        <br>
      
        <?php if(date('z')==365){ ?>
            <marquee direction="right" scrollamount=10><h5 class="red-text text-darken-2"> Today is 1st january. Scroll down to Reset</h5></marquee><br>   
       
        <?php } ?>
        <h6  class="purple-text center">  Authenticate a Teacher </h6><br>
        <div class="container">
        <div class="container ">
        <div class="card-panel  " >
        <form name="frm" onsubmit="return passwdcheck()" action="afteradminLogin.php" method="post" >
            <div class="input-field ">
            <input type="text" name="name" id="name" value="<?php echo $name ?>" required> 
            <label for="name" >Name</label>
            </div>
            <div class="input-field ">
            <input type="number" name="tid" id="tid"  required>
            <span class="red-text"><?php echo $checkid; ?> </span> 
            <label for="tid" >Teacher ID</label>
            </div>
            <div class="input-field ">
            <input type="text" name="school" id="school" value="<?php echo $school ?>" required> 
            <label for="school" >School Name</label>
            </div>
           
            <br>
            <div class="center">
            <input type="submit" name="submit" value="Add Teacher" required>
        </div>
        </form>
        </div>
        </div>
        </div>
        <br>
        <div class="container ">
        <div class="container center ">
        <h6  class="purple-text">Unregistered Authenticated Teachers List</h6>
    <table id="example" class="striped centered  bordered " style="width:100%" >
        <thead class="purple lighten-2">
            <tr>
                <th>Name</th>
                <th>ID</th>
                <th>School</th>
                <th>Edit/Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($adata as $adatas){?>
                <tr>
                    <td><?php echo $adatas['name'];?></td>
                    <td><?php echo $adatas['id'];?></td>
                    <td><?php echo $adatas['school'];?></td>
                    <td>
    
                        <a href="editAuth.php?id=<?php echo $adatas['id'].'&name='. $adatas['name'];?>" ><i class="material-icons purple-text">create</i></a>
                        <a href="deleteAuth.php?id=<?php echo $adatas['id'].'&name='. $adatas['name'];?>"  onClick="return confirm('Do you want to delete?')"><i class="material-icons purple-text">delete</i></a>
                    </td>
                </tr>
            <?php }?>
        </tbody>
        
    </table>
</div>
</div>

<div class="container  center">
                
                <a class="btn red darken-3 white-text center" href="reset.php" id="reset" onClick="return confirm('Do you want to reset all accounts?')" ><i class="material-icons">warning</i><span class="red darken-3 white-text">RESET ALL ACCOUNTS</span></a>
                
</div>

        
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
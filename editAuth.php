<?php
    session_start();
    if($_SESSION['id']!='admin')
    {
        session_unset();
        session_destroy();
        header("Location: adminLogin.php");
    }
    
    $name='';
    $id ='';
    $phoneno = '';
    $dob = '';
    $gender ='';
    $email = '';
    $checkid='';
    $flag3='';
    $error='';
    $un_id='';
    $un_name='';
    $school='';
  //  $auser='';
?>

<?php

$un_id=$_GET['id'];
$un_name=$_GET['name'];
include('php/connection.php');
$sql = "SELECT * FROM userauthentication WHERE id=$un_id";
    $result = mysqli_query($conn,$sql);
    $adata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($adata))
    {
        header("Location: afteradminLogin.php");
    }



    $name = $adata[0]['name'];
    $id = $adata[0]['id'];
    
    $school=$adata[0]['school'];

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $id = $_POST['tid'];
    $school = $_POST['school'];
    $sqla = 'SELECT id FROM userauthentication';
    $flag1=0;
        $resulta = mysqli_query($conn,$sqla);
        $adata = mysqli_fetch_all($resulta, MYSQLI_ASSOC);
        foreach($adata as $adatas)
        {
                if($un_id!=$id)
                {
                    if($adatas['id']==$id )    
                    {

                        $flag1=1;
                        break;  
                    
                    }
            }
            
        }

    $sql = 'SELECT id FROM teacherprofile';
        $result = mysqli_query($conn,$sql);
        $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $flag=0;
        foreach($tdata as $tdatas)
        {
                if($un_id!=$id)
                {
                    if($tdatas['id']==$id )    
                    {

                        $flag=1;
                        break;  
                    
                    }
            }
            
        }
    if($flag==1 || $flag1==1)
    {
        $checkid= "Another User with same ID exists. ";
    }

    else
    {
        
        $sql = "UPDATE userauthentication SET name='$name',id='$id',school='$school' WHERE id=$un_id";
        if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
        } 
        else
        {
            echo "Error updating record: " . mysqli_error($conn);
        }
        
        header("Location: afteradminLogin.php");
    }

}
?>


<!DOCTYPE html>
<html>
    <head>
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
        <!-- <link type="text/css" rel="stylesheet" href="css/register.css"> -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        
        <!-- Compiled and minified CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    </head>
    <body>
    <?php include('about.php'); ?>
 <?php include('contact.php'); ?>

    <nav class="purple">
            <div class="nav-wrapper container">
                <a href="" class=" center">Teacher Registration Form</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    
                    <li><a href="afteradminLogin.php" class="hoverable purple">Admin Home</a></li>
                    <li><a href="#about" class=" hoverable modal-trigger purple">About</a></li> 
                    <li><a href="#contact" class="hoverable modal-trigger purple">Contact</a></li>

                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
                       
        <li><a href="afteradminLogin.php" class="hoverable ">Admin Home</a></li>
                    <li><a href="#about" class=" hoverable modal-trigger">About</a></li> 
                    <li><a href="#contact" class="hoverable modal-trigger ">Contact</a></li>
            
        </ul>
        <br>
        <div class="container">
        <div class="container">
        <div class="card-panel">
        <form name="frm" onsubmit="return passwdcheck()" action="editAuth.php?id=<?php echo $un_id.'&name='. $un_name;?>" method="post" >
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
            <input type="submit" name="submit" value="Update Teacher" required>
        </div>
        </form>
        </div>
        </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
             $(document).ready(function(){
                $('.modal').modal(); 
                $('.sidenav').sidenav();
            });
        </script>   
    </body>
</html>
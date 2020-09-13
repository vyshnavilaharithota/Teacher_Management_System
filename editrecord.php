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
?>

<?php

$un_id=$_GET['id'];
$un_name=$_GET['name'];
include('php/connection.php');
$sql = "SELECT * FROM teacherprofile WHERE id=$un_id";
    $result = mysqli_query($conn,$sql);
    $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($tdata))
    {
        header("Location: viewinfo.php");
    }


$sql = "SELECT * FROM teacherprofile WHERE id=$un_id";
$result = mysqli_query($conn,$sql);
$tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
//print_r($tdata);
if(count($tdata)==0)
{
    header("Location: viewinfo.php");
}
    $name = $tdata[0]['name'];
    $id = $tdata[0]['id'];
    $phoneno = $tdata[0]['phoneno'];
    $dob = $tdata[0]['dob'];
    $gender = $tdata[0]['gender'];
    $email = $tdata[0]['email'];
    $leavesLeft=$tdata[0]['leavesLeft'];
    $school=$tdata[0]['school'];

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $id = $_POST['tid'];
    $phoneno = $_POST['phno'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $leavesLeft=$_POST['leavesLeft'];
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
        $sql = "UPDATE teacherprofile SET name='$name',id='$id',phoneno='$phoneno',dob='$dob',gender='$gender',email='$email',school='$school',leavesLeft='$leavesLeft'  WHERE id=$un_id";
        if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
        } 
        else
        {
            echo "Error updating record: " . mysqli_error($conn);
        }
        //$sql = "UPDATE userauthentication SET name='$name',id='$id' WHERE id=$un_id";
        // if (mysqli_query($conn, $sql)) {
        // echo "Record updated successfully";
        // } 
        // else
        // {
        //     echo "Error updating record: " . mysqli_error($conn);
        // }
        $old_table='t'.$un_id;
        $new_table='t'.$id;
        if($un_id!=$id)
        {
            $sql="ALTER TABLE $old_table RENAME TO $new_table";
            if (mysqli_query($conn, $sql)) {
                echo "Table Altered successfully";
                
                } 
            else 
            {
                echo "Error altering table: " . mysqli_error($conn);
            }

        }
        header("Location: viewinfo.php");
    }

}
?>


<!DOCTYPE html>
<html>
    <head>
        <script>
        function passwdcheck()
            {
                
               
                var phno=document.frm.phno.value;
                var tid=document.frm.tid.value;
                if(phno.length!==10)
                {
                    alert("Enter a valid phone no");
                    return false;
                }

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
                    <li><a href="#about" class=" hoverable modal-trigger ">About</a></li> 
                    <li><a href="#contact" class="hoverable modal-trigger ">Contact</a></li>   
            
        </ul>
        <br>
        <div class="container">
        <div class="container">
        <div class="card-panel">
        <form name="frm" onsubmit="return passwdcheck()" action="editrecord.php?id=<?php echo $un_id.'&name='.$un_name  ?>" method="post" >
            <div class="input-field ">
            <input type="text" name="name" id="name" value="<?php echo $name ?>" required> 
            <label for="name" >Name</label>
            </div>
            <div class="input-field ">
            <input type="number" name="tid" id="tid"  value="<?php echo $id ?>"required>
            <span class="red-text"><?php echo $checkid; ?> </span> 
            <label for="tid" >Teacher ID</label>
            </div>
            <div class="input-field ">
            <input type="number" name="phno" id="phno" value="<?php echo $phoneno ?>" required> 
            <label for="phno" >Phone Number</label>
            </div>
            <div class="input-field ">
            <input type="date" name="dob" id="dob" value="<?php echo $dob ?>" required> 
            <label for="dob" >Date of Birth</label>
            </div>
            <label>
            <span>Gender</span>
        </label>
        <br>
            <label>
                <input name="gender" type="radio" value="male" required />
                <span>Male</span>
            </label>
            <br>
            <label>
                <input name="gender" type="radio" value="female" required />
                <span>Female</span>
            </label>
            <!-- Gender
            <br>
            <input type="radio" name="gender" value="male" required>male<br>
            <input type="radio" name="gender" value="female" required>female
            <br><br> -->
            <div class="input-field ">
            <input type="email" name="email" id="email" value="<?php echo $email ?>" required> 
            <label for="email" >Email</label>
            </div>
            <div class="input-field ">
            <input type="text" name="school" id="school" value="<?php echo $school ?>" required> 
            <label for="school" >School Name</label>
            </div>
            <div class="input-field ">
            <input type="number" name="leavesLeft" id="leavesLeft" value="<?php echo $leavesLeft ?>" required> 
            <label for="leavesLeft" >Leaves Left</label>
            </div>
            
            <br>
            <div class="center">
            <span class="red-text"><?php echo $error; ?> </span> 
            <span class="red-text"><?php echo $flag3; ?> </span> 
            <br>
            <input type="submit" name="submit" value="Update" required>
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
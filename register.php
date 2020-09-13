<?php

$name='';
    $id ='';
    $phoneno = '';
    $dob = '';
    $gender ='';
    $email = '';
    $checkid='';
    $flag3='';
    $error='';
    $school='';
?>


<?php include('php/connection.php');
//'$_POST['name']', '$_POST['tid']',  '$_POST['phno']', '$_POST['dob']', '$_POST['gender']', '$_POST['email']', '$_POST['pass']' )

if(isset($_POST['submit']))
{
    $flag=0;
    $flag2=0;
    
    //echo 'working';    
    $name = $_POST['name'];
    $id = $_POST['tid'];
    $phoneno = $_POST['phno'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $school = $_POST['school'];
   
        $sql = 'SELECT id FROM teacherprofile';
        $result = mysqli_query($conn,$sql);
        $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        foreach($tdata as $tdatas)
        {
            if($tdatas['id']==$id)    
            {

            $flag=1;
            break;
            }
            
        }
        
        if($flag==0)
        {   
            $sql = 'SELECT id FROM userauthentication';
            $result = mysqli_query($conn,$sql);
            $auth = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if(!$result)
            {
                $error = "Server Error!! Try again";
        
            }
            else{
            foreach($auth as $auths)
            {
                if($auths['id']==$id)
                {
                    $flag2=1;
                    break;
                }
            }
            if($flag2==1)
            {


            $l=0;
            if($gender=="male")
            {
                $l=22;
            }
            else
            {
                $l=27;
            }
            $sql = "INSERT INTO teacherprofile(name, id, phoneno, dob, gender, email, password,leavesLeft,school) VALUES('$name', $id, $phoneno, '$dob', '$gender', '$email', '$password',$l,'$school') ";
            $result = mysqli_query($conn,$sql);
            if(!$result)
            {
                header("Location: register.php");
            }
            $tablename = 't'. $id;
            $sql="CREATE TABLE $tablename (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                fromDate DATE NOT NULL,
                toDate DATE NOT NULL,
                noofDays FLOAT NOT NULL,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )"; 
                
                if (!mysqli_query($conn, $sql)) {
                    echo "Error creating table: " . mysqli_error($conn);
                    $sql = "DELETE FROM teacherprofile WHERE id=$id";
                    $result = mysqli_query($conn,$sql);
                    header("Location: register.php");
                } else {
                    
                    $sql = "DELETE FROM userauthentication WHERE id=$id";
                    if (mysqli_query($conn, $sql)) {
                        echo "Authentication Successful";
                      } else {

                        echo "Authentication Failed" . mysqli_error($conn);
                        $sql = "DELETE FROM teacherprofile WHERE id=$id";
                        $sqlt="DROP TABLE $tablename";
                        $result = mysqli_query($conn,$sql);
                        $resultt = mysqli_query($conn,$sqlt);


                      }
                    mysqli_close($conn);
                
                    header("Location: index.php");


                }
            
            }  

        
        else{
            $flag3="Your account is not authenticated. Try again later";
            // echo $flag3;
           
        }
            }
            }
            else{
                $checkid="Id already exists check again";
            }
    
    }
    else
    {
        
        //header("Location: register.php");
    }    
        

   
   


 //

// $result = mysqli_query($conn,$sql);
// $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
//print_r($tdata);

?>


<!DOCTYPE html>
<html>
    <head>
        <script>
        function passwdcheck()
            {
                
                var passwd=document.frm.pass.value;
                var confirmpasswd=document.frm.conpass.value;
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
                if(passwd!==confirmpasswd)
                 {
                    alert("passwords do not match");
                    return false;
                    
                 }
                 //document.querySelector(".myForm").innerHTML='<p><br><a href="index.html">Navigate to home Page</a><br><a href="teacherLogin.html">Navigate to Teacher Login Page</a></p>';
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
                    
                    <li><a href="index.php" class="hoverable purple">Home</a></li>
                    <li><a href="#about" class=" hoverable modal-trigger purple">About</a></li> 
                    
                    <li><a href="#contact" class="hoverable modal-trigger purple">Contact</a></li>
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
                    
            <li><a href="index.php" class="hoverable ">Home</a></li>
            <li><a href="#about" class="hoverable modal-trigger">About</a></li> 
            <li><a href="#contact" class="hoverable modal-trigger ">Contact</a></li>
        </ul>
        <br>
        <div class="container">
        <div class="container">
        
        <div class="card-panel ">
        <div class="center">
        <span class="red-text"><?php echo $flag3; ?> </span> </div><br>
        <form name="frm" onsubmit="return passwdcheck()" action="register.php" method="post" >
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
            <input type="password" name="pass" id="pass"  required> 
            <label for="pass" >Password</label>
            </div>
            <div class="input-field ">
            <input type="password" name="conpass" id="conpass"  required> 
            <label for="conpass" >Confirm Password</label>
            </div>
            <div class="input-field ">
            <input type="text" name="school" id="school" value="<?php echo $school ?>" required> 
            <label for="school" >School Name</label>
            </div>
           
            <br>
            <div class="center">
            <span class="red-text"><?php echo $error; ?> </span> 
           
            <br>
            <input type="submit" name="submit" value="Register" required>
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
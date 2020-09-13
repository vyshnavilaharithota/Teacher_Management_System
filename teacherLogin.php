<?php 

session_start();
$tid="";
//$gender="";
$error='';
//$lea=0;
if(isset($_POST["submit"])){
    
include('php/connection.php');
$flag=0;

$sql = 'SELECT * FROM teacherprofile';
    $result = mysqli_query($conn,$sql);
    $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    foreach($tdata as $tdatas)
    {
        if($tdatas['id']==$_POST['id'] && $tdatas['password']==$_POST['pass'])      {
        $_SESSION['name']=$tdatas['name'];
        $gender=$tdatas['gender'];
        $flag=1;
        break;
        }
        
    }
    if($flag==1)
    {
        $_SESSION['id']=$_POST['id'];
        $_SESSION['password']=$_POST['pass'];
       // include('reset.php');
       // echo "succesful";
        header("Location: afterlogin.php");
    }
    else{
        $error= "Password or Teacher ID is incorrect";
        }
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            .formadjust{
                padding-top: 150px;
            }
            </style>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher Management System</title>
        
        <!-- Compiled and minified CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <script>
  
    function validate(){
        var id=document.loginform.id.value;
     if(id.length!==7)
                {
                    alert("Enter a valid ID of size 7");
                    return false;
                }
                return true;
                }

    </script>
    
    </head>
    <?php include('about.php'); ?>
 <?php include('contact.php'); ?>
    <body class=" purple lighten-5">

    <nav class="purple">
            <div class="nav-wrapper container">
                <a href="" class=" center">Teacher Login</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    
                <li><a href="index.php" class="hoverable  purple">Home</a></li>
                    <li><a href="#about" class="hoverable modal-trigger purple">About</a></li> 
                    
                    <li><a href="#contact" class="hoverable modal-trigger purple">Contact</a></li>
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
                    
        <li><a href="index.php" class="hoverable">Home</a></li>
                    <li><a href="#about" class="hoverable modal-trigger ">About</a></li> 
                    
                    <li><a href="#contact" class="hoverable modal-trigger ">Contact</a></li>
        </ul>
        
    

        <div class="container formadjust">
        <div class="container center">
        <div class="card-panel">
        <form name="loginform" method="post" action="teacherLogin.php" onsubmit="return validate()" class="logincss" >
        
            <div class="input-field ">
            <input type="number" name="id"  id="id" required>
            <label for="id" >Teacher ID</label>
            </div>
           <div class="input-field">
            <input type="password" id="pp" name="pass" required>
            <label for="pp" >Password</label>
            </div>
            <label class="red-text"><?php echo $error ; ?></label><br>
            <input type="submit" name="submit" value="Sign in">
            
           
        
        </form>
        <br>
        not registered?
        <a href="register.php">sign up</a>
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
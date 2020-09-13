<?php
    $error='';
    if(isset($_POST['submit']))
    {
        session_start();
       
       // header("Location: afteradminLogin.php");
        include('php/connection.php');
        $sql = 'SELECT * FROM admin';
    $result = mysqli_query($conn,$sql);
    $admindata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if($_POST['id']==$admindata[0]['id'] && $_POST['pass']==$admindata[0]['password'])
    {
        $_SESSION['id']='admin';
        header("Location: afteradminLogin.php");
    }
    else
    {
        $error="Admin Credentials are incorrect.";
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

    
   

    </script>
    
    </head>

    <body class=" purple lighten-5">
    <?php include('about.php'); ?>
    <?php include('contact.php'); ?>
    <nav class="purple">
            <div class="nav-wrapper container">
                <a href="" class=" center">Admin Login</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    
                    <li><a href="index.php" class="hoverable purple">Home</a></li>
                    <li><a href="#about" class=" hoverable modal-trigger purple">About</a></li> 
                    <li><a href="#contact" class="hoverable modal-trigger purple">Contact</a></li>
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
                    
            <li><a href="index.php" class="hoeverable">Home</a></li>
            <li><a href="#about" class=" hoverable modal-trigger">About</a></li> 
            <li><a href="#contact" class="hoverable modal-trigger">Contact</a></li>
        </ul>
    

        <div class="container formadjust">
        <div class="container center">
        <div class="card-panel">
        <form name="loginform" method="post" action="adminLogin.php" onsubmit="return validate()" class="logincss" >
        
            <div class="input-field ">
            <input type="text" name="id"  id="id" required>
            <label for="id" >Admin ID</label>
            </div>
           <div class="input-field">
            <input type="password" id="pp" name="pass" required>
            <label for="pp" >Password</label>
            </div>
            <label class="red-text text-darken-2"><?php echo $error; ?></label><br>
            <input type="submit" name="submit" value="Sign in">
    
           
        
        </form>
        <br>
       
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
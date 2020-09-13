<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    </head>
    <body>
    <?php include('about.php'); ?>
    <?php include('contact.php'); ?>

        <nav class="purple">
            <div class="nav-wrapper container">
                <a href="" class="center">Teacher Management System</a>
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
        <br>
        <br>
        <br>
        <br>
        
        <div class="container ">
            <div class="container">
                <div class="card-panel center purple lighten-5">
                    <a href="teacherLogin.php" ><img src="img/teacherlogin.png" width="145px" height="145px"><br><span class="purple-text">Teacher Login</span></a></a>
                    <br>
                    <br>
                    <a href="adminLogin.php" ><img src="img/adminlogin.png" width="150px" height="150px"><br><span class="purple-text">Admin Login</span></a></a>
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
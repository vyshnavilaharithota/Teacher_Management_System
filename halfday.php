<?php
    session_start();
    $leaveserror='';
    if(!$_SESSION['id'])
    {
        session_unset();
        session_destroy();
        header("Location: teacherLogin.php");
    }
    $pid = 't'. $_SESSION['id']; 
    $pname=$_SESSION['name'];
    $id=$_SESSION['id'];
    include('php/connection.php');
    $sql = "SELECT * FROM $pid";
    $result = mysqli_query($conn,$sql);
    $ldata=mysqli_fetch_all($result, MYSQLI_ASSOC); 
   
    $sql = "SELECT leavesLeft FROM teacherprofile WHERE id=$id";
    $result = mysqli_query($conn,$sql);
    $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($tdata))
    {
        header("Location: afterlogin.php");
    }
    $leaves = $tdata[0]['leavesLeft'];
////echo $_SESSION['id'];                                 
?>
<?php
    
    if(isset($_POST['submit']))
    {
       // echo "hello";
        
        $tablename = 't'. $_SESSION['id'];
        $from = $_POST['date'];
        $to = $_POST['date'];
        $from1=strtotime($from);
        $to1=strtotime($to);
        $sql = "SELECT * FROM  $tablename";
        $result = mysqli_query($conn,$sql);
        $leavesdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        $array_check=[];
        $i=0;
        for($i=0;$i<count($leavesdata);$i++)
        {
            $before1=$leavesdata[$i]['fromDate'];
            $after1=$leavesdata[$i]['toDate'];
            $before=strtotime($leavesdata[$i]['fromDate']);
            $after=strtotime($leavesdata[$i]['toDate']);
            if(($from1>=$before && $from1<=$after) && ($to1<=$after && $to1>=$before) )
            {
                $leaveserror= "Current applied Half day leave $from  is in between past applied leave period $before1 and $after1 <br>Check and Apply Again";
                break;
                
            }
            else if(($from1<$before && $to1>$after))
            {
                $leaveserror= "Past applied leave period $before1 and $after1 is in between Current applied half-day leave $from <br>Check and Apply Again ";
                break;
            }

            else if(($from1>=$before && $from1<=$after) && $to1>$after)
            {
                $leaveserror="Current applied Half day leave  $from is in between past applied leave period $before1 and $after1 <br>Check and Apply Again";
                 break;
            }
            else if($from1<$before && ($to1>=$before && $to1<=$after))
            {
                $leaveserror="Current applied leave period Half day leave $to is in between past applied leave period $before1 and $after1 <br>Check and Apply Again";
                break;

            }
            else
            {
                continue;
            }
        }
        if($i==count($leavesdata))
        {

        
            $diff=0.5;
            $sql = "SELECT leavesLeft FROM teacherprofile WHERE id=$id";
            $resultr = mysqli_query($conn,$sql);
            $tdata = mysqli_fetch_all($resultr, MYSQLI_ASSOC);
            $leavesLeft=0;
            $leavesLeft=floatval($tdata[0]['leavesLeft'])-$diff;
            
            
            if($leavesLeft>=0)
            {
                $sql = "INSERT INTO $tablename(fromDate, toDate, noofDays) VALUES('$from', '$to', '$diff') ";
                $result = mysqli_query($conn,$sql);
                if($result)
                {   
                    $id=$_SESSION['id'];
                
                    
                        $leavesLeft=floatval($tdata[0]['leavesLeft'])-$diff;
                        
                        $sql = "UPDATE teacherprofile SET leavesLeft='$leavesLeft' WHERE id=$id";
                        if (mysqli_query($conn, $sql))
                        {
                        echo "Record updated successfully";

                        echo "Leave application submitted succesfully";
                        header("Location: afterlogin.php");
                    
                        }
                    
                        else
                        {
                            echo "response not recorded";
                    //header("Location: afterLogin.php");
                            
                        }
            
                }
            }
            else
            {
                    $leaveserror= "You don't have sufficient no of leaves $leavesLeft";
                    //echo $leaveserror;
            }
        }
    }
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

<?php include('about.php');
    include('contact.php'); ?>
<nav class="purple">
            <div class="nav-wrapper container">
                <a href="" class="center">Teacher Management System</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                   
                <li><a href="afterlogin.php" class="hoverable modal-trigger purple">User Home</a></li> 
                    <li><a href="#about" class="hoverable modal-trigger purple">About</a></li> 
                    
                    <li><a href="#contact" class="hoverable  modal-trigger purple">Contact</a></li>
                    <li><a class="hoverable purple" href="editrecordUser.php">Edit Profile</a></li>
                    <li><a href="logout.php" class="hoverable purple">Sign Out</a></li>
                    
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
        <li><a href="afterlogin.php" class="hoverable modal-trigger ">User Home</a></li> 
                    <li><a href="#about" class="hoverable  modal-trigger ">About</a></li> 
                    
                    <li><a href="#contact" class="hoverable  modal-trigger ">Contact</a></li>
                    <li><a class="hoverable " href="editrecordUser.php">Edit Profile</a></li>
                    <li><a href="logout.php" class="hoverable ">Sign Out</a></li>
           
           
        </ul>
        <br>
<br><br>
<br>
    
    <div class="container ">
    <div class="container  center">
    <div class="card-panel">
    <form method="post" action="halfday.php" >
        
        <h5 class="center purple-text">Half-Day Leave Application</h5><br><br>
        <p class="red-text"><?php echo $leaveserror; ?></p>
        <div class="input-field">
        <input type="date" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" required>
        <label for="date">Date</label>
       
        </div>
       
        <br>
        <div class="center">
        
        <input type="submit" name="submit" value="Submit">
        </div>
        </div>
        </div>
    
    </form>





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
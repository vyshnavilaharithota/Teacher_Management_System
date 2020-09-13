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
        header("Location: logout.php");
    }
    $leaves = $tdata[0]['leavesLeft'];
////echo $_SESSION['id'];                                  
?>
<?php
    
    if(isset($_POST['submit']))
    {
       // echo "hello";
        
        $tablename = 't'. $_SESSION['id'];
        $from = $_POST['from'];
        $to = $_POST['to'];
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
                $leaveserror= "Current applied leave period $from and $to is in between past applied leave period $before1 and $after1 <br>Check and Apply Again";
                break;
                
            }
            else if(($from1<$before && $to1>$after))
            {
                $leaveserror= "Past applied leave period $before1 and $after1 is in between Current applied leave $from and $to <br>Check and Apply Again ";
                break;
            }

            else if(($from1>=$before && $from1<=$after) && $to1>$after)
            {
                $leaveserror="Current applied leave period 'From Date': $from is in between past applied leave period $before1 and $after1 <br>Check and Apply Again";
                 break;
            }
            else if($from1<$before && ($to1>=$before && $to1<=$after))
            {
                $leaveserror="Current applied leave period 'To Date': $to is in between past applied leave period $before1 and $after1 <br>Check and Apply Again";
                break;

            }
            else
            {
                continue;
            }
        }
        if($i==count($leavesdata))
        {
            $date1=date_create($from);
            $date2=date_create($to);
            $cnt=0;
            if(empty($_POST['hdate']))
            {
                $hdate=NULL;
            }
            else
            {
                $hdate=$_POST['hdate'];
                $cnt=floatval(count($hdate));
            }
            if(empty($_POST['reason']))
            {
                $reason=NULL;
            }
            else
            {
                $reason=$_POST['reason'];
            }

            
            $diff=date_diff($date1,$date2);
            $diff=(floatval($diff->format("%a")))+1-$cnt;
            $sql = "SELECT leavesLeft FROM teacherprofile WHERE id=$id";
            $resultr = mysqli_query($conn,$sql);
            $tdata = mysqli_fetch_all($resultr, MYSQLI_ASSOC);
            $leavesLeft=0;
            $leavesLeft=floatval($tdata[0]['leavesLeft'])-$diff;
            $j=0;
            if($diff>10)
            {
                $leaveserror="Leave period cannot exceed 10 days";
            }
            else if($leavesLeft>=0)
            {
                $flag=0;
                $sqls = "SELECT * from hlist";
                $results = mysqli_query($conn,$sqls);
                $sdata = mysqli_fetch_all($results, MYSQLI_ASSOC);
               
                for($i=0;$i<count($hdate);$i++)
                {
                    for($j=0;$j<count($sdata);$j++)
                    {
                        if($hdate[$i]==$sdata[$j]['date'])
                        {
                            break;
                        }
                    }
                        if($j==count($sdata))
                        {
                            $sqlh = "INSERT INTO hlist(date, reason) VALUES('$hdate[$i]', '$reason[$i]') ";
                            $resulth = mysqli_query($conn,$sqlh);
                            if(!$resulth)
                            {
                                $flag=1;
                                break;
                            }
                        }
                }
             
                $sql = "INSERT INTO $tablename(fromDate, toDate, noofDays) VALUES('$from', '$to', '$diff') ";
                $result = mysqli_query($conn,$sql);
                if($result && $flag==0)
                {   
                    $id=$_SESSION['id'];
                
                        //echo(count($hdate));
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
                    $leaveserror= "You don't have sufficient no of leaves $leavesLeft<br> You cannot apply.";
                    //echo $leaveserror;
            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet"></link> -->
    
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"></link>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 
</head>
<body >
<?php include('about.php');
    include('contact.php'); ?>
<nav class="purple">
            <div class="nav-wrapper container">
                <a href="" class="center">Teacher Management System</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                   
                    <li><a class="hoverable btn modal-trigger purple"    href="#modal1">Apply for Leave</a></li>
                    <li><a class='dropdown-trigger hoverable purple' href='#' data-target='dropdown2'>Leave Cancellation</a></li>

                        <!-- Dropdown Structure -->
                        <ul id='dropdown2' class='dropdown-content'>
                            <li><a href="#modal2" class="hoverable modal-trigger purple  white-text">Current Remaining Leaves Cancellation</a></li>
                           
                            <li><a href="futureLeaveCancel.php" class="hoverable modal-trigger purple  white-text">Future Leaves Cancellation</a></li>
                            
                            
                            
                        </ul>
                   
                    
                    <li><a href="#about" class="hoverable modal-trigger purple">About</a></li> 
                    
                    <li><a href="#contact" class="hoverable  modal-trigger purple">Contact</a></li>
                    <li><a class="hoverable purple" href="editrecordUser.php">Edit Profile</a></li>
                    <li><a href="logout.php" class="hoverable purple">Sign Out</a></li>
                    
                </ul>
            </div>

        </nav>

        <ul class="sidenav" id="mobile-demo">
            <li><a class="hoverable btn modal-trigger purple " href="#modal1">Apply for Leave</a></li>
            <li><a class='dropdown-trigger hoverable ' href='#' data-target='dropdown1'>Leave Cancellation</a></li>

                        <!-- Dropdown Structure -->
                        <ul id='dropdown1' class='dropdown-content'>
                            <li><a href="#modal2" class="hoverable modal-trigger purple-text">Current Cancellation</a></li>
                            
                            <li><a href="futureLeaveCancel.php" class="hoverable modal-trigger purple-text">Future Leaves Cancellation</a></li>
                            
                            
                            
                        </ul>
                    <li><a href="#about" class="hoverable  modal-trigger ">About</a></li> 
                    
                    
                    <li><a href="#contact" class="hoverable  modal-trigger ">Contact</a></li>
                    <li><a class="hoverable " href="editrecordUser.php">Edit Profile</a></li>
                    <li><a href="logout.php" class="hoverable ">Sign Out</a></li>
           
           
        </ul>
        

<div id="modal1" class="modal">
  <div class="modal-content center">
    <h4 class="">Leave Application</h4>
    <a class="hoverable purple-text  right" href="halfday.php">click here to apply for Half-Day Leave </a>
    <form method="post" action="afterlogin.php">
        <br>
        <div class="input-field">
        <input type="date" name="from" id="StartDate" min="<?php echo date('Y-m-d');?>" required>
        <label for="StartDate">From Date</label>
        </div>
        <div class="input-field">
        <input type="date" name="to" id="EndDate"  min="<?php echo date('Y-m-d'); ?>" required>
        <label for="EndDate">To Date</label>
        </div>
        <br>

        <div class="center">
        <table id="employee_table" class="striped bordered centered">
    <tr id="row1">
       
    </tr>
    </table>
  <input type="button" onclick="add_row();" value="Add Holiday"><br>
        <input type="submit" name="submit" value="Submit">
        </div>
    </form>
  </div>
  <div class="modal-footer">
  
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
  </div>
</div>

<div id="modal2" class="modal">
  <div class="modal-content center">
    <h4 class="">Cancel Current Remaining Leaves</h4>
    <?php
    $i=0;
    $t=$_SESSION['id'];
    $pid='t'.$t;
    $sqlf = "SELECT * FROM $pid";
    $resultf = mysqli_query($conn,$sqlf);
    $fdata = mysqli_fetch_all($resultf, MYSQLI_ASSOC);
    
     
    for($i=0;$i<count($fdata);$i++)
    {

        if(strtotime($fdata[$i]['fromDate'])<=strtotime(date('Y-m-d')) && strtotime($fdata[$i]['toDate'])>strtotime(date('Y-m-d')))
        { 
            $fr=$fdata[$i]['fromDate'];
            $to=$fdata[$i]['toDate']; 
    
                break;
        } 
        else
        {
            continue;
        }
     } ?>
    <?php
        if($i==count($fdata))
        {?>
            <h6>You have not applied for any leave in this period from tomorrow</h6>
  
    <?php }  

      else
        {?>
            <h6>Your current leave period is  <?php echo "$fr to $to"; ?><br> Are you sure, Do you want to cancel remaining days from tomorrow?</h6>
            <button onclick="window.location.href='currentLeaveCancel.php'">Yes</button>
            <button onclick="window.location.href=''">No</button>

     <?php   } ?>
  </div>
  <div class="modal-footer">


    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
  </div>
</div>



<div class="container center ">
    <div class="container center ">
    <div class="container center ">
    <br>
    <!-- <a class="right" href="editrecord.php"><i class="material-icons">create</i></a> -->
    <h5 class="purple-text "> <?php echo "Welcome $pname!! " ;?></h5>
    
    <h6 class="">Your Leave Information</h6>
    <h6 >Leaves Left : <?php echo $leaves ?> </h6><br>
    <h6 class="red-text"><?php echo $leaveserror ?> </h6><br>
    <table class="striped bordered centered" style="width:100%" id="example">
    
    <thead class="purple lighten-2">
    <tr>
    <th>From Date</th>
    <th>To Date</th>
    <th>No of Days</th>
    </tr></thead>
    <tbody>
    <?php foreach($ldata as $ldatas){ ?>
    <tr>
        <td> <?php echo $ldatas['fromDate']; ?> </td>
        <td> <?php echo $ldatas['toDate']; ?> </td>
        <td> <?php echo $ldatas['noofDays']; ?> </td>
    </tr>
    <?php } ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
        
    
    

    
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>  
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
function add_row()
{
    var startDate = document.getElementById("StartDate").value;
    var endDate = document.getElementById("EndDate").value;
    //                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              console.log(endDate);

    $rowno=$("#employee_table tr").length;
    $rowno=$rowno+1;
    $("#employee_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='date' name='hdate[]' id='dt"+$rowno+"' placeholder='Holiday Date' required></td><td><input type='text' name='reason[]' placeholder='Reason' required></td><td><input type='button' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
    document.getElementById('dt'+$rowno).max=endDate;
    document.getElementById('dt'+$rowno).min=startDate;
}

function delete_row(rowno)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
{
 $('#'+rowno).remove();
}           
</script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
        
        
        <script>
    
            
   
            $(document).ready(function(){
                $('.modal').modal();   
                $('.sidenav').sidenav();
                $('.dropdown-trigger').dropdown();
            });
        </script>  
    <script>
      $("#EndDate").change(function () {
    var startDate = document.getElementById("StartDate").value;
    var endDate = document.getElementById("EndDate").value;

    if ((Date.parse(startDate) > Date.parse(endDate))) {
        alert("End date should be greater than Start date");
        document.getElementById("EndDate").value = "";
    }
});
   </script>    
   
    
            
   
   
</body>
</html>
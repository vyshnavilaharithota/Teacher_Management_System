<?php
include('php/connection.php');
session_start();
$t=$_SESSION['id'];
$pid='t'.$t;
$sql = "SELECT * FROM $pid";
$result = mysqli_query($conn,$sql);
$ldata = mysqli_fetch_all($result, MYSQLI_ASSOC);

if(empty($ldata))
{
    header("Location: afterlogin.php");
}
for($i=0;$i<count($ldata);$i++)
{

    if(strtotime($ldata[$i]['fromDate'])<=strtotime(date('Y-m-d')) && strtotime($ldata[$i]['toDate'])>strtotime(date('Y-m-d')))
    {
    
        $newto=date('Y-m-d');
        $date3=date_create($ldata[$i]['fromDate']);
        $date4=date_create($ldata[$i]['toDate']);
        $diff=date_diff($date3,$date4);
        $deldiff=(floatval($diff->format("%a")))+1;
        $newfrom=$ldata[$i]['fromDate'];
        $date1=date_create($newfrom);
        $date2=date_create($newto);
        $diff=date_diff($date1,$date2);
        $sqlli="SELECT * FROM hlist";
        $resultli = mysqli_query($conn,$sqlli);
        $hlist = mysqli_fetch_all($resultli, MYSQLI_ASSOC);
        print_r($hlist);
        $hols=0;
        $ahols=0;
        for($j=0;$j<count($hlist);$j++)
        {
            if(strtotime($hlist[$j]['date'])>strtotime(date('Y-m-d')) && strtotime($ldata[$i]['toDate'])>=strtotime(date('Y-m-d')))
            {
                $hols++;
            }
            if(strtotime($hlist[$j]['date'])>=strtotime($ldata[$i]['fromDate']) && strtotime($ldata[$i]['toDate'])>=strtotime($hlist[$j]['date']))
            {
                $ahols++;
            }
        }
        $adddiff=(floatval($diff->format("%a")))+floatval(1);
        //echo $hols;
        $noofdays=floatval($ldata[$i]['noofDays']);

        $sql = "UPDATE $pid SET toDate='$newto',noofDays='$adddiff' WHERE fromDate='$newfrom'";
                
        if (mysqli_query($conn, $sql)) 
        {
            echo "Record updated successfully";
        } 
        else 
        {
            echo "Error updating record: " . mysqli_error($conn);
        }
        $sql = "SELECT leavesLeft FROM teacherprofile WHERE id=$t ";
        $result = mysqli_query($conn,$sql);
        $tdata = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if($deldiff==$noofdays+floatval($ahols))
        {
            $leaves=floatval($tdata[0]['leavesLeft'])+$deldiff-$adddiff-floatval($hols);
            //echo $leaves;
            for($j=0;$j<count($hlist);$j++)
            {
            
                if(strtotime($hlist[$j]['date'])>=strtotime($ldata[$i]['fromDate']) && strtotime(date('Y-m-d'))>=strtotime($hlist[$j]['date']))
                {
                    $adddiff--;
                }
            }
            $sql = "UPDATE $pid SET noofDays='$adddiff' WHERE fromDate='$newfrom'";
                
            if (mysqli_query($conn, $sql)) 
            {
                echo "Record updated successfully";
            } 
            else 
            {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
       
        else if($deldiff==$noofdays)
        {
            // echo $adddiff;
            // echo $deldiff;
            // echo $noofdays;
            for($j=0;$j<count($hlist);$j++)
            {
            
                if(strtotime($hlist[$j]['date'])>=strtotime($ldata[$i]['fromDate']) && strtotime(date('Y-m-d'))>=strtotime($hlist[$j]['date']))
                {
                    $adddiff--;
                }
            }
            $sql = "UPDATE $pid SET noofDays='$adddiff' WHERE fromDate='$newfrom'";
                
            if (mysqli_query($conn, $sql)) 
            {
                echo "Record updated successfully";
            } 
            else 
            {
                echo "Error updating record: " . mysqli_error($conn);
            }
            $leaves=floatval($tdata[0]['leavesLeft'])+$deldiff-$adddiff;
        }

        else
        {
            // echo $deldiff;
            // echo $adddiff;
            // echo $hols;
            for($j=0;$j<count($hlist);$j++)
            {
            
                if(strtotime($hlist[$j]['date'])>=strtotime($ldata[$i]['fromDate']) && strtotime(date('Y-m-d'))>=strtotime($hlist[$j]['date']))
                {
                    $adddiff--;
                }
            }
            $sql = "UPDATE $pid SET noofDays='$adddiff' WHERE fromDate='$newfrom'";
                
            if (mysqli_query($conn, $sql)) 
            {
                echo "Record updated successfully";
            } 
            else 
            {
                echo "Error updating record: " . mysqli_error($conn);
            }
            $leaves=floatval($tdata[0]['leavesLeft'])+$deldiff-$adddiff-floatval($hols);
        }


        $sql = "UPDATE teacherprofile SET leavesLeft=$leaves WHERE id=$t";
        $result = mysqli_query($conn,$sql);
        if (mysqli_query($conn, $sql)) {
            echo "Record changed successfully";
            header("Location: afterlogin.php");
        } 
        else 
        {
            echo "Error changing record: " . mysqli_error($conn);
        }
    break;
    }
}
if($i==count($ldata))
{
        echo "nothing";
        header("Location: afterlogin.php");
}

?>
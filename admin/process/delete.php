<?php
    include '../config/database.php';

    if(isset($_GET['del'])){
        $id=$_GET['del'];
    }

    if(isset($_GET['data']))
    {
        switch($_GET['data'])
        {
            case 'list_network':
                mysqli_query($con,"delete from tm_network where id='".$id."'");
                header("location:../home.php?page=list_network");
            break;

            case 'list_visit':
                mysqli_query($con,"delete from tm_visit where id='".$id."'");
                header("location:../home.php?page=list_visit");
            break;

            case 'list_cs':
                mysqli_query($con,"delete from tbl_users where userId='".$id."'");
                header("location:../home.php?page=list_cs");
            break;
        }
    }
?>
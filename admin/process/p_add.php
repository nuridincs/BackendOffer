<?php 
	include '../config/database.php';

	if(isset($_GET['data']))
    {
        switch($_GET['data'])
        {
        	case 'addCs':
        		print_r($_POST);
        		$roleId = $_POST['roleid'];
        		$nama = $_POST['nama'];
        		$email = $_POST['email'];
        		$password = md5($_POST['password']);
        		mysqli_query($con,"insert into tbl_users(userId,email,password,name,roleId) values('','".$email."','".$password."','".$nama."', '".$roleId."')");
        		#header("location:../home.php?page=list_cs");
        	break;
        }
    }
?>
<?php 
	include '../config/database.php';

	session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $email = mysqli_real_escape_string($con,$_POST['email']);
      $password = mysqli_real_escape_string($con,$_POST['password']); 
      $encryt = md5($password);

      #print_r($email." -> ".$password);die();
      
      $sql = "SELECT userId FROM tbl_users WHERE email = '$email' and password = '$encryt'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      print_r($count);
      
      // If result matched $email and $password, table row must be 1 row
		
      if($count == 1) {
        session_register("email");
        $_SESSION['login_user'] = $email;
         
        header("location: ../home.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
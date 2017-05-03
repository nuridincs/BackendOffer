<?php
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($con,"select email from tbl_users where email = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $_SESSION['userSession'] = $row['email'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:../login.php");
   }
?>
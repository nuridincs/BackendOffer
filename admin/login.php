<?php 
  include 'config/database.php';

  session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $email = mysqli_real_escape_string($con,$_POST['email']);
      $password = mysqli_real_escape_string($con,$_POST['password']); 
      $encryt = md5($password);
      #print_r($email." -> ".$password);die();
      
      $sql = "SELECT a.userId,a.email,a.password,a.name,a.roleId,b.role
                FROM tbl_users a, tbl_roles b
                WHERE a.roleId = b.roleId
                AND a.email = '".$email."' AND a.password = '".$encryt."'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);
      
      // If result matched $email and $password, table row must be 1 row
    
      if($count == 1) {
        $_SESSION['userSession'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['roleName'] = $row['role'];
        $_SESSION['userId'] = $row['userId'];
        $_SESSION['role'] = $row['roleId'];
        $_SESSION['start'] = time();

        $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
        header("location: home.php?page=dashboard");
      }else {
        $checkErr = '0';
        $error = "Your Login Email or Password is invalid";
      }
   }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>System | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome Icons -->
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <!-- Theme style -->
         <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link href="<?php //echo base_url('assets/bootstrap/plugins/iCheck/square/blue.css') ?>" rel="stylesheet" type="text/css" />
        <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(dist/img/Preloader_2.gif) center no-repeat #fff;
        }
        .bg{
            background: url(dist/img/bg.jpg) no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .head{
            position: absolute;
            /* top: -15%; */
            left: 45%;
        }

        .login{
            padding: 50px;
            border-radius: 9px;
        }
        </style>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script> -->
        <script>
            //paste this code under head tag or in a seperate js file.
            // Wait for window load
            $(window).load(function() {
                // Animate loader off screen
                $(".se-pre-con").fadeOut("slow");;
            });
        </script>
    </head>
    <body class="login-page bg">
    <div class="se-pre-con"></div>
        <div class="login-box">
            <?php 
              if(isset($error) != "") {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error; ?>                    
            </div>
            <?php } ?>
            <div class="head img-responsive">
                    <img src="dist/img/avatar6.png" width="125" alt=""/>
            </div>
            <!----><div class="login-logo">
                <a href="#"><b>&nbsp;<!-- System --></b></a>
            </div><!-- /.login-logo -->
            <div class="login-box-body login">
                <h3 align="center" class="login-box-msg" style="padding: 1em">Login Aplikasi</h3>
                <form action="" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="email" placeholder="Email"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="Password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">    
                           <!-- <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox"> Remember Me
                                </label>
                            </div>  -->                      
                        </div><!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                        </div><!-- /.col -->
                    </div>
                </form>
                <!--
                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
                </div>--><!-- /.social-auth-links -->
                <!--
                <a href="#">I forgot my password</a><br>
                <a href="register.html" class="text-center">Register a new membership</a>
                -->
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
        
        <!-- jQuery 2.1.3 -->
       <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <!-- <script src="<?php echo base_url('assets/bootstrap/plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script> -->
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
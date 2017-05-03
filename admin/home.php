<?php
    #include('process/session.php');
    extract($_POST);
    $con=mysqli_connect('localhost','root','','db_sales2');
    session_start();
    #include_once 'dbconnect.php';

    if (!isset($_SESSION['userSession'])) {
     header("Location: index.php");
    }

    $now = time(); 

    /**/
    if ($now > $_SESSION['expire']) {
        session_destroy();
        header("Location: index.php");
        //echo "Your session has expired! <a href='login.php'>Login here</a>";
    }

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>System | <?php echo $_SESSION['roleName'] ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="assets/images/logo.png">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

        <!--jquery-->
         <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script> 
        <!--<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>-->

        <script type="text/javascript" src="plugins/datepicker/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="plugins/datepicker/bootstrap-datepicker3.css"/>
        <link rel="stylesheet" href="dist/css/summernote.css">
        <script src="dist/js/summernote.js"></script>
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
        </style>

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

    <body class="hold-transition skin-blue sidebar-mini">
    <div class="se-pre-con"></div>
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>LT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b><?php echo $_SESSION['roleName'] ?></b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                    </a>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include'menu.php'; ?>
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->

                    <!-- Main content -->
                    <section class="content">
                        <?php 
                            if(isset($_GET['page'])){
                                switch($_GET['page']){
                                    case 'dashboard': include'dashboard.php';$order=3; break; 
                                    case 'list_visit': include'list_visit.php';$order=0; break;
                                    case 'list_network': include'list_network.php';$order=3; break;
                                    case 'list_cs': include'list_cs.php';$order=3; break;
                                    case 'change_password': include'form_change_pass.php';$order=3; break;
                                    case 'report_cs': include'report_cs.php';$order=3; break;
                                    case 'report_network': include'report_network.php';$order=3; break;
                                }   
                            }
                        ?>
                    </section>
                </div>
                <!-- /.content-wrapper -->
                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 2.3.0
                    </div>
                    <strong>Copyright &copy; 2017<a href="#"> &nbsp; Creathinker</a>.</strong> &nbsp;  All rights reserved.
                </footer>
                <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <!-- Bootstrap 3.3.5 -->
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <!-- <script src="../bootstrap/js/jqeuery-min.js"></script> -->
        <script>
            $(document).ready(function () {
                $('.konten').summernote({
                    height: 300, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true, // set focus to editable area after initializing summernote
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'hr']],
                        ['view', ['fullscreen', 'codeview']]
                    ],
                    
					onPaste: function (e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        setTimeout(function () {
                            document.execCommand('insertText', false, bufferText);
                        }, 10);
					 }
					
					
					
                });
				
				
            });
        </script>
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script>
            $(function () {
               /**/ $("#example1").DataTable({
                    "order": [[<?php echo $order; ?>, "desc"]],
                    stateSave: true
                });
            });
        </script>
        <script>

            /*$.widget.bridge('uibutton', $.ui.button);*/
            /*var table = $('.example12').DataTable();

            $('.example12').on('page.dt', function(){
                var info = table.page.info();
                console.log( 'Showing page: '+info.page+' of '+info.pages );
            });*/
        </script>
        <!-- Sparkline -->
         <!-- <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
                 jvectormap
                 <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
                 <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
                 jQuery Knob Chart
                 <script src="plugins/knob/jquery.knob.js"></script>
                 daterangepicker
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
                 <script src="plugins/daterangepicker/daterangepicker.js"></script>
                 datepicker
                 <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
                 Slimscroll
                 <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
                 FastClick
                 <script src="plugins/fastclick/fastclick.min.js"></script> -->
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!-- <script src="dist/js/pages/dashboard.js"></script> -->
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
        <script>
            /*$('#tgl_agenda').datepicker({
                format: 'dd-mm-yyyy'
            })*/
        </script>
    </body>
    </html>
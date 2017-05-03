<?php 
	session_start();
	include '../config/database.php';
	#print_r($data);

	if(isset($_GET['data']))
    {
        switch($_GET['data'])
        {
        	case 'get_cs':
        		$id = $_POST['id'];
				$data=mysqli_fetch_assoc(mysqli_query($con,"select * from tbl_users where userId='".$id."'"));
				$dataArr = array(
					'userId' => $data['userId'],
					'email' => $data['email'],
					'name' => $data['name'],
					'password' => $data['password']
				);
				echo json_encode($dataArr);
        	break;

        	case 'update_cs':
        		mysqli_query($con,"update tbl_users set email='".$_POST['email']."',name='".$_POST['name']."',password='".md5($_POST['password'])."' where userId= '".$_POST['userId']."' ");
        	break;

        	/*case 'changePass':
        		$oldpassword = md5($_POST['pass']);
				$newpassword = md5($_POST['pass1']);
				$repeatnewpassword = md5($_POST['pass2']);

        		$data=mysqli_fetch_assoc(mysqli_query($con,"select * from tbl_users where userId='".$_SESSION['userId']."'"));

        		if ($data['password'] == $oldpassword) {
        			if ($newpassword == $repeatnewpassword) {
        				mysqli_query($con,"update tbl_users set password='".$newpassword."' where userId= '".$_SESSION['userId']."' ");
        				echo "<div class=\"alert alert-success\">
							  <strong>Success!</strong> Indicates a successful or positive action.
							</div>";
        			}else{
        				echo "<div class=\"alert alert-danger\">
							  <strong>Danger!</strong> Password tidak sesuai.
							</div>";
        			}
        		}else{
        			echo "<div class=\"alert alert-danger\">
							  <strong>Danger!</strong> Password lama salah.
							</div>";
        		}
        	break;*/
        }
    }
?>
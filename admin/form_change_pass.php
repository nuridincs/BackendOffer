<?php 
  //echo $_SESSION['role'];
	if (isset($_POST['changePass'])) {
		$oldpassword = md5($_POST['pass']);
		$newpassword = md5($_POST['pass1']);
		$repeatnewpassword = md5($_POST['pass2']);
		$cekErr = 0;

		$data=mysqli_fetch_assoc(mysqli_query($con,"select * from tbl_users where userId='".$_SESSION['userId']."'"));

		if ($data['password'] == $oldpassword) {
			if ($newpassword == $repeatnewpassword) {
				mysqli_query($con,"update tbl_users set password='".$newpassword."' where userId= '".$_SESSION['userId']."' ");
				$error = "Password Berhasil di ubah";
			}else{
				$cekErr = 1;
				$error = "Password tidak sesuai";
			}
		}else{
			$cekErr = 1;
			$error = "Password lama tidak sesuai";
		}
	}
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Ubah Password</h3>
            </div>
            <?php 
            	if (isset($error) != "") { ?>
	            <div class="alert alert-danger alert-dismissable">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <?php echo $error; ?>                    
	            </div>
            <?php
        		}
            ?>
            <div class="box-body">
				<form role="form" action="" method="post">
                  <div class="form-group">
                  	<label for="network_id">Password Lama</label> 
                      <input type="password" class="form-control" name="pass"
                          id="pass" value="" placeholder=""/>
                  </div>
                  <div class="form-group">
                    <label for="network_name">Password Baru</label>
                      <input type="password" class="form-control" name="pass1"
                      id="pass1" placeholder=""/>
                  </div>
                  <div class="form-group">
                    <label for="postbackurl">Konfirmasi Password Baru</label>
                      <input type="password" class="form-control" name="pass2"
                          id="pass2" value="" placeholder=""/>
                  </div>
                  <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="changePass"
                          id="changePass" value="Ubah" placeholder=""/>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
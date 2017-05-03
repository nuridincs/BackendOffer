<?php 
	include 'admin/config/database.php';
	if (isset($_POST['order'])) {
		$getId=mysqli_fetch_row(mysqli_query($con,"select max(id) from tm_visit"));
		$getSeq=mysqli_fetch_row(mysqli_query($con,"SELECT LPAD(SEQUENCE+1,'5','0') SEQ, (SEQUENCE+1) SEQUE FROM tbl_generate_squence WHERE TYPE = 'ORDER'"));
		$seq = date('Ymd').$getSeq[0];
		$upSeq = $getSeq[1];
		//print_r($seq."->".$upSeq);die();
		$id = $getId[0];
		mysqli_query($con,"update tm_visit set nama='".$_POST['nama']."',no_telpon='".$_POST['no_telepon']."', order_id='".$seq."' where id='".$id."'");
		mysqli_query($con,"update tbl_generate_squence set SEQUENCE='".$upSeq."' where TYPE='ORDER'");
	    /*if ($getId == null) {
	    	$id = '1';
	    }else{
	    	$id = $getId[0]+1;
	    }*/
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Details Order</title>
<meta charset="utf-8"/> 
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link href="admin/assets/css/custom.css" rel="stylesheet"/>
<link rel="shortcut icon" type="image/x-icon" href="admin/assets/images/logo.png">
</head>
<body>
<div class="mod wrap_block_success">
<div class="block_success">
<h2>SELAMAT! PESANAN ANDA TELAH DITERIMA!</h2>
<p class="success">
                Selanjutnya, operator pusat layanan informasi kami akan segera menghubungi Anda untuk mengkonfirmasi pesanan Anda. Pastikan ponsel Anda dalam kondisi aktif.
            </p>
<h3>Silakan periksa informasi yang telah Anda masukkan</h3>
<div class="wrap_list_info">
<ul class="list_info">
<li><span>Nama: </span> 
<text class="js-name"><?php echo $_POST['nama']; ?></text>
</li>
<li><span>Telepon: </span>
<text class="js-phone"><?php echo $_POST['no_telepon'] ?></text>
</li>
</ul>
</div>
<p class="fail"><a href="#" onclick="history.go(-1); return false;">Apabila Anda membuat kesalahan dalam pengisian formulir, silakan kembali dan mengisi ulang</a></p>
<form action="" class="email" id="details" method="post"><input name="order_id" type="hidden" value="1419094"/>
<input name="order_id" type="hidden" value="1419094"/>
<input name="order_id" type="hidden" value="1419094"/>
<input name="order_id" type="hidden" value="1419094"/>
<input name="order_id" type="hidden" value="1419094"/>
<h3>Silakan periksa informasi yang telah Anda masukkan</h3>
<div class="mail_block">
<input id="email" name="email" placeholder="email" type="text" required="required" />
</div>
<div class="mail_block" style="display: none">
                    
                    <input id="adress" name="address" placeholder="address" type="text"/>
                </div>
<div class="">
<input type="submit" name="upMail" class="button" value="Kirim">
</div>
</form>
</div>
</div>
</body>
</html>
<?php if (isset($_POST['upMail'])): ?>
<?php
	$getId=mysqli_fetch_row(mysqli_query($con,"select max(id) from tm_visit"));
	$id = $getId[0];
	mysqli_query($con,"update tm_visit set email='".$_POST['email']."' where id='".$id."'");
	require 'plugins/class.phpmailer.php';
	$textHtml = '
				<!DOCTYPE html>
					<html>
					<head>
						<title>Details Order</title>
						<meta charset="utf-8"/> 
						<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
						<link href="admin/assets/css/custom.css" rel="stylesheet"/>
						<link rel="shortcut icon" type="image/x-icon" href="admin/assets/images/logo.png">
					</head>
					<body>
						<div class="mod wrap_block_success">
							<div class="block_success">
								<h2>SELAMAT! PESANAN ANDA TELAH DITERIMA!</h2>
								<p class="success">
					                Selanjutnya, operator pusat layanan informasi kami akan segera menghubungi Anda untuk mengkonfirmasi pesanan Anda. Pastikan ponsel Anda dalam kondisi aktif.
					            </p>
							</div>
						</div>
					</body>
					</html>
	';
	$mail = new PHPMailer;

	//Enable SMTP debugging. 
	$mail->SMTPDebug = 4;                               
	//Set PHPMailer to use SMTP.
	$mail->isSMTP();            
	//Set SMTP host name                          
	$mail->Host = "smtp.gmail.com";
	//Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;                          
	//Provide username and password     
	$mail->Username = "nuridin50@gmail.com";                 
	$mail->Password = "unaspasim";                           
	//If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "tls";                           
	//Set TCP port to connect to 
	$mail->Port = 587;                                   

	$mail->From = "nuridin.mu23@gmail.com";
	$mail->FromName = "Muhammad Nuridin";

	$mail->addAddress("nuridin50@gmail.com", "Recepient Nuridincs");

	$mail->isHTML(true);

	$mail->Subject = "Subject Text";
	$mail->Body = html_entity_decode($textHtml);//"<i>Mail body in HTML</i>";
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
		echo "<script>
				window.location.href = 'order_sukses.php';
			</script>";
	    //echo "Message has been sent successfully";
	}
	header('location:index.php');
?>
<?php endif ?>
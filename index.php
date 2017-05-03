<?php 
	include 'admin/config/database.php';
	$uri = $_SERVER['REQUEST_URI']; 
	/*$exploded_uri = explode('/', $uri); 
	$domain_name = $exploded_uri[1];
	$arrexp = explode('?', $domain_name);
	$xx = explode('=',$arrexp[1]);
	$xxx = explode('&',$xx[1]);*/
	$clickID = '';//$xxx[0];
	$networkID = '';//$xx[2];
  if ($networkID == '') {
    $cknetworkid = '0';
  }else {
    $cknetworkid = $networkID;
  }

	#print_r($uri);die();

	$getId=mysqli_fetch_row(mysqli_query($con,"select max(id) from tm_visit"));
  if ($getId == null) {
  	$id = '1';
  }else{
  	$id = $getId[0]+1;
  }

  $curentDate = mysqli_fetch_row(mysqli_query($con,"select max(DATE_FORMAT(wk_rekam, '%Y-%m-%d')) as 'cekdate' from tm_visit"));
  mysqli_query($con,"insert into tm_visit(id,clickid,networkid,wk_rekam) values('".$id."','".$clickID."','".$cknetworkid."', '".date('Y-m-d H:i:s')."')");

  $datenow = date("Y-m-d");
  if ($curentDate[0] != $datenow) {
    mysqli_query($con,"UPDATE tbl_generate_squence SET SEQUENCE = '0'
    WHERE TYPE = 'ORDER'");
    #echo "Sini Update";
  }else{
    #echo "Tidak update";
  }
  //echo $curentDate[0]."->".$datenow;	
  #die();
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Home Page</title>
  <link rel="shortcut icon" type="image/x-icon" href="admin/assets/images/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">  
  <link rel="stylesheet" href="admin/assets/css/style.css">
</head>

<body>
  
<div class="container">
  <div class="row header">
    <h1>CONTACT US &nbsp;</h1>
    <h3>Fill out the form below to learn more!</h3>
  </div>
  <div class="row body">
    <form action="detail_order.php" method="post">
      <ul>
        
        <li>
          <p class="left">
            <label for="nama">Nama</label>
            <input type="text" name="nama" placeholder="Masukan Nama" required="required" />
          </p>
          <p class="pull-right">
            <label for="no_telepon">No. Telepon</label>
            <input type="text" name="no_telepon" placeholder="Masukan No. Telepon" required="required" />      
          </p>
        </li>
        
        <!-- <li>
               <p>
                 <label for="email">email <span class="req">*</span></label>
                 <input type="email" name="email" placeholder="john.smith@gmail.com" />
               </p>
             </li>    -->     
        <li><div class="divider"></div></li>
        <!-- <li>
          <label for="alamat">Alamat</label>
          <textarea cols="46" rows="3" name="alamat" placeholder="Masukan Alamat"></textarea>
        </li> -->
        
        <li>
          <input class="btn btn-submit" type="submit" name="order" value="Order Now" />
          <!-- <small>atau klik <strong>enter</strong></small> -->
        </li>
        
      </ul>
    </form>  
  </div>
</div>
</body>
</html>


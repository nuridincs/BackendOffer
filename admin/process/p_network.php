<?php 
	#print_r($_POST);die();
	$con=mysqli_connect('localhost','root','','db_sales2');
	$network_id = $_POST['network_id'];
    $network_name = $_POST['network_name'];
    $postbackurl = $_POST['postbackurl'];

    $getId=mysqli_fetch_row(mysqli_query($con,"select max(id) from tm_network"));
    if ($getId == null) {
    	$id = '1';
    }else{
    	$id = $getId[0]+1;
    }

    mysqli_query($con,"insert into tm_network values('".$id."','".$network_id."','".$network_name."','".$postbackurl."')");

    echo "
    <script>
    location.assign('home.php?page=list_network&ps=true1');
    </script>
    ";

	/*pesan berhasil update*/
	if(isset($_GET['ps'])=='true2')
	    echo "<div class='alert alert-success' role='alert'>Data Berhasil Terupdate</div>";
	elseif(isset($_GET['ps'])=='true1')
	    echo "<div class='alert alert-success' role='alert'>Data Berhasil Terimpan</div>";

?>
<?php 
	#print_r($_POST);
	include '../config/database.php';
	#print_r($data);

	if(isset($_GET['data']))
    {
        switch($_GET['data'])
        {
            case 'get_network':
				$id = $_POST['id'];
				$data=mysqli_fetch_assoc(mysqli_query($con,"select * from tm_network where id='".$id."'"));
				$dataArr = array(
					'id' => $data['id'],
					'networkid' => $data['networkid'],
					'network_name' => $data['network_name'],
					'postback_url' => $data['postback_url']
				);
				echo json_encode($dataArr);
	                /*mysqli_query($con,"delete from tm_network where id='".$id."'");
	                header("location:../home.php?page=list_network");*/
            break;

            case 'update_network':
        		mysqli_query($con,"update tm_network set network_name='".$_POST['network_name']."',postback_url='".$_POST['postbackurl']."' where networkid= '".$_POST['network_id']."' ");
        		
        		header("location:../home.php?page=list_network");
        	break;
        }
    }
?>
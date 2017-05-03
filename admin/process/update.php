<?php
    session_start();
    include '../config/database.php';

    if(isset($_GET['del'])){
        $id=$_GET['del'];
    }

    if(isset($_GET['data']))
    {
        switch($_GET['data'])
        {
            case 'list_visit':
                $ax = explode('Rp', $_POST['total_bayar']);
                /*for ($i=0; $i < $ax ; $i++) { 
                    //print_r($ax);
                }*/
                $axx = explode(".", $ax[1]);
                //print_r(count($axx));
                $tmp = '';

                for ($i=0; $i < count($axx) ; $i++) { 
                    $tmp .= $axx[$i];
                }
                $total_bayar = $tmp;
                //print_r($tmp);
                //print_r($tmp);die();
                $networkid = $_GET['networkid'];
                mysqli_query($con,"update tm_visit set jml_botol = '".$_POST['jmlh_btl']."', total_pembayaran = '".$total_bayar."', order_status='SALE' where id='".$id."'");
                $param=mysqli_fetch_row(mysqli_query($con,"select clickid from tm_visit where networkid='".$networkid."' and id = '".$id."'"));

                $postbackUrl = mysqli_fetch_row(mysqli_query($con,"select postback_url,network_name,networkid from tm_network where networkid='".$networkid."'"));
                //echo $postbackUrl[0].$param[0];
                /*if ($postbackUrl[2] == '1') {
                    //$url = "http://8oh4x.trackvoluum.com/postback?cid=".$param[0];
                    $url = substr($postbackUrl[0], 0, 42);
                    echo $url.$param[0];
                    #file_get_contents($url);
                }else if($postbackUrl[2] == '8'){
                    $url2 = substr($postbackUrl[0], 0, 42);
                    echo $url2.$param[0];
                    #file_get_contents($url2[0].$param[0]);
                }*/
                //die();
               /* echo $postbackUrl[1];
                echo $url2.$param[0];die();*/
                //echo strlen($postbackUrl[0]);

                #print_r($postbackUrl[0]);die();
                
                #$url = "http://8oh4x.trackvoluum.com/postback?cid=".$param[0];
                #file_get_contents($url);
                #file_get_contents($postbackUrl[0]);
                header("location:../home.php?page=list_visit");
            break;

            case 'list_visit_cancel':
                $networkid = $_GET['networkid'];
                mysqli_query($con,"update tm_visit set order_status='CANCEL' where id='".$id."'");
                #$param=mysqli_fetch_row(mysqli_query($con,"select clickid from tm_visit where networkid='".$networkid."' and id = '".$id."'"));
                
                #$url = "http://8oh4x.trackvoluum.com/postback?cid=".$param[0];
                #file_get_contents($url);
                header("location:../home.php?page=list_visit");
            break;

            case 'cs_follUp':
                #mysqli_query($con,"insert into tx_followup values('','".$_SESSION['userId']."','".$id."','1')");
                mysqli_query($con,"update tm_visit set followup_id='".$_SESSION['userId']."' where id='".$id."'");
                header("location:../home.php?page=list_visit");
            break;

            case 'cs_cancelfollUp':
                mysqli_query($con,"update tm_visit set followup_id= NULL where id='".$id."'");
                header("location:../home.php?page=list_visit");
            break;

            case 'update_addrress':
                mysqli_query($con,"update tm_visit set alamat= '".$_POST['address']."' where id='".$_POST['idAddress']."'");
                header("location:../home.php?page=list_visit");
            break;
        }
    }
?>
<script>
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });

    /*function datepick(){
        var start = $('#start').val();
        var end = $('#end').val();
        //alert(start+"->"+end);
        /*$('input[name="start"]').val(start);
        $('input[name="end"]').val(end);*/
    }*/
</script>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Visit</h3>
            </div>
            <div class="panel-body">
                <table>
                    <form action="" method="post">  
                        <tr>
                            <td>
                                <label class="col-sm-3 control-label" style="width: 115px;">Date Range</label>
                            </td>
                            <td>
                                <div class="input-daterange input-group datepicker2" id="datepicker2" name="datepicker2" style="width: 300px;">
                                    <input type="text" class="input-sm form-control" id="start" name="start" />
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" id="end" name="end" />
                                </div>
                            </td>
                            <td>
                                <span class="col-sm-3">
                                    <input type="submit" class="btn btn-primary btn-xs" name="act" value="Search" />
                                </span>
                            </td>
                        </tr>
                    </form>
                </table>
                <!-- <form action="" method="post">
                    <div class="form-group">d
                        <label class="col-sm-3 control-label" style="width: 115px;">Date Range</label>
                        <div class="input-daterange input-group datepicker2" id="datepicker2" name="datepicker2" style="width: 300px;">
                            <input type="text" class="input-sm form-control" name="start" />
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="end" />
                        </div>
                            <input type="submit" class="btn btn-primary" name="act" value="Search" /> 
                            <a href="" class="btn btn-primary">search<span class='glyphicon glyphicon-search'></span></a>
                   </div>
                </form> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>No. Telpon</th>
                            <th>Alamat</th>
                            <th>Jumlah Botol</th>
                            <th>Total Pembayaran</th>
                            <?php 
                                if ($_SESSION['role'] == '1') {
                                    echo "<th>Network ID</th>";
                                }
                            ?>
                            <th>Status Order</th>
                            <th>Action</th>
                            <th>Status Follow Up</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                            if (isset($_POST['act'])) {
                                //print_r($_POST);
                                $from_date = $_POST['start'];
                                $to_date = $_POST['end'];

                                echo "<script>
                                        $('input[name=\"start\"]').val('$from_date');
                                        $('input[name=\"end\"]').val('$to_date');
                                    </script>";

                                $between = "AND DATE(a.wk_rekam) BETWEEN DATE('".$from_date."') AND DATE('".$to_date."')";
                            } else {
                                $between = '';
                            }
                            /*$qu=mysqli_query($con,"select a.id,a.nama, a.no_telpon,a.alamat,a.networkid, a.order_status, 
                                                (select count(networkid) from tm_visit where networkid = a.networkid) as 'total'
                                                from tm_visit a
                                                group by networkid");*/
                            $qu = mysqli_query($con, "SELECT a.*,
                                                        CASE WHEN a.networkid = '0' THEN NULL ELSE a.networkid END AS 'cknetworkid',b.name
                                                        FROM tm_visit a
                                                        LEFT JOIN tbl_users b ON a.followup_id = b.userId
                                                        WHERE a.nama != '' AND a.no_telpon !=''
                                                        $between
                                                        ORDER BY a.wk_rekam DESC");
                            $total_btl = 0;
                            $total_jmlh_bay = 0;
                            while($has=mysqli_fetch_assoc($qu))
                            {
                                $total_btl += $has["jml_botol"];
                                $total_jmlh_bay += $has["total_pembayaran"];
                                $total_bay = 'Rp. '.number_format($has['total_pembayaran'], 2, '.', ',');

                                echo "
                                <tr>
                                    <td>$has[wk_rekam]</td>
                                    <td>$has[nama]</td>
                                    <td>$has[no_telpon]</td>
                                    <td>$has[alamat]</td>
                                    <td>$has[jml_botol]</td>
                                    <td>$total_bay</td>";
                                    if ($_SESSION['role'] == '1') {
                                        echo "<td>$has[cknetworkid]</td>";
                                    }

                                    if ($has['order_status'] == 'SALE') {
                                        echo "<td class='text-success'>$has[order_status]</td>";
                                    }else  if ($has['order_status'] == 'CANCEL') {
                                        echo "<td class='text-danger'>$has[order_status]</td>";
                                    }else{
                                        echo "<td class='text-default'>$has[order_status]</td>";
                                    }
                                    echo "<td style='text-align:center'>";
                                    if ($_SESSION['role'] == '1') {
                                        $del = "<a href='#' onclick='datadel($has[id],&#39;list_visit&#39;)' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#modalDel'><span data-placement='top' data-toggle='tooltip' title='Delete'><span class='glyphicon glyphicon-trash'></span><span></a>";
                                        $sale = "<a href='#' onclick='dataAcc($has[id],$has[networkid],&#39;list_visit&#39;)' class='btn btn-primary btn-xs' data-title='Sale' data-toggle='modal' data-target='#modalAcc'><span data-placement='top' data-toggle='tooltip' title='Sale'><span class='glyphicon glyphicon-shopping-cart'></span><span></a>";

                                        $cancel = "<a href='#' onclick='dataCancel($has[id],$has[networkid],&#39;list_visit_cancel&#39;)' class='btn btn-warning btn-xs' data-title='Cancel' data-toggle='modal' data-target='#modalCancel'><span data-placement='top' data-toggle='tooltip' title='Cancel'><span class='glyphicon glyphicon-remove'></span><span></a>";
                                        $address = "<a href='#' onclick='updateAddress($has[id],&#39;update_addrress&#39;)' class='btn btn-success btn-xs' data-title='Address' data-toggle='modal' data-target='#modalAddress'><span data-placement='top' data-toggle='tooltip' title='Address'><span class='glyphicon glyphicon-map-marker'></span><span></a>";
                                        $FollowUp = "</td>";
                                    } else {
                                        $del = '</td>';
                                        $sale = "<a href='#' onclick='dataAcc($has[id],$has[networkid],&#39;list_visit&#39;)' class='btn btn-primary btn-xs' data-title='Sale' data-toggle='modal' data-target='#modalAcc'><span data-placement='top' data-toggle='tooltip' title='Sale'><span class='glyphicon glyphicon-shopping-cart'></span><span></a>";

                                        $cancel = "<a href='#' onclick='dataCancel($has[id],$has[networkid],&#39;list_visit_cancel&#39;)' class='btn btn-warning btn-xs' data-title='Cancel' data-toggle='modal' data-target='#modalCancel'><span data-placement='top' data-toggle='tooltip' title='Cancel'><span class='glyphicon glyphicon-remove'></span><span></td>";

                                        $FollowUp = "<a href='#' onclick='FollowUp($has[id],&#39;cs_follUp&#39;)' class='btn btn-info btn-xs' data-title='Follow Up' data-toggle='modal' data-target='#modalFollow'><span data-placement='top' data-toggle='tooltip' title='Follow Up'><span class='glyphicon glyphicon-transfer'></span><span></a>";

                                        $address = "<a href='#'  onclick='updateAddress($has[id],&#39;update_addrress&#39;)' class='btn btn-success btn-xs' data-title='Address' data-toggle='modal' data-target='#modalAddress'><span data-placement='top' data-toggle='tooltip' title='Address'><span class='glyphicon glyphicon-map-marker'></span><span></a>";
                                    }

                                    if($_SESSION['role'] == '2'){
                                        if ($has['order_status'] == 'SALE') {
                                            echo "SALE by &nbsp;<b>$has[name]</b>".$del;
                                        } else if($has['order_status'] == 'CANCEL'){
                                            echo "CANCEL by &nbsp;<b>$has[name]</b>".$del;
                                        } else {
                                            if ($has['name'] != NULL) {
                                                if ($_SESSION['userId'] == $has['followup_id']) {
                                                    $cekFol = $sale."&nbsp&nbsp&nbsp".$address."&nbsp&nbsp&nbsp".$cancel."&nbsp&nbsp&nbsp";
                                                } else {
                                                    $cekFol = "<div style='pointer-events: none;'>".$sale."&nbsp&nbsp&nbsp".$address."&nbsp&nbsp&nbsp".$cancel."&nbsp&nbsp&nbsp</div>";
                                                }

                                                echo $cekFol;
                                                
                                            }else{
                                                if($_SESSION['role'] == '1'){
                                                    if ($has['order_status'] == 'SALE') {
                                                    echo $del;
                                                    } else if($has['order_status'] == 'CANCEL'){
                                                        echo $del;
                                                    } else {
                                                        echo $sale."&nbsp&nbsp&nbsp".$cancel."&nbsp&nbsp&nbsp".$del;
                                                    }
                                                }
                                                echo $FollowUp."</td>";
                                            }
                                            //echo $sale."&nbsp&nbsp&nbsp".$address."&nbsp&nbsp&nbsp".$cancel."&nbsp&nbsp&nbsp";
                                        }
                                    }else if($_SESSION['role'] == '1'){
                                        if ($has['order_status'] == 'SALE') {
                                            echo $del;
                                        } else if($has['order_status'] == 'CANCEL'){
                                            echo $del;
                                        } else {
                                            if ($has['name'] != NULL) {
                                                echo $sale."&nbsp&nbsp&nbsp".$cancel."&nbsp&nbsp&nbsp".$del;
                                            }else{
                                                if($_SESSION['role'] == '1'){
                                                    if ($has['order_status'] == 'SALE') {
                                                    echo $del;
                                                    } else if($has['order_status'] == 'CANCEL'){
                                                        echo $del;
                                                    } else {
                                                        echo $sale."&nbsp&nbsp&nbsp".$cancel."&nbsp&nbsp&nbsp".$del;
                                                    }
                                                }
                                                echo $FollowUp."</td>";
                                            }
                                            #echo $sale."&nbsp&nbsp&nbsp".$cancel."&nbsp&nbsp&nbsp".$del;
                                        }
                                    }

                                    if ($has['name'] != NULL) {
                                        if($_SESSION['role'] == '1'){
                                            echo "<td align='center'><span data-placement='top' data-toggle='tooltip' title='Cancel'><button onclick='CancelFollowUp($has[id],&#39;cs_cancelfollUp&#39;)' class='btn btn-danger btn-xs' data-title='Cancel' data-toggle='modal' data-target='#modalFollow' ><span class='glyphicon glyphicon-remove'></span></button><span><br>Follow Up By &nbsp;<b>$has[name]</b></td>
                                                    </tr>";
                                        }else{
                                            if ($has['order_status'] == 'SALE') {
                                                echo "<td align='center'>Follow Up By &nbsp;<b>$has[name]</b></td>
                                                    </tr>";
                                            }else if ($has['order_status'] == 'CANCEL') {
                                               echo "<td align='center'>Follow Up By &nbsp;<b>$has[name]</b></td>
                                                    </tr>";
                                            }else{
                                                if ($_SESSION['userId'] == $has['followup_id']) {
                                                    $cancelFoll = "<td align='center'>
                                                                <span data-placement='top' data-toggle='tooltip' title='Cancel'><button onclick='CancelFollowUp($has[id],&#39;cs_cancelfollUp&#39;)' class='btn btn-danger btn-xs' data-title='Cancel' data-toggle='modal' data-target='#modalFollow' ><span class='glyphicon glyphicon-remove'></span></button><span><br>Follow Up By &nbsp;<b>$has[name]</b>
                                                            </td>
                                                                </tr>";
                                                }else {
                                                    $cancelFoll = "<td style='pointer-events: none;' align='center'>
                                                                <span data-placement='top' data-toggle='tooltip' title='Cancel'><button onclick='CancelFollowUp($has[id],&#39;cs_cancelfollUp&#39;)' class='btn btn-danger btn-xs' data-title='Cancel' data-toggle='modal' data-target='#modalFollow' ><span class='glyphicon glyphicon-remove'></span></button><span><br>Follow Up By &nbsp;<b>$has[name]</b>
                                                            </td>
                                                                </tr>";
                                                }

                                                echo $cancelFoll;
                                            }
                                        }
                                    }else {
                                        echo "<td align='center'></td>
                                                    </tr>";
                                    }
                            }
                       ?>
                       <tr id="addTr">
                           <td></td>
                           <td></td>
                           <td></td>
                           <td><b class="label label-danger">Total</b></td>
                           <td><b><?php echo $total_btl; ?></b></td>
                           <td><b><?php echo 'Rp. '.number_format($total_jmlh_bay, 2, '.', ','); ?></b></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                       </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
<script>
    /* $(function () {
       $("#addTr").DataTable({
            "order": [['1', "asc"]],
            //stateSave: true
        });
    });*/
</script>
<script>
    function dataAcc(value,networkid,jenis){
        //alert(value);return false;
        $('input[name="order_id"]').val(value);
        $('input[name="network_id"]').val(networkid);
       ///document.getElementById('mylink').href="process/update.php?del="+value+"&data="+jenis+"&networkid="+networkid;
    }

    function datadel(value,jenis){
       document.getElementById('deletevisit').href="process/delete.php?del="+value+"&data="+jenis;
    }

    function dataCancel(value,networkid,jenis){
       document.getElementById('cancelvisit').href="process/update.php?del="+value+"&data="+jenis+"&networkid="+networkid;
    }

    function FollowUp(value,jenis){
        window.location.assign("process/update.php?del="+value+"&data="+jenis);
        //windows.location.href="process/update.php?del="+value+"&data="+jenis;
    }

    function CancelFollowUp(value,jenis){
        window.location.assign("process/update.php?del="+value+"&data="+jenis);
        //windows.location.href="process/update.php?del="+value+"&data="+jenis;
    }

    function updateAddress(value,jenis){
        //alert(value);
        $('input[name="idAddress"]').val(value);

        document.getElementById('Upaddress').href="process/update.php?del="+value+"&data="+jenis;
    }

    function upAddress(){
        var idAddress = $('#idAddress').val();
        var address = $('#address').val();
        $.ajax({
            type: 'post',
            url: 'process/update.php?del='+idAddress+'&data=update_addrress',
            data: { idAddress:idAddress, address:address },
            success:function(data){
                console.log(data);
                //window.location.href = 'home.php?page=list_network';
            }
        });
        /*window.location.reload(true);*/
        $('.modalDetail').modal('hide');
    }

    function updateSale(){
        var order_id = $('#order_id').val();
        var network_id = $('#network_id').val();
        var jmlh_btl = $('#jmlh_btl').val();
        var total_bayar = $('#total_bayar').val();

        //alert(order_id+jmlh_btl+total_bayar);
        /**/
        $.ajax({
            type: 'post',
            url: 'process/update.php?del='+order_id+'&data=list_visit&networkid='+network_id,
            data: { order_id:order_id, network_id:network_id, jmlh_btl:jmlh_btl, total_bayar:total_bayar },
            success:function(data){
                console.log(data);
                window.location.href = 'home.php?page=list_visit';
            }
        });
    }
</script>

<div class="modal fade" id="modalAcc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Data akan terupdate !</h4>
            </div>
            <div class="modal-body">
                <!-- Apakah Anda yakin memilih sale ? -->
                <form role="form">
                  <div class="form-group">
                   <!--  <label for="network_id">Network ID</label> -->
                      <input type="hidden" class="form-control" name="order_id"
                          id="order_id" value="<?php //echo ; ?>" readonly placeholder=""/>
                  </div>
                  <div class="form-group">
                   <!--  <label for="network_id">Network ID</label> -->
                      <input type="hidden" class="form-control" name="network_id"
                          id="network_id" value="<?php //echo ; ?>" readonly placeholder=""/>
                  </div>
                  <div class="form-group">
                    <label for="network_name">Jumlah Botol</label>
                      <input type="text" class="form-control"
                      id="jmlh_btl" placeholder="Masukan Jumlah Botol"/>
                  </div>
                  <div class="form-group">
                    <label for="postbackurl">Total Pembayaran</label>
                      <input type="text" class="form-control"
                          id="total_bayar" value="" placeholder="Masukan Total Pembayaran"/>
                  </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="updateSale()" class="btn btn-primary">Update Data</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    
    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('total_bayar');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        //$("#tot_bay").val(this.value);
        dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });
    
    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>

<div class="modal fade" id="modalDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Data akan terhapus !</h4>
            </div>
            <div class="modal-body">
                Anda yakin ingin menghapus data ini ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a id="deletevisit" href=""><button type="button" class="btn btn-primary">Delete Data</button></a>
            </div>
        </div>
    </div>
</div>

<!----> <div class="modal fade" id="modalAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Data akan Terupdate !</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="idAddress" id="idAddress" value="">
                   <label for="network_id">Alamat</label>
                   <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Masukan Alamat"></textarea>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a id="Upaddress" href=""><button type="button" onclick="upAddress()" class="btn btn-primary">Update Address</button></a>
            </div>
        </div>
    </div>
</div> 

<div class="modal fade" id="modalCancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Data akan tercancel !</h4>
            </div>
            <div class="modal-body">
                Anda yakin memilih cancel ?
            </div>
            <div class="modal-footer">
                <a id="cancelvisit" href=""><button type="button" class="btn btn-primary">Yes</button></a>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.row -->
<!-- Modal -->
<div id="modalNetwork" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
    $('.datepicker2').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        autoclose: true
    })

    $('.input-daterange').datepicker({
        //$(this).datepicker('hide');
    });
</script>
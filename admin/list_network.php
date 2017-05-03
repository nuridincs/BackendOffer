<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script> -->
<script>
    function act(){
        var network_id = $('#network_id').val();
        var network_name = $('#network_name').val();
        var postbackurl = $('#postbackurl').val();
        $.ajax({
            type: 'post',
            url: 'process/p_network.php',
            data: { network_id:network_id, network_name:network_name, postbackurl:postbackurl },
            success:function(data){
                console.log(data);
                window.location.href = 'home.php?page=list_network';
            }
        });
        /*window.location.reload(true);*/
        $('.modalDetail').modal('hide');
    }

    function actUpNetwork(){
        var network_id = $('#network_id_update').val();
        var network_name = $('#network_name_update').val();
        var postbackurl = $('#postbackurl_update').val();
        $.ajax({
            type: 'post',
            url: 'process/update_network.php?data=update_network',
            data: { network_id:network_id, network_name:network_name, postbackurl:postbackurl },
            success:function(data){
                console.log(data);
                window.location.href = 'home.php?page=list_network';
            }
        });
        /*window.location.reload(true);*/
        $('.modalDetail').modal('hide');
    }

    function refresh(){
        window.location.reload(true);
    }
</script>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Network</h3>
            </div>
            <div align="right" class="panel-body">
                <!-- <a href="#" id="addNetwork" class="btn btn-primary" data-toggle="modal" data-target="#modal">Add Network</a> glyphicon-refresh-->
                <button class="btn btn-primary btn-sm" onclick="refresh()">
                    <span class='glyphicon glyphicon-refresh'></span>
                </button> 
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalNetwork">
                    Add Network&nbsp;<span class='glyphicon glyphicon-plus'></span>
                </button> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Network ID</th>
                            <th>Network Name</th>
                            <th>PostBack URL</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                            $qu=mysqli_query($con,"select * from tm_network order by id desc");
                            while($has=mysqli_fetch_assoc($qu))
                            {
                                echo "
                                <tr>
                                    <td>$has[networkid]</td>
                                    <td>$has[network_name]</td>
                                    <td>$has[postback_url]</td>
                                    <td style='text-align:center'>

                                    <span data-placement='top' data-toggle='tooltip' title='Update'><button onclick='dataUpdate($has[id],&#39;get_network&#39;)' class='btn btn-primary btn-xs' data-title='Update' data-toggle='modal' data-target='#modalUpNetwork' ><span class='glyphicon glyphicon-pencil'></span></button><span>

                        <span data-placement='top' data-toggle='tooltip' title='Delete'><button onclick='datadel($has[id],&#39;list_network&#39;)' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#modalDel' ><span class='glyphicon glyphicon-trash'></span></button><span>
                                    </td>
                                </tr>
                                ";
                            }
                       ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
<script>
    function datadel(value,jenis){
       document.getElementById('mylink').href="process/delete.php?del="+value+"&data="+jenis;
    }

    function dataUpdate(value,jenis){
        $.ajax({
            method: 'POST',
            url: 'process/update_network.php?data='+jenis,
            data : {id:value},
            success:function(data){
                console.log(data);
                var obj_result = jQuery.parseJSON(data);
                var id = obj_result.id;
                var networkid = obj_result.networkid;
                var network_name = obj_result.network_name;
                var postback_url = obj_result.postback_url;
                /*alert(obj_result.postback_url);*/
                $('input[name="id_net"]').val(id);
                $('input[name="network_id_update"]').val(networkid);
                $('input[name="network_name_update"]').val(network_name);
                $('input[name="postbackurl_update"]').val(postback_url);
            }
        });
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
                <a id="mylink" href=""><button type="button" class="btn btn-primary">Delete Data</button></a>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.row -->
<?php 
    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>
<!-- Modal -->
<div class="modal fade modalDetail" id="modalNetwork" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Add Network
                </h4>
            </div>
            <?php 
                $getId=mysqli_fetch_row(mysqli_query($con,"select max(networkid) from tm_network"));
                if ($getId == null) {
                    $networkid = '1';
                }else{
                    $networkid = $getId[0]+1;
                }
            ?>
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form role="form">
                  <div class="form-group">
                   <!--  <label for="network_id">Network ID</label> -->
                      <input type="hidden" class="form-control"
                          id="network_id" value="<?php echo $networkid; ?>" readonly placeholder="Network ID"/>
                  </div>
                  <div class="form-group">
                    <label for="network_name">Network Name</label>
                      <input type="text" class="form-control"
                      id="network_name" placeholder="Network Name"/>
                  </div>
                  <div class="form-group">
                    <label for="postbackurl">PostBack URL</label>
                      <input type="text" class="form-control"
                          id="postbackurl" value="<?php //echo generateRandomString(); ?>" placeholder="PostBack URL"/>
                  </div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" id="saveNetwork" onclick="act()" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalUpdate" id="modalUpNetwork" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Update Network
                </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form role="form">
                  <div class="form-group">
                   <!--  <label for="network_id">Network ID</label> -->
                   <input type="hidden" name="id_net">
                      <input type="hidden" class="form-control"
                          id="network_id_update" name="network_id_update" value="<?php //echo $networkid; ?>" readonly placeholder="Network ID"/>
                  </div>
                  <div class="form-group">
                    <label for="network_name">Network Name</label>
                      <input type="text" name="network_name_update" class="form-control"
                      id="network_name_update" value="<?php  ?>" placeholder="Network Name"/>
                  </div>
                  <div class="form-group">
                    <label for="postbackurl">PostBack URL</label>
                      <input type="text" class="form-control" name="postbackurl_update"
                          id="postbackurl_update" value="<?php //echo generateRandomString(); ?>" placeholder="PostBack URL"/>
                  </div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" onclick="actUpNetwork()" class="btn btn-primary">
                    Update
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function actAdd(){
        var roleid = $('#roleid').val();
        var nama = $('#nama').val();
        var email = $('#email').val();
        var password = $('#password').val();
       /* alert(roleid+nama+email+password);
        return false;*/
        $.ajax({
            type: 'post',
            url: 'process/p_add.php?data=addCs',
            data: { roleid:roleid, nama:nama, email:email, password:password },
            success:function(data){
                console.log(data);
                window.location.href = 'home.php?page=list_cs';
            }
        });
        /*window.location.reload(true);*/
        //$('.modalDetail').modal('hide');
    }

    function actUpCs(){
        var userId = $('#roleidUp').val();
        var name = $('#namaUp').val();
        var email = $('#emailUp').val();
        var password = $('#passwordUp').val();
        $.ajax({
            type: 'post',
            url: 'process/p_update.php?data=update_cs',
            data: { userId:userId, name:name, email:email, password:password },
            success:function(data){
                console.log(data);
               window.location.href = 'home.php?page=list_cs';
            }
        });
        /*window.location.reload(true);*/
        //$('.modalDetail').modal('hide');
    }


</script>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Customer Service</h3>
            </div>
            <div align="right" class="panel-body">
                <!-- <a href="#" id="addNetwork" class="btn btn-primary" data-toggle="modal" data-target="#modal">Add Network</a> glyphicon-refresh-->
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddCus">
                    Add Customer&nbsp;<span class='glyphicon glyphicon-plus'></span>
                </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped dataTable no-footer">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Nama</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                            $qu=mysqli_query($con,"select * from tbl_users where roleId = '2'");
                            while($has=mysqli_fetch_assoc($qu))
                            {
                                echo "
                                <tr>
                                    <td>$has[email]</td>
                                    <td>$has[name]</td>
                                    <td>$has[password]</td>
                                    <td style='text-align:center'>
                        <span data-placement='top' data-toggle='tooltip' title='Update'><button onclick='dataUpdateCs($has[userId],&#39;get_cs&#39;)' class='btn btn-primary btn-xs' data-title='Update' data-toggle='modal' data-target='#modalUpCs' ><span class='glyphicon glyphicon-pencil'></span></button><span>
                        
                        <span data-placement='top' data-toggle='tooltip' title='Delete'><button onclick='datadel($has[userId],&#39;list_cs&#39;)' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#myModal' ><span class='glyphicon glyphicon-trash'></span></button><span>
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
</div>
<script>
    function datadel(value,jenis){
       document.getElementById('mylink').href="process/delete.php?del="+value+"&data="+jenis;
    }

    function dataUpdateCs(value,jenis){
        $.ajax({
            method: 'POST',
            url: 'process/p_update.php?data='+jenis,
            data : {id:value},
            success:function(data){
                console.log(data);
                var obj_result = jQuery.parseJSON(data);
                var userId = obj_result.userId;
                var email = obj_result.email;
                var name = obj_result.name;
                var password = obj_result.password;
                /*alert(obj_result.postback_url);*/
                $('input[name="roleidUp"]').val(userId);
                $('input[name="emailUp"]').val(email);
                $('input[name="namaUp"]').val(name);
                $('input[name="passwordUp"]').val(password);
            }
        });
    }
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<!-- /.row -->
<div class="modal fade modalDetail" id="modalAddCus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel aria-hidden="true">
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
                    Add Customer
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
                          id="roleid" value="2" readonly placeholder="Role"/>
                  </div>
                  <div class="form-group">
                    <label for="network_name">Email</label>
                      <input type="email" class="form-control"
                      id="email" placeholder="Masukan Email"/>
                  </div>
                  <div class="form-group">
                    <label for="postbackurl">Nama</label>
                      <input type="text" class="form-control"
                          id="nama" value="<?php //echo generateRandomString(); ?>" placeholder="Masukan Nama"/>
                  </div>
                  <div class="form-group">
                    <label for="postbackurl">Password</label>
                      <input type="text" class="form-control"
                          id="password" value="<?php //echo generateRandomString(); ?>" placeholder="Masukan Password"/>
                  </div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" id="saveNetwork" onclick="actAdd()" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalUpdate" id="modalUpCs" tabindex="-1" role="dialog" 
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
                    Update Customer
                </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form role="form">
                  <div class="form-group">
                   <!--  <label for="network_id">Network ID</label> -->
                      <input type="hidden" class="form-control" name="roleidUp"
                          id="roleidUp" value="" readonly placeholder="Role"/>
                  </div>
                  <div class="form-group">
                    <label for="network_name">Email</label>
                      <input type="email" class="form-control" name="emailUp"
                      id="emailUp" placeholder="Masukan Email"/>
                  </div>
                  <div class="form-group">
                    <label for="postbackurl">Nama</label>
                      <input type="text" class="form-control" name="namaUp"
                          id="namaUp" value="<?php //echo generateRandomString(); ?>" placeholder="Masukan Nama"/>
                  </div>
                  <div class="form-group">
                    <label for="postbackurl">Password</label>
                      <input type="text" class="form-control" name="passwordUp"
                          id="passwordUp" value="<?php //echo generateRandomString(); ?>" placeholder="Masukan Password"/>
                  </div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" onclick="actUpCs()" class="btn btn-primary">
                    Update
                </button>
            </div>
        </div>
    </div>
</div>
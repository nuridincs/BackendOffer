
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Report Customer Service</h3>
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
                    <div class="form-group">
                        <label class="col-sm-3 control-label" style="width: 115px;">Date Range</label>
                         <div class="input-daterange input-group datepicker2" id="datepicker2" name="datepicker2" style="width: 300px;">
                            <input type="text" class="input-sm form-control" name="start" />
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="end" />
                        </div>
                            <input type="submit" class="btn btn-primary" name="act" value="Search" />
                   </div>
                </form> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped dataTable no-footer">
                    <thead>
                        <tr>
                            <th>Nama CS</th>
                            <th>Follow Up</th>
                            <th>Sales</th>
                            <th>Pending</th>
                            <th>Cancel</th>
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

                                $between = "DATE(wk_rekam) BETWEEN DATE('".$from_date."') AND DATE('".$to_date."')";
                                $qu=mysqli_query($con,"SELECT A.name, (SELECT COUNT(C.followup_id) FROM tm_visit C WHERE A.userId = C.followup_id AND DATE(C.wk_rekam) BETWEEN DATE('$from_date') AND DATE('$to_date')) AS 'FOLLOW_UP',
                                (SELECT COUNT(D.order_status) FROM tm_visit D WHERE D.order_status = 'SALE' AND A.userId = D.followup_id AND DATE(D.wk_rekam) BETWEEN DATE('$from_date') AND DATE('$to_date')) AS 'SALES',
                                (SELECT COUNT(E.order_status) FROM tm_visit E WHERE E.order_status = 'PENDING' AND A.userId = E.followup_id AND DATE(E.wk_rekam) BETWEEN DATE('$from_date') AND DATE('$to_date')) AS 'PENDING',
                                (SELECT COUNT(F.order_status) FROM tm_visit F WHERE F.order_status = 'CANCEL' AND A.userId = F.followup_id AND DATE(F.wk_rekam) BETWEEN DATE('$from_date') AND DATE('$to_date')) AS 'CANCEL'
                                FROM tbl_users A");
                            } else {
                                $between = '';
                                $qu=mysqli_query($con,"SELECT A.name, (SELECT COUNT(C.followup_id) FROM tm_visit C WHERE A.userId = C.followup_id) AS 'FOLLOW_UP',
                                (SELECT COUNT(D.order_status) FROM tm_visit D WHERE D.order_status = 'SALE' AND A.userId = D.followup_id) AS 'SALES',
                                (SELECT COUNT(E.order_status) FROM tm_visit E WHERE E.order_status = 'PENDING' AND A.userId = E.followup_id) AS 'PENDING',
                                (SELECT COUNT(F.order_status) FROM tm_visit F WHERE F.order_status = 'CANCEL' AND A.userId = F.followup_id) AS 'CANCEL'
                                FROM tbl_users A");
                            }
                            /*$qu=mysqli_query($con,"SELECT A.name, (SELECT COUNT(C.followup_id) FROM tm_visit C WHERE A.userId = C.followup_id) AS 'FOLLOW_UP',
                                (SELECT COUNT(D.order_status) FROM tm_visit D WHERE D.order_status = 'SALE' AND A.userId = D.followup_id) AS 'SALES',
                                (SELECT COUNT(E.order_status) FROM tm_visit E WHERE E.order_status = 'PENDING' AND A.userId = E.followup_id) AS 'PENDING',
                                (SELECT COUNT(F.order_status) FROM tm_visit F WHERE F.order_status = 'CANCEL' AND A.userId = F.followup_id) AS 'CANCEL'
                                FROM tbl_users A");
                                print_r("SELECT A.name, (SELECT COUNT(C.followup_id) FROM tm_visit C WHERE A.userId = C.followup_id AND C.$between) AS 'FOLLOW_UP',
                                (SELECT COUNT(D.order_status) FROM tm_visit D WHERE D.order_status = 'SALE' AND A.userId = D.followup_id AND D.$between) AS 'SALES',
                                (SELECT COUNT(E.order_status) FROM tm_visit E WHERE E.order_status = 'PENDING' AND A.userId = E.followup_id AND E.$between) AS 'PENDING',
                                (SELECT COUNT(F.order_status) FROM tm_visit F WHERE F.order_status = 'CANCEL' AND A.userId = F.followup_id AND F.$between) AS 'CANCEL'
                                FROM tbl_users A");*/

                            
                            while($has=mysqli_fetch_assoc($qu))
                            {
                                echo "
                                <tr>
                                    <td>$has[name]</td>
                                    <td>$has[FOLLOW_UP]</td>
                                    <td>$has[SALES]</td>
                                    <td style='text-align:center'>
                                        $has[PENDING]
                                    </td>
                                    <td>$has[CANCEL]</td>
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
       document.getElementById('mylink').href="hapus.php?del="+value+"&data="+jenis;
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
</div>
<!-- /.row -->
<script>
    $('.datepicker2').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        autoclose: true,
    })

    $('.input-daterange').datepicker({
        //$(this).datepicker('hide');
    });
</script>
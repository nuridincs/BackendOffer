<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Report Network</h3>
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
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Network</th>
                            <th>Network ID</th>
                            <th>Total Traffic</th>
                            <th>Sales</th>
                            <th>Pending</th>
                            <th>Cancel</th>
                            <th>Sales Rate</th>
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
                                $qu=mysqli_query($con,"SELECT A.network_name, A.networkid, (SELECT COUNT(B.networkid) FROM tm_visit B WHERE A.networkid = B.networkid AND DATE(B.wk_rekam) BETWEEN DATE('$from_date') AND DATE('$to_date')) AS 'TOTAL_TRAFIC',
                                    (SELECT COUNT(C.order_status) FROM tm_visit C WHERE C.order_status = 'SALE' AND A.networkid = C.networkid AND DATE(C.wk_rekam) BETWEEN DATE('$from_date') AND DATE('$to_date')) AS 'SALES',
                                    (SELECT COUNT(D.order_status) FROM tm_visit D WHERE D.order_status = 'PENDING' AND A.networkid = D.networkid AND DATE(D.wk_rekam) BETWEEN DATE('$from_date') AND DATE('$to_date')) AS 'PENDING',
                                    (SELECT COUNT(E.order_status) FROM tm_visit E WHERE E.order_status = 'CANCEL' AND A.networkid = E.networkid AND DATE(E.wk_rekam) BETWEEN DATE('$from_date') AND DATE('$to_date')) AS 'CANCEL'
                                    FROM tm_network A");
                            } else {
                                $between = '';
                                $qu=mysqli_query($con,"SELECT A.network_name, A.networkid, (SELECT COUNT(B.networkid) FROM tm_visit B WHERE A.networkid = B.networkid) AS 'TOTAL_TRAFIC',
                                (SELECT COUNT(C.order_status) FROM tm_visit C WHERE C.order_status = 'SALE' AND A.networkid = C.networkid) AS 'SALES',
                                (SELECT COUNT(D.order_status) FROM tm_visit D WHERE D.order_status = 'PENDING' AND A.networkid = D.networkid) AS 'PENDING',
                                (SELECT COUNT(E.order_status) FROM tm_visit E WHERE E.order_status = 'CANCEL' AND A.networkid = E.networkid) AS 'CANCEL'
                                FROM tm_network A");
                            }
                            
                            while($has=mysqli_fetch_assoc($qu))
                            {
                                $total = ($has['SALES'] + $has['PENDING'] + $has['CANCEL']) * 100;
                                //$count_sales_rate = $has['SALES'] / $total * 100;

                                if($has['SALES'] == 0){
                                    $sales_rate = '0';
                                } else {
                                    $sales_rate = $has['SALES'] / $total;
                                }
                                echo "
                                <tr>
                                    <td>$has[network_name]</td>
                                    <td>$has[networkid]</td>
                                    <td>$has[TOTAL_TRAFIC]</td>
                                    <td style='text-align:center'>
                                    $has[SALES]
                                    </td>
                                    <td>$has[PENDING]</td>
                                    <td>$has[CANCEL]</td>
                                    <td>$sales_rate</td>
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
    $('.datepicker2').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        autoclose: true,
    })

    $('.input-daterange').datepicker({
        //$(this).datepicker('hide');
    });
</script>
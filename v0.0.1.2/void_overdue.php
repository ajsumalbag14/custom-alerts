
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Voids</h1>
                </div>
                <!-- /.col-lg-12 -->

            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="text-muted">Resolution Overdue</h4>
                            <?php
                                
                                
                                $que = "SELECT * FROM tbl_void where FEEDBACK > 0 ".$que_reg.$que_dis.$que_str.$que_rule;

                                //echo $que;

                                if($sth = $set->con->query($que))
                                {
                                    $totcount = sizeof($sth->fetch_array(MYSQLI_NUM));
                                    
                                }
                                else
                                {
                                    $err = $set->con->error;
                                }

                                $ctr = 1;
                            ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div id="open" class="panel-body">
                            <?php include("modules/err.php") ?>
                            
                                
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Region</th>
                                            <th>District</th>
                                            <th>Store</th>
                                            <th>Manager</th>
                                            <th>Void</th>
                                            <th>Feedback <br>Count</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    
                                            <?php

                                                if($totcount > 0 and !isset($err))
                                                {
                                                    echo '<tbody style="font-size:12px">';
                                                    $_jarr = array();
                                                    
                                                    foreach($set->con->query($que) as $rs)
                                                    {

                                                        
                                                        $link = "'feedback.php?page=void&id=".$rs['ID']."'";

                                                        if($ctr%2==0)
                                                            $tr = '<tr class="odd">';
                                                        else
                                                            $tr = '<tr class="even">';
                                                        
                                                        echo $tr.'
                                                                <td>'.$ctr.'</td>
                                                                <td>'.$rs['REGION'].'</td>
                                                                <td>'.$rs['DISTRICT'].'</td>
                                                                <td>'.$rs['STORE'].'</td>
                                                                <td>'.$rs['MANAGER'].'</td>
                                                                <td>'.$rs['VOID'].'</td>
                                                                <td width="50" align="center">'.$rs['FEEDBACK'].'</td>
                                                                <td width=100>
                                                                    <a href="javascript:Popup('.$link.')"><i class="fa fa-external-link"></i> Open Report</a>
                                                                </td>
                                                            </tr>
                                                        ';
                                                    
                                                        
                                                        

                                                        $ctr ++;
                                                    }
                                                    echo '</tbody>';
                                                }
                                                else
                                                    echo '<tr class="odd"><td colspan=10>No result found</td></tr>';


                                            ?>
                                    
                                </table>

    
                                
                            </div>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->


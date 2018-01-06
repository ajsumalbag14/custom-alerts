<?php
    //submit response
    require_once('modules/main.class.php');
    include('function.php');
    //include('modules/param-exe.php');

    $linkid = "'".$_GET['page']."','".$_GET['id']."'";

    switch($_GET['page'])
    {
        case 'DIP':
            $col = 'DISC';
            $tbl = 'tbl_disc';
            $title = 'Discount Percent';
        break;
        case 'CLS':
            $col = 'CNCLSLS';
            $tbl = 'tbl_cncl';
            $title = 'Cancelled Sales';
        break;
        case 'VDS':
            $col = 'VOID';
            $tbl = 'tbl_void';
            $title = 'Voids';
        break;


        case 'COS':
            $col = 'COS';
            $tbl = 'tbl_custom';
            $title = 'CASH OVER / SHORTS';
        break;
        case 'COA':
            $col = 'COA';
            $tbl = 'tbl_custom';
            $title = 'CASH OVER / SHORTS ABS';
        break;
        case 'CMD':
            $col = 'CMD';
            $tbl = 'tbl_custom';
            $title = 'COMP $';
        break;
        case 'CMP':
            $col = 'CMP';
            $tbl = 'tbl_custom';
            $title = 'COMP %';
        break;
        case 'CSD':
            $col = 'CSD';
            $tbl = 'tbl_custom';
            $title = 'COST $';
        break;
        case 'DID':
            $col = 'DID';
            $tbl = 'tbl_custom';
            $title = 'DISCOUNT $';
        break;
        case 'DPT':
            $col = 'DPT';
            $tbl = 'tbl_custom';
            $title = 'DPT';
        break;
        case 'EDD':
            $col = 'EDD';
            $tbl = 'tbl_custom';
            $title = 'EMPLOYEE DISCOUNT $';
        break;
        case 'EDP':
            $col = 'EDP';
            $tbl = 'tbl_custom';
            $title = 'EMPLOYEE DISCOUNT %';
        break;
        case 'HRS':
            $col = 'HRS';
            $tbl = 'tbl_custom';
            $title = 'HOURS';
        break;
        case 'IVD':
            $col = 'IVD';
            $tbl = 'tbl_custom';
            $title = 'INVENTORY VARIANCE $';
        break;
        case 'IVP':
            $col = 'IVP';
            $tbl = 'tbl_custom';
            $title = 'INVENTORY VARIANCE %';
        break;
        case 'MGD':
            $col = 'MGD';
            $tbl = 'tbl_custom';
            $title = 'MARGIN $';
        break;
        case 'MGP':
            $col = 'MGP';
            $tbl = 'tbl_custom';
            $title = 'MARGIN %';
        break;
        case 'MFT':
            $col = 'MFT';
            $tbl = 'tbl_custom';
            $title = 'MARKDOWN FOLLOWTHRU';
        break;
        case 'NWH':
            $col = 'NWH';
            $tbl = 'tbl_custom';
            $title = 'NEW HIRES';
        break;
        case 'NSL':
            $col = 'NSL';
            $tbl = 'tbl_custom';
            $title = 'NO SALE';
        break;
        case 'PDO':
            $col = 'PDO';
            $tbl = 'tbl_custom';
            $title = 'PAID OUT';
        break;
        case 'PRD':
            $col = 'PRD';
            $tbl = 'tbl_custom';
            $title = 'PRODUCTIVITY';
        break;
        case 'RTD':
            $col = 'RTD';
            $tbl = 'tbl_custom';
            $title = 'RETURN $';
        break;
        case 'RTP':
            $col = 'RTP';
            $tbl = 'tbl_custom';
            $title = 'RETURN %';
        break;
        case 'SLS':
            $col = 'SLS';
            $tbl = 'tbl_custom';
            $title = 'SALES';
        break;
        case 'STR':
            $col = 'STR';
            $tbl = 'tbl_custom';
            $title = 'STASH TRANSACTIONS';
        break;
        case 'STD':
            $col = 'STD';
            $tbl = 'tbl_custom';
            $title = 'STASH $';
        break;
        case 'TRN':
            $col = 'TRN';
            $tbl = 'tbl_custom';
            $title = 'TRANSACTIONS';
        break;
        case 'UNI':
            $col = 'UNI';
            $tbl = 'tbl_custom';
            $title = 'UNITS';
        break;
        case 'UPT':
            $col = 'UPT';
            $tbl = 'tbl_custom';
            $title = 'UPT';
        break;
        
    }


    include("header.php");
    $_head = new Settings;

    echo '
  <body class="nav-md">
    <div class="container body">

    ';
?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="container" style="background:#f2f2f2; padding:1em; text-align:right; margin-bottom:1em">
                                <small><a href="#" onclick="closeWin()">Close Window
                                    <i class="fa fa-times"></i>
                                </a></small>
                                
                            </div>

                            <h1 class="page-header"><?php echo $title; ?></h1>
                            <h4 class="text-muted">Open Cases</h4>

                            <?php include("modules/err.php") ?>

                            <?php
                                
                                
                                $que = "SELECT REGION,DISTRICT,STORE,MANAGER,".$col." FROM ".$tbl." where NOTI = 0";

                                //echo $que;

                                $sth = $set->con->query($que);

                                if(!$sth->con->error)
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
                                            <th><?php echo $title; ?></th>
                                        </tr>
                                    </thead>
                                    
                                            <?php

                                                if($totcount > 0 and !isset($err))
                                                {
                                                    echo '<tbody style="font-size:12px">';
                                                    $_jarr = array();
                                                    
                                                    foreach($set->con->query($que) as $rs)
                                                    {

                                                        
                                                        $link = "'feedback.php?page=cncl&id=".$rs['ID']."'";

                                                        if($ctr%2==0)
                                                            $tr = '<tr class="odd">';
                                                        else
                                                            $tr = '<tr class="even">';

                                                        
                                                        $manager = $rs['MANAGER']!='' ? $rs['MANAGER'] : '---';

                                                        echo $tr.'
                                                                <td>'.$ctr.'</td>
                                                                <td>'.$rs['REGION'].'</td>
                                                                <td>'.$rs['DISTRICT'].'</td>
                                                                <td>'.$rs['STORE'].'</td>
                                                                <td>'.$manager.'</td>
                                                                <td>'.$rs[$col].'</td>
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

<?php


echo '
    <div class="row">
    <br>
    <center><small>&copy;2014-2017 <a href="https://www.lassu.net" target="_blank">Lassu</a> &bull; '.$_head->getAppName().' '.$_head->getVersion().'</small></center>
     
    </div>
</div>
<!-- /#wrapper -->
</body>
';



include('footer.php');



echo '
</html>
';

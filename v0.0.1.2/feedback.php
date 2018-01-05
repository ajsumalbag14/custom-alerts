<?php
	//submit response
	require_once('modules/main.class.php');
	include('function.php');

	$linkid = "'".$_GET['page']."','".$_GET['id']."'";


	include("header.php");
	$_head = new Settings;

	echo '
  <body class="nav-md">
    <div class="container body">

	';
?>



<div class="row" style="background:white;">

		<div class="container" style="background:#f2f2f2; padding:2em; text-align:right; margin-bottom:1em">
			Feedback Form | 
			<small><a href="#" onclick="closeWin()">Close Window
				<i class="fa fa-times"></i>
			</a></small>
			
		</div>

		<div class="clearfix"></div>


		<?php include("modules/err.php") ?>

		

		<div class="container" style="padding: 5em;">
				<h3>Feedback Lists</h3>
				<table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>User</th>
                          <th>Findings</th>
                          <th>Comments</th>
                          <th>Status</th>
                          <th>Timestamp</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 

                      		$que = "select * from TBLALERTRESP where alert = '".$_GET['page']."' and TRXN_ID = ".$_GET['id'];
                      		$ctr = 1;
                      		foreach($set->con->query($que) as $rs)
                            {

                            	foreach ($_findings as $key => $val) {
                            		if($key == $rs['DISPCODE'])
                            			$despo = $val;
                            	}

                            	echo '
                        		
			                        <tr>
			                       		<td>'.$ctr.'</td>
			                        	<td>'.$set->getAdminName($rs['USERID']).'</td>
			                    		<td>'.$despo.'</td>
			                    		<td>'.$rs['COMMENTS'].'</td>
			                    		<td>'.$rs['STATUS'].'</td>
			                    		<td>'.$rs['CDATE'].'</td>
			                        </tr>
		                      	
                            	';

                            	$ctr++;
                            }

                      ?>
                      </tbody>

                      
                </table>

				<div id="err" class="alert alert-danger" style="display:none">
				</div>
				
				<div id="loading" class="progress" style="display:none">
				  <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
				    <span>Sending response...</span>
				  </div>
				</div>

				<form name="resp">	
				<table class="table table-bordered">

					<tr>
						<td colspan="2">
							<b>Case Response</b>
						</td>
					</tr>

					<tr>
						<td>Findings</td>
						<td>
							<select id="ardisp" name="dispcode" onchange="arDisp()" class="form-control">
								<option>--- Please select one ---</option>
								<?php
									foreach ($_findings as $key => $val) {
										echo '<option value="'.$key.'">'.$val.'</option>';
									}
								?>	
							</select>
						</td>
					</tr>

					<tr>
						<td>Comments</td>
						<td>
								<textarea name="upe_comment" rows="10"  class="form-control"></textarea>
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<a class="btn btn-success" onclick="sendResp(<?php echo $linkid?>)">Submit Response</a>
						</td>
					</tr>

				</form>
				</table>
		</div>


</div>



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
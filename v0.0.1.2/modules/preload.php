<?php
	
	

	switch($_GET['page'])
	{
		case 'user':
			switch($_GET['sub'])
			{
				case 'profile':
					if($_GET['id']!='')
					{
						
						
				
						$que = "SELECT * FROM TBLADMIN WHERE ID = ".$_GET['id'];
						
						$sth = $_user->con->query($que);
						$rs = $sth->fetch_array(MYSQLI_ASSOC);

						//$updateby = $_user->getAdminName($rs['UPDATEDBY']);

						if($_COOKIE['adminid'] != $_GET['id'])
						{
							$que1 = "SELECT * FROM TBLADMINPERM WHERE ADMINID = ".$_GET['id'];
							$sth1 = $_user->con->query($que1);
							$rs1 = $sth1->fetch_array(MYSQLI_ASSOC);

							$msuper = $rs1['MSUPER'] == 1 ? 'Yes' : 'No';
							$marea = $rs1['MAREA'] == 1 ? 'Yes' : 'No';
							$mstore = $rs1['MSTORE'] == 1 ? 'Yes' : 'No';
							$mformat = $rs1['MFORMAT'] == 1 ? 'Yes' : 'No';
							$mglp = $rs1['MGLP'] == 1 ? 'Yes' : 'No';
							$msetting = $rs1['SETTINGS'] == 1 ? 'Yes' : 'No';

							
						}
						
						
					}
					else
						$err = 'No result found.';

				break;
				case 'editstore':
					
					$que = "SELECT STORE,ACCES,LOC,FORMAT,COMPANY,LOB FROM TBLADMIN WHERE ID = ".$_GET['id'];
					$sth = $_user->con->query($que);
					$r = $sth->fetch_array(MYSQLI_ASSOC);

					$loc = explode(",", $r['LOC']);
					$len = count($loc);

					$frm = explode(",", $r['FORMAT']);
					$len2 = count($frm);
					
					$acc = $r['ACCES'];

				break;

				case 'editperm':
				 	$que = "SELECT a.*,b.ACCES FROM 
				              TBLADMINPERM a
				              INNER JOIN 
				              TBLADMIN b
				              ON a.ADMINID = b.ID 
				              WHERE b.ID = ".$_GET['ref'];
			      	
			      	$sth = $_user->con->query($que);
					$r = $sth->fetch_array(MYSQLI_ASSOC);

				      if(!isset($r['ACCES']))
				      {
				          $ins = "INSERT INTO TBLADMINPERM(ADMINID) VALUES(".$_GET['id'].")";
				          
				       
				          	
				          	$sth = $_user->con->prepare($ins);
				          	$sth->execute();
				          
				             $que = "SELECT a.*,b.ACCES FROM 
				                TBLADMINPERM a
				                INNER JOIN 
				                TBLADMIN b
				                ON a.ADMINID = b.ID 
				                WHERE b.ID = ".$_GET['ref'];

				              	$sth = $_user->con->query($que);
								$r = $sth->fetch_array(MYSQLI_ASSOC);
				          
				      }

				     // echo '<div style="text-align:right; width:700px; float:right">'.$que.'</div>';

				      $acc = $r['ACCES'];
				break;

				

				case 'editaccount':
					$que = "SELECT * FROM TBLADMIN WHERE ID = ".$_GET['ref'];
					$sth = $_user->con->query($que);
					$rs = $sth->fetch_array(MYSQLI_ASSOC);

					//extract pwd
					$getpwd = $_user->mh10decrypt($rs['PASSWORD']);
					$pwd = explode("_", $getpwd);

					$acc = $rs['ACCES'];
					$aName = $rs['NAME'];
					$aUser = $rs['USERNAME'];
					$aEmail = $rs['EMAIL'];
					$aImg = $rs['IMG'];

				break;
				/*
				case 'my':
					$que = "select * from tbluser where ID = ?";
					try {
						$sth = $_user->con->prepare($que);
						$sth->execute(array($_SESSION['uid']));
						$rs = $sth->fetch(PDO::FETCH_BOTH);
						
						$fname = $rs['NAME'];
						$uname = $rs['USERNAME'];
						$oname = $rs['USERNAME'];
						$epwd = explode("_",mh10decrypt($rs['PASSWORD']));
						$upwd = $epwd[1];
						$upwd2 = $upwd;
						$opwd = $upwd;
						$uaccess = $rs['ACCES'];
					}	
					catch (PDOException $e)
					{
						$err = $e->getMessage();
					}	
					
				break;
				*/

				case 'pps':
						
			
					$que = "select * from TBLADMINPPS where ID = 1";
					$sth = $_user->con->query($que);
					$rs = $sth->fetch_array(MYSQLI_ASSOC);
					
					$pwdlen = $rs['PWDLEN'];
					$bi_num = $rs['BI_NUM'];
					$bi_case = $rs['BI_CASE'];
					$bi_char = $rs['BI_CHAR'];
					$bi_change = $rs['BI_CHANGE'];
					$change_days = $rs['CHANGE_DAYS'];
					$updatedby = $rs['UPDATEDBY'];
					$updatedte = $rs['UPDATEDTE'];
					
					
				break;
			}
		break;

		default:

		$que = "select * from rpt_param a inner join rpt_filters_all b on a.ID = b.PARAMID where a.USERID = ".$_COOKIE['adminid'];

		$sth = $set->con->query($que);
		if(!$sth->con->error)
		{
			//$rs = $sth->fetch_array(MYSQLI_ASSOC);
			
		}
		else
			$err = $sth->con->error;


		

		

		
	}
?>
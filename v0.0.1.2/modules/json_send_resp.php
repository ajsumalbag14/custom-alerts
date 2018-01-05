<?php
	require_once('../modules/main.class.php');

	$set = new Settings;
	$sqldatetime = date("Y-m-d G:i:s");

	$page = $_POST['page'];
	$id = $_POST['id'];
	$disp = $_POST['disp'];
	//$sanc = $_POST['sanc'];
	$strmgr = $_COOKIE['adminid'];
	$comment = $_POST['body'];
	$mode = $_POST['mode'];
	$respid = $_POST['respid'];

	switch($page)
	{
		case 'disc':
			$tbl = 'tbl_disc';
		break;

		case 'cncl':
			$tbl = 'tbl_cncl';
		break;

		case 'void':
			$tbl = 'tbl_void';
		break;
	}

	if($disp != '')
	{

		if($disp == 'DP01')
		{
			if($comment != '')
			{
				$allow = 1;
				$mod = 1;
			}
			else
				$noti = 'Please provide comment.';
		}
		else
		{
			if($comment != '')
			{
				$allow = 1;
				$mod = 2;
			}
			else
				$noti = 'Please complete the response needed.';
		}

		//save to db
		if($allow == 1)
		{
			if($mode == 'edit')
			{

				$updte = $strmgr.'|'.$sqldatetime;
				$que = "update TBLALERTRESP set DISPCODE = :disp, SANCCODE = :sanc, COMMENTS = :comments, UPDTE = :updte
						where ID = :respid";

				try {

					$sth = $set->con->prepare($que);
					$sth->bindParam(':disp',$disp);
					//$sth->bindParam(':sanc',$sanc);
					$sth->bindParam(':comments',$comment);
					$sth->bindParam(':updte',$updte);
					$sth->bindParam(':respid',$respid);
					$sth->execute();
					
					$noti = 1;
					
				}
				catch (PDOException $e)
				{
					$noti = $e->getMessage().'[Edit Resp]';
				}
			}
			else
			{ //insert

					$que = "INSERT INTO TBLALERTRESP
		           	(
			           USERID
			           ,DISPCODE
			           ,COMMENTS
			           ,ALERT
			           ,TRXN_ID
			           ,CDATE)
		    		 VALUES
		           (".$_COOKIE['adminid'].",'$disp','$comment','$page','$id','$sqldatetime')";
				
				if($sth = $set->con->prepare($que))
				{
					$sth->execute();

					

						//update transaction flag
						$quep = "UPDATE ".$tbl." SET FEEDBACK = FEEDBACK + 1 WHERE ID = ".$id;
						
						if($st = $set->con->prepare($quep))
						{
							$st->execute();

							$noti = 1;
						}
						else
						{
							$noti = $set->con->error.' [Inner Error] ';
						}
				}
				else 
				{
					$noti = $set->con->error.'[Outer Error]';
				}
				
			} //end if
			
		}

	}
	else
		$noti = 'Please complete the response needed.';

	echo $noti;

?>
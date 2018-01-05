<?php
	
	if(isset($_POST['submit']))
	{

		switch($_GET['page'])
		{

			case 'rpt':
			$set = new Settings;

			    //table param
			    $_metric = $_POST['metric'];
			    $daterange = explode('-',$_POST['daterange']);
			    $_sdate = $daterange[0];
			    $_edate = $daterange[1];

			    $_rule = $_POST['rule'];
			    $param1 = $_POST['param1'] > 0 ? $_POST['param1'] : 0;
			    $param2 = $_POST['param2'] > 0 ? $_POST['param2'] : 0;

			    $_filter = '';
			    for($i=0; $i < sizeof($_POST['filter']); $i++){
			      if($_filter == '')
			        $_filter = $_POST['filter'][$i];
			      else
			        $_filter = $_filter.'#'.$_POST['filter'][$i];

			    }

			    $_region = 'null';
			    for($i=0; $i < sizeof($_POST['region']); $i++){
			      if($_region == 'null')
			        $_region = $_POST['region'][$i];
			      else
			        $_region = $_region.'#'.$_POST['region'][$i];

			    }

			    $_district = 'null';
			    for($i=0; $i < sizeof($_POST['district']); $i++){
			      if($_district == 'null')
			        $_district = $_POST['district'][$i];
			      else
			        $_district = $_district.'#'.$_POST['district'][$i];

			    }

			    $_store = 'null';
			    for($i=0; $i < sizeof($_POST['store']); $i++){
			      if($_store == 'null')
			        $_store = $_POST['store'][$i];
			      else
			        $_store = $_store.'#'.$_POST['store'][$i];

			    }

			    $_status = 'null';
			    for($i=0; $i < sizeof($_POST['status']); $i++){
			      if($_status == 'null')
			        $_status = $_POST['status'][$i];
			      else
			        $_status = $_status.'#'.$_POST['status'][$i];

			    }

			    $_manager = 'null';
			    for($i=0; $i < sizeof($_POST['manager']); $i++){
			      if($_manager == 'null')
			        $_manager = $_POST['manager'][$i];
			      else
			        $_manager = $_manager.'#'.$_POST['manager'][$i];

			    }

			    $_loc_type = 'null';
			    for($i=0; $i < sizeof($_POST['loc_type']); $i++){
			      if($_loc_type == 'null')
			        $_loc_type = $_POST['loc_type'][$i];
			      else
			        $_loc_type = $_loc_type.'#'.$_POST['loc_type'][$i];

			    }

			    $_lifestyle = 'null';
			    for($i=0; $i < sizeof($_POST['lifestyle']); $i++){
			      if($_lifestyle == 'null')
			        $_lifestyle = $_POST['lifestyle'][$i];
			      else
			        $_lifestyle = $_lifestyle.'#'.$_POST['lifestyle'][$i];

			    }

			    $_assoc = 'null';
			    for($i=0; $i < sizeof($_POST['assoc']); $i++){
			      if($_assoc == 'null')
			        $_assoc = $_POST['assoc'][$i];
			      else
			        $_assoc = $_assoc.'#'.$_POST['assoc'][$i];

			    }

			    $_daypart = 'null';
			    for($i=0; $i < sizeof($_POST['daypart']); $i++){
			      if($_daypart == 'null')
			        $_daypart = $_POST['daypart'][$i];
			      else
			        $_daypart = $_daypart.'#'.$_POST['daypart'][$i];

			    }

			    //echo $_sdate.'<br>'.$_edate;

			    
				// insert sql
			    $que = "INSERT INTO rpt_param
			            (
			            USERID,
			            METRICID,
			            STARTDATE,
			            ENDDATE,
			            RULE,
			            PARAM1,
			            PARAM2,
			            DATE_ADDED)
			            VALUES(".$_COOKIE['adminid'].",'$_metric','$_sdate','$_edate','$_rule',
			                $param1,$param2,'$sqldatetime')";

			    $stmt = $set->con->prepare($que);
				$stmt->execute();

				if(!$set->con->error)
				{
					$suc = 'Custom Report Submitted.';
					$proceed = 2;

			    }
			    else
			    {
			      $err = 'Insert SQL: '.$set->con->error;
			    }
				

				//all filters table

				if($proceed == 2)
			    {

				   	//check if there is an existing rules set
				    $q = "select ID from rpt_param where METRICID = '".$_metric."' and USERID = ".$_COOKIE['adminid']." order by ID desc limit 1";
				    if($stmt = $set->con->query($q)) {
				    	$rs = $stmt->fetch_array(MYSQLI_ASSOC);
				    }

					// insert sql
				    $que = "INSERT INTO rpt_filters_all
				            (
							USERID,
							PARAMID,
							REGION,
							DISTRICT,
							STORE,
							MANAGER,
							STATUS,
							LOCATION,
							LIFESTYLE,
							ASSOC,
							DAYPART)
				            VALUES(".$_COOKIE['adminid'].",".$rs['ID'].",'$_region','$_district','$_store','$_manager',
				                '$_status','$_loc_type','$_lifestyle','$_assoc','$_daypart')";

				    $stmt = $set->con->prepare($que);
					$stmt->execute();

					if(!$set->con->error)
					{
						$suc = 'Custom Report Submitted.';
						$proceed = 2;

				    }
				    else
				    {
				      $err = 'Insert SQL: '.$set->con->error;
				    }

				}
				


			  

			break;

			case 'user':
			$_user = new UserSettings;

				//filter date

				$mm = strlen($_POST['mm']) == 1 ? '0'.$_POST['mm'] : $_POST['mm'];
					$dd = strlen($_POST['dd']) == 1 ? '0'.$_POST['dd'] : $_POST['dd'];
					$yy = $_POST['yy'];
					
					$postdte = $yy.'-'.$mm.'-'.$dd;
					if($postdte == '--')
						{}
					else
					{
						if($yy!='' and $mm!='' and $dd!='')
						{
							switch ($mm) {
										case '02':
											if($yy%2 == 0)
											{
												if($dd > 29)
													$err = "Invalid date range.";

											}
											else
											{
												if($dd > 28)
													$err = "Invalid date range.";
											}
											break;

										case '04':
										case '06':
										case '09':
										case '11':
											if($dd > 30)
													$err = "Invalid date range.";
										break;
									}
						}
						else
							$err = "Invalid date range.";
					}	

					$mm2 = strlen($_POST['mm2']) == 1 ? '0'.$_POST['mm2'] : $_POST['mm2'];
					$dd2 = strlen($_POST['dd2']) == 1 ? '0'.$_POST['dd2'] : $_POST['dd2'];
					$yy2 = $_POST['yy2'];

					$postdte2 = $yy2.'-'.$mm2.'-'.$dd2;
					if($postdte2 == '--')
						{}
					else
					{
						if($yy2!='' and $mm2!='' and $dd2!='')
						{
							switch ($mm2) {
										case '02':
											if($yy2%2 == 0)
											{
												if($dd2 > 29)
													$err = "Invalid date range.";

											}
											else
											{
												if($dd2 > 28)
													$err = "Invalid date range.";
											}
											break;

										case '04':
										case '06':
										case '09':
										case '11':
											if($dd2 > 30)
													$err = "Invalid date range.";
										break;
									}
						}
						else
							$err = "Invalid date range.";
					}

					$dt1 = $_POST['yy'].$mm.$dd;
					$dt2 = $_POST['yy2'].$mm2.$dd2;

					if($dt1 > $dt2)
						$err = "Invalid date range.";

				//end filter date

				
				switch($_GET['sub'])
				{
					

					case 'editperm':
							$userid = $_POST['userid'];
							$msuper = $_POST['msuper'] != '' ? $_POST['msuper'] : 0;
							$marea = $_POST['marea'] != '' ? $_POST['marea'] : 0;
							$mstore = $_POST['mstore'] != '' ? $_POST['mstore'] : 0;
							$mglp = $_POST['mglp'] != '' ? $_POST['mglp'] : 0;
							$mformat = $_POST['mformat'] != '' ? $_POST['mformat'] : 0;
							$msetting = $_POST['msetting'] != '' ? $_POST['msetting'] : 0;


							try {
							  $q = "
							      UPDATE TBLADMINPERM
							      SET
							     MSUPER = ".$msuper."
							     ,MAREA = ".$marea."
							     ,MSTORE = ".$mstore."
							     ,MGLP = ".$mglp."
							     ,MFORMAT = ".$mformat."
							     ,SETTING = ".$msetting." WHERE ADMINID = $userid
							    ";
							  $sth = $_user->con->prepare($q);
							  $sth->execute();

							  	$_GET['sub'] = "profile";
					       		$_GET['id'] = $userid;
					       		$suc = "Permission has been successfully updated.";
							}
							catch (Exception $e)
							{
							    $err = $_user->con->error;
							}
							$acc = $r['ACCES'];
					break;

					

					case 'new':
						      $postname = $_POST['aName'];
						      $postuser = $_POST['aUser'];
						      $postpwd = $_POST['aUser'];//$_POST['aPwd'];
						      $postaccess = $_POST['access'];
						      $postemail = $_POST['aEmail'];


						      if($postname != '' and $postemail != '' and $postuser != '' and $postpwd != '')
						      {

						      	/*
						      	//password policy check
						      	$proceed = 0;
								$ppsq = "select * from TBLADMINPPS where ID = 1";
								$st = $_user->con->prepare($ppsq);
								$st->execute();
								$pp = $st->fetch_array(MYSQLI_ASSOC);

								$pwdlen = $pp['PWDLEN'] - 1;
								$len = strlen($postpwd);

								if($len > $pwdlen)
								{
									
									if($pp['BI_NUM'] == 1)
									{
										$proc = 0;
										for($i=0; $i<$len; $i++){
											if(is_numeric($postpwd[$i]))
											{
												$proc = 1;
											}
										}

										if($proc == 0)
										{
											$err = "Password requires at least one numerical digit";
										}
									}

									if($pp['BI_CASE'] == 1 && !isset($err))
									{
										$proc1 = 0;
										$lower = 0;
										$upper = 0;
										for($i=0; $i<$len; $i++){
											//ord 65-122 alphabet
											if(ord($postpwd[$i]) > 64 && ord($postpwd[$i]) < 91)
												$upper = 1;
											elseif(ord($postpwd[$i]) > 90 && ord($postpwd[$i]) < 122)
												$lower = 1;
										}

										if($lower == 1 && $upper == 1)
										{
											$proc1 = 1;
										}
										else
											$err = "Password requires at least one lower case and at least one upper case letter";
									}

									if($pp['BI_CHAR'] == 1 && !isset($err))
									{
										$proc2 = 0;
										for($i=0; $i<$len; $i++){

											//ord 65-122 alphabet
											//ord 48-57 1-9 numbers
											if(ord($postpwd[$i]) < 48)
												$proc2 = 1;
											elseif(ord($postpwd[$i]) > 57 && ord($postpwd[$i]) < 65)
												$proc2 = 1;
											elseif(ord($postpwd[$i]) > 122)
												$proc2 = 1;
										}

										if($proc2 == 0)
										{
											$err = "Password requires at least one special character";
										}
									}
									

									//final value assignment
									$proc = !isset($proc) ? 1 : $proc;
									$proc1 = !isset($proc1) ? 1 : $proc1;
									$proc2 = !isset($proc2) ? 1 : $proc2;

									if($proc == 1 && $proc1 == 1 && $proc2 == 1)
									{
										$proceed = 1;
									}

									
								}
								else
									$err = "Password length should be greater than ".$pwdlen;

								//END password policy check
								*/
								
									$proceed = 1;

								if($proceed == 1)
								{

							          //search duplicate
							          $q = "SELECT ID FROM TBLADMIN WHERE USERNAME = '".$postuser."'";
							          $sth = $_user->con->query($q);
							          $numsql = sizeof($sth->fetch_array(MYSQLI_NUM));


							          if($numsql<1)
							          {

							              $suffix = date("Ymd");
							              //mh10 hashing
							              $hashpwd = $_user->mh10encrypt($postpwd,$postuser,$suffix);
							              $result = $_user->addUser($postname,$postemail,$postuser,$hashpwd,$_COOKIE['adminid'],$postaccess,'.');

							              if($result == '1')
							              {
							                $q = "SELECT ID FROM TBLADMIN WHERE USERNAME = '".$postuser."'";
							                
							                try {

							                	$sth = $_user->con->query($q);
							                	$r = $sth->fetch_array(MYSQLI_ASSOC);

								                $_SESSION['temp_access'] = $postaccess;

								                if($postaccess != 'Manager')
								                {
								                	$_GET['sub'] = "addperm";
								                	$_GET['ref'] = $r['ID']; 
								                }
								                else
								                {
								                	$_GET['sub'] = "addstore";
								                	$_GET['ref'] = $r['ID']; 
								                }
							            	}
							            	catch (Exception $e)
							            	{
							            		$err = $_user->con->error;
							            	}
							              }
							              else
							                $err = $result;
							          }
							          else
							            $err = 'Duplicate entry for USERNAME.';
						    	}//proceed
						      }
						      else
						        $err = 'Please complete all given fields.';
					break;

					case 'addperm':
						      $userid = $_POST['userid'];
						      $msuper = $_POST['msuper'] != '' ? $_POST['msuper'] : 0;
						      $marea = $_POST['marea'] != '' ? $_POST['marea'] : 0;
						      $mstore = $_POST['mstore'] != '' ? $_POST['mstore'] : 0;
						      $mglp = $_POST['mglp'] != '' ? $_POST['mglp'] : 0;
						      $mformat = $_POST['mformat'] != '' ? $_POST['mformat'] : 0;
						      $msetting = $_POST['msetting'] != '' ? $_POST['msetting'] : 0;

						          //search duplicate
						          $q = "
						              INSERT INTO TBLADMINPERM
						             (ADMINID
						             ,MSUPER
						             ,MAREA
						             ,MSTORE
						             ,MGLP 
						             ,MFORMAT
						             ,SETTING)
						             VALUES
						                   (".$userid."
						                   ,".$msuper."
						                   ,".$marea."
						                   ,".$mstore."
						                   ,".$mglp."
						                   ,".$mformat."
						                   ,".$msetting.")
						            ";
						         echo $q;

					          	try {

					          		$sth = $_user->con->prepare($q);
					          		$sth->execute();


				                	
					          		$_GET['sub'] = '';
					          		$suc = "User account has been successfully added.";
					          		
				         	 	}
					          	catch (Exception $e)
					          	{
						            $err = $_user->con->error;

								}
					break;

					case 'pps':
						$pwdlen = $_POST['pwdlen'];
						$bi_num = $_POST['bi_num'];
						$bi_case = $_POST['bi_case'];
						$bi_char = $_POST['bi_char'];
						$bi_change = $_POST['bi_change'];
						$change_days = $bi_change == 0 ? 0 : $_POST['change_days'];
						$updatedby = $_POST['updatedby'];
						$updatedte = $_POST['updatedte'];

						$proceed = 0;
						if($bi_change == 1)
						{
							if(is_numeric($change_days))
							{
								if($change_days > 0)
								{
									$proceed = 1;
								}
								else
									$err = "Value of days for force password change should be greater than 0";	
							}
							else
								$err = "Value of days entered is non-numeric.";
						}
						else
							$proceed = 1;

						if($proceed == 1)
						{

							if(is_numeric($pwdlen))
							{
								if($pwdlen > 3 && $pwdlen < 25)
								{

									
									try {
									  $q = "
									      UPDATE TBLADMINPPS
									      SET
									     PWDLEN = ".$pwdlen."
									     ,BI_NUM = ".$bi_num."
									     ,BI_CASE = ".$bi_case."
									     ,BI_CHAR = ".$bi_char."
									     ,BI_CHANGE = ".$bi_change."
									     ,UPDATEDBY = '".$_COOKIE['adminuser']."'
									     ,UPDATEDTE = '".$sqldatetime."'
									     ,CHANGE_DAYS = ".$change_days." WHERE ID = 1
									    ";
									  $sth = $_user->con->prepare($q);
									  $sth->execute();

									  	$_GET['sub'] = "pps";
							       		$suc = "Policy has been successfully updated.";
									}
									catch (Exception $e)
									{
									    $err = $_user->con->error;
									}

								}
								else
									$err = "Password length should be greater than 3 and less than 24.";
							}
							else
								$err = "Invalid password length.";
						}
					break;

					case 'editaccount':
					case 'my':
						      $postname = $_POST['aName'];
						      $postuser = $_POST['aUser'];
						      $postuser2 = $_POST['aUser2'];
						      $postpwd = $_POST['aPwd'];
						      $postpwd2 = $_POST['aPwd2'];
						      $postaccess = $_POST['access'];
						      $postemail = $_POST['aEmail'];

						    if(strlen($_FILES['aImg']['name']) > 2)
							{

								$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
								$detectedType = exif_imagetype($_FILES['aImg']['tmp_name']);
								$error = !in_array($detectedType, $allowedTypes);

								if(!$error)
								{

										$tmp_name = $_FILES["aImg"]["tmp_name"];
										$name = time().'_img_'.$_FILES["aImg"]["name"];
										move_uploaded_file($tmp_name, "images/$name");
										$proc_img = 1;

								}
								else
									$err = "Image type is invalid.";


							}
							else
							{
								$proc_img = 0;
							}

						   
						          //search duplicate
						          if($postuser != $postuser2)
						          {
						            //search duplicate
							          $q = "SELECT ID FROM TBLADMIN WHERE USERNAME = '".$postuser."'";
							          $sth = $_user->con->query($q);
							          $numsql = sizeof($sth->fetch_array(MYSQLI_NUM));
						            	
						            	if($numsql<1)
						              		$proceed = 1;
						          }
						          else
						            $proceed = 1;

						          if($proceed == 1)
						          {

						              if($postpwd != $postpwd2)
						              {

						              	//password policy check
								      	$proceed = 0;
										$ppsq = "select * from TBLADMINPPS where ID = 1";
										$st = $_user->con->query($ppsq);
										$pp = $st->fetch_array(MYSQLI_ASSOC);

										$pwdlen = $pp['PWDLEN'] - 1;
										$len = strlen($postpwd);

										if($len > $pwdlen)
										{
											
											if($pp['BI_NUM'] == 1)
											{
												$proc = 0;
												for($i=0; $i<$len; $i++){
													if(is_numeric($postpwd[$i]))
													{
														$proc = 1;
													}
												}

												if($proc == 0)
												{
													$err = "Password requires at least one numerical digit";
												}
											}

											if($pp['BI_CASE'] == 1 && !isset($err))
											{
												$proc1 = 0;
												$lower = 0;
												$upper = 0;
												for($i=0; $i<$len; $i++){
													//ord 65-122 alphabet
													if(ord($postpwd[$i]) > 64 && ord($postpwd[$i]) < 91)
														$upper = 1;
													elseif(ord($postpwd[$i]) > 90 && ord($postpwd[$i]) < 122)
														$lower = 1;
												}

												if($lower == 1 && $upper == 1)
												{
													$proc1 = 1;
												}
												else
													$err = "Password requires at least one lower case and at least one upper case letter";
											}

											if($pp['BI_CHAR'] == 1 && !isset($err))
											{
												$proc2 = 0;
												for($i=0; $i<$len; $i++){

													//ord 65-122 alphabet
													//ord 48-57 1-9 numbers
													if(ord($postpwd[$i]) < 48)
														$proc2 = 1;
													elseif(ord($postpwd[$i]) > 57 && ord($postpwd[$i]) < 65)
														$proc2 = 1;
													elseif(ord($postpwd[$i]) > 122)
														$proc2 = 1;
												}

												if($proc2 == 0)
												{
													$err = "Password requires at least one special character";
												}
											}
											

											//final value assignment
											$proc = !isset($proc) ? 1 : $proc;
											$proc1 = !isset($proc1) ? 1 : $proc1;
											$proc2 = !isset($proc2) ? 1 : $proc2;

											if($proc == 1 && $proc1 == 1 && $proc2 == 1)
											{
												$proceed = 1;
											}

											
										}
										else
											$err = "Password length should be greater than ".$pwdlen;

										//END password policy check

										if($proceed == 1)
										{
							                $suffix = date("Ymd");
							                //mh10 hashing
							                $hashpwd = $_user->mh10encrypt($postpwd,$postuser,$suffix);
							                $result = $_user->editUser($postname,$postemail,$name,$proc_img,$postuser,$hashpwd,$postaccess,'.',$_COOKIE['adminid'],$_POST['aID']);
						              	}
						              	else
						              		$result = $err;
						              }
						              else
						              {
						                $hashpwd = '0';
						                $result = $_user->editUser($postname,$postemail,$name,$proc_img,$postuser,$hashpwd,$postaccess,'.',$_COOKIE['adminid'],$_POST['aID']);  
						              }

						              if($result == '1')
						              {
						                
						                	$_GET['sub'] = "profile";
								       		$_GET['id'] = $_POST['aID'];
								       		$suc = "User has been successfully updated.";
						              	
						              }
						              else
						                $err = $result;
						          }
						          else
						            $err = 'Duplicate entry for USERNAME.';
						    

						      $acc = $_POST['access'];
							  $aName = $_POST['aName'];
							  $aUser = $_POST['aUser'];
					break;
				}
			break;

			case 'setting':
				switch($_GET['mod'])
				{
				case 'rsk_add':
				
					$tr_ct = $_POST['tr_ct'];
					$tr_day = $_POST['tr_day'];
					$elv_ct = isset($_POST['elv_ct']) ? $_POST['elv_ct'] : 0;
					$postlvl = $_POST['lvl'];
					$postelv = $_POST['elv'];
					$code = $_GET['ref'];
					$comp = isset($_POST['company']) ? $_POST['company'] : $_COOKIE['company'];
					
					if($tr_ct != '' and $tr_day != '' and $postelv != '' and $postlvl != '')
					{
						//check numeric values
						if(is_numeric($tr_ct) and is_numeric($tr_day) and is_numeric($elv_ct))
						{
							if($tr_ct > 0)
							{
								if($postelv == 'E1' OR $postelv == 'E2')
								{
									if($elv_ct > 0)
									{
										
										$que = "
												INSERT INTO tblalertsettingrsk (CODE
											           ,TR_CT
											           ,TR_DAY
											           ,LVL
											           ,ELV_RSK
											           ,ELV_CT
											           ,COMPANY)
											     VALUES
											           (:code
											           ,:tr_ct
											           ,:tr_day
											           ,:postlvl
											           ,:postelv
											           ,:elv_ct
											           ,:comp)
										";

										try{

											$sth = $set->con->prepare($que);
											$sth->bindParam(':code',$code);
											$sth->bindParam(':tr_ct',$tr_ct);
											$sth->bindParam(':tr_day',$tr_day);
											$sth->bindParam(':postlvl',$postlvl);
											$sth->bindParam(':postelv',$postelv);
											$sth->bindParam(':elv_ct',$elv_ct);
											$sth->bindParam(':comp',$comp);
											$sth->execute();	
										}
										catch (Exception $e)
										{
											$err = $set->con->error;
										}
									}
									else
										$err = 'Invalid elevated risk factor "n" value.';
								}
								else
								{
									//proceed to insert
									
									$que = "
											INSERT INTO tblalertsettingrsk
										           (CODE
										           ,TR_CT
										           ,TR_DAY
										           ,LVL
										           ,ELV_RSK
										           ,ELV_CT
										           ,COMPANY)
										     VALUES
										           (:code
										           ,:tr_ct
										           ,:tr_day
										           ,:postlvl
										           ,:postelv
										           ,:elv_ct
										           ,:comp)
									";
									
									try{
											$sth = $set->con->prepare($que);
											$sth->bindParam(':code',$code);
											$sth->bindParam(':tr_ct',$tr_ct);
											$sth->bindParam(':tr_day',$tr_day);
											$sth->bindParam(':postlvl',$postlvl);
											$sth->bindParam(':postelv',$postelv);
											$sth->bindParam(':elv_ct',$elv_ct);
											$sth->bindParam(':comp',$comp);
											$sth->execute();
									}
									catch (Exception $e)
									{
										$err = $set->con->error;
									}

								}

									//redirect or notify
									$_GET['mod'] = $err != '' ? $_GET['mod'] : 'rsk';
									$_GET['comp'] = $comp;
							}
							else
								$err = 'Values for Number of Transactions and Business Day must be greater than zero (0).';
						}
						else
							$err = 'You have field(s) that expects numeric value only.';
					}
					else
						$err = 'You have field(s) with missing data.';
				break;

				case 'rsk_edit':
				
					$tr_ct = $_POST['tr_ct'];
					$tr_day = $_POST['tr_day'];
					$elv_ct = isset($_POST['elv_ct']) ? $_POST['elv_ct'] : 0;
					$postlvl = $_POST['lvl'];
					$postelv = $_POST['elv'];
					$id = $_GET['rskid'];
					$comp = isset($_POST['company']) ? $_POST['company'] : $_COOKIE['company'];
					
					if($tr_ct != '' and $tr_day != '' and $postelv != '' and $postlvl != '')
					{
						//check numeric values
						if(is_numeric($tr_ct) and is_numeric($tr_day) and is_numeric($elv_ct))
						{
							if($tr_ct > 0)
							{
								if($postelv == 'E1' OR $postelv == 'E2')
								{
									if($elv_ct > 0)
									{
										//proceed to insert
										
										$que = "
											UPDATE tblalertsettingrsk
											   SET TR_CT = :tr_ct
											      ,TR_DAY = :tr_day
											      ,LVL = :postlvl
											      ,ELV_RSK = :postelv
											      ,ELV_CT = :elv_ct

											 WHERE ID = :id
										";

										try{
											$sth = $set->con->prepare($que);
											$sth->bindParam(':id',$id);
											$sth->bindParam(':tr_ct',$tr_ct);
											$sth->bindParam(':tr_day',$tr_day);
											$sth->bindParam(':postlvl',$postlvl);
											$sth->bindParam(':postelv',$postelv);
											$sth->bindParam(':elv_ct',$elv_ct);
											$sth->execute();
										}
										catch (Exception $e)
										{
											$err = $set->con->error;
										}
									}
									else
										$err = 'Invalid elevated risk factor "n" value.';
								}
								else
								{
									//proceed to insert
										if($set->provider == 'MSSQL')
										$que = "EXEC EDIT_RISK_SETTINGS $tr_ct,$tr_day,$postlvl,'$postelv',$elv_ct,$id";
										else
										$que = "
											UPDATE tblalertsettingrsk
											   SET TR_CT = :tr_ct
											      ,TR_DAY = :tr_day
											      ,LVL = :postlvl
											      ,ELV_RSK = :postelv
											      ,ELV_CT = :elv_ct
											 WHERE ID = :id
										";

										try{
											$sth = $set->con->prepare($que);
											$sth->bindParam(':id',$id);
											$sth->bindParam(':tr_ct',$tr_ct);
											$sth->bindParam(':tr_day',$tr_day);
											$sth->bindParam(':postlvl',$postlvl);
											$sth->bindParam(':postelv',$postelv);
											$sth->bindParam(':elv_ct',$elv_ct);
											$sth->execute();
										}
										catch (Exception $e)
										{
											$err = $set->con->error;
										}
								}

									//redirect or notify
									$_GET['mod'] = $err != '' ? $_GET['mod'] : 'rsk';
									$_GET['comp'] = $comp;
							}
							else
								$err = 'Values for Number of Transactions and Business Day must be greater than zero (0).';
						}
						else
							$err = 'You have field(s) that expects numeric value only.';
					}
					else
						$err = 'You have field(s) with missing data.';
				break;
				case 'fctr_add':
				
					$postrcode = $_POST['rcode'];
					$postxval = $_POST['xval'];
					$postyval = $_POST['yval'];
					$postramt = $_POST['ramt'];
					$base = $_GET['ref'];
					$comp = isset($_POST['company']) ? $_POST['company'] : $_COOKIE['company'];
					
					if($postxval != '' and $postyval != '')
					{
						//check numeric values
						if(is_numeric($postxval) and is_numeric($postyval))
						{
							if($postxval > 0 and $postyval > 0)
							{
								
									//proceed to insert
									
									$que = "
										INSERT INTO tblalertsettingfctr
									           (BASE
									           ,RCODE
									           ,X
									           ,Y
									           ,CT
									           ,COMPANY)
									     VALUES
									           (:base
									           ,:postrcode
									           ,:postxval
									           ,:postyval
									           ,:postramt
									           ,:comp)
									";

									try{
										$sth = $set->con->prepare($que);
										$sth->bindParam(':base',$base);
										$sth->bindParam(':postrcode',$postrcode);
										$sth->bindParam(':postxval',$postxval);
										$sth->bindParam(':postyval',$postyval);
										$sth->bindParam(':postramt',$postramt);
										$sth->bindParam(':comp',$comp);
										$sth->execute();
									}
									catch (Exception $e)
									{
										$err = $set->con->error;
									}

									//redirect or notify
									$_GET['mod'] = $err != '' ? $_GET['mod'] : 'fctr';
							}
							else
								$err = 'Values for X or Y must be greater than zero (0).';
						}
						else
							$err = 'You have field(s) that expects numeric value only.';
					}
					else
						$err = 'You have field(s) with missing data.';
				break;

				case 'fctr_edit':
				
					$postrcode = $_POST['rcode'];
					$postxval = $_POST['xval'];
					$postyval = $_POST['yval'];
					$postramt = $_POST['ramt'];
					$id = $_GET['fctrid'];
					
					if($postxval != '' and $postyval != '')
					{
						//check numeric values
						if(is_numeric($postxval) and is_numeric($postyval))
						{
							if($postxval > 0 and $postyval > 0)
							{
								
									//proceed to insert
									if($set->provider == 'MSSQL')
									$que = "EXEC EDIT_FCTR_SETTINGS '$postrcode',$postxval,$postyval,$postramt,$id";
									else
									$que = "
										UPDATE tblalertsettingfctr
										   SET RCODE = :postrcode
										      ,X = :postxval
										      ,Y = :postyval
										      ,CT = :postramt
										 WHERE ID = :id
									";

									try{
										$sth = $set->con->prepare($que);
										$sth->bindParam(':id',$id);
										$sth->bindParam(':postrcode',$postrcode);
										$sth->bindParam(':postxval',$postxval);
										$sth->bindParam(':postyval',$postyval);
										$sth->bindParam(':postramt',$postramt);
										$sth->execute();
									}
									catch (Exception $e)
									{
										$err = $set->con->error;
									}

									//redirect or notify
									$_GET['mod'] = $err != '' ? $_GET['mod'] : 'fctr';
							}
							else
								$err = 'Values for X or Y must be greater than zero (0).';
						}
						else
							$err = 'You have field(s) that expects numeric value only.';
					}
					else
						$err = 'You have field(s) with missing data.';
				break;

				

				
				case 'store':
						switch($_GET['sub'])
						{
							case 'addstr':
								
								//add store
								$storenme = $_POST['strnme'];
								$storecde = $_POST['strcde'];
								$mrcid = $_POST['mrcid'];
	

									//check for code dups
									$que = "select * from tblstore where STRCODE = ?";
									$sth = $set->con->prepare($que);
									$sth->execute(array($storecde));
									$numsql = sizeof($sth->fetch_array(MYSQLI_NUM));
									if($numsql == 0)
									{

										$que = "insert into tblstore(STORE,STRCODE,MERCHANT_ID) 
											VALUES('$storenme','$storecde','$mrcid')";
										
										try{
											$set->con->exec($que);
											$suc = 'New store has been successfully added.';
											$_GET['sub'] = '';
										}
										catch (Exception $e)
										{
											$err = $set->con->error;
										}
									}
									else
										$err = 'Store code already exist.';


							break;
							case 'editstr':
								//update store
								$storenme = $_POST['strnme'];
								$storecde = $_POST['strcde'];
								$mrcntcde = $_POST['mrcid'];

									if($_POST['strcde2'] != $storecde)
									{
										//check for code dups
										$que = "select * from tblstore where STRCODE = '$storecde'";
										$sth = $set->con->prepare($que);
										$sth->execute(array($storecde));
										$numsql = sizeof($sth->fetch_array(MYSQLI_NUM));

										if($numsql == 0)
										$trig = 1;
										else
										$err = 'Store code already exist.';
									}
									else
										$trig = 1;

									if($trig == 1)
									{
										$que = "update tblstore set STORE = '$storenme', STRCODE = '$storecde', MERCHANT_ID = '$mrcntcde' where ID = ".$_POST['strid'];
										
										try{
											$set->con->exec($que);
											$suc = 'Record has been updated.';
											$_GET['sub'] = '';
										}
										catch (Exception $e)
										{
											$err = $set->con->error;
										}

									}
									
							break;
						}		
				break;


				default:
				
					$alrt_id = $_GET['ref'];
					$alrt_nme = $_POST['altnme'];
					$alrt_stat = $_POST['stat'];
					$alrt_every = $_POST['every'];
					$alrt_ite = isset($_POST['ite']) ? $_POST['ite'] : 0;
					$alrt_gra = isset($_POST['gra']) ? $_POST['gra'] : 0;
					$alrt_spend = isset($_POST['spend']) ? $_POST['spend'] : 0;
					$alrt_start_dte = $_POST['start_dte'];
					$alrt_aging = isset($_POST['aging']) ? $_POST['aging'] : 0;
					$alrt_rem = $_POST['remarks'];

					if($alrt_stat == 1)
					{
						if(isset($alrt_id) != '' AND isset($alrt_nme) != '' AND
							isset($alrt_every) AND isset($alrt_start_dte) AND isset($alrt_aging))
						{
							if(is_numeric($alrt_every))
							{
								if(is_numeric($alrt_aging))
								{
									//check if date is valid and not yet passed
									$cdte = date("Ymd");
									$dte = str_replace("-","",$alrt_start_dte);
									if($dte > $cdte)
									{
							
										$uq = "
												 UPDATE tblalertsettings
												   SET ALERT = :alrt_nme
												      ,EVERY = :alrt_every
												      ,ITERATIVE = :alrt_ite
												      ,GRACE = :alrt_gra
												      ,AGE_THRS_HLD = :alrt_aging
												      ,SPEND_LEVEL = :alrt_spend
												      ,START_RUN = :alrt_start_dte
												      ,NEXT_RUN = NULL
												      ,ACTIVE = :alrt_stat
												      ,REMARKS = :alrt_rem
												      ,LASTUPDATE = :updte
												      ,UPDATEDBY = :adminid
												 WHERE ID = :alrt_id

										";

										try{
											$sth = $set->con->prepare($uq);
											$sth->bindParam(':alrt_nme',$alrt_nme);
											$sth->bindParam(':alrt_every',$alrt_every);
											$sth->bindParam(':alrt_ite',$alrt_ite);
											$sth->bindParam(':alrt_gra',$alrt_gra);
											$sth->bindParam(':alrt_aging',$alrt_aging);
											$sth->bindParam(':alrt_spend',$alrt_spend);
											$sth->bindParam(':alrt_start_dte',$alrt_start_dte);
											$sth->bindParam(':alrt_stat',$alrt_stat);
											$sth->bindParam(':alrt_rem',$alrt_rem);
											$sth->bindParam(':updte',$inidatetime);
											$sth->bindParam(':adminid',$_COOKIE['adminid']);
											$sth->bindParam(':alrt_id',$alrt_id);
											$sth->execute();

											$suc = 'Report settings has been successfully updated.';
										}
										catch (Exception $e)
										{
											$err = $set->con->error;
										}
											

									}
									else
										$err = 'Invalid Start Date. It should be later than today.';
								}
								else
									$err = 'Invalid Aging Threshold. Please provide valid numeric value.';
							}
							else
								$err = 'Invalid Cycle Schedule. Please provide valid numeric value.';
						}
						else
							$err = 'You have field(s) with missing data.';
					}
					else
					{
							$uq = "
									UPDATE tblalertsettings
									   SET 
									      ACTIVE = :alrt_stat
									      ,LASTUPDATE = :updte
									      ,UPDATEDBY = :adminid
									      
									 WHERE ID = :alrt_id

							";

							try{
								$sth = $set->con->prepare($uq);
								$sth->bindParam(':alrt_stat',$alrt_stat);
								$sth->bindParam(':updte',$inidatetime);
								$sth->bindParam(':adminid',$_COOKIE['adminid']);
								$sth->bindParam(':alrt_id',$alrt_id);
								$sth->execute();
								$suc = 'Report settings has been successfully updated.';
							}
							catch (Exception $e)
							{
								$err = $set->con->error;
							}
								
					}

					$_GET['mod'] = $err != '' ? 'set' : '';
				}//end mod switch

			break;
			case 'alert':
				switch($_GET['sub'])
				{
					case 'upe':
					case 'neg':
					case 'eli':
					case 'exp':
					case 'pts':
					case 'tfr':
						
							$mm = strlen($_POST['mm']) == 1 ? '0'.$_POST['mm'] : $_POST['mm'];
							$dd = strlen($_POST['dd']) == 1 ? '0'.$_POST['dd'] : $_POST['dd'];
							$yy = $_POST['yy'];

							
							$postdte = $yy.'-'.$mm.'-'.$dd;
							if($postdte == '--')
							{}
							else
							{
								if($yy!='' and $mm!='' and $dd!='')
								{

									switch ($mm) {
										case '02':
											if($yy%2 == 0)
											{
												if($dd > 29)
													$err = "Invalid date range.";

											}
											else
											{
												if($dd > 28)
													$err = "Invalid date range.";
											}
											break;

										case '04':
										case '06':
										case '09':
										case '11':
											if($dd > 30)
													$err = "Invalid date range.";
										break;
									}

								}
								else
									$err = "Invalid date range.";
							}	
								

							$mm2 = strlen($_POST['mm2']) == 1 ? '0'.$_POST['mm2'] : $_POST['mm2'];
							$dd2 = strlen($_POST['dd2']) == 1 ? '0'.$_POST['dd2'] : $_POST['dd2'];
							$yy2 = $_POST['yy2'];

							
							$postdte2 = $yy2.'-'.$mm2.'-'.$dd2;
							if($postdte2 == '--')
								{}
							else
							{
								if($yy2!='' and $mm2!='' and $dd2!='')
								{
									switch ($mm2) {
										case '02':
											if($yy2%2 == 0)
											{
												if($dd2 > 29)
													$err = "Invalid date range.";

											}
											else
											{
												if($dd2 > 28)
													$err = "Invalid date range.";
											}
											break;

										case '04':
										case '06':
										case '09':
										case '11':
											if($dd2 > 30)
													$err = "Invalid date range.";
										break;
									}

								}
								else
									$err = "Invalid date range.";
							}
							
								
							$dt1 = $yy.$mm.$dd;
							$dt2 = $yy2.$mm2.$dd2;

							if($dt1 > $dt2)
								$err = "Invalid date range.";
						
					break;
					/*
					case 'exp':
						
							$mm = strlen($_POST['mm']) == 1 ? '0'.$_POST['mm'] : $_POST['mm'];
							
							$postdte = $_POST['yy'].'-'.$mm;

							$mm2 = strlen($_POST['mm2']) == 1 ? '0'.$_POST['mm2'] : $_POST['mm2'];
							
							$postdte2 = $_POST['yy2'].'-'.$mm2;

							$dt1 = $_POST['yy'].$mm;
							$dt2 = $_POST['yy2'].$mm2;

							if($dt1 > $dt2)
								$err = "Invalid date range.";
						
					break;*/
				}
			break;

			case 'history':
					$mm = strlen($_POST['mm']) == 1 ? '0'.$_POST['mm'] : $_POST['mm'];
					$dd = strlen($_POST['dd']) == 1 ? '0'.$_POST['dd'] : $_POST['dd'];
					$yy = $_POST['yy'];
					
					$postdte = $yy.'-'.$mm.'-'.$dd;
					if($postdte == '--')
						{}
					else
					{
						if($yy!='' and $mm!='' and $dd!='')
						{
							switch ($mm) {
										case '02':
											if($yy%2 == 0)
											{
												if($dd > 29)
													$err = "Invalid date range.";

											}
											else
											{
												if($dd > 28)
													$err = "Invalid date range.";
											}
											break;

										case '04':
										case '06':
										case '09':
										case '11':
											if($dd > 30)
													$err = "Invalid date range.";
										break;
									}
						}
						else
							$err = "Invalid date range.";
					}	

					$mm2 = strlen($_POST['mm2']) == 1 ? '0'.$_POST['mm2'] : $_POST['mm2'];
					$dd2 = strlen($_POST['dd2']) == 1 ? '0'.$_POST['dd2'] : $_POST['dd2'];
					$yy2 = $_POST['yy2'];

					$postdte2 = $yy2.'-'.$mm2.'-'.$dd2;
					if($postdte2 == '--')
						{}
					else
					{
						if($yy2!='' and $mm2!='' and $dd2!='')
						{
							switch ($mm2) {
										case '02':
											if($yy2%2 == 0)
											{
												if($dd2 > 29)
													$err = "Invalid date range.";

											}
											else
											{
												if($dd2 > 28)
													$err = "Invalid date range.";
											}
											break;

										case '04':
										case '06':
										case '09':
										case '11':
											if($dd2 > 30)
													$err = "Invalid date range.";
										break;
									}
						}
						else
							$err = "Invalid date range.";
					}

					$dt1 = $_POST['yy'].$mm.$dd;
					$dt2 = $_POST['yy2'].$mm2.$dd2;

					if($dt1 > $dt2)
						$err = "Invalid date range.";
				
				
			break;

			case 'monitor':
				switch($_GET['mod'])
				{
					case 'case':
					case 'cardview':
							if($_POST['postmodule'] != 'All')
							$postmodule = "and a.ALERT = '".$_POST['postmodule']."'";

							$postmoduleval = $_POST['postmodule'];

							$mm = strlen($_POST['mm']) == 1 ? '0'.$_POST['mm'] : $_POST['mm'];
							$dd = strlen($_POST['dd']) == 1 ? '0'.$_POST['dd'] : $_POST['dd'];

							$postdte = $_POST['yy'].'-'.$mm.'-'.$dd;

							$mm2 = strlen($_POST['mm2']) == 1 ? '0'.$_POST['mm2'] : $_POST['mm2'];
							$dd2 = strlen($_POST['dd2']) == 1 ? '0'.$_POST['dd2'] : $_POST['dd2'];

							$postdte2 = $_POST['yy2'].'-'.$mm2.'-'.$dd2;

							$dt1 = $_POST['yy'].$mm.$dd;
							$dt2 = $_POST['yy2'].$mm2.$dd2;

							if($dt1 > $dt2)
								$err = "Invalid date range.";

					break;
					case 'aging':
							
							$postmodule = "and ALERT = '".$_POST['postmodule']."'";
							$postmoduleval = $_POST['postmodule'];
					break;
					case 'userlog':
						//filter date time

								$mm = strlen($_POST['mm']) == 1 ? '0'.$_POST['mm'] : $_POST['mm'];
								$dd = strlen($_POST['dd']) == 1 ? '0'.$_POST['dd'] : $_POST['dd'];
								$yy = $_POST['yy'];
								
								$postdte = $yy.'-'.$mm.'-'.$dd;
								if($postdte == '--')
									{}
								else
								{
									if($yy!='' and $mm!='' and $dd!='')
									{
										switch ($mm) {
													case '02':
														if($yy%2 == 0)
														{
															if($dd > 29)
																$err = "Invalid date range.";

														}
														else
														{
															if($dd > 28)
																$err = "Invalid date range.";
														}
														break;

													case '04':
													case '06':
													case '09':
													case '11':
														if($dd > 30)
																$err = "Invalid date range.";
													break;
												}
									}
									else
										$err = "Invalid date range.";
								}	

								$hh = strlen($_POST['hh']) == 1 ? '0'.$_POST['hh'] : $_POST['hh'];
								$mi = strlen($_POST['mi']) == 1 ? '0'.$_POST['mi'] : $_POST['mi'];
								
								$posttime = $hh.':'.$mi;
								if($posttime == '--')
									{}
								else
								{
									if($hh!='' and $mi!='')
									{
																			}
									else
										$err = "Invalid time range.";
								}	


								$mm2 = strlen($_POST['mm2']) == 1 ? '0'.$_POST['mm2'] : $_POST['mm2'];
								$dd2 = strlen($_POST['dd2']) == 1 ? '0'.$_POST['dd2'] : $_POST['dd2'];
								$yy2 = $_POST['yy2'];

								$postdte2 = $yy2.'-'.$mm2.'-'.$dd2;
								if($postdte2 == '--')
									{}
								else
								{
									if($yy2!='' and $mm2!='' and $dd2!='')
									{
										switch ($mm2) {
													case '02':
														if($yy2%2 == 0)
														{
															if($dd2 > 29)
																$err = "Invalid date range.";

														}
														else
														{
															if($dd2 > 28)
																$err = "Invalid date range.";
														}
														break;

													case '04':
													case '06':
													case '09':
													case '11':
														if($dd2 > 30)
																$err = "Invalid date range.";
													break;
												}
									}
									else
										$err = "Invalid date range.";
								}

								$hh2 = strlen($_POST['hh2']) == 1 ? '0'.$_POST['hh2'] : $_POST['hh2'];
								$mi2 = strlen($_POST['mi2']) == 1 ? '0'.$_POST['mi2'] : $_POST['mi2'];
								
								$posttime2 = $hh2.':'.$mi2;
								if($posttime2 == '--')
									{}
								else
								{
									if($hh2!='' and $mi2!='')
									{
										
									}
									else
										$err = "Invalid time range.";
								}

								$dt1 = $_POST['yy'].$mm.$dd;
								$dt2 = $_POST['yy2'].$mm2.$dd2;

								if($dt1 > $dt2)
									$err = "Invalid date range.";

								$tm1 = $hh.$mi;
								$tm2 = $hh2.$mi2;

								if($tm1 > $tm2)
									$err = "Invalid time range.";
								
							//end filter date time
					break;
				}
			break;

		}//end switch

	}//end if
	elseif($_GET['page']=='user' and $_GET['sub'] == 'dec' and $_GET['id'] != '')
	{
		echo '
				<script>
					var ans = confirm("You want to deactivate this user?");
					if(ans)
						document.location = "?page=user&sub=deact&id='.$_GET['id'].'"
				</script>
		';
	}
	elseif($_GET['page']=='user' and $_GET['sub'] == 'deact' and $_GET['id'] != '')
	{
		$_user = new UserSettings;
		$delid = $_GET['id'];
		$que = "update TBLADMIN set STATUS = 'InActive' where ID = ".$delid;
		
		if($sth = $_user->con->prepare($que))
		{
			$sth->execute();	
			$suc = "User has been deactivated.";
		}
		else
		{
			$err = $_user->con->error;
		}
				
	}
	elseif($_GET['page']=='user' and $_GET['sub'] == 'deluser' and $_GET['id'] != '')
	{
		echo '
				<script>
					var ans = confirm("You want to permanently delete this user?");
					if(ans)
						document.location = "?page=user&sub=delusergo&id='.$_GET['id'].'"
				</script>
		';
	}
	elseif($_GET['page']=='user' and $_GET['sub'] == 'delusergo' and $_GET['id'] != '')
	{
		$_user = new UserSettings;
		$delid = $_GET['id'];

		if($delid > 0 and $delid != '')
		{
			$delAd = "delete from TBLADMIN where ID = ".$delid;
			$delPerm = "delete from TBLADMINPERM where ADMINID = ".$delid;
		}
		
		try {
			
			$sth = $_user->con->prepare($delAd);
			$sth->execute();

			$sth = $_user->con->prepare($delPerm);
			$sth->execute();

			$suc = "User has been deleted.";
		}
		catch (Exception $e)
		{
			$err = $_user->con->error;
		}
				
	}
	elseif($_GET['page']=='rpt' and $_GET['sub'] == 'del' and $_GET['metric'] != '')
	{
		echo '
				<script>
					var ans = confirm("You want to permanently delete this parameter?");
					if(ans)
						document.location = "?page=rpt&sub=delgo&metric='.$_GET['metric'].'"
				</script>
		';
	}
	elseif($_GET['page']=='rpt' and $_GET['sub'] == 'delgo' and $_GET['metric'] != '')
	{
		$set = new Settings;
		$delid = $_GET['metric'];


			$delParam = "delete from rpt_param where METRICID = ".$delid;
			$delFilter = "delete from rpt_filters_all where METRICID = ".$delid;
		
		
		try {
			
			$sth = $set->con->prepare($delParam);
			$sth->execute();

			$sth = $set->con->prepare($delFilter);
			$sth->execute();

			$suc = "Parameter has been deleted.";
		}
		catch (Exception $e)
		{
			$err = $set->con->error;
		}
				
	}
	elseif($_GET['page']=='user' and $_GET['sub'] == 'rea' and $_GET['id'] != '')
	{
		echo '
				<script>
					var ans = confirm("You want to Re-activate this user?");
					if(ans)
						document.location = "?page=user&sub=react&id='.$_GET['id'].'"
				</script>
		';
	}
	elseif($_GET['page']=='user' and $_GET['sub'] == 'react' and $_GET['id'] != '')
	{
		$_user = new UserSettings;
		$delid = $_GET['id'];
		$que = "update TBLADMIN set STATUS = 'Active' where ID = ".$delid;
		try {
			$sth = $_user->con->prepare($que);
			$sth->execute();	
			$suc = "User has been Re-activated.";
		}
		catch (Exception $e)
		{
			$err = $_user->con->error;
		}		
	}
	elseif($_GET['del']!='')
	{
		if($_GET['del'] == 1)
		{
			if($_GET['mod'] == 'rsk')
			echo '<script>
						var ans = confirm("Delete this risk level permanently?");
						if(ans)
							document.location="?page='.$_GET['page'].'&mod=rsk&ref='.$_GET['ref'].'&rskid='.$_GET['rskid'].'&del=2&comp='.$_GET['comp'].'"
					</script>';
			elseif($_GET['mod'] == 'typ')
			echo '<script>
						var ans = confirm("Delete this alert type permanently?");
						if(ans)
							document.location="?page='.$_GET['page'].'&mod=typ&ref='.$_GET['ref'].'&typid='.$_GET['typid'].'&del=2"
					</script>';
			else
			echo '<script>
						var ans = confirm("Delete this risk factor permanently?");
						if(ans)
							document.location="?page='.$_GET['page'].'&mod=fctr&ref='.$_GET['ref'].'&fctrid='.$_GET['fctrid'].'&del=2&comp='.$_GET['comp'].'"
					</script>';
		}
		elseif($_GET['del'] == 2)
		{
			if($_GET['mod'] == 'rsk')
			{
				$dq = "delete from tblalertsettingrsk where ID = ".$_GET['rskid']."
						";
				$da = "delete from tbladhocparam where RISK = ".$_GET['rskid']."";

				$txt = 'Risk Level';
			}
			elseif($_GET['mod'] == 'typ')
			{
				$dq = "delete from tblalertsettingtype where ID = ".$_GET['typid'];
				$txt = 'Alert Type';
			}
			else
			{
				$dq = "delete from tblalertsettingfctr where ID = ".$_GET['fctrid'];
				$txt = 'Risk Factor';
			}
			try {	

				$result = $set->con->exec($dq);
				if($da != '')
					$set->con->exec($da);

				$suc = $result." ".$txt." has been deleted.";
			}
			catch (Exception $e)
			{
				$err = $_user->con->error;
			}


		}
	}
	elseif($_GET['sub'] == 'delstr')
	{
		echo '<script>
				var	ans = confirm("Delete this store permanently?");
				if(ans)
					document.location="?page='.$_GET['page'].'&mod='.$_GET['mod'].'&delstr=1&trc='.$_GET['trc'].'";
				</script>';
	}
	elseif($_GET['delstr'] == 1){

		try {
			$que = "delete from tblstore where ID = ".$_GET['trc'];
			$sth = $set->con->prepare($que);
			$sth->execute();
			
			$suc = 'Record has been deleted.';
		} catch (Exception $e)
		{
			$err = $_user->con->error;
		}
	}
	elseif($_GET['page'] == 'rpt' and $_GET['sub'] == 'email')
	{
		include('modules/mail.php');
	}
	

?>
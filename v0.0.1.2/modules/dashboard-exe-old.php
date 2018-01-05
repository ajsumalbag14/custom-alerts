<?php
	
/***

	Report Parameters Execution

	0 - CNCL SLS
	7 - DISC %
	29 - VOIDS
***/	



//CLEAR VALUE
$que_reg = ''; $que_dis = ''; $que_str = ''; $que_rule = '';


$metricid = 0;
$outlier = 237;
$tbl = 'tbl_cncl';
$column = 'CNCLSLS';
$que = "select * from rpt_param a inner join rpt_filters_all b on a.METRICID = b.METRICID where a.METRICID = ".$metricid;

	if($sth = $set->con->query($que))
	{
		$rs = $sth->fetch_array(MYSQLI_ASSOC);

		if($rs['ID']!='')
		{
			/* DATE RANGE */

			/* REGION */

			$ureg = explode("#", $rs['REGION']);
			$nreg = '';
			foreach ($ureg as $val) {
				if($val != 'null')
				{
					if($nreg == '')
						$nreg = "'".$val."'";
					else
						$nreg = $nreg.",'".$val."'";
				}
			}


			/* DISTRICT */
			$udis = explode("#", $rs['DISTRICT']);
			$ndis = '';
			foreach ($udis as $val) {
				if($val != 'null')
				{
					if($ndis == '')
						$ndis = "'".$val."'";
					else
						$ndis = $ndis.",'".$val."'";
				}
			}

			/* STORE */
			$ustr = explode("#", $rs['STORE']);
			$nstr = '';
			foreach ($ustr as $val) {
				if($val != 'null')
				{
					if($nstr == '')
						$nstr = "'".$val."'";
					else
						$nstr = $nstr.",'".$val."'";
				}
			}


			$que_reg = $nreg != '' ? ' AND REGION in ('.$nreg.') ' : '';
			$que_dis = $ndis != '' ? ' AND DISTRICT in ('.$ndis.') ' : '';
			$que_str = $nstr != '' ? ' AND STORE in ('.$nstr.') ' : '';



			$u_rule = $rs['RULE'];
			$u_param1 = $rs['PARAM1'];
			$u_param2 = $rs['PARAM2'];

			switch($u_rule)
			{
				case 'LT':
					$que_rule = ' AND '.$column.' < '.$u_param1;
				break;
				case 'GT':
					$que_rule = ' AND '.$column.' > '.$u_param1;
				break;
				case 'BT':
					$que_rule = ' AND '.$column.' BETWEEN '.$u_param1.' AND '.$u_param2;
				break;
				case 'OT':
					$que_rule = ' AND '.$column.' > '.$outlier;
				break;
				default:

			}
		}//rs ID


		$q = "SELECT count(*) as CT FROM ".$tbl." where NOTI = 0 ".$que_reg.$que_dis.$que_str.$que_rule;

        //echo $q;

        if($st = $set->con->query($q))
        {
           	$row = $st->fetch_array(MYSQLI_ASSOC);
            $totcount_cncl = $row['CT'] > 0 ? $row['CT'] : 0;
            
        }
        else
        {
            $err = $set->con->error;
        }
		
	}
	else
		$err = $set->con->error;

//CLEAR VALUE
$que_reg = ''; $que_dis = ''; $que_str = ''; $que_rule = '';

$metricid = 7;
$outlier = 17.87;
$tbl = 'tbl_disc';
$column = 'DISC';
$que = "select * from rpt_param a inner join rpt_filters_all b on a.METRICID = b.METRICID where a.METRICID = ".$metricid;

	if($sth = $set->con->query($que))
	{
		$rs = $sth->fetch_array(MYSQLI_ASSOC);

		if($rs['ID']!='')
		{
			/* DATE RANGE */

			/* REGION */

			$ureg = explode("#", $rs['REGION']);
			$nreg = '';
			foreach ($ureg as $val) {
				if($val != 'null')
				{
					if($nreg == '')
						$nreg = "'".$val."'";
					else
						$nreg = $nreg.",'".$val."'";
				}
			}


			/* DISTRICT */
			$udis = explode("#", $rs['DISTRICT']);
			$ndis = '';
			foreach ($udis as $val) {
				if($val != 'null')
				{
					if($ndis == '')
						$ndis = "'".$val."'";
					else
						$ndis = $ndis.",'".$val."'";
				}
			}

			/* STORE */
			$ustr = explode("#", $rs['STORE']);
			$nstr = '';
			foreach ($ustr as $val) {
				if($val != 'null')
				{
					if($nstr == '')
						$nstr = "'".$val."'";
					else
						$nstr = $nstr.",'".$val."'";
				}
			}


			$que_reg = $nreg != '' ? ' AND REGION in ('.$nreg.') ' : '';
			$que_dis = $ndis != '' ? ' AND DISTRICT in ('.$ndis.') ' : '';
			$que_str = $nstr != '' ? ' AND STORE in ('.$nstr.') ' : '';



			$u_rule = $rs['RULE'];
			$u_param1 = $rs['PARAM1'];
			$u_param2 = $rs['PARAM2'];

			switch($u_rule)
			{
				case 'LT':
					$que_rule = ' AND '.$column.' < '.$u_param1;
				break;
				case 'GT':
					$que_rule = ' AND '.$column.' > '.$u_param1;
				break;
				case 'BT':
					$que_rule = ' AND '.$column.' BETWEEN '.$u_param1.' AND '.$u_param2;
				break;
				case 'OT':
					$que_rule = ' AND '.$column.' > '.$outlier;
				break;
				default:

			}
		}//rs ID


		$q = "SELECT count(*) as CT FROM ".$tbl." where NOTI = 0 ".$que_reg.$que_dis.$que_str.$que_rule;

        //echo $q;

        if($st = $set->con->query($q))
        {
           	$row = $st->fetch_array(MYSQLI_ASSOC);
            $totcount_disc = $row['CT'] > 0 ? $row['CT'] : 0;
            
        }
        else
        {
            $err = $set->con->error;
        }
		
	}
	else
		$err = $set->con->error;

//CLEAR VALUE
$que_reg = ''; $que_dis = ''; $que_str = ''; $que_rule = '';

$metricid = 29;
$outlier =  364;
$tbl = 'tbl_void';
$column = 'VOID';
$que = "select * from rpt_param a inner join rpt_filters_all b on a.METRICID = b.METRICID where a.METRICID = ".$metricid;

	if($sth = $set->con->query($que))
	{
		$rs = $sth->fetch_array(MYSQLI_ASSOC);

		if($rs['ID']!='')
		{
			/* DATE RANGE */

			/* REGION */

			$ureg = explode("#", $rs['REGION']);
			$nreg = '';
			foreach ($ureg as $val) {
				if($val != 'null')
				{
					if($nreg == '')
						$nreg = "'".$val."'";
					else
						$nreg = $nreg.",'".$val."'";
				}
			}


			/* DISTRICT */
			$udis = explode("#", $rs['DISTRICT']);
			$ndis = '';
			foreach ($udis as $val) {
				if($val != 'null')
				{
					if($ndis == '')
						$ndis = "'".$val."'";
					else
						$ndis = $ndis.",'".$val."'";
				}
			}

			/* STORE */
			$ustr = explode("#", $rs['STORE']);
			$nstr = '';
			foreach ($ustr as $val) {
				if($val != 'null')
				{
					if($nstr == '')
						$nstr = "'".$val."'";
					else
						$nstr = $nstr.",'".$val."'";
				}
			}


			$que_reg = $nreg != '' ? ' AND REGION in ('.$nreg.') ' : '';
			$que_dis = $ndis != '' ? ' AND DISTRICT in ('.$ndis.') ' : '';
			$que_str = $nstr != '' ? ' AND STORE in ('.$nstr.') ' : '';



			$u_rule = $rs['RULE'];
			$u_param1 = $rs['PARAM1'];
			$u_param2 = $rs['PARAM2'];

			switch($u_rule)
			{
				case 'LT':
					$que_rule = ' AND '.$column.' < '.$u_param1;
				break;
				case 'GT':
					$que_rule = ' AND '.$column.' > '.$u_param1;
				break;
				case 'BT':
					$que_rule = ' AND '.$column.' BETWEEN '.$u_param1.' AND '.$u_param2;
				break;
				case 'OT':
					$que_rule = ' AND '.$column.' > '.$outlier;
				break;
				default:

			}
		}//rs ID


		$q = "SELECT count(*) as CT FROM ".$tbl." where NOTI = 0 ".$que_reg.$que_dis.$que_str.$que_rule;

        //echo $q;

        if($st = $set->con->query($q))
        {
           	$row = $st->fetch_array(MYSQLI_ASSOC);
            $totcount_void = $row['CT'] > 0 ? $row['CT'] : 0;
            
        }
        else
        {
            $err = $set->con->error;
        }
		
	}
	else
		$err = $set->con->error;


			


	
	



?>
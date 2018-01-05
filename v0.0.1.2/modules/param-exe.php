<?php
	
/***

	Report Parameters Execution

	0 - CNCL SLS
	7 - DISC %
	29 - VOIDS
***/	

	switch($_GET['page'])
	{

		case 'cncl':
			$metricid = 0;
			$outlier = 237;
			$column = 'CNCLSLS';
		break;

		case 'disc':
			$metricid = 7;
			$outlier = 17.87;
			$column = 'DISC';
		break;

		case 'void':
			$metricid = 29;
			$outlier =  364;
			$column = 'VOID';
		break;
	}


	$que = "select * from rpt_param a inner join rpt_filters_all b on a.ID = b.PARAMID where a.METRICID = ".$metricid;
	//echo $que;
	$sth = $set->con->query($que);

	if(!$sth->con->error)
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
		
	}
	else
		$err = $set->con->error;
		

	
	



?>
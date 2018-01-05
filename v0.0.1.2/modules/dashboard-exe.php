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
$tbl = 'tbl_cncl';
$column = 'CNCLSLS';

$q = "SELECT count(*) as CT FROM ".$tbl." where NOTI = 0 ";

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
	

//CLEAR VALUE
$que_reg = ''; $que_dis = ''; $que_str = ''; $que_rule = '';

$metricid = 7;
$tbl = 'tbl_disc';
$column = 'DISC';

$q = "SELECT count(*) as CT FROM ".$tbl." where NOTI = 0 ";

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
		

//CLEAR VALUE
$que_reg = ''; $que_dis = ''; $que_str = ''; $que_rule = '';

$metricid = 29;
$tbl = 'tbl_void';
$column = 'VOID';

$q = "SELECT count(*) as CT FROM ".$tbl." where NOTI = 0 ";

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
		


			


	
	



?>
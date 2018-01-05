<?php  
/*
  session_start();
  error_reporting(E_ALL ^ E_NOTICE);
  date_default_timezone_set('Asia/Manila');

  $mysqli = new mysqli('localhost:3306', 'root', '@rvinLASSU2017', 'zumiez');
  //$mysqli = new mysqli('localhost', 'idiscipl_cmp', 'dbm@sterIDL77', 'idiscipl_t4g216');


  if ($mysqli->connect_error) {
      die('Connect Error (' . $mysqli->connect_errno . ') '
              . $mysqli->connect_error);
  }
*/


  if(isset($_COOKIE['adminid']))
  {
    $set = new Settings;
    $expire=time()+60*$set->session;
    setcookie("adminuser",$_COOKIE['adminuser'],$expire,'/');
    setcookie("adminid",$_COOKIE['adminid'],$expire,'/');
    setcookie("access",$_COOKIE['access'],$expire,'/');
    setcookie("store",$_COOKIE['store'],$expire,'/');
    setcookie("loc",$_COOKIE['loc'],$expire,'/');
    setcookie("format",$_COOKIE['format'],$expire,'/');
    setcookie("company",$_COOKIE['company'],$expire,'/');
    setcookie("lob",$_COOKIE['lob'],$expire,'/');
  }

  if(!isset($_COOKIE["adminuser"]))
    { 
    if(isset($_GET['env']))
      die("Your session has expired.");
    else
      header("Location: login.php?logout=sessionexpired");
  }

  switch($_GET['page'])
  {
    case 'user': $navuser = 'active'; break;
    case 'setting': $navsetting = 'active'; break;
    case 'alert': $navalert = 'active'; break;
    case 'monitor': $navmonitor = 'active'; break;
    case 'msg': $navmsg = 'active'; break;
    case 'history': $navhist = 'active'; break;
    default:
      $navdash = 'active'; 
  }

  $var_name = $_COOKIE["adminuser"];
  $adminid = $_COOKIE["adminid"];
    
  //restrictions
  $res = array(6,3);
  foreach($res as $val)
  {
    if($val == $adminid)
    $rst = 'Yes';
  }


  $suf = '';
  if($_SESSION['MSUPER'] == 1)
  {
    $suf = "'Super'";
    $ar = 'Super';
  }
  if($_SESSION['MGLP'] == 1)
  { 
    $suf = $suf != '' ? $suf.",'GLP'" : "'GLP'";
    $ar = $ar != '' ? $ar.',GLP' : 'GLP';
    $adduser = 1;
  }
  if($_SESSION['MFORMAT'] == 1)
  {
    $suf = $suf != '' ? $suf.",'Format'" : "'Format'";
    $ar = $ar != '' ? $ar.',Format' : 'Format';
    $adduser = 1;
  }
  if($_SESSION['MSTORE'] == 1)
  {
    $suf = $suf != '' ? $suf.",'Manager'" : "'Manager'";
    $ar = $ar != '' ? $ar.',Manager' : 'Manager';
    $adduser = 1;
  }
  
  
    //access criteria
    if($_SESSION['PERMID']!='')
      $line = "WHERE ACCES in (".$suf.") AND ID <> $adminid";
    else
      $line = "WHERE ID <> $adminid"; 

  $_access = explode(",", $ar);

  //despostion values
  $_despo = array("DP01"=>"Normal Activity","DP02"=>"Inappropriate Activity");
  //sanctions
  $_sanc = array("SN01"=>"Employee Incident Report","SN02"=>"Termination","SN03"=>"Other (Refer to comment)");
  //cases
  $_case = array("Close"=>"Closed Cases","Open"=>"Open Cases");
  
  //findings
  $_findings = array("FD01"=>"Abuse","FD02"=>"Training Issue","FD03"=>"Other");

  $sqldatetime = date("Y-m-d G:i:s");


  // FUNCTION AREA //




?>
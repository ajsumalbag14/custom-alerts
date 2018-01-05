<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	date_default_timezone_set('Asia/Manila');


	//PROCESS LAPSE TRACK
	$time_start = microtime(true);
    sleep(1);

	//SQL DATES
	$_default = new Settings;
	$_default->setYmd(date("Ymd"));
	$_default->setNoSpaceDate(date("YmdGis"));
	$_default->setSqlDate(date("Y-m-d G:i:s"));

	//URL Config / CONTANT
	$host = $_SERVER['REMOTE_ADDR'] == '::1' ? 'localhost' : $_SERVER['REMOTE_ADDR'];
	$_default->setUrl($host);
	$_default->setBaseHash('lassuapp');
	$_default->setHostName('lassuappp/v');

	$inidatetime = date("Y-m-d G:i:s");

	$mRandom = mt_rand(0, 1000000);
	
?>
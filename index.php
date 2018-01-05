<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	$prod = array("MySQL");
	$appname = "Lassu, Inc. App";
	$version = '0.0.1.2';
	$vd = "v".$version."/";
	include("lib.php");

	$_SESSION['test'] = 'Test';

	if($_SESSION['test'] == 'Test')
	{
	
			libxml_use_internal_errors(true);

			if($_POST['test'] == 'Test Connection')
			{

				if($_POST['server']!='' and $_POST['dbname']!='')
				{
					//setting maximum execution to 30mins
					set_time_limit(108000);

					//database credentials
					$server = $_POST['server'];
					$dbname = $_POST['dbname'];
					$user = $_POST['usr'];
					$pwd = $_POST['pwd'];

					if($_POST['provider'] == 'MSSQL')
					{
						$dsn = 'odbc:'.$server;

						 try {

				            $con = new PDO($dsn, $user, $pwd);
				            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				            $alert = '<div class="success">
									<b>Connection successful!</b>
									<input type="submit" name="save" value="Save" class="btn btn-success"></div>
									';

				        } catch (PDOException $e) {
							$alert=  '<div class="alert">
							<b>CONNECTION FAILED</b>
							<br>
							Unable to connect to the server ['.$server.']. 
							Please check your server configuration or network connection.
							<br>
							<small><b>Details:</b> '.$e->getMessage().'</small></div>';
						
						}
					}
					elseif($_POST['provider'] == 'ORACLE')
					{
						$dsn = 'oci:dbname=//'.$server.'/'.$dbname;

						 try {

				            $con = new PDO($dsn, $user, $pwd);
				            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				            $alert = '<div class="success">
									<b>Connection successful!</b>
									<input type="submit" name="save" value="Save" class="btn btn-success"></div>
									';

				        } catch (PDOException $e) {
							$alert=  '<div class="alert">
							<b>CONNECTION FAILED</b>
							<br>
							Unable to connect to the server ['.$server.']. 
							Please check your server configuration or network connection.
							<br>
							<small><b>Details:</b> '.$e->getMessage().'</small></div>';
						
						}
					}
					else
					{
						$dsn = 'mysql:host='.$server.';dbname'.$dbname;

						$mysqli = new mysqli('localhost:3306', $user, $pwd, $dbname);
						//$mysqli = new mysqli('localhost', $user, $pwd, $dbname);

						/*
						* This is the "official" OO way to do it,
						* BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
						*/
						if ($mysqli->connect_error) {

							$alert=  '<div class="alert">
							<b>CONNECTION FAILED</b>
							<br>
							Unable to connect to the server ['.$server.']. 
							Please check your server configuration or network connection.
							<br>
							<small><b>Details:</b> '.$mysqli->connect_error.'</small></div>';
						}
						else
						{
							$alert = '<div class="success">
									<b>Connection successful!</b>
									<input type="submit" name="save" value="Save" class="btn btn-success"></div>
									';
						}

						 
					}
				}
				else
					$alert = '<div class="alert">Server and Database name should not be empty.</div>';

			}
			elseif($_POST['save'] == 'Save')
			{

				if($_POST['server']!='' and $_POST['dbname']!='')
				{

					//mh02 pwd hashing
					$pass = mh02encrypt($_POST['pwd']);

					//echo $pass;

					//xml encoding
					$xml = new SimpleXmlElement('<config/>');
					$xml->appname = $appname;
					$xml->version = $version;
					$xml->provider = $_POST['provider'];
					$xml->server = $_POST['server'];
					$xml->database = $_POST['dbname'];
					$xml->usr = $_POST['usr'];
					$xml->pwd = $pass;
					$xml->max_exec_time = 10800;
					$xml->addChild("settings");
					$xml->settings->addChild("session_timeout","15");
					$xml->saveXML('config.xml');
					$xml->saveXML($vd.'config.xml');
					$xml->saveXML($vd.'modules/config.xml');
					//$xml->saveXML($vd.'control/config.xml');
					//$xml->saveXML($vd.'reports/config.xml');
					
					//redirect to home page
					header("Location: ".$vd);
				}
				else
					$alert = '<div class="alert">Server and Database name should not be empty.</div>';

			}
			else
			{

				if($_GET['bypass'] != 'ok')
				{
					$xml = simplexml_load_file("config.xml");
					if (!$xml) {
					    //echo "Failed loading XML: \n";
					    //foreach(libxml_get_errors() as $error) {
					    //    echo "\t", $error->message;
					   // }
					}
					else
					{
						if($xml->server != '' and $xml->database != '')
						{
							header("Location: ".$vd);
						}
					}
				}

			}

	}
	else
	{	$important =  '
		<div class="alert">
		<center>
			<h1>ACCESS DENIED</h1>
			<p>This browser is not allowing SESSION variables. Please try to use other browser.</p>
		</center>
		</div>
	';
	}
	//session check	

	print_r(PDO::getAvailableDrivers());

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Configuration | <?php echo $appname." ".$version?></title>

    <style type="text/css">
    	body{ font-family: Arial; text-align:center;}
    	.alert {color:red; font-size:11px; padding:5px}
    	.success {color:green; font-size:11px; padding:5px}
    </style>

</head>
<body>

<div class="container">
	<h1>Lassu, Inc. | App Version <?php echo $version?></h1>
	<h3>Configuration Set up</h3>
	<form action="?" method="post" style="background:#f2f2f2; padding:1em; margin:auto; width:300px">
		<?php
		if($alert!='') 
			echo $alert;
		
		if(!isset($important))
		{
		echo ' 
		<table>
		<tr>
			<td>Provider:</td>
			<td>
					<select name="provider">
					';
							foreach($prod as $val){
								if($val == $_POST['provider'])
									echo '<option value="'.$val.'" selected="selected">'.$val;
								else
									echo '<option value="'.$val.'">'.$val;
							}

		echo '
					</select>
			</td>
		</tr>
		<tr>
		<td>Host:</td> <td><input type="text" maxlength="100" name="server" value="'.$_POST['server'].'"></td>
		</tr>
		<tr>
		<td>Database / SID:</td> <td><input type="text" maxlength="20" name="dbname" value="'.$_POST['dbname'].'"></td>
		</tr>
		<tr>
		<td>Username:</td> <td><input type="text" maxlength="20" name="usr" value="'.$_POST['usr'].'"></td>
		</tr>
		<tr>
		<td>Password:</td> <td><input type="password" maxlength="20" name="pwd" value="'.$_POST['pwd'].'"></td>
		</tr>
		</table>
		<br>
		<input type="submit" name="test" value="Test Connection" class="btn btn-large">
		';
		}
		else
			echo $important;
		?>
	</form>
</div>
	<div id="footer">
		<p>&copy;2014-2017 <?php echo $appname." ".$version; ?> <a href="https://www.lassu.net" target="_blank">Lassu, Inc.</a></p>
	</div>
</body>
</html>
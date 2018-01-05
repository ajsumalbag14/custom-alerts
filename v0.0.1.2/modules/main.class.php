<?php
	
	require_once('ini.php');

	/**
	* Connection Settings
	*/
	class DbConnect
	{
		public $con;
		public $provider;
		public $appname;
		public $version;
		public $session;

		function __construct()
		{
			
			//extract xml config file
			libxml_use_internal_errors(true);
			$xml = simplexml_load_file("config.xml");
			if (!$xml) {
			    echo '<center>';
			    echo "<h1>Lassu, Inc.</h1>";
			    echo "<br>";
			    echo "Failed loading XML: \n";
			    foreach(libxml_get_errors() as $error) {
			        echo "\t", $error->message;
			    }
			    echo '
			    <br>Click 
			    <a href="../index.php?bypass=ok">Configuration Panel</a>
			    </center>';

			    die();
			}
			else
			{

				$user = $xml->usr;
				$dbname = $xml->database;
				$this->provider = $xml->provider;
				$this->appname = $xml->appname;
				$this->version = $xml->version;
				$this->session = $xml->settings->session_timeout;

				if($xml->provider == 'MSSQL')
				$dsn = 'odbc:'.$xml->server;
				elseif($xml->provider == 'ORACLE')
				$dsn = 'oci:dbname=//'.$xml->server.'/'.$xml->database;
				elseif($xml->provider == 'MySQL')
				$dsn = 'mysql:host='.$server.';dbname'.$dbname;

				$pwd = $xml->pwd;
				if($pwd!='')
				{
					$real = '';
					$bit = '';
					$array = explode("-", $pwd);
					$len2 = count($array);
					for($a=$len2-1; $a>=0; $a--)
					$real = $real.chr($array[$a]);
					
					$password = $real;
				}
				else
					$password = $pwd;

			}
			
	  

				$this->con = new mysqli('localhost:3306', $user, $password, $dbname);
				//$this->con = new mysqli('localhost', $user, $password, $dbname);

				/*
				* This is the "official" OO way to do it,
				* BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
				*/
				if ($this->con->connect_error) {
					die('Connect Error (' . $this->con->connect_errno . ') '
					      . $this->con->connect_error);
				}

		}

		   
		

		
	}


	/**
	* Settings
	*/
	class Settings extends DbConnect
	{

		protected $ymd;
		protected $sqldate;
		protected $nospacedate;
		protected $url;
		protected $basehash;
		protected $hostname;

			function getProvider(){
				return $this->provider;
			}

			function setBaseHash($var){
				return $this->basehash  = $var;
			}

			function setHostName($var){

				return $this->hostname = $var.$this->version;
			}

			function setAppName($app){
				return $this->appname = $app;
			}

			function getAppName(){
				return $this->appname;
			}

			function setVersion($ver){
				return $this->version = $ver;
			}

			function getVersion(){
				return $this->version;
			}

			function setUrl($url){
				return $this->url = $url;
			}

			function setYmd($ymd){
				return $this->ymd = $ymd;
			}

			function setNoSpaceDate($date){
				return $this->nospacedate = $date;
			}

			function getNoSpaceDate(){
				return $this->nospacedate;
			}

			function setSqlDate($sqldate){
				return $this->sqldate = $sqldate;
			}

			function getSqlDate(){
				return $this->sqldate;
			}



			//Dashboard Donut Function
			function getDonutVal($access,$lob,$company,$store,$mode,$dte){

				//force date
				//$dte = '2014-05-21';

				try {
					switch($access)
					{
						case 'Super': 
							$que = "select count(*) as CT from tblAlertTrxn where SENT_TO_ADMIN is null and RISK_FTR_CT = :mod and to_char(TRXN_DTE,'yyyy-mm-dd') = :dte";
							$sth = $this->con->prepare($que);
							$sth->bindParam(':mod',$mode);
							$sth->bindParam(':dte',$dte);	
						break;
						case 'GLP':
							if($lob == 'All')
							{
								$que = "select count(*) as CT from tblAlertTrxn where SENT_TO_ADMIN is null and RISK_FTR_CT = :mod and to_char(TRXN_DTE,'yyyy-mm-dd') = :dte";
								$sth = $this->con->prepare($que);
								$sth->bindParam(':mod',$mode);
								$sth->bindParam(':dte',$dte);
							}
							else
							{
								$ar_comp = $this->getLocQueryComp($lob);
								$que = "select count(*) as CT from tblAlertTrxn where SENT_TO_ADMIN is null and RISK_FTR_CT = :mod and to_char(TRXN_DTE,'yyyy-mm-dd') = :dte AND COMPANY IN (".$ar_comp.")";
								$sth = $this->con->prepare($que);
								$sth->bindParam(':mod',$mode);
								$sth->bindParam(':dte',$dte);
								//$sth->bindParam(':comp',$ar_comp);
							}
						break;
						case 'Format':
								$que = "select count(*) as CT from tblAlertTrxn where SENT_TO_ADMIN is null and RISK_FTR_CT = :mod and to_char(TRXN_DTE,'yyyy-mm-dd') = :dte AND COMPANY = :comp";
								$sth = $this->con->prepare($que);
								$sth->bindParam(':mod',$mode);
								$sth->bindParam(':dte',$dte);
								$sth->bindParam(':comp',$company);
						break;

						case 'Manager':		
							$que = "select count(*) as CT from tblAlertTrxn where SENT_TO_ADMIN is null and RISK_FTR_CT = :mod and to_char(TRXN_DTE,'yyyy-mm-dd') = :dte AND COMPANY = :comp AND STORE = :stor";
							$sth = $this->con->prepare($que);
							$sth->bindParam(':mod',$mode);
							$sth->bindParam(':dte',$dte);
							$sth->bindParam(':comp',$company);
							$sth->bindParam(':stor',$store);
						break;
					}
					
					$sth->execute();

					$rs = $sth->fetch_array(MYSQLI_ASSOC);

					return $rs['CT'];

				}
				catch (Exception $e)
				{
					return $this->con->error;
				}
				

			}

			function getImg($id){

				
				$que = "select IMG from TBLADMIN where ID = ".$id;
				if($sth = $this->con->query($que))
				{
					$rs = $sth->fetch_array(MYSQLI_ASSOC);
					
					return $rs['IMG'];
				}
				else
				{
					return $this->con->error;
				}

			}


			function getLocQuery($array_store,$mode)
			{
				//populate stores
				$loc = explode(",", $array_store);
					$len = count($loc);
					$ar_store = '';
					for($s=0;$s<$len;$s++)
					{
						if($loc[$s]!='')
						{
							$newstr = explode("#",$loc[$s]);
							if($mode == 'C')
								$ar = $newstr[1];
							else
								$ar = $newstr[0];

							if($ar_store == '')
							$ar_store = "'".$ar."'";
							else
							$ar_store = $ar_store.','."'".$ar."'";
		        		}
		        }

		        return $ar_store;
			}

			function getLocQueryTyp($array_store)
			{
				//populate stores
				$loc = explode(",", $array_store);
					$len = count($loc);
					$ar_store = '';
					for($s=0;$s<$len;$s++)
					{
						if($loc[$s]!='')
						{

							if($ar_store == '')
							$ar_store = "'".$loc[$s]."'";
							else
							$ar_store = $ar_store.','."'".$loc[$s]."'";
		        		}
		        }

		        return $ar_store;
			}
			

			function getLocQueryMerc($array_store)
			{
				try {
					//populate stores
					$loc = explode(",", $array_store);
						$len = count($loc);
						$ar_store = '';
						for($s=0;$s<$len;$s++)
						{
							if($loc[$s]!='')
							{
								//get all unique store id
								$que = "select BRANCH from tblstore where unicode = ? group by BRANCH";
								$sth = $this->con->prepare($que);
								$sth->execute(array($loc[$s]));
								while($rs = $sth->fetch_array(MYSQLI_ASSOC))
								{
									$newloc = $rs['BRANCH'];
									if($newloc!='')
									{
										if($ar_store == '')
										$ar_store = "'".$newloc."'";
										else
										$ar_store = $ar_store.','."'".$newloc."'";
									}
								}
			        	}
			        }

			        return $ar_store;
		    	}
		    	catch (Exception $e)
		    	{
		    		return $this->con->error;
		    	}	
			}

			function getLocQueryComp($lob)
			{
				try {
						$ar_store = '';
						//get all unique store id
						if($lob == 'All')
						{
							$que = "select CMPNY_CD from tblcompany group by CMPNY_CD";
							$sth = $this->con->prepare($que);
							$sth->execute();
						}
						else
						{
							$que = "select CMPNY_CD from tblcompany where BUS_GRP = ? group by CMPNY_CD";
							$sth = $this->con->prepare($que);
							$sth->execute(array($lob));
						}
						while($rs = $sth->fetch_array(MYSQLI_ASSOC))
						{
							$newloc = $rs['CMPNY_CD'];
							if($newloc!='')
							{
								if($ar_store == '')
								$ar_store = "'".$newloc."'";
								else
								$ar_store = $ar_store.','."'".$newloc."'";
							}
						}
			        	
			        

			        return $ar_store;
		    	}
		    	catch (Exception $e)
		    	{
		    		return $this->con->error;
		    	}	
			}

			
			function getMerchant($store){

				//get merchant_id 
				if($this->provider == 'MSSQL')
				$que = "SELECT top 1 STRCODE FROM tblstore WHERE unicode = ?";
				elseif($this->provider == 'ORACLE')
				$que = "SELECT * from ( select STORE FROM tblstore WHERE unicode = ? ) where ROWNUM = 1";
				elseif($this->provider == 'MySQL')
				$que = "SELECT STRCODE FROM tblstore WHERE unicode = ? limit 1";
					
				$sth = $this->con->prepare($que);
				$sth->execute(array($store));
				$rs = $sth->fetch_array(MYSQLI_ASSOC);

				return $rs['STORE'];

			}


			function getStoreName($code){

				try {
					if($this->provider == 'MSSQL')
					$que = "select top 1 UNISTR from tblstore where unicode = ?";
					elseif($this->provider == 'ORACLE')
					$que = "SELECT * from (select UNISTR from tblstore where unicode = ?) where ROWNUM = 1";
					elseif($this->provider == 'MySQL')
					$que = "select UNISTR from tblstore where unicode = ? limit 1";
					
					$st = $this->con->prepare($que);
					$st->execute(array($code));
					$rs = $st->fetch_array(MYSQLI_ASSOC);
					
					return $rs['UNISTR']; 
					
				}
				catch (Exception $e)
				{
					return $this->con->error;
				}
			}

			function getStoreName2($mer){

				if($this->provider == 'MSSQL')
				$que = "select top 1 STORE from tblstore where strcode = ?";
				elseif($this->provider == 'ORACLE')
				$que = "SELECT * from (select STORE from tblstore where STORE = ?) where ROWNUM = 1";
				elseif($this->provider == 'MySQL')
				$que = "select STORE from tblstore where strcode = ? limit 1";
				
				$sth = $this->con->prepare($que);
				$sth->execute(array($mer));
				$rs = $sth->fetch_array(MYSQLI_ASSOC);	
				

				return $rs['STORE']; 

			}

			function getCompanyName($code){

				try {
					if($this->provider == 'MSSQL')
					$que = "select top 1 COMPANY from tblstore where MERCHANT_ID = ?";
					elseif($this->provider == 'ORACLE')
					$que = "SELECT * from (select CMPNY_CD from tblCompany where CMPNY_CD = ?) where ROWNUM = 1";
					elseif($this->provider == 'MySQL')
					$que = "select COMPANY from tblstore where MERCHANT_ID = ? limit 1";
					
					$st = $this->con->prepare($que);
					$st->execute(array($code));
					$rs = $st->fetch_array(MYSQLI_ASSOC);
					
					return strtoupper($rs['COMPANY']); 
					
				}
				catch (Exception $e)
				{
					return $this->con->error;
				}
			}

			function getTender($ln,$comp){

				if($comp == 'SM MART INC.')
				{
					$comp = 'THE SM STORE';
				}


				try {
					//select EST_NO from tblCompany
					$qc = "select EST_NO from tblCompany where CMPNY_CD = ?";

					$st = $this->con->prepare($qc);
					$st->execute(array($comp));
					
					$rs = $st->fetch_array(MYSQLI_ASSOC);
					$estno = $rs['EST_NO'];
					
				

					$shrt = '';
					$ar_sm = array(5,8,49,74,76,80,82,84,85,94,101,228,230,290,292,38,35,267,125,213,78,37,113,44,185,184,32,250,58,186,126,81);
					foreach ($ar_sm as $val) {
						if($val == $estno)
							$shrt = 'Shoemart Inc.';
					}

					
					if($estno == 142)
						$shrt = 'Sanford';
					elseif($estno == 2)
						$shrt = 'Super SM';
					elseif ($estno == 7) {
						$shrt = 'SVI';
					}
					

					if($shrt != '')
					{
						$que = "select DISTINCT TNDR_DESC from tblTender where TNDR_LN_TYP = :ln AND CMPNY_SHRT_NM = :csn ";
						
						$st = $this->con->prepare($que);
						$st->bindParam(':ln',$ln);
						$st->bindParam(':csn',$shrt);
						$st->execute();

						$tndr = '';
						
						$rs = $st->fetch_array(MYSQLI_ASSOC);
						$tndr = $rs['TNDR_DESC'];
						
						return strtoupper($tndr); 
					}
					else
						return 'undefined';
						//return 'TNDR#'.$ln; 
					
				}
				catch (Exception $e)
				{
					return $this->con->error;
				}
			}

			//library modules
			function viewStore($selected)
			{

				$que = "select UNISTR,UNICODE from tblstore group by unistr,unicode  order by unistr asc";
				$sth = $this->con->prepare($que);
				$sth->execute();
				$option = '';
				while($rs = $sth->fetch_array(MYSQLI_ASSOC)){
						if($selected == $rs['UNICODE'])
						 	$option = $option.'<option value="'.$rs['UNICODE'].'" selected="selected">'.$rs['UNISTR'];
						else
							$option = $option.'<option value="'.$rs['UNICODE'].'">'.$rs['UNISTR'];
				}

				return $option;
			}

			function viewStore2($selected)
			{

				$que = "select UNISTR,UNICODE from tblstore group by unistr,unicode order by unistr asc";
				$sth = $this->con->prepare($que);
				$sth->execute();
				$option = '';
				while($rs = $sth->fetch_array(MYSQLI_ASSOC)){
						if($selected == $rs['UNICODE'])
						 	$option = $option.'<option value="'.$rs['UNICODE'].'" selected="selected">'.$rs['UNISTR'];
						else
							$option = $option.'<option value="'.$rs['UNICODE'].'">'.$rs['UNISTR'];
				}

				return $option;
			}

			function viewStore3($selected)
			{

				$que = "select UNISTR,UNICODE from tblstore group by unistr,unicode where unicode = ?";
				$sth = $this->con->prepare($que);
				$sth->execute(array($selected));
				$option = '';
				$rs = $sth->fetch_array(MYSQLI_ASSOC);	
					$option = $option.'<option value="'.$rs['UNICODE'].'">'.$rs['UNISTR'];

				return $option;
			}



			function viewStoreNew($access,$lob,$company,$selected)
			{
				
				$que = "select BRNCH_NM from tblcompany where BUS_GRP = :lob and CMPNY_CD = :comp group by BRNCH_NM order by BRNCH_NM asc";

				$sth = $this->con->prepare($que);
				$sth->bindParam(':lob',$lob);
				$sth->bindParam(':comp',$company);
				$sth->execute();
				$option = '';
				
				while($rs = $sth->fetch_array(MYSQLI_ASSOC)){

						if($selected == $rs['BRNCH_NM'])
						 	$option = $option.'<option value="'.$rs['BRNCH_NM'].'" selected="selected">'.$rs['BRNCH_NM'];
						else
							$option = $option.'<option value="'.$rs['BRNCH_NM'].'">'.$rs['BRNCH_NM'];
				}

				return $option;
			}

			function viewStoreSrch($access,$stores,$selected)
			{
				if($access == 'Area' or $access == 'GLP')
				{
					if($stores != 'All')
					{
						//populate stores
						$loc = explode(",", $stores);
			  			$len = count($loc);
			  			$newstore = '';
			  			for($s=0;$s<$len;$s++)
			  			{
			  				if($loc[$s]!='')
			  				{
			  					if($newstore == '')
			  					$newstore = "'".$loc[$s]."'";
			  					else
			  					$newstore = $newstore.','."'".$loc[$s]."'";
			            	}
			            }

			            $que = "select UNISTR,UNICODE from tblstore where unicode in (".$newstore.") group by unistr,unicode order by unistr asc";
					}
					else
						$que = "select UNISTR,UNICODE from tblstore group by unistr,unicode order by unistr asc";
				}
				else
					$que = "select UNISTR,UNICODE from tblstore group by unistr,unicode order by unistr asc";

				try {
					$sth = $this->con->prepare($que);
					$sth->execute();
					$option = '';
					
					while($rs = $sth->fetch_array(MYSQLI_ASSOC)){

						$unistr = strtoupper($rs['UNISTR']);
							if($selected == $rs['UNICODE'])
							 	$option = $option.'<option value="'.$rs['UNICODE'].'" selected="selected">'.$unistr;
							else
								$option = $option.'<option value="'.$rs['UNICODE'].'">'.$unistr;
					}
				}
				catch (Exception $e)
				{
					$option = $e->getMessage();
				}

				return $option;
			}

			function viewStoreSrch2($access,$company,$selected)
			{
				if($company == 'All')
				$que = "select BRNCH_NM from tblcompany group by BRNCH_NM order by BRNCH_NM asc";
				else
				$que = "select BRNCH_NM from tblcompany where CMPNY_CD = '".$company."' group by BRNCH_NM order by BRNCH_NM asc";
					
				try {
					$sth = $this->con->prepare($que);
					$sth->execute();
					$option = '';
					
					while($rs = $sth->fetch_array(MYSQLI_ASSOC)){

						$unistr = strtoupper($rs['BRNCH_NM']);
							if($selected == $rs['BRNCH_NM'])
							 	$option = $option.'<option value="'.$rs['BRNCH_NM'].'" selected="selected">'.$unistr;
							else
								$option = $option.'<option value="'.$rs['BRNCH_NM'].'">'.$unistr;
					}
				}
				catch (Exception $e)
				{
					$option = $e->getMessage();
				}

				return $option;
			}

			function viewCompany($access,$lob,$selected)
			{
				if($access != 'Super')
				{
					if($lob == 'All')
		        	$que = "select CMPNY_CD from tblcompany where BUS_GRP <> ? group by CMPNY_CD 
			            order by CMPNY_CD asc";
			        else
			       	$que = "select CMPNY_CD from tblcompany where BUS_GRP = ? group by CMPNY_CD 
			            order by CMPNY_CD asc";
					
					$sth = $this->con->prepare($que);
					$sth->execute(array($lob));
				}
				else
				{
					$que = "select CMPNY_CD from tblcompany group by CMPNY_CD 
			            order by CMPNY_CD asc";

			        $sth = $this->con->prepare($que);
					$sth->execute();
				}
				
				
				$option = '';
				
				while($rs = $sth->fetch_array(MYSQLI_ASSOC)){

					$comp = strtoupper($rs['CMPNY_CD']);
						if($selected == $rs['CMPNY_CD'])
						 	$option = $option.'<option value="'.$rs['CMPNY_CD'].'" selected="selected">'.$comp;
						else
							$option = $option.'<option value="'.$rs['CMPNY_CD'].'">'.$comp;
				}

				return $option;
				
			}

			function viewLob($selected)
			{
				
				$que = "select distinct BUS_GRP from tblcompany order by BUS_GRP asc";

		        $sth = $this->con->prepare($que);
				$sth->execute();
			
				
				
				$option = '';
				
				while($rs = $sth->fetch_array(MYSQLI_ASSOC)){

					$bus = strtoupper($rs['BUS_GRP']);
						if($selected == $rs['BUS_GRP'])
						 	$option = $option.'<option value="'.$rs['BUS_GRP'].'" selected="selected">'.$bus;
						else
							$option = $option.'<option value="'.$rs['BUS_GRP'].'">'.$bus;
				}

				return $option;
				
			}


			function viewCompanySrch($access,$lob,$selected)
			{
				
				if($lob == 'All' or !isset($lob))
				$que = "select CMPNY_CD from tblcompany group by CMPNY_CD 
	            order by CMPNY_CD asc";
				else	
        		$que = "select CMPNY_CD from tblcompany WHERE BUS_GRP = '".$lob."'  group by CMPNY_CD 
	            order by CMPNY_CD asc";
			
				
				$sth = $this->con->prepare($que);
				$sth->execute();
				$option = '';
				
				while($rs = $sth->fetch_array(MYSQLI_ASSOC)){

					$comp = strtoupper($rs['CMPNY_CD']);
						if($selected == $rs['CMPNY_CD'])
						 	$option = $option.'<option value="'.$rs['CMPNY_CD'].'" selected="selected">'.$comp;
						else
							$option = $option.'<option value="'.$rs['CMPNY_CD'].'">'.$comp;
				}

				return $option;
				
			}




			//get customer name
			function getCustName($card){

				$que =  "select * from (SELECT CRDNME FROM tblRawTrxn where crdno = ?) where rownum = 1";
				try {
					$sth = $this->con->prepare($que);
					$sth->execute(array($card));
					$rs = $sth->fetch_array(MYSQLI_ASSOC);
					
					if($rs['CRDNME']!='')
						$crdnme = $rs['CRDNME'];
					else
						$crdnme = '(No Name)';

					return $crdnme;
					
				}
				catch(Exception $e)
				{
					return $this->con->error;
					
				}

				
			
			}

			//check if cardnumber exist
			function ifCardExist($card){

				$que =  "SELECT ID FROM tblhistory where cardno = ?";
				try {
					$sth = $this->con->prepare($que);
					$sth->execute(array($card));
					$rs = sizeof($sth->fetchAll(PDO::FETCH_NUM));
					
					$num = $rs > 0 ? 'Yes' : 'No';

					return $num;
				}
				catch(Exception $e)
				{
					return $this->con->error;
					
				}
			
			}//end function

			//check if cardnumber exist inside tbladhocmember
			function ifCardExistInAdhoc($card,$comp){

				$que =  "SELECT ID FROM tbladhocmember where CARDNO = :cardno and COMPANY = :comp";
				try {
					$sth = $this->con->prepare($que);
					$sth->bindParam(':cardno',$card);
					$sth->bindParam(':comp',$comp);
					$sth->execute();
					$rs = sizeof($sth->fetchAll(PDO::FETCH_NUM));
					
					$num = $rs > 0 ? 'Yes' : 'No';

					return $num;
				}
				catch(Exception $e)
				{
					return $this->con->error;
					
				}

			}//end function



			function getAdminName($id){

				try {
					$que = "SELECT NAME FROM TBLADMIN WHERE ID = ".$id;
					$st = $this->con->query($que);
					$rs = $st->fetch_array(MYSQLI_ASSOC);
					
					return $rs['NAME']; 
					
				}
				catch (Exception $e)
				{
					return $this->con->error;
				}

			}

			function getAdminAccess($id){

				try {
					$que = "SELECT ACCES FROM TBLADMIN WHERE ID = ".$id;
					$st = $this->con->query($que);
					$rs = $st->fetch_array(MYSQLI_ASSOC);
					
					return $rs['ACCES']; 
					
				}
				catch (Exception $e)
				{
					return $this->con->error;
				}

			}

			function getAdminBranch($id){

				try {
					$que = "SELECT STORE,COMPANY FROM TBLADMIN WHERE ID = ?";
					$st = $this->con->prepare($que);
					$st->execute(array($id));
					$rs = $st->fetch_array(MYSQLI_ASSOC);
					
					return $rs['STORE'].'#'.$rs['COMPANY']; 
					
				}
				catch (Exception $e)
				{
					return $this->con->error;
				}

			}

			function getAccessName($id){

				$_access = array("Super"=>"System Admin", "GLP"=>"Compliance Officer","Area"=>"Area Manager",
						"Manager"=>"Branch Manager","Format"=>"Company Manager");

				foreach($_access as $key=>$val)
				{
					if($id == $key)
						return $val;
				}

			}

			function getDir($id){

				try {
					$que = "SELECT * FROM TBLADMINDIR WHERE ADMINID = ? ";
					$sth = $this->con->prepare($que);
					$sth->execute(array($id));
					$rs = $sth->fetch_array(MYSQLI_ASSOC);

					$arr = array();

					$arr[] = $rs['ALT_R1'] == 1 ? 'R1' : NULL;
					$arr[] = $rs['ALT_R2'] == 1 ? 'R2' : NULL;
					$arr[] = $rs['ALT_R3'] == 1 ? 'R3' : NULL;
					$arr[] = $rs['ALT_R4'] == 1 ? 'R4' : NULL;
					$arr[] = $rs['ALT_R5'] == 1 ? 'R5' : NULL;
					$arr[] = $rs['ALT_R6'] == 1 ? 'R6' : NULL;
					$arr[] = $rs['ALT_R7'] == 1 ? 'R7' : NULL;
					$arr[] = $rs['ALT_R8'] == 1 ? 'R8' : NULL;

					return $arr;
				}
				catch(Exception $e)
				{
					return $this->con->error;
				}

			}

		function openReport($access,$user,$code,$task,$crdno,$stor,$comp){

			$date = date("Y-m-d");
			$time = date("G:i:s");
			$name = $this->getAdminName($user);
			
			//update tblalerttrxn
			if($access == 'Format' or $access == 'Manager')
			{
				try {
					$que = "update tblalerttrxn set NOTI = 1 where CRDNO = :crdno and STORE = :stor and COMPANY = :comp and RISK_FTR_CT <> 0";
					$sth = $this->con->prepare($que);
					$sth->bindParam(':crdno',$crdno);
					$sth->bindParam(':stor',$stor);
					$sth->bindParam(':comp',$comp);
					$sth->execute();
				}
				catch (Exception $e)
				{
					$err = $e->getMessage().'[1]';
				}
			}
		

			return $err;

		}

		function elapsed_string($lastdate){

			$date1 = $lastdate; 

			$date2 = date("Y-m-d G:i:s"); 

			$diff = abs(strtotime($date2) - strtotime($date1)); 

			$years   = floor($diff / (365*60*60*24)); 
			$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
			$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

			$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

			$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

			if($years != 0)
			{
				$result = $years == 1 ? $years. " year ago" : $years." years ago";
			}
			elseif($months != 0)
			{
				$result = $months == 1 ? $months." month ago" : $months." months ago";
			}
			elseif($days != 0)
			{
				$result = $days == 1 ? $days." day ago" : $days." days ago";	
			}
			elseif($hours != 0)
			{
				$result = $hours == 1 ? $hours." hour ago" : $hours." hours ago";
			}
			elseif($minuts != 0)
			{
				$result = $minuts == 1 ? $minuts." minute ago" : $minuts." minutes ago";
			}
			else{
				$result =  "just now";
			}

			return $result;
		}//end function
		function time_elapsed_string($datetime, $full = false) {
			   $now = new DateTime;
			   $ago = new DateTime($datetime);
			   $diff = $now->diff($ago);

			   if (isset($diff)) {
			        $string = array(
			        'y' => 'year',
			        'm' => 'month',
			        'd' => 'day',
			        'h' => 'hour',
			        'i' => 'minute'
			    );

			    foreach ($string as $k => &$v) {
			        if ($diff->$k) {
			            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			        } else {
			            unset($string[$k]);
			        }
			    }

			    if (!$full)
			        $string = array_slice($string, 0, 1);
			    return $string ? implode(', ', $string) . ' ago' : 'just now';
				}
			   	else {
			          return 0;
			        }
		}//end function

		function clearNoti($code,$id){

			try {
				$que = "update TBLADMINlocator set NOTI = 1 
						where REPORT = :id, CODE = :code and NOTI = :noti";

				$sth = $this->con->prepare($que);
				$sth->bindParam(':id',$id);
				$sth->bindParam(':code',$code);
				$sth->bindParam(':noti',1);
				$sth->execute();
			}
			catch (Exception $e)
			{
				$err = $e->getMessage();
			}

		}

		function getAdhocID($ref)
		{
			try {
				$que = "select ID from tbladhoc where REF = ?";
				$sth = $this->con->prepare($que);
				$sth->execute(array($ref));
				$rs = $sth->fetch_array(MYSQLI_ASSOC);

				return $rs['ID'];
			}
			catch (Exception $e)
			{
				return $this->con->error;
			}
		}

		function insParam($id,$code,$company)
		{
			
			$arr = array();
			$num = 0;
			try {
				
				$que = "select ID from tblalertsettingrsk where CODE = :code and COMPANY = :comp";
				$sth = $this->con->prepare($que);
				$sth->bindParam(':code',$code);
				$sth->bindParam(':comp',$company);
				$sth->execute();
				while($rs = $sth->fetch_array(MYSQLI_ASSOC))
				{
					$arr[] = $rs['ID'];
					$num++;
				}

				for($i=0; $i<$num; $i++)
				{
					try {
						$ins = "insert into tbladhocparam(ADHOC_ID,CODE,RISK,COMPANY)
								values(:adhoc,:code,:risk,:comp)";
						$sth = $this->con->prepare($ins);
						$sth->bindParam(':adhoc',$id);
						$sth->bindParam(':code',$code);
						$sth->bindParam(':risk',$arr[$i]);
						$sth->bindParam(':comp',$company);
						$sth->execute();
					}
					catch (Exception $e)
					{
						return $this->con->error;
						break;
					}

				}//end for

				return $i;
			}
			catch (Exception $e)
			{
				return $this->con->error;
			}
		}


		function errLog($name,$msg,$ip,$user,$store){
			try {
			$date = date("Y-m-d G:i:s");
			$que = "insert into tblerrlog(ERR_NME,ERR_MSG,IPLOC,USR,STORE,ERRTIME)
				values(:name,:msg,:ip,:usr,:store,:time)";
			$sth = $this->con->prepare($que);
			$sth->bindParam(":name",$name);
			$sth->bindParam(":msg",$msg);
			$sth->bindParam(":ip",$ip);
			$sth->bindParam(":usr",$user);
			$sth->bindParam(":store",$store);
			$sth->bindParam(":time",$date);
			$sth->execute();
			}
			catch (Exception $e)
			{
				return $name.$msg.$ip.$user.$store;
			}

		}

		function openMsg($tr,$id)
		{
			try{
				$date = date("Y-m-d G:i:s");
				//update noti
				$que = "update tblmessagenoti set NOTI = 1, NDATE = :ndate
						where THREAD = :thread and SENDER_ID = :id";
				$sth = $this->con->prepare($que);
				$sth->bindParam(":ndate",$date);
				$sth->bindParam(":thread",$tr);
				$sth->bindParam(":id",$id);
				$sth->execute();
			}
			catch (Exception $e)
			{
				return $this->con->error;
			}
		}

		function getThreshold($code){

			try {
				$que = "select AGE_THRS_HLD as AGE from tblalertsettings where CODE = ?";
				$sth = $this->con->prepare($que);
				$sth->execute(array($code));
				$rs = $sth->fetch_array(MYSQLI_ASSOC);
				
				return $rs['AGE'];
			}
			catch (Exception $e)
			{
				return $this->con->error;
			}
		}

		function getGrace($code){

			try {
				$que = "select GRACE from tblalertsettings where CODE = ?";
				$sth = $this->con->prepare($que);
				$sth->execute(array($code));
				$rs = $sth->fetch_array(MYSQLI_ASSOC);
				
				return $rs['GRACE'];
			}
			catch (Exception $e)
			{
				return $this->con->error;
			}
		}

		function getCycleTime($code){

			try {
				$que = "select EVERY from tblalertsettings where CODE = ?";
				$sth = $this->con->prepare($que);
				$sth->execute(array($code));
				$rs = $sth->fetch_array(MYSQLI_ASSOC);
				
				return $rs['EVERY'];
			}
			catch (Exception $e)
			{
				return $this->con->error;
			}

		}

		function getSpendLevel($code){

			try {
				$que = "select SPEND_LEVEL from tblalertsettings where CODE = ?";
				$sth = $this->con->prepare($que);
				$sth->execute(array($code));
				$rs = $sth->fetch_array(MYSQLI_ASSOC);
				
				return $rs['SPEND_LEVEL'];
			}
			catch (Exception $e)
			{
				return $this->con->error;
			}

		}

		function getLatestDate($access,$lob,$company,$store){

			try {
				switch($access)
				{
					case 'Super': 
						$que = "select max(to_char(TRXN_DTE,'yyyy-mm-dd')) as T_DTE from tblAlertTrxn where RISK_FTR_CT > 0";
						$sth = $this->con->prepare($que);
					break;
					case 'GLP':
						if($lob == 'All')
						{
							$que = "select max(to_char(TRXN_DTE,'yyyy-mm-dd')) as T_DTE from tblAlertTrxn where RISK_FTR_CT > 0";
							$sth = $this->con->prepare($que);
						}
						else
						{
							$ar_comp = $this->getLocQueryComp($lob);
							$que = "select max(to_char(TRXN_DTE,'yyyy-mm-dd')) as T_DTE from tblAlertTrxn where RISK_FTR_CT > 0 and COMPANY IN (".$ar_comp.")";
							$sth = $this->con->prepare($que);
						}
					break;
					case 'Format':
							$que = "select max(to_char(TRXN_DTE,'yyyy-mm-dd')) as T_DTE from tblAlertTrxn where RISK_FTR_CT > 0 and COMPANY = :comp";
							$sth = $this->con->prepare($que);
							$sth->bindParam(':comp',$company);
					break;

					case 'Manager':		
						$que = "select max(to_char(TRXN_DTE,'yyyy-mm-dd')) as T_DTE from tblAlertTrxn where RISK_FTR_CT > 0 and COMPANY = :comp AND STORE = :stor";
						$sth = $this->con->prepare($que);
						$sth->bindParam(':comp',$company);
						$sth->bindParam(':stor',$store);
					break;
				}

				$sth->execute();
				$rs = $sth->fetch_array(MYSQLI_ASSOC);
				
				return $rs['T_DTE'];
			}
			catch (Exception $e)
			{
				return $this->con->error;
			}
		}

	}

	/**
	* User Settings
	*/
	class UserSettings extends Settings
	{
		protected $Name;
		protected $Username;
		protected $Pwd;
		protected $Access;
		protected $Status;
		protected $Store;
		protected $Loc;
		protected $Format;
		protected $Firstlog;



		function setName($name){
			return $this->Name = $name;
		}

		function GetName(){
			return $this->Name;
		}

		function setUserName($username){
			return $this->Username = $username;
		}

		function GetUserName(){
			return $this->Username;
		}

		function setAccess($access){
			return $this->Access = $access;
		}

		function GetAccess(){
			return $this->Access;
		}

		function setStatus($status){
			return $this->Status = $status;
		}

		function GetStatus(){
			return $this->Status;
		}

		function setStore($store){
			return $this->Store = $store;
		}

		function GetStore(){
			return $this->Store;
		}

		function setLoc($loc){
			return $this->Loc = $loc;
		}

		function GetLoc(){
			return $this->Loc;
		}

		function setFormat($format){
			return $this->Format = $format;
		}

		function GetFormat(){
			return $this->Format;
		}

		function setPassword($pwd){
			return $this->Pwd = $pwd;
		}

		function setFirstLog($ft){
			return $this->Firstlog = $ft;
		}

		function getFirstLog()
		{
			return $this->Firstlog;
		}


 	 	function mh02encrypt($pwd){

	 		//mh01 pwd hashing
			$temp = $pwd;
			$len = strlen($temp);
			$chr = '';
			for($i=$len-1; $i>=0; $i--){
				if($chr == '')
			 	$chr = ord($temp[$i]);
			 	else
			 	$chr = $chr.'-'.ord($temp[$i]);
			}

			return $chr;

 		}
 		

 	 	function addUser($name,$email,$user,$pwd,$by,$access,$store){

	 	 	$datetime = $this->sqldate;
	 	 	if($this->provider == 'MSSQL')
	 	 	$que = "EXEC PROCINSERTUSER '$name','$user','$pwd',$by,'$access','$store'";
	 	 	else
	 	 	{
	 	 		if($access == 'Super')
				$que = "INSERT INTO TBLADMIN(NAME,EMAIL,USERNAME,PASSWORD,ACCES,UPDATEDBY,LASTUPDATE,LOB,STATUS) 
					VALUES('$name','$email','$user','$pwd','$access',$by,'$datetime','All','Active')";
	 	 		else
	 	 		$que = "INSERT INTO TBLADMIN(NAME,USERNAME,PASSWORD,ACCES,UPDATEDBY,LASTUPDATE,STATUS) 
					VALUES('$name','$user','$pwd','$access',$by,'$datetime','Active')";
			}
			try {

				$sth = $this->con->prepare($que);
				$sth->execute();

				return 1;

			}	
			catch (Exception $e)
			{
				return $this->con->error;;
			}	

			
 	 	}

 	 	function addDir($id){

			$userid = $id;
			      
			$r1 = 1;
			$r2 = $_POST['r2'] != '' ? $_POST['r2'] : 0;
			$r3 = $_POST['r3'] != '' ? $_POST['r3'] : 0;
			$r4 = $_POST['r4'] != '' ? $_POST['r4'] : 0;
			$r5 = $_POST['r5'] != '' ? $_POST['r5'] : 0;
			$r6 = $_POST['r6'] != '' ? $_POST['r6'] : 0;
			$r7 = $_POST['r7'] != '' ? $_POST['r7'] : 0;
			$r8 = $_POST['r8'] != '' ? $_POST['r8'] : 0;

			$q = "
				INSERT INTO TBLADMINDIR
				 (ADMINID
				 ,ALT_R1,ALT_R2,ALT_R3,ALT_R4,ALT_R5,ALT_R6,ALT_R7,ALT_R8)
				VALUES
				 (".$userid.",".$r1.",".$r2.",".$r3.",".$r4.",".$r5.",".$r6.",".$r7.",".$r8.")
				";

			try
			{
				$sth = $this->con->prepare($q);
				$sth->execute();
			}
			catch (Exception $e)
			{
				return $e->getMessage().'<br>'.$q;
			}



 	 	}

 	 	function editUser($name,$email,$img,$imgyes,$user,$pwd,$access,$str,$by,$id){

	 	 	$datetime = $this->sqldate;
	 	 	

				if ($pwd != '0')
					$epwd = "PASSWORD='$pwd',";
				if($imgyes != '0')
					$eimg = "IMG='$img',";

				$que = "UPDATE TBLADMIN SET NAME='$name',
				EMAIL='$email',
				USERNAME='$user', 
				".$epwd."
				".$eimg."
				ACCES='$access',
				LASTUPDATE = '$datetime', UPDATEDBY = $by 
				WHERE ID = $id";
			

	 		if($sth = $this->con->prepare($que))
	 		{
				$sth->execute();

				return 1;

			}	
			else
			{
				return $this->con->error;;
			}	

 	 	}
	 

 		function showUserList($adminid,$access,$stores,$company,$lob){

			$suf = '';
			if($_SESSION['MSUPER'] == 1)
				$suf = "'Super'";
			if($_SESSION['MGLP'] == 1)
				$suf = $suf != '' ? $suf.",'GLP'" : "'GLP'";
			if($_SESSION['MFORMAT'] == 1)
				$suf = $suf != '' ? $suf.",'Format'" : "'Format'";
			if($_SESSION['MAREA'] == 1)
				$suf = $suf != '' ? $suf.",'Area'" : "'Area'";
			if($_SESSION['MSTORE'] == 1)
				$suf = $suf != '' ? $suf.",'Manager'" : "'Manager'";
			
			
				//access criteria
				if($_SESSION['PERMID']!='')
					$line = "WHERE ACCES in (".$suf.") AND ID <> $adminid";
				else
					$line = "WHERE ID <> $adminid";	
			
				//store criteria
				if($access == 'Super')
				{
					$que = "SELECT * FROM TBLADMIN ".$line." and ID <> 1 ORDER BY ACCES,STORE,NAME ASC";
					
				}
				elseif($access == 'GLP')
				{
					if($lob == 'All')
					$que = "SELECT * FROM TBLADMIN ".$line." AND LOB <> '".$lob."' ORDER BY ACCES,STORE,NAME ASC";
					else
					$que = "SELECT * FROM TBLADMIN ".$line." AND LOB = '".$lob."' ORDER BY ACCES,STORE,NAME ASC";
					
				}
				elseif($access == 'Format')
				{
					$que = "SELECT * FROM TBLADMIN ".$line." AND LOB = '".$lob."' AND COMPANY = '".$company."' ORDER BY ACCES,STORE,NAME ASC";
					
				}
				

				try {
				    $sth = $this->con->query($que);
				    $str = '';
				    $param = '';
				    $ctr = 1;
				    while($rs = $sth->fetch_array(MYSQLI_ASSOC)){

				    	//explode location
				    	if($rs['ACCES'] != 'Manager')
							$store = '-';
						else
							$store = $rs['STORE'];
				    	
				      if($rs['STATUS'] == 'Active'){
				        $param = "'admin','".$rs['ID']."','Are you sure you want to deactivate agent <b><i>".$rs['NAME']."<i></b>?'";
				        
				        if($ctr%2==0)
			                $tr = '<tr class="odd">';
			            else
			                $tr = '<tr class="even">';

			            $_com = $rs['COMPANY'] != '' ? $rs['COMPANY'] : '-';

			            $_log = $rs['LOG'] == 'IN' ? '<small style="color:green">ACTIVE</small>' : '<small style="color:#333">LOGGED OUT</small>';

			            if(strlen($rs['IMG']) > 2)
			            	$img = 'images/'.$rs['IMG'];
			            else
			            	$img = 'images/user.png';
			         

				        $str.=
				          	$tr.
				       		'<td>'.$ctr.'</td> 
				          
				          <td align="center"> <img src="'.$img.'" width="50" class="img-circle"/></td>
				          <td>'.$rs['NAME'].'</td> 
				          <td>'.$rs['USERNAME'].'</td>
				          <td>'.$this->getrolename($rs['ACCES']).'</td> 
				          <td>'.$rs['EMAIL'].'</td> 
				          <td style="font-size:9px">'.$_log.' <br> </td> 
				          <td width="140">
				          		<a href="?page=user&sub=profile&id='.$rs['ID'].'" class="btn btn-xs btn-info btn-circle" title="Show Details">
				          		<i class="fa fa-list"></i></a>
				              	| 
				              	<a href="?page=user&sub=dec&id='.$rs['ID'].'" class="btn btn-xs btn-warning btn-circle" title="De-activate">
				          		<i class="fa fa-minus"></i></a>
				          		';

				          		if($adminid == 1)
				          		{
				          		$str = $str.'
				          		| 
				              	<a href="?page=user&sub=deluser&id='.$rs['ID'].'" class="btn btn-xs btn-danger btn-circle" title="Delete User">
				          		<i class="fa fa-times"></i></a>
				          		';
				          		}

				          $str = $str.'
				          	</td></tr>
				          ';
				      }
				      else{
				       	
				       	if($ctr%2==0)
			                $tr = '<tr class="odd warning">';
			            else
			                $tr = '<tr class="even warning">';
				        $str.=
				        $tr.'
				        <td>'.$ctr.'</td> 
				        <td align="center"> <img src="'.$img.'" width="50" class="img-circle"/></td>
						<td>'.$rs['NAME'].'</td> 
						<td>'.$rs['USERNAME'].'</td>
						<td>'.$this->getrolename($rs['ACCES']).'</td> 
				        <td>'.$rs['EMAIL'].'</td> 
				        <td style="font-size:9px">'.$_log.' <br> <a href="'.$_loghistory.'">Log History</a></td> 
				        <td width="140">
				        	<a href="?page=user&sub=rea&id='.$rs['ID'].'"class="btn btn-xs btn-success btn-circle" title="Re-activate">
							<i class="fa fa-check"></i></a>
				        	</a>';

				        	if($adminid == 1)
				          		{
				          		$str = $str.'
				          		| 
				              	<a href="?page=user&sub=deluser&id='.$rs['ID'].'" class="btn btn-xs btn-danger btn-circle" title="Delete User">
				          		<i class="fa fa-times"></i></a>
				          		';
				          		}

				          $str = $str.'
				          	</td></tr>
				          ';
				      }

				      $ctr++;


		    		}//end while
	    		}
	    		catch (Exception $e)
	    		{
	    			$str = $e->getMessage();
	    		}
	    


	    	return $str;
	  	}//end function

	  	

	  	function getrolename($code){

			$_access = array("Super"=>"Super User","GLP"=>"Compliance Officer","Format"=>"Company Access Level","Manager"=>"Branch Access Level");
			foreach ($_access as $key => $val) {

				if($code == $key)
				return $val;
			}//foreach
		}//end fucntion 


		function mh10encrypt($pwd,$usr,$suf){

	 	 	//pwd enrypting
			$temp = date("Ymd").'_'.$pwd.'_'.$suf.'_'.$usr;
			$len = strlen($temp);
			$chr = '';
			for($i=$len-1; $i>=0; $i--)
			  $chr = $chr.chr(ord($temp[$i])+5);

			return $chr;
 	 	}

		function mh10decrypt($chr){

	 	 	//pwd decrypting
	 	 	$real = '';
			$len2 = strlen($chr);
			for($a=$len2-1; $a>=0; $a--)
			  $real = $real.chr(ord($chr[$a])-5);

			return $real;

 	 	}//end function


	}//enc class

	/**
	* Login Class
	*/
	class Login extends UserSettings
	{
	

		function logtime($id,$val){
			$ip = $_SERVER['REMOTE_ADDR'];

			if($id!='')
			{
				$que = "update TBLADMIN set LOGTIME = '".$val."', LOC = '".$ip."' where ID = ".$id;

				try {	
				$stmt = $this->con->prepare($que);
	            $stmt->execute();

		            return 1;
	        	}
	        	catch (Exception $e)
	        	{
	        		return $this->con->error;
	        	}

			}
			else
			{
				$que = "update TBLADMIN set LOGTIME = '".$val."' where LOC = '".$ip."'";

				try {	
				$stmt = $this->con->prepare($que);
	            $stmt->execute();

		            return 1;
	        	}
	        	catch (Exception $e)
	        	{
	        		return $this->con->error;
	        	}

			}

				
			
		}//end function

		function logout($id,$val){
			$ip = $_SERVER['REMOTE_ADDR'];

			if($id!='')
			{
				$que = "update TBLADMIN set LOGOUT = '".$val."', LOC = '".$ip."' where ID = ".$id;

				try {	
				$stmt = $this->con->prepare($que);
	            $stmt->execute();

		            return 1;
	        	}
	        	catch (Exception $e)
	        	{
	        		return $this->con->error;
	        	}

			}
			else
			{
				$que = "update TBLADMIN set LOGOUT = '".$val."' where LOC = '".$ip."'";

				try {	
				$stmt = $this->con->prepare($que);
	            $stmt->execute();

		            return 1;
	        	}
	        	catch (Exception $e)
	        	{
	        		return $this->con->error;
	        	}

			}

				
			
		}//end function

		/*
		function logger($id,$task,$remarks){

			$ip = $_SERVER['REMOTE_ADDR'];

			if($id !='')
			{
				$que = "insert into TBLADMINlogger(ADMINID,TASK,IP,REMARKS) VALUES(:adminid,:task,:ip,:remarks)";
			}	
			else
			{
				$que = "insert into TBLADMINlogger(ADMINID,TASK,IP,REMARKS)
				select ADMINID,:task,:ip,:remarks from (select ADMINID from TBLADMINLogger where IP = :ip order by DT DESC) where rownum = 1";
			}

			try {	
				$stmt = $this->con->prepare($que);
	            $stmt->bindParam(':adminid', $id);
	            $stmt->bindParam(':task', $task);
	            $stmt->bindParam(':ip', $ip);
	            $stmt->bindParam(':remarks', $remarks);
	            $stmt->execute();

	            return 1;
        	}
        	catch (Exception $e)
        	{
        		return $this->con->error;
        	}
        }

		*/

		function validate()
		{
			
			$que = "select * from TBLADMIN where USERNAME = '".$this->Username."'";
			//die($que);
			if($sth = $this->con->query($que))
			{
				$rs = $sth->fetch_array(MYSQLI_ASSOC);
			}
			else
			{
				return $this->con->error;
			}

			if($rs['ID'] != '')
			{
				
					$exp = explode("_",$this->mh10decrypt($rs['PASSWORD']));
					if($this->Pwd == $exp[1])
					{
						if($rs['STATUS'] == 'Active')
						{
							
								//log time
								$result = $this->setPerm($rs['ID']);
								//$result = $this->setDir($rs['ID']);

								if($result!=1)
									$err = $result;
								else
								{
									$expire=time()+60*$this->session;
									setcookie("adminuser",$rs['NAME'],$expire,'/');
									setcookie("adminid",$rs['ID'],$expire,'/');
									setcookie("access",$rs['ACCES'],$expire,'/');
									setcookie("store",$rs['STORE'],$expire,'/');
									setcookie("loc",$rs['LOC'],$expire,'/');
									setcookie("format",$rs['FORMAT'],$expire,'/');
									setcookie("company",$rs['COMPANY'],$expire,'/');
									setcookie("lob",$rs['LOB'],$expire,'/');

									$this->setFirstLog($rs['FIRST_TIME']);

									//logger
									$this->logtime($rs['ID'],'IN');
									//$this->logger($rs['ID'],'LOGIN','');

								}
							

						}
						else
							return 'Access denied. This account has been deactivated.';
					}
					else
						return 'Invalid password.';
				
			}
			else
				return "Invalid username.";
		}//end function

		function validatePwd($id,$user,$postpwd,$postpwd2)
		{

			//password policy check
	      	$proceed = 0;
			$ppsq = "select * from TBLADMINpps where ID = 1";
			$st = $this->con->query($ppsq);
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
                $hashpwd = $this->mh10encrypt($postpwd,$user,$suffix);


				try {
					$que = "update TBLADMIN set password = '".$hashpwd."', FIRST_TIME = 1 where id = ".$id;
					$sth = $this->con->prepare($que);
					$sth->execute();

					return 1;
				}
				catch(Exception $e)
				{
					return $this->con->error;
				}

			}
			else
				return $err;
		}//end function

		function setPerm($id){

		
				$que = "SELECT * FROM TBLADMINPERM WHERE ADMINID = ".$id;
				//die($que);
				$sth = $this->con->query($que);
			
				$rs = $sth->fetch_array(MYSQLI_ASSOC);

				$_SESSION['PERMID'] = $rs['ID'];
				$_SESSION['MSUPER'] = $rs['MSUPER'];
				$_SESSION['MGLP'] = $rs['MGLP'];
				$_SESSION['MSTORE'] = $rs['MSTORE'];
				$_SESSION['MFORMAT'] = $rs['MFORMAT'];
				$_SESSION['SETTINGS'] = $rs['SETTINGS'];

				
				if(!$this->con->error)	
				{
					return 1;
				}
				else
				{
					return $this->con->error;
				}

		}

		function setDir($id){

			try {
				$que = "SELECT * FROM TBLADMINDIR WHERE ADMINID =  ".$id;
				$sth = $this->con->query($que);
				$rs = $sth->fetch_array(MYSQLI_ASSOC);

				for($i=1; $i<9; $i++)
				$_SESSION['R'.$i] = $rs['ALT_R'.$i];

				return 1;
			}
			catch(Exception $e)
			{
				return $this->con->error;
			}

		}

	}//end class login



?>
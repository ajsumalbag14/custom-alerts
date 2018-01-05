<?php
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
?>
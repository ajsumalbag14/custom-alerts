<?php
	if($err!='')
	echo '<div class="alert alert-danger" role="alert">'.$err.'</div>';
	elseif($suc!='')
	echo '<div class="alert alert-success" role="alert">'.$suc.'</div>';
	elseif($noti!='')
	echo '<div class="alert alert-warning" role="alert">'.$noti.'</div>';

?>
<?php
    include("main.class.php");
    $set = new Settings;


$htmlbody = '
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="@ajsumalbag">
    <meta name="title" content="">

    <meta property="og:url" content="https://lassu.net/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="" />

    <title>Zumienzite by Lassu</title>


    <style type="text/css">

            body {font-family: Helvetica;}
            .logo {width:200px;}
            .footer { text-align: center; font-size: 11px;}
            .table {text-align: center; font-size: 14px; 
                    background: #f2f2f2; 
                    margin: auto;}
            .table td {text-indent: 1em; background: white; padding:5px;}
            .table th {text-indent: 1em;}
            p {width: 100%}
    </style>
</head>

<body>
        <div style="margin:auto; width:500px; border:solid 1px #CCC; padding:1em; background:#f3f3f3; text-align: center">
            <div style="text-align:center">
                <img src="https://lassu.net/sandbox/app/zumiez/v'.$set->getVersion().'/images/mail-heading.png" width="400"/>
            </div>
            <hr>
            <h1>
               Custom Report Summary <br>
               <small>Date: 2017-12-10</small>
            </h1>
            <br><br>
            <table class="table">
                <tr>
                    <th>Discount Percent</th>
                    <th>Cancelled Sales</th>
                    <th>Voids</th>
                </tr>
                <tr>
                    <td width=200>
                      <h2><u>0</u></h2>
                    </td>

                    <td width=200>
                      <h2><u>0</u></h2>
                    </td>

                    <td width=200>
                      <h2><u>0</u></h2>
                    </td>
                </tr>

            </table>

            <br><br><br><br>
            <a href="https://lassu.net/sandbox/app/zumiez" class="btn btn-success btn-lg" target="_blank">  Review Alerts</a>
           
           <div class="clearfix"></div>
            <br><br>
            <hr>
            <div class="footer">
                <p>&copy; 2017 <a href="https://www.lassu.net/" target="_blank">Lassu, Inc</a>. All Rights Reserved. </p>
            </div>
        </div>



</body>

</html>
	';


echo $htmlbody;
	
?>

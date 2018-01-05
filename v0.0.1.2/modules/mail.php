<?php
    //include("main.class.php");

    //$set = new Settings;
    //require_once '../../Swift-4.2.1/lib/swift_required.php';
    require_once '/home1/lassuloy/public_html/sandbox/app/Swift-4.2.1/lib/swift_required.php';
    include("dashboard-exe.php");

    $rptdate = date("Y-m-d");
    $disc = number_format($totcount_disc);
    $cncl = number_format($totcount_cncl);
    $void = number_format($totcount_void);


    $cque = $set->con->query("select NAME,EMAIL from TBLADMIN where ID = ".$_COOKIE['adminid']);
    $rs = $cque->fetch_array(MYSQLI_ASSOC);
    $to_email = $rs['EMAIL'];
    $to_name = $rs['NAME'];


$htmlbody = '
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Lassu, Inc.">
    <meta name="author" content="@ajsumalbag">
    <meta name="title" content="Lassu, Inc.">

    <meta property="og:url" content="https://lassu.net/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="Lassu, Inc." />
    <meta property="og:image" content="Lassu, Inc." />

    <title>Zumienzite by Lassu</title>


    <style type="text/css">

            body {font-family: Helvetica}
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
        <div style="margin:auto; width:500px; border:solid 1px #CCC; padding:1em; background:#f3f3f3; text-align:center">
            <div style="text-align:center">
                <img src="https://lassu.net/sandbox/app/zumiez/v'.$set->getVersion().'//images/mail-heading.png" width="400"/>
            </div>
            <hr>
            <h1>
               Custom Report Summary <br>
               <small>Date: '.$rptdate.'</small>
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
                      <h2><u>'.$disc.'</u></h2>
                    </td>

                    <td width=200>
                      <h2><u>'.$cncl.'</u></h2>
                    </td>

                    <td width=200>
                      <h2><u>'.$void.'</u></h2>
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

    if($to_name != '' and $to_email != '')
    {
       try{
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance('mail.lassu.net', 465)
           ->setEncryption('ssl')
           ->setUsername('zumienzite@lassu.net')
           ->setPassword('@\Y:-614b>_k');

        //$transport = Swift_SmtpTransport::newInstance('mail.idisciple.ph', 465)
        //->setEncryption('ssl')
        //->setUsername('events@idisciple.ph')
        //->setPassword('IDevents2017');

        //$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465)
            //->setEncryption('ssl')
            //->setUsername('ajsumalbag14@gmail.com')
            //->setPassword('ybgiwifabhbugwuj');
          
        
        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);
        
        // Create the message
        $message = Swift_Message::newInstance();
        
            $subject = "Zumienzite Report Notification";
            // Give the message a subject
            $message->setSubject($subject);
            
            // Set the From address with an associative array
            $message->setFrom(array('zumienzite@lassu.net'=>'Zumienzite'));
            
            // Set the To addresses with an associative array
            $message->setTo(array($to_email => $to_name));
    
            //embed image
            //$cid = $message->embed(Swift_Image::fromPath('../images/solera-email-logo.png'));
            
            // Give it a body
            $message->setBody($htmlbody,'text/html');
            
        
        
        // Send the message
        $result = $mailer->send($message);

        $suc = 'Email notification has been sent to '.$to_email.'.';
        
        
        } catch (Exception $e) {
          $err = $e->getMessage();
        }
    }
    else
        $err = "No email and contact name.";

//echo $htmlbody;
	
?>

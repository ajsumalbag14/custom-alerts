<?php
    require_once('modules/main.class.php');
    $_head = new Settings;

    if($_COOKIE['adminid']!='')
    {

        if(isset($_POST['submit']))
        {

            if($_POST['upwd'] == $_POST['rupwd'])
            {
                $log = new Login;
                $err = $log->validatePwd($_COOKIE['adminid'],$_COOKIE['adminuser'],$_POST['upwd'],$_POST['rupwd']);
                
                if($err == 1)
                {
                    $expire=time()-3600;
                    setcookie("adminuser",'',$expire,'/');
                    setcookie("adminid",'',$expire,'/');
                    setcookie("store",'',$expire,'/');
                    setcookie("access",'',$expire,'/');
                    //clear session
                    session_unset();   
                }
            }
            else
            {
                $err = 'Password mismatch.';
            }

        }   
    }
    else
        header("Location: login.php");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>POC | Zumiez</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="">
                        
                        <?php if($err == 1) { ?>
                            <div class="alert alert-success text-center">
                                Your password has been reset successfully.
                            </div>

                            <h3 class="text-center"><a href="login.php" class="btn btn-lg">Login &raquo;</a></h3>

                        <?php } else { ?>
                        <?php if(isset($err)) echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">'.$err.'</div>'; ?>
                        <div><h3>CHANGE PASSWORD.</h3><hr></div>
                        <form class="form-horizontal form-label-left" role="form" action="?" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" maxlength="20" placeholder="New Password" id="upwd" name="upwd" type="password"
                                     required value="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" maxlength="20" placeholder="Re-type Password" id="rupwd" name="rupwd" type="password"
                                     required value="">
                                </div>
                                <div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                                </div>
                            </fieldset>
                        </form>
                        <?php } ?>

                            <div class="separator">

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                  <h1>Zumiez</h1>
                                  <p>©2017 All Rights Reserved. Lassu, Inc.</p>
                                </div>
                            </div>
            </section>
        </div>

        
      </div>
    </div>
  </body>
</html>
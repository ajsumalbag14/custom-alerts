<?php
    require_once('modules/main.class.php');
    $_head = new Settings;
    if(isset($_POST['login']))
    {
        $log = new Login;
        $log->setUserName($_POST['uname']);
        $log->setPassword($_POST['upwd']);
        $err = $log->validate();

        if($err!='')
        { }
        else
        {

            if($log->getFirstLog() == 1)
            {
                header("Location: index.php");
            }
            else
            {
                header("Location: firstlog.php");
            }
        }
    }
    elseif($_GET['logout']!='')
    {
        
        $log = new Login;

        if(isset($_COOKIE['adminid']))
        {
            $adid = $_COOKIE['adminid'];
            
            $log->logout($adid,'OUT');
        }
    

        $expire=time()-3600;
        setcookie("adminuser",'',$expire,'/');
        setcookie("adminid",'',$expire,'/');
        setcookie("store",'',$expire,'/');
        setcookie("access",'',$expire,'/');
        //clear session
        session_unset();
    }

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

            <?php include("modules/err.php") ?>
            <form role="form" action="?" method="post">
              <h1>Zumienzite</h1>
              <div class="form-group">
                <input class="form-control"  maxlength="20" placeholder="Username" name="uname" type="text" required autofocus
                                    value="<?php echo $_POST['uname']?>">
              </div>
              <div class="form-group">
                <input class="form-control" maxlength="20" placeholder="Password" id="upwd" name="upwd" type="password"
                                     required value="">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-default" name="login" value="Login">
                <div class="clearfix"></div>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <p class="text-muted">Zumienzite by Lassu</p>
                  <p>©2017 All Rights Reserved. Lassu, Inc.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        
      </div>
    </div>
  </body>
</html>

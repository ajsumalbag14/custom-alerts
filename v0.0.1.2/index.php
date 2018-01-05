<?php
    require_once('modules/main.class.php');
    include('import.php');
    include('function.php');
    include('modules/main.php');

    include('header.php');

    $set = new Settings;

    //PROFILE IMAGE
    $locimg = $set->getImg($_COOKIE['adminid']);

?>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title text-center" style="border: 0; background: #fff">
              <a href="index.php" class="site_title"><!--<span>POC | Zumiez</span>-->
              <img src="images/193-logo-zumiez-logo.jpg" height="50">
              </a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <?php
                  if(strlen($locimg) > 2)
                    {
                      echo '<img src="images/'.$locimg.'" alt="" class="img-circle profile_img">';
                      //echo $locimg;
                    }
                    else
                      echo '<img src="images/user.png" alt="" class="img-circle profile_img">';
                ?>
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $_COOKIE['adminuser'];?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="index.php?page=dashboard"><i class="fa fa-home"></i> Dashboard</a>
                    
                  </li>

                  <li><a>Standard Reports</a></li>

                  <li><a>&nbsp;&nbsp;&nbsp;&bull;&nbsp;Discount Percent <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.php?page=disc&sub=open">Open Cases</a></li>
                      <li><a href="index.php?page=disc&sub=pending">Pending Review</a></li>
                      <li><a href="index.php?page=disc&sub=overdue">Resolution Overdue</a></li>
                      <li><a href="index.php?page=disc&sub=top">Top Cases</a></li>
                    </ul>
                  </li>

                  <li><a>&nbsp;&nbsp;&nbsp;&bull;&nbsp;Cancelled Sales <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.php?page=cncl&sub=open">Open Cases</a></li>
                      <li><a href="index.php?page=cncl&sub=pending">Pending Review</a></li>
                      <li><a href="index.php?page=cncl&sub=overdue">Resolution Overdue</a></li>
                      <li><a href="index.php?page=cncl&sub=top">Top Cases</a></li>
                    </ul>
                  </li>

                  <li><a>&nbsp;&nbsp;&nbsp;&bull;&nbsp;Voids <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.php?page=void&sub=open">Open Cases</a></li>
                      <li><a href="index.php?page=void&sub=pending">Pending Review</a></li>
                      <li><a href="index.php?page=void&sub=overdue">Resolution Overdue</a></li>
                      <li><a href="index.php?page=void&sub=top">Top Cases</a></li>
                    </ul>
                  </li>

                  <li><a href="index.php?page=rpt">Custom Reports</a>
                    
                  </li>

                  

                  <li><a><i class="fa fa-user"></i> User Settings <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?page=user&sub=list">User List</a></li>
                      <li><a href="?page=user&sub=profile&id=<?php echo $_COOKIE['adminid']?>">My Profile</a></li>
                      <li><a href="?page=user&sub=pps">Password Policy Setting</a></li>
                    </ul>
                  </li>
                  
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="User Settings" href="?page=user">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.php?logout=ok">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    
                    <?php 

                    
                    if(strlen($locimg) > 2)
                    {
                      echo '<img src="images/'.$locimg.'" alt="">';
                      //echo $locimg;
                    }
                    else
                      echo '<img src="images/user.png" alt="">';

                    echo $_COOKIE['adminuser'];
                    ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="?page=user&sub=profile&id=<?php echo $_COOKIE['adminid']?>"> Profile</a></li>
                    <li>
                      <a href="?page=user">
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="login.php?logout=ok"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">


            <?php

                switch($_GET['page'])
                {

                  case 'user':

                        $_user = new UserSettings;

                        switch($_GET['sub'])
                        {
                          case 'profile':
                            if(!isset($_POST['submit']) or $suc != '')
                            include("modules/preload.php");
                          
                            $backbutton = 1;
                            include('user_profile.php');
                          break;

                          case 'new':

                            include("user_new.php");
                          break;

                          case 'addperm':
                            include("user_addperm.php");
                          
                          break;

                          case 'pps':

                            if(!isset($_POST['submit']) or $suc != '')
                            include("modules/preload.php");

                            include("user_pps.php");
                          break;

                          case 'editstore':
                            if(!isset($_POST['submit']))
                                include("modules/preload.php");
                            include("user_editstore.php");
                          break;

                          case 'editperm':
                            if(!isset($_POST['submit']))
                                include("modules/preload.php");
                            include("user_editperm.php");
                          break;

                          case 'editaccount':
                            if(!isset($_POST['submit']))
                                include("modules/preload.php");

                            include("user_editaccount.php");
                          break;

                          default:
                            include('user_dash.php');


                        }

                  break;

                  case 'disc':
                   
                  //include('modules/param-exe.php');
                      switch($_GET['sub'])
                      {

                        case 'pending':
                          include('disc_pending.php');
                        break;
                        case 'overdue':
                          include('disc_overdue.php');
                        break;
                        case 'top':
                          include('disc_top.php');
                        break;
                        default:
                          include('disc_dash.php');
                      }
                  break;

                  case 'cncl':
                   
                  //include('modules/param-exe.php');
                      switch($_GET['sub'])
                      {

                        case 'pending':
                          include('cncl_pending.php');
                        break;
                        case 'overdue':
                          include('cncl_overdue.php');
                        break;
                        case 'top':
                          include('cncl_top.php');
                        break;
                        default:
                          include('cncl_dash.php');
                      }
                  break;

                  case 'void':
                   
                  //include('modules/param-exe.php');
                      switch($_GET['sub'])
                      {

                        case 'pending':
                          include('void_pending.php');
                        break;
                        case 'overdue':
                          include('void_overdue.php');
                        break;
                        case 'top':
                          include('void_top.php');
                        break;
                        default:
                          include('void_dash.php');
                      }
                  break;


                  case 'rpt':

                  

                  include("modules/preload.php");
                  include('rpt_form.php');

                  break;
                  
                  default:

                  
                  include('modules/dashboard-exe.php');
                  include('dashboard.php');

                }
            ?>

        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            POC Zumiez - Lassu, Inc.</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <?php 

      include('footer.php');

    ?>
  </body>
</html>

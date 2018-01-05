

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Account Details
                    </h1>
                    <?php include("modules/err.php") ?>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <form role="form" action="?page=user&sub=editaccount&ref=<?php echo $_GET['ref']?>" method="post" enctype="multipart/form-data">

                                    <input type="hidden" name="aID" value="<?php echo $_GET['ref']?>">

                                    <?php 
                                        if($aImg != '')
                                            echo '<img src="images/'.$aImg.'" width="100"/>';
                                        else
                                            echo '<img src="images/user.png" width="100" />';
                                    ?>

                                    <br><br>

                                    <input type="file" class="form-control" name="aImg" value="<?php echo $aImg?>">
                        
                                    <?php

                                      if($_COOKIE['adminid'] != $_GET['ref'])
                                      {
                                      echo '
                                        User Access: 
                                        <select name="access" class="form-control">
                                      ';
                                        foreach($_access as $val)
                                        {
                                            if($acc == $val)
                                            echo '<option value="'.$val.'" selected>'.$_user->getrolename($val).'</option>';
                                            else
                                            echo '<option value="'.$val.'">'.$_user->getrolename($val).'</option>';
                                          
                                        }
                                      echo '
                                        </select>';
                                      }
                                      else
                                        echo '<input type="hidden" name="access" value="'.$acc.'">';
                                    ?>
                                
                                <br>
                                Name<br>
                                <input required type="text" class="form-control" name="aName" maxlength="30" placeholder="Name..." value="<?php echo $aName?>">
                                <br>
                                 Email<br>
                                <input required type="email" class="form-control" name="aEmail" maxlength="50" placeholder="Email Address..." value="<?php echo $aEmail?>">
                                <br>
                                Username<br>
                                <input required type="text" name="aUser" maxlength="20" placeholder="Username" class="form-control" value="<?php echo $aUser?>">
                                <input type="hidden" name="aUser2" maxlength="15" class="form-control" value="<?php echo $aUser?>">
                                <br>

                                Password<br>
                                <input required type="password" id="aPwd" name="aPwd" maxlength="24" placeholder="Password" class="form-control" value="<?php echo $pwd[1]?>">
                                <input type="hidden" name="aPwd2" maxlength="24" class="form-control" value="<?php echo $pwd[1]?>">
                                

                                <label style="font-weight:normal; float:right">
                                            <small>
                                            <input type="checkbox" id="chechkShowPass" onclick="showPass('chechkShowPass','aPwd')"> 
                                            Show password
                                            </small></label>
                                    
                                        <span class="clearfix"></span>
                                <br>
                                <input type="submit" name="submit" value="Save Changes" class="btn btn-success">
                                <a href="?page=user&sub=profile&id=<?php echo $_GET['ref']?>" class="btn btn-md btn-outline btn-primary">Cancel</a>
                              
                              </form> 

                            </div>
                        </div>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

         <script type="text/javascript">
        
            function chkAll(){
            var len = document.getElementById("chkCount").value;

            for(i = 1; i < len ; i ++ )
            {
              if(document.getElementById("stor_all").checked == true)
                document.getElementById("stor_"+i).checked = true;
              else
                document.getElementById("stor_"+i).checked = false;
            }

                
            }       

        </script>



    

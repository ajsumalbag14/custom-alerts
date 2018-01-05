<!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">New User</h1>
                    <?php include("modules/err.php") ?>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <form role="form" action="?page=user&sub=new" method="post">
                                    User Access: 
                                    <select name="access" class="form-control">
                                        <?php
                                            foreach($_access as $val)
                                            {
                                              if($_POST['access'] == $val)
                                              echo '<option value="'.$val.'" selected>'.$_user->getrolename($val).'</option>';
                                              else
                                              echo '<option value="'.$val.'">'.$_user->getrolename($val).'</option>';
                                            }
                                        ?>
                                    </select>
                                    <br>
                                    Name<br>
                                    <input required type="text" name="aName" maxlength="50" placeholder="Name..." class="form-control" value="<?php echo $postname?>">
                                    <br>
                                    Username<br>
                                    <input required type="text" name="aUser" maxlength="20" placeholder="Username" class="form-control" value="<?php echo $postuser?>">
                                    <br>
                                    Email<br>
                                    <input required type="email" name="aEmail" maxlength="30" placeholder="Email Address..." class="form-control" value="<?php echo $postemail?>">

                                    <!--
                                    Password<br>
                                    <input required type="password" id="aPwd" name="aPwd" maxlength="24" placeholder="Password" class="form-control" value="<?php //echo $postpwd?>">
                                    <label style="font-weight:normal; float:right">
                                        <small>
                                        <input type="checkbox" id="chechkShowPass" onclick="showPass('chechkShowPass','aPwd')"> 
                                        Show password
                                        </small></label>
                                    
                                    <span class="clearfix"></span>
                                    -->
                                    <br>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                    <a href="?page=user" class="btn btn-outline btn-primary">Go back</a> 
                                </form>
                            </div>
                        </div>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
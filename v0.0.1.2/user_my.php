

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Account</h1>
                    <?php include("control/err.php") ?>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <form role="form" action="?actn=user&page=my&id=<?php echo $_SESSION['uid']?>" method="post">
                                    <input type="hidden" name="uaccess" value="<?php echo $uaccess?>">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input required class="form-control" name="fname" maxlength="100" value="<?php echo $fname?>">
                                        <p class="help-block">Enter Full Name</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="hidden" name="oname" value="<?php echo $oname?>">
                                        <input required class="form-control" name="uname" maxlength="30" value="<?php echo $uname?>">
                                        <p class="help-block">Max of 30 alpha numeric characters.</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="hidden" name="opwd" value="<?php echo $opwd?>">
                                        <input required type="password" class="form-control" maxlength="20" id="upwd" name="upwd" value="<?php echo $upwd?>">
                                        <label style="font-weight:normal; float:right">
                                            <small>
                                            <input type="checkbox" id="chechkShowPass" onclick="showPass('chechkShowPass','upwd')"> 
                                            Show password
                                            </small></label>
                                    
                                        <span class="clearfix"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Re-type Password</label>
                                        <input required type="password" class="form-control" maxlength="20" id="upwd2" name="upwd2"  value="<?php echo $upwd2?>">
                                        <label style="font-weight:normal; float:right">
                                            <small>
                                            <input type="checkbox" id="chechkShowPass" onclick="showPass('chechkShowPass','upwd2')"> 
                                            Show password
                                            </small></label>
                                    
                                        <span class="clearfix"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary btn-lg" name="submit" value="Submit">
                                        <a href="index.php?actn=user">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    

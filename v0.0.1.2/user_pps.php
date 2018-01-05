

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Password Policy Settings</h1>
                    <?php include("modules/err.php") ?>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form role="form" action="?page=user&sub=pps" method="post">

                                    <div class="form-group">
                                        <blockquote class="text-muted"><small>Last Update: <?php echo $updatedte?> | By: <?php echo $updatedby;?></small></blockquote>
                                        <input type="hidden" name="updatedby" value="<?php echo $updatedby?>">
                                        <input type="hidden" name="updatedte" value="<?php echo $updatedte?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Minimum Password Length</label> <small class="text-muted">(Maximum password length is 24 characters.)</small>

                                        <table class="table">
                                            <tr>
                                                <td width="100">
                                                <input type="number" required class="form-control" name="pwdlen" maxlength="2" value="<?php echo $pwdlen?>">
                                                </td>
                                                <td></td>
                                            </tr>
                                        </table>


                                    </div>
                                    <div class="form-group">
                                        <label>Passwrod Rule Settings</label>
                                        <table class="table">
                                            <tr>
                                                <td width="400">Require at least one numeric digit?</td>
                                                <td>
                                                <?php
                                                    if($bi_num == 1)
                                                    echo' 
                                                    <label><input type="radio" name="bi_num" checked="" value="1"> Yes</label>
                                                    <label><input type="radio" name="bi_num" value="0"> No</label>';
                                                    else
                                                    echo' 
                                                    <label><input type="radio" name="bi_num" value="1"> Yes</label>
                                                    <label><input type="radio" name="bi_num" checked="" value="0"> No</label>';
                                                        
                                                ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Require at least one lower case and at least one upper case letter?</td>
                                                <td>
                                                <?php
                                                    if($bi_case == 1)
                                                    echo '
                                                    <label><input type="radio" name="bi_case" checked="" value="1"> Yes</label>
                                                    <label><input type="radio" name="bi_case"  value="0"> No</label>';
                                                    else
                                                    echo '
                                                    <label><input type="radio" name="bi_case" value="1"> Yes</label>
                                                    <label><input type="radio" name="bi_case" checked="" value="0"> No</label>';    
                                                ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Require at least one special character?</td>
                                                <td>
                                                <?php
                                                    if($bi_char == 1)
                                                    echo '
                                                    <label><input type="radio" name="bi_char" checked="" value="1"> Yes</label>
                                                    <label><input type="radio" name="bi_char" value="0"> No</label>';
                                                    else
                                                    echo '
                                                    <label><input type="radio" name="bi_char" value="1"> Yes</label>
                                                    <label><input type="radio" name="bi_char" checked="" value="0"> No</label>';
                                                ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <label>Password Change Policy</label>
                                        <table class="table">
                                            <tr>
                                                <td width="400">Force password change?</td>
                                                <td>
                                                <?php
                                                    if($bi_change == 0)
                                                    echo '
                                                    <label><input type="radio" name="bi_change" value="1"> Yes</label>
                                                    <label><input type="radio" name="bi_change" checked="" value="0"> No</label>';
                                                    else
                                                    echo '
                                                    <label><input type="radio" name="bi_change" checked="" value="1"> Yes</label>
                                                    <label><input type="radio" name="bi_change" value="0"> No</label>';    
                                                ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td width="100">Every
                                                    <input type="number" class="form-control" name="change_days" maxlength="2" value="<?php echo $change_days; ?>">
                                                    days.
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                   
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" name="submit" value="Save Changes">
                                        <a href="index.php?actn=user" class="btn btn-default">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    

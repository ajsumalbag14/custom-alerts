
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Accounts</h1>
                </div>
                <!-- /.col-lg-12 -->

            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            List of Users
                            <?php
                            if($_COOKIE['access'] != 'Manager')
                            echo ' 
                            <a class="btn btn-primary btn-circle" href="?page=user&sub=new" title="New User"><i class="fa fa-user"></i></a>
                            ';
                            ?>
                            <a class="btn btn-success btn-circle" href="?page=user&sub=profile&id=<?php echo $_COOKIE['adminid']?>" title="My Account"><i class="fa fa-edit"></i></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="font-size:12px">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="50"></th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Access</th>
                                            <th>Email</th>
                                            <th>Log Status</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                            
                                            echo $_user->showUserList($_COOKIE['adminid'],$_COOKIE['access'],$_COOKIE['store'],$_COOKIE['company'],$_COOKIE['lob']);
                                        ?>

                                    </tbody>
                                </table>
                                
                            </div>

                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->


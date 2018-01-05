

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Profile</h1>
                    <?php include("modules/err.php") ?>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">

                                <?php 
                                  if($rs['IMG']!='')
                                    echo '<img src="images/'.$rs['IMG'].'" width="250" class="img-circle"/>';
                                  else
                                    echo '<img src="images/user.png" width="250" class="img-circle"/>';

                                ?>

                                
                            </div>
                            
                            <div class="col-lg-6">
                                <h4> <a class="btn btn-md btn-outline btn-success" href="?page=user&sub=editaccount&ref=<?php echo $_GET['id']?>">Edit Profile</a>| 
                                  <a href="?page=user" class="btn btn-md btn-outline btn-primary">Go back</a>
                                </h4>
                                <table class="table table-striped">
                                      <tr>
                                          <th>Name</th>
                                          <td><?php echo $rs['NAME']?></td>
                                      </tr>
                                      <tr>
                                          <th>Username</th>
                                          <td><?php echo $rs['USERNAME']?></td>
                                      </tr>
                                      <tr>
                                          <th>Email Address</th>
                                          <td><?php echo $rs['EMAIL']?></td>
                                      </tr>
                                      <tr>
                                          <th>Access</th>
                                          <td><?php echo $rs['ACCES']?></td>
                                      </tr>
                                      <tr>
                                          <th>Last Update</th>
                                          <td><?php echo $rs['LASTUPDATE'] != '' ? $rs['LASTUPDATE'] : '---';?></td>
                                      </tr>
                                      <tr>
                                          <th>Updated By</th>
                                          <td><?php echo $updateby?></td>
                                      </tr>
                                      

                                      

                                          
                                  </table>


                                  <?php
                                  if($rs['ACCES'] != 'Manager')
                                  {
                                    if($_COOKIE['ACCES'] != 'Manager' and $_COOKIE['ACCES'] != 'Format' and $_COOKIE['adminid'] != $_GET['id'])
                                    echo '
                                    <h4>Permission <small><a class="btn btn-xs btn-outline btn-success" href="?page=user&sub=editperm&ref='.$_GET['id'].'">Edit</a></small></h4>
                                    <table class="table table-bordered">';

                                    if($msuper == 'Yes')
                                      echo '
                                      <tr>
                                          <th>Manage Super User</th>
                                          <td>'.$msuper.'</td>
                                      </tr>';
                                    if($mglp == 'Yes')
                                      echo '
                                      <tr>
                                          <th>Manage Compliance Officer</th>
                                          <td>'.$mglp.'</td>
                                      </tr>';
                                    if($mformat == 'Yes')
                                      echo '
                                      <tr>
                                          <th>Manage Company Manager</th>
                                          <td>'.$mformat.'</td>
                                      </tr>';
                                    if($mstore == 'Yes')
                                      echo '  
                                      <tr>
                                          <th>Manage Branch Manager</th>
                                          <td>'.$mstore.'</td>
                                      </tr>';
                                    if($_COOKIE['access'] == 'Super' and $msetting == 'Yes')  
                                      echo '
                                      <tr>
                                          <th>Manage Rules Setting</th>
                                          <td>'.$msetting.'</td>
                                      </tr>';
                                       
                                  echo '
                                  </table>

                                   ';
                                 }
                                       ?>
                            </div>
                        </div>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    



        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Permission
                        <a href="?page=user&sub=profile&id=<?php echo $_GET['ref']?>" class="btn btn-xs btn-outline btn-primary">Go back</a>
                    </h1>
                    <?php include("modules/err.php") ?>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <form role="form" action="?page=user&sub=editperm&ref=<?php echo $_GET['ref']?>" method="post">

                                  <input type="hidden" name="userid" value="<?php echo $_GET['ref']; ?>">
                                  <input type="hidden" name="access" value="<?php echo $r['ACCESS']; ?>">
                                  <table>
                                  <?php
                                 
                                    if($_COOKIE['adminid'] == 1)
                                    {
                                        echo '<tr>
                                                    <td>Manage Super User</td>
                                                    <td>
                                                        <select name="msuper" class="form-control">
                                                        ';

                                                          if($r['MSUPER'] == 1)
                                                          echo'
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No
                                                          ';
                                                          else
                                                          echo'
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No
                                                          ';
                                                echo '        
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                echo '
                                                    <tr>
                                                    <td>Manage Compliance Users</td>
                                                    <td>
                                                        <select name="mglp" class="form-control">
                                                      ';
                                                          if($r['MGLP'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                          else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';  
                                                echo '        
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                echo '
                                                    <tr>
                                                    <td>Manage Company Manager</td>
                                                    <td>
                                                        <select name="mformat" class="form-control">
                                                    ';
                                                        if($r['MFORMAT'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                        else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';
                                                echo '
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';


                                                echo '
                                                    <tr>
                                                    <td>Manage Branch Manager</td>
                                                    <td>
                                                        <select name="mstore" class="form-control">
                                                    ';
                                                        if($r['MSTORE'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                        else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';
                                                echo '        
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                
                                                echo '
                                                    <tr>
                                                    <td>Manage Centralized Rules Settings</td>
                                                    <td>
                                                        <select name="msetting" class="form-control">
                                                    ';
                                                        if($r['SETTINGS'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                        else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';
                                                echo '
                                                        </select>
                                                    </td>
                                                    </tr>';
                                    }
                                    else 
                                    {

                                      switch($acc)
                                      {
                                          case 'Super':
                                                echo '<tr>
                                                    <td>Manage Super User</td>
                                                    <td>
                                                        <select name="msuper" class="form-control">
                                                        ';

                                                          if($r['MSUPER'] == 1)
                                                          echo'
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No
                                                          ';
                                                          else
                                                          echo'
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No
                                                          ';
                                                echo '        
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                echo '
                                                    <tr>
                                                    <td>Manage Compliance Users</td>
                                                    <td>
                                                        <select name="mglp" class="form-control">
                                                      ';
                                                          if($r['MGLP'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                          else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';  
                                                echo '        
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                echo '
                                                    <tr>
                                                    <td>Manage Company Manager</td>
                                                    <td>
                                                        <select name="mformat" class="form-control">
                                                    ';
                                                        if($r['MFORMAT'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                        else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';
                                                echo '
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';


                                                echo '
                                                    <tr>
                                                    <td>Manage Branch Manager</td>
                                                    <td>
                                                        <select name="mstore" class="form-control">
                                                    ';
                                                        if($r['MSTORE'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                        else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';
                                                echo '        
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                
                                                echo '
                                                    <tr>
                                                    <td>Manage Centralized Rules Settings</td>
                                                    <td>
                                                        <select name="msetting" class="form-control">
                                                    ';
                                                        if($r['SETTINGS'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                        else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';
                                                echo '
                                                        </select>
                                                    </td>
                                                    </tr>';
                                          break;

                                          case 'GLP':
                                                
                                                echo '
                                                    <tr>
                                                    <td>Manage Company Manager</td>
                                                    <td>
                                                        <select name="mformat" class="form-control">
                                                    ';
                                                        if($r['MFORMAT'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                        else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';
                                                echo '
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                echo '
                                                    <tr>
                                                    <td>Manage Store Manager</td>
                                                    <td>
                                                        <select name="mstore" class="form-control">
                                                    ';
                                                        if($r['MSTORE'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                        else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';
                                                echo '        
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                

                                                
                                          break;

                                          case 'Format':
                                             
                                               echo '
                                                    <tr>
                                                    <td>Manage Branch Manager</td>
                                                    <td>
                                                        <select name="mstore" class="form-control">
                                                    ';
                                                        if($r['MSTORE'] == 1)
                                                          echo '
                                                           <option value="1" selected> Yes
                                                           <option value="0"> No';
                                                        else
                                                          echo '
                                                           <option value="1"> Yes
                                                           <option value="0" selected> No';
                                                echo '        
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';
                                          break;
                                      }//end switch
                                    }//end if-else
                                  ?>
                                  </table>
                                  <br>

                                  <input type="submit" name="submit" value="Save Changes" class="btn btn-success">
                              </form> 

                            </div>
                        </div>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->




    

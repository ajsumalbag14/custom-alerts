

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Permission</h1>
                    <?php include("modules/err.php") ?>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <form role="form" action="?page=user&sub=addperm" method="post">

                                  <input type="hidden" name="userid" value="<?php echo $_GET['ref']; ?>">
                                  <table class="table">
                                  <?php
                                      switch($_SESSION['temp_access'])
                                      {
                                          case 'Super':
                                                echo '<tr>
                                                    <td>Manage Super User</td>
                                                    <td>
                                                        <select name="msuper" class="form-control">
                                                           <option value="1"> Yes
                                                           <option value="0"> No
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                 echo '
                                                    <tr>
                                                    <td>Manage Business Group Users</td>
                                                    <td>
                                                        <select name="mglp" class="form-control">
                                                           <option value="1"> Yes
                                                           <option value="0"> No
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                echo '
                                                    <tr>
                                                    <td>Manage Company Manager</td>
                                                    <td>
                                                        <select name="mformat" class="form-control">
                                                           <option value="1"> Yes
                                                           <option value="0"> No
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';
                                                echo '
                                                    <tr>
                                                    <td>Manage Branch Manager</td>
                                                    <td>
                                                        <select name="mstore" class="form-control">
                                                           <option value="1"> Yes
                                                           <option value="0"> No
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                                
                                                echo '
                                                    <tr>
                                                    <td>Manage Centralized Rules Setting</td>
                                                    <td>
                                                        <select name="msetting" class="form-control">
                                                           <option value="1"> Yes
                                                           <option value="0"> No
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
                                                           <option value="1"> Yes
                                                           <option value="0"> No
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    '; 
                                                echo '
                                                    <tr>
                                                    <td>Manage Branch Manager</td>
                                                    <td>
                                                        <select name="mstore" class="form-control">
                                                           <option value="1"> Yes
                                                           <option value="0"> No
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
                                                           <option value="1"> Yes
                                                           <option value="0"> No
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    ';

                                          break;
                                      }
                                  ?>
                                  </table>
                                  <br>

                                  <input type="submit" name="submit" value="Next" class="btn btn-success">
                              </form> 

                            </div>
                        </div>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->




    

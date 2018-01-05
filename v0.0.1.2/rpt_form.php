
            

            <div class="page-title">
                <div class="title_left">
                  <h3>Custom Reports</h3>

                </div>
            </div>
            <div class="clearfix"></div>

            <?php include("modules/err.php") ?>

                <div class="row">
                  <div class="col-md-7">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Report Criteria</h2>
                        
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <br />
                        <form action="?page=rpt" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                      
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Choose your metric :</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <select class="select2_single form-control" tabindex="-1" name="metric" required="">
                                <option></option>
                                
                                <?php

                                  foreach ($metric as $key => $value) {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                  }

                                ?>

                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Range :</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <div class="input-prepend input-group">
                                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                <input type="text" style="width: 200px" name="daterange" id="reservation" class="form-control" value="<?php echo $inpt_date;?>" />
                              </div>
                            </div>


                            
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Filters :</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" id="filter" name="filter[]" onchange="filterShow()" required="">
                                
                                <?php

                                  foreach ($filters as $value) {
                                    echo '<option value="'.$value.'">'.$value.'</option>';
                                  }

                                ?>


                              </select>
                            </div>
                          </div>

                            <div class="form-group" id="region" style="display:none">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Region :</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" name="region[]">

                                  <?php

                                    foreach ($region as $value) {
                                      echo '<option value="'.$value.'">'.$value.'</option>';
                                    }

                                  ?>


                                </select>
                              </div>
                            </div>

                            <div class="form-group" id="district" style="display:none">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">District :</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" name="district[]">
  
                                  <?php

                                    foreach ($district as $value) {
                                      echo '<option value="'.$value.'">'.$value.'</option>';
                                    }

                                  ?>


                                </select>
                              </div>
                            </div>

                            <div class="form-group" id="store" style="display:none">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Store :</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" name="store[]">
              
                                  <?php

                                    foreach ($store as $value) {
                                      echo '<option value="'.$value.'">'.$value.'</option>';
                                    }

                                  ?>


                                </select>
                              </div>
                            </div>

                            <div class="form-group" id="status" style="display:none">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Status :</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" name="status[]">
                          
                                  <?php

                                    foreach ($status as $value) {
                                      echo '<option value="'.$value.'">'.$value.'</option>';
                                    }

                                  ?>


                                </select>
                              </div>
                            </div>

                            <div class="form-group" id="manager" style="display:none">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Manager :</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" name="manager[]">
                         
                                  <?php

                                    foreach ($manager as $value) {
                                      echo '<option value="'.$value.'">'.$value.'</option>';
                                    }

                                  ?>


                                </select>
                              </div>
                            </div>

                            <div class="form-group" id="loc_type" style="display:none">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Location Type :</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" name="loc_type[]">
                     
                                  <?php

                                    foreach ($loc_type as $value) {
                                      echo '<option value="'.$value.'">'.$value.'</option>';
                                    }

                                  ?>


                                </select>
                              </div>
                            </div>

                            <div class="form-group" id="lifestyle" style="display:none">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Cust Lifestyle :</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" name="lifestyle[]">
                               
                                  <?php

                                    foreach ($lifestyle as $value) {
                                      echo '<option value="'.$value.'">'.$value.'</option>';
                                    }

                                  ?>


                                </select>
                              </div>
                            </div>

                            <div class="form-group" id="associate" style="display:none">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Associate ID :</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" name="assoc[]">
                             
                                  <?php

                                    foreach ($associate as $value) {
                                      echo '<option value="'.$value.'">'.$value.'</option>';
                                    }

                                  ?>


                                </select>
                              </div>
                            </div>

                            <div class="form-group" id="daypart" style="display:none">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Day Part :</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="select2_multiple form-control" multiple="multiple" tabindex="-1" name="daypart[]">
                           
                                  <?php

                                    foreach ($daypart as $value) {
                                      echo '<option value="'.$value.'">'.$value.'</option>';
                                    }

                                  ?>


                                </select>
                              </div>
                            </div>



                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Create your rule :</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <select class="select2_single form-control" tabindex="-1" id="rule" name="rule" onchange="ruleParam()">
                                
                                <?php

                                  foreach ($rule as $key => $value) {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                  }

                                ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group" id="param1" style="display: none">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="param1">Parameter 1 : <span class="required">*</span>
                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <input name="param1" type="text" id="param1" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>

                          <div class="form-group" id="param2" style="display: none">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="param2">Parameter 2 : <span class="required">*</span>
                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <input name="param2" type="text" id="param2" class="form-control col-md-3 col-xs-12">
                            </div>
                          </div>
                        
                          <div class="ln_solid"></div>
                          <div class="form-group">
                              <input type="submit" name="submit" class="btn btn-success"></button>
                          
                          </div>

                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="clearfix"></div>

                  <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                          <h2>Report Parameters Summary </h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                          <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>METRIC</th>
                                <th>DATE RANGE</th>
                                <th>FILTER</th>
                                <th>RULES</th>
                                <th>DATE ADDED</th>
                                <th>OPTION</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                              <?php 

                                $ctr = 1;
                                foreach($set->con->query($que) as $rs)
                                {

                                  if($rs['REGION'] != 'null')
                                    $tregion = '<small>Region(s): </small>'.str_replace('#', ', ', $rs['REGION']).'<br>';

                                  if($rs['DISTRICT'] != 'null')
                                    $tdistrict = '<small>District(s): </small>'.str_replace('#', ', ',$rs['DISTRICT']).'<br>';

                                  if($rs['STORE'] != 'null')
                                    $tstore = '<small>Store(s): </small>'.str_replace('#', ', ',$rs['STORE']).'<br>';

                                  if($rs['MANAGER'] != 'null')
                                    $tmanager = '<small>Manager(s): </small>'.str_replace('#', ', ',$rs['MANAGER']).'<br>';

                                  if($rs['STATUS'] != 'null')
                                    $tstatus = '<small>Status(s): </small>'.str_replace('#', ', ',$rs['STATUS']).'<br>';

                                  if($rs['LOCATION'] != 'null')
                                    $tlocation = '<small>Location Type(s): </small>'.str_replace('#', ', ',$rs['LOCATION']).'<br>';

                                  if($rs['LIFESTYLE'] != 'null')
                                    $tlifetyle = '<small>Cust Lifestyle(s): </small>'.str_replace('#', ', ',$rs['LIFESTYLE']).'<br>';

                                  if($rs['ASSOC'] != 'null')
                                    $tassoc = '<small>Associate ID(s): </small>'.str_replace('#', ', ',$rs['ASSOC']).'<br>';

                                  if($rs['DAYPART'] != 'null')
                                    $tdaypart = '<small>Day Part(s): </small>'.str_replace('#', ', ',$rs['DAYPART']).'<br>';

                                  foreach($rule as $key => $value) {
                                    if($key == $rs['RULE'])
                                    {

                                      switch($key)
                                      {
                                        case 'LT':

                                        $trule = 'LESS THAN '.$rs['PARAM1'];
                                        break;
                                        case 'GT':

                                        $trule = 'GREATER THAN '.$rs['PARAM1'];
                                        break;

                                        case 'BT':
                                        $trule = 'BETWEEN '.$rs['PARAM1'].' AND '.$rs['PARAM2'];
                                        break;

                                        case 'OT':
                                        $trule = 'OUTLIER';
                                        break;

                                        case 'All':
                                        $trule = 'All';
                                        break;

                                      } 
                                      
                                    }
                                  }

                                  foreach($metric as $key => $value) {
                                    if($key == $rs['METRICID'])
                                    {
                                        $tmetric = $value;
                                    }
                                  }

                                  $link = "'view_report.php?page=".$rs['METRICID']."&id=".$rs['ID']."'";

                                  echo '
                                    <tr>
                                      <td>'.$ctr.'</td>
                                      <td>'.$tmetric.'</td>
                                      <td>'.$rs['STARTDATE'].' to '.$rs['ENDDATE'].'</td>
                                      <td>'.$tregion.$tdistrict.$tstore.$tmanager.$tstatus.$tlocation.$tlifetyle.$tassoc.$tdaypart.'</td>
                                      <td>'.$trule.'</td>
                                      <td>'.$rs['DATE_ADDED'].'</td>
                                      <td>
                                        
                                        
                                        <a href="javascript:Popup('.$link.')" title="View Report">
                                        <i class="fa fa-external-link-square"></i> View Report</a>
                                        &bull;
                                        <a href="?page=rpt&sub=email" title="Click to send email notification">
                                        <i class="fa fa-envelope"></i> Mail</a>
                                        &bull;
                                        <a href="?page=rpt&sub=del&metric='.$rs['METRICID'].'" title="Delete Settings">
                                        <i class="fa fa-remove"></i> Delete</a>


                                      </td>
                                    </tr>

                                  ';

                                  $ctr++;
                                }
                              ?>

                            </tbody>

                          </table>
                          
                        </div>
                    </div>


                    <div class="clearfix"></div>
                  </div>

              </div>
            </div>
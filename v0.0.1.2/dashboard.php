
  <!-- Page Content -->
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header">Dashboard</h1>
              <?php include("modules/err.php") ?>
          </div>
          <!-- /.col-lg-12 -->

      </div>
      <!-- /.row -->
      <div class="row">
          <div class="col-lg-12">

              <!-- top tiles -->
              <div class="row tile_count">


                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top">Discount Percent</span>
                  <div class="count"><?php echo number_format($totcount_disc);?></div>
                  <a href="?page=disc" class="btn btn-info btn-sm">  Review Alerts</a>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top">Cancelled Sales</span>
                  <div class="count"><?php echo number_format($totcount_cncl);?></div>
                  <a href="?page=cncl" class="btn btn-info btn-sm">  Review Alerts</a> 
                </div>

                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top">Voids</span>
                  <div class="count"><?php echo number_format($totcount_void);?></div>
                  <a href="?page=void" class="btn btn-info btn-sm"> Review Alerts</a>
                </div>


              </div>
              <!-- /top tiles -->

          </div>
      </div>

  </div>


     
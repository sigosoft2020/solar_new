<!DOCTYPE html>
<html lang="en">
  <head>
   <?php $this->load->view('admin/includes/head');?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
             <?php $this->load->view('admin/includes/topbar');?>
        <!-- top navigation -->
             <?php $this->load->view('admin/includes/navbar');?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="page-title">
              <div class="title_left">
                <h3 style="color: #ff6600;">Call Button</h3>
              </div>              
            </div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                       <form class="form form-horizontal" method="POST" action="<?=site_url('admin/calls/insert_data')?>" enctype="multipart/form-data">
                               <div class="row">
                                  <div class="col-md-8">
                                      <div class="">
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="title" class="form-control" placeholder=" Title" maxlength="250" required>
                                              </div>
                                          </div>
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone </label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="phonenumber" class="form-control" placeholder="Phone Number" maxlength="10" pattern="[6-9]{1}[0-9]{9}" title="Enter a valid phonenumber"" required>
                                              </div>
                                          </div>                                            
                                      </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <button type="submit" class="btn btn-warning btn-rounded waves-light waves-effect w-md pull-right" id="submit-button">Add</button>
                                    </div>
                                </div>
                         </form>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
        <!-- /page content -->

        <!-- footer content -->
         <?php $this->load->view('admin/includes/footer');?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <?php $this->load->view('admin/includes/scripts');?>
  </body>
</html>

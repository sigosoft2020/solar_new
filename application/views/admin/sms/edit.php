<!DOCTYPE html>
<html lang="en">
  <head>
   <?php $this->load->view('admin/includes/head');?>
   <link rel="stylesheet" href="<?=base_url()?>plugins/image-crop/croppie.css">
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
                <h3 style="color: #ff6600;">SMS Gateway</h3>
              </div>              
            </div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                     <form class="form form-horizontal" method="POST" action="<?=site_url('admin/sms/update_data')?>" enctype="multipart/form-data">
                              <input type="hidden" name="sms_id" value="<?=$sms->sms_id?>">
                               <div class="row">
                                  <div class="col-md-8">
                                      <div class="">
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text"  value="<?=$sms->title?>" name="title" class="form-control" placeholder="Banner Title" maxlength="250" required>
                                              </div>
                                          </div>
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Link</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text"  value="<?=$sms->link?>" name="link" class="form-control" placeholder="SMS Title" maxlength="500" required>
                                              </div>
                                          </div> 
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                               <select  name="status" class="form-control">
                                                <option value="Active" <?php if($sms->status == 'Active'){?>selected<?php } ?> >Active</option>
                                                <option value="Blocked" <?php if($sms->status == 'Blocked'){?>selected<?php } ?> >Blocked</option>
                                              </select>
                                            </div>
                                          </div>    
                                      </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <button type="submit" class="btn btn-warning btn-rounded waves-light waves-effect w-md pull-right" id="submit-button">Update</button>
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

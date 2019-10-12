<!DOCTYPE html>
<html lang="en">
  <head>
     <?php $this->load->view('admin/includes/datatable_css');?>
  </head>
  <?php $message  = $this->session->flashdata('add_message'); ?>
  <?php $message1 = $this->session->flashdata('edit_message'); ?>
  <?php $error    = $this->session->flashdata('add_error'); ?>
  <body class="nav-md">

   <?php if (isset($message)){ ?>
        <div class="alert alert-success additional">
          <strong>Success</strong> Data added successfully
        </div>
    <?php } ?>

    <?php if (isset($message1)){ ?>
        <div class="alert alert-success additional">
          <strong>Success</strong> Data modified successfully
        </div>
    <?php } ?>

    <?php if (isset($error)){ ?>
        <div class="alert alert-danger additional">
          <strong>Oops</strong> Data already added
        </div>
    <?php } ?>

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
                <h3 style="color: #ff6600;">FAQ</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Manage</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                    <table id="user_data" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="20%" style="border-color: #ff6600;">Image</th>    
                          <th width="20%" style="border-color: #ff6600;">Title</th>
                          <th width="40%" style="border-color: #ff6600;">Description</th>
                          <th width="10%" style="border-color: #ff6600;">Date</th>
                          <th width="5%" style="border-color: #ff6600;">Status</th>
                          <th width="5%" style="border-color: #ff6600;">Edit</th>
                        </tr>
                      </thead>
                    </table>
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
    <?php $this->load->view('admin/includes/datatable_js');?>
    <script type="text/javascript">
      $(document).ready(function(){
        var dataTable = $('#user_data').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
            url:"<?=site_url('admin/news/get')?>",
            type:"POST"
          },
          "columnDefs":[
            {
              "target":[0,3,4],
              "orderable":true
            }
          ]
        });
      });
   </script>
   <script type="">         
       $("document").ready(function(){
       $(".additional").delay(1500).fadeOut(1200 );
       })
   </script>
  </body>
</html>
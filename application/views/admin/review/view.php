<!DOCTYPE html>
<html lang="en">
  <head>
     <?php $this->load->view('admin/includes/datatable_css');?>
  </head>
  <?php $message1 = $this->session->flashdata('edit_message'); ?>
  <body class="nav-md">

    <?php if (isset($message1)){ ?>
        <div class="alert alert-success additional">
          <strong>Success</strong> Data modified successfully
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
                <h3 style="color: #ff6600;">Product Reviews</h3>
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
                          <th width="1%" style="border-color: #ff6600;">Order Number</th>
                          <th width="10%" style="border-color: #ff6600;">Customer Name</th>
                          <th width="10%" style="border-color: #ff6600;">Product Name</th>
                          <th width="20%" style="border-color: #ff6600;">Product Review</th>
                          <th width="5%" style="border-color: #ff6600;">Star Rating</th>
                          <th width="5%" style="border-color: #ff6600;">Status</th>
                          <th width="2%" style="border-color: #ff6600;">Edit</th>
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
          <div id="edit-status" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                      <div class="modal-body">
                          <h2 class="text-uppercase text-center m-b-30">
                              <span><h4 style="color: #ff6600;">Edit Status</h4></span>
                          </h2>

                          <form class="form-horizontal" action="<?=site_url('admin/product_review/update_data')?>" method="post">
                              <input type="hidden" name="review_id" id="review_id">
                               <div class="form-group m-b-25">
                                  <div class="col-6">
                                    <label for="select">Status</label>
                                    <select  name="status" class="form-control">
                                      <option value="Active">Active</option>
                                      <option value="Blocked">Blocked</option>
                                    </select>
                                  </div>
                               </div>
                               <div class="form-group account-btn text-center m-t-10">
                                  <div class="col-6">
                                      <button type="reset" class="btn w-lg btn-rounded btn-light waves-effect m-l-5" data-dismiss="modal">Back</button>
                                      <button class="btn w-lg btn-rounded btn-warning waves-effect waves-light" type="submit">Update</button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
       </div>       
 
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
            url:"<?=site_url('admin/product_review/get')?>",
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
     function edit(id,status)
      {
        // alert(id);
        // alert(status);
         $('#review_id').val(id);
         // $('#review_status').val(status);
         $('#edit-status').modal('show');
      }
     </script> 
     <script type="">         
         $("document").ready(function(){
         $(".additional").delay(1500).fadeOut(1200 );
         })
     </script>
  </body>
</html>
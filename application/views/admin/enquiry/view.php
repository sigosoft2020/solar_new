<!DOCTYPE html>
<html lang="en">
  <head>
     <?php $this->load->view('admin/includes/datatable_css');?>
  </head>
  <?php $message  = $this->session->flashdata('message'); ?>
  <body class="nav-md">

   <?php if (isset($message)){ ?>
        <div class="alert alert-success additional">
          <strong>Success</strong> Data added successfully
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
                <h3 style="color: #ff6600;">Enquiry</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 style="color: #ff6600;">Manage Enquiries</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                    <table id="user_data" class="table table-striped table-bordered">
                      <thead>
                        <tr>                          
                          <th style="border-color: #ff6600;">Product Name</th>
                          <th style="border-color: #ff6600;">Customer Name</th>
                          <th style="border-color: #ff6600;">Customer Phone</th>
                          <th style="border-color: #ff6600;">Customer Address</th>
                          <th style="border-color: #ff6600;">Response</th>
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

        <div id="add-response" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-body">
                          <h2 class="text-uppercase text-center m-b-30">
                              <span><h4 style="color: #ff6600;">Add Enquiry Response</h4></span>
                          </h2>


                          <form class="form-horizontal" action="<?=site_url('admin/enquiry/add_response')?>" method="post">

                              <div class="form-group m-b-25">
                                  <div class="col-12">
                                      <label for="select">Enquiry Comments</label>
                                      <input type="text" name="comments" id="enquiry_comments" class="form-control" required>
                                      <input type="hidden" name="enquiry_id" id="enquiry_id" class="form-control" required>
                                  </div>
                              </div>
                              <div class="form-group m-b-25">
                                  <div class="col-12">
                                      <label for="select">Response</label>
                                      <textarea type="text" name="response" id="response" class="form-control" required></textarea>
                                  </div>
                              </div>
                              
                              <div class="form-group account-btn text-center m-t-10">
                                  <div class="col-12">
                                      <button type="reset" class="btn w-lg btn-rounded btn-light waves-effect m-l-5" data-dismiss="modal">Back</button>
                                      <button class="btn w-lg btn-rounded btn-warning waves-effect waves-light" type="submit">Add</button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
       </div>

       <div id="view-response" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-body">
                          <h2 class="text-uppercase text-center m-b-30">
                              <span><h4 style="color: #ff6600;">View Enquiry</h4></span>
                          </h2>

                          <form class="form-horizontal">

                              <div class="form-group m-b-25">
                                  <div class="col-12">
                                      <label for="select">Enquiry Comments</label>
                                      <input type="text" name="comments" id="enquiry_comment" class="form-control" required>
                                    
                                  </div>
                              </div>
                              <div class="form-group m-b-25">
                                  <div class="col-12">
                                      <label for="select">Response</label>
                                      <textarea type="text" name="response" id="enquity_response" class="form-control" required></textarea>
                                  </div>
                              </div>
                             
                              <div class="form-group account-btn text-center m-t-10">
                                  <div class="col-12">
                                      <button type="reset" class="btn w-lg btn-rounded btn-light waves-effect m-l-5" data-dismiss="modal">Back</button>
                                     
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
            url:"<?=site_url('admin/enquiry/get')?>",
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
     function add(id,comments)
      {
        // alert(id);
       $('#enquiry_id').val(id);
       $('#enquiry_comments').val(comments);
       $('#add-response').modal('show');
      }

      function view(res,comments)
      {
        // alert(res);
       $('#enquity_response').val(res);
       $('#enquiry_comment').val(comments);
       $('#view-response').modal('show');
      }
     </script> 
   <script type="">         
       $("document").ready(function(){
       $(".additional").delay(1500).fadeOut(1200 );
       })
   </script>
  </body>
</html>
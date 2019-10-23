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
                <h3 style="color: #ff6600;">User Doubts</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 style="color: #ff6600;">Manage doubts</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                    <table id="user_data" class="table table-striped table-bordered">
                      <thead>
                        <tr>                          
                          <th width="25%" style="border-color: #ff6600;">Customer Name</th>
                          <th width="60%" style="border-color: #ff6600;">Question</th>
                          <th width="15%" style="border-color: #ff6600;">Status</th>
                          <th width="5%" style="border-color: #ff6600;">Answer</th>
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

        <div id="add-answer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-body">
                          <h2 class="text-uppercase text-center m-b-30">
                              <span><h4 style="color: #ff6600;">Add Answer</h4></span>
                          </h2>


                          <form class="form-horizontal" action="<?=site_url('admin/chats/add_answer')?>" method="post">

                              <div class="form-group m-b-25">
                                  <div class="col-12">
                                      <label for="select">Question</label>
                                      <input type="text" name="comments" id="question" class="form-control" required readonly>
                                      <input type="hidden" name="qs_id" id="qs_id" class="form-control" required>
                                  </div>
                              </div>
                              <div class="form-group m-b-25">
                                  <div class="col-12">
                                      <label for="select">Answer</label>
                                      <textarea type="text" name="answer" id="answer" class="form-control" required></textarea>
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

       <div id="edit-answer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-body">
                          <h2 class="text-uppercase text-center m-b-30">
                              <span><h4 style="color: #ff6600;">Edit Answer</h4></span>
                          </h2>

                          <form class="form-horizontal" action="<?=site_url('admin/chats/edit_answer')?>" method="post">

                              <div class="form-group m-b-25">
                                  <div class="col-12">
                                      <label for="select">Question</label>
                                      <input type="text" name="question" id="quest" class="form-control" readonly>
                                      <input type="hidden" name="qst_id" id="qst_id" class="form-control" required>
                                  </div>
                              </div>
                              <div class="form-group m-b-25">
                                  <div class="col-12">
                                      <label for="select">Answer</label>
                                      <textarea type="text" name="ans" id="ans" class="form-control" required></textarea>
                                  </div>
                              </div>
                             
                              <div class="form-group account-btn text-center m-t-10">
                                  <div class="col-12">
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
            url:"<?=site_url('admin/chats/get')?>",
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
     function add(id,quesion)
      {
        // alert(id);
       $('#qs_id').val(id);
       $('#question').val(quesion);
       $('#add-answer').modal('show');
      }

      function edit(id,answer,quesion)
      {
        // alert(res);
        $('#qst_id').val(id);
       $('#ans').val(answer);
       $('#quest').val(quesion);
       $('#edit-answer').modal('show');
      }
     </script> 
   <script type="">         
       $("document").ready(function(){
       $(".additional").delay(1500).fadeOut(1200 );
       })
   </script>
  </body>
</html>
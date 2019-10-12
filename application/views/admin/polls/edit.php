<!DOCTYPE html>
<html lang="en">
  <head>
   <?php $this->load->view('admin/includes/head');?>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css" rel="stylesheet">
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
                <h3 style="color: #ff6600;">Polls</h3>
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
                       <form class="form form-horizontal" method="POST" action="<?=site_url('admin/polls/editPoll')?>" enctype="multipart/form-data">
                               <div class="row">
                                  <div class="col-md-7">
                                      <div class="">
                                         <input type="hidden" name="poll_id" value="<?=$poll->poll_id?>">
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Question <span style="color:red">*</span></label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" maxlength="150" placeholder="Enter poll question" name="question" id="question" class="form-control" value="<?=$poll->question?>" required>
                                              </div>
                                          </div>
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Poll end date</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="date" class="form-control" id="datepicker3" name="end_date" value="<?=$poll->end_date?>">
                                                <p id="start-date-error" style="color:red;"></p>
                                              </div>
                                          </div>
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Poll end time : <span style="font-style:italic;font-size:13px;">(Click on the icon to select time)</span></label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class='input-group date' id='myDatepicker3'>
                                                    <input type='text' class="form-control" name="end_time" value="<?=$poll->end_time?>" required/>
                                                    <span class="input-group-addon">
                                                       <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                              </div>
                                          </div>
                                          <br>
                                           <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class='input-group date' id='myDatepicker3'>
                                                    <select class="form-control" name="status">
                                                        <option <?php if($poll->status){ echo "selected";}?> value="1">Active</option>
                                                        <option value="0" <?php if(!$poll->status){ echo "selected";}?>>Blocked</option>
                                                    </select>
                                                </div>
                                              </div>
                                          </div>
                                          <br>
                                          <div class="form-group">
                                            
                                          </div>
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Add Options</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <div id="options-div">
                                                <table id="options" width="100%">
                                                   <?php $i=0; foreach ($options as $option) { ?>
                                                    <tr>
                                                      <td width="95%"><input type="text" class="form-control" name="options<?=$option->opt_id?>" value="<?=$option->option_name?>" required></td>
                                                      <td><a class='btn btn-link' onclick='deleteRow(this,<?=$option->opt_id?>);'><i style='font-size:25px; color:red;' class='fa fa-minus-circle'></i></a></td>
                                                    </tr>
                                                  <?php $i++; } ?>
                                                </table>
                                              </div>
                        
                                              <div class="text-center">
                                                <button type="button" class="btn btn-link" onclick="addRow()"><i style="font-size:25px;" class="fa fa-plus-circle"></i></button>
                                              </div>
                                            </div>  
                                          </div>
                                          <br>
                                          
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
    <script src="<?=base_url()?>plugins/image-crop/croppie.js"></script>
    <script>
        $('#myDatepicker').datetimepicker();
        
        $('#myDatepicker2').datetimepicker({
            format: 'DD.MM.YYYY'
        });
        
        $('#myDatepicker3').datetimepicker({
            format: 'hh:mm A'
        });
        
        $('#myDatepicker4').datetimepicker({
            ignoreReadonly: true,
            allowInputToggle: true
        });
    
        $('#datetimepicker6').datetimepicker();
        
        $('#datetimepicker7').datetimepicker({
            useCurrent: false
        });
        
        $("#datetimepicker6").on("dp.change", function(e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        
        $("#datetimepicker7").on("dp.change", function(e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
   </script>
    <script type="text/javascript">
        function addRow()
        {
          var col1 = "<tr><td><input type='text' class='form-control' name='options[]' required></td>";
    
          var col2 = "<td><a class='btn btn-link' onclick='deleteRow(this);'><i style='font-size:25px; color:red;' class='fa fa-minus-circle'></i></a></td></tr>";
          var row = col1 + col2;
          $('#options').append(row);
        }
        
        function deleteRow(row,id)
        {
          if (id == 0) {
            $(row).closest('tr').remove();
    
            var length = $('#options tr').length;
            if(length == 0)
            {
              addRow();
            }
          }
          else {
            if (confirm('Are you sure to remove this option from the poll , all users polls on this option will get deleted')) {
              $.ajax({
                method: "POST",
                url: "<?=site_url('admin/polls/deletePollOption');?>",
                data : { opt_id : id },
                dataType : "json",
                success : function( data ){
                  $(row).closest('tr').remove();
    
                  var length = $('#options tr').length;
                  if(length == 0)
                  {
                    addRow();
                  }
                }
              });
            }
          }
        }
  </script>
  </body>
</html>

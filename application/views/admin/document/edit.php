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
                <h3 style="color: #ff6600;">My Documents</h3>
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
                      <form class="form form-horizontal" method="POST" action="<?=site_url('admin/documents/update_data')?>" enctype="multipart/form-data">
                         <input type="hidden" name="document_id" value="<?=$document->document_id?>">
                               <div class="row">
                                  <div class="col-md-6">
                                      <div class="">
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Document Title</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" value="<?=$document->document_title?>" name="title" class="form-control" placeholder="Document Title" maxlength="250" required>
                                              </div>
                                          </div>
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Document Type</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select name="type" id="type" class="form-control" required>
                                                   <option value="">---Select Type---</option>
                                                   <option value="photo" <?php if($document->document_type == 'photo'){?>selected<?php } ?> >Image</option>
                                                    <option value="video" <?php if($document->document_type == 'video'){?>selected<?php } ?> >Video</option>
                                                    <option value="audio" <?php if($document->document_type == 'audio'){?>selected<?php } ?> >Audio</option>
                                                    <option value="fact_sheet" <?php if($document->document_type == 'fact_sheet'){?>selected<?php } ?> >Fact sheet</option>
                                                </select>
                                              </div>
                                          </div>
                                        
                                         <?php if($document->document_type == 'photo')
                                            {
                                          ?>  
                                         <div class="form-group" id='add_image'>
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <input type="file" class="form-control" id="upload">
                                            </div>
                                          </div>
                                          <?php } else {?>  
                                            <div class="form-group" style='display:none;' id='add_image'>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="file" class="form-control" id="upload">
                                              </div>
                                          </div>
                                          <?php };?>

                                          <?php if($document->document_type == 'video') {?>  
                                            <div class="form-group" id='add_video'>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Video link</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                 <input type="text" value="<?=$document->file?>" class="form-control" name="video" id="video" maxlength="500">
                                              </div>
                                          </div>
                                         <?php } else {?>   
                                            <div class="form-group" style='display:none;' id='add_video'>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Video</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                 <input type="text" class="form-control" name="video" id="video" maxlength="500">
                                              </div>
                                          </div>
                                         <?php };?>


                                          <?php if($document->document_type == 'audio') { ?>
                                            <div class="form-group" id='add_audio'>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Audio</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                 <input type="file" class="form-control" name="audio" id="audio"  onchange="preview_audio(this)">
                                              </div>
                                          </div>
                                          <?php } else {?>  
                                          <div class="form-group" style='display:none;' id='add_audio'>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Audio</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                               <input type="file" class="form-control" name="audio" id="audio"  onchange="preview_audio(this)">
                                            </div>
                                          </div>
                                          <?php };?>


                                         <?php if($document->document_type == 'fact_sheet') {?>
                                          <div class="form-group" id='add_sheet'>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fact Sheet</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="file" class="form-control" name="fact_sheet" id="fact_sheet" onchange="preview_sheet(this)">
                                              </div>
                                          </div>  
                                          <?php } else { ?>  
                                          <div class="form-group" style='display:none;' id='add_sheet'>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fact Sheet</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <input type="file" class="form-control" name="fact_sheet" id="fact_sheet" onchange="preview_sheet(this)">
                                            </div>
                                          </div>  
                                          <?php };?>
                                         
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                               <select  name="status" class="form-control">
                                                <option value="Active" <?php if($document->document_status == 'Active'){?>selected<?php } ?> >Active</option>
                                                <option value="Blocked" <?php if($document->document_status == 'Blocked'){?>selected<?php } ?> >Blocked</option>
                                              </select>
                                            </div>
                                          </div>                                               
                                      </div>
                                    </div>

                                    <div class="col-md-6">     
                                       
                                       <?php if($document->document_type == 'photo')
                                          {
                                        ?>
                                        <div id="current-image">  
                                           <img src="<?=base_url() . $document->file?>" height="180px" width="300px"> 
                                        </div>   
                                        <?php } elseif($document->document_type == 'audio') { ?>
                                          <div id="current-image">    
                                           <audio controls>           
                                              <source src="<?=base_url().$document->file?>" type="audio/mpeg">    
                                              </audio>
                                          </div>    
                                         <?php } elseif($document->document_type == 'fact_sheet') { ?> 
                                          <div id="current-image"> 
                                           <a href="<?=base_url().$document->file?>"><img src="<?=base_url()?>assets/images/pdf.png" width="60" height="60"></a>  
                                          </div>
                                        <?php } else {?>
                                          <div id="current-image"></div>
                                        <?php };?>    

                                      <div class="upload-div" style="display:none;">
                                        <div id="upload-demo"></div>
                                        <div class="col-12 text-center">
                                          <a href="#" class="btn btn-warning btn-flat" style="border-radius : 5px;" id="crop-button">Crop</a>
                                        </div>
                                      </div>

                                      <div class="upload-result text-center" id="upload-result" style="display : none; margin-bottom:10px;">

                                      </div>
                                      <input type="hidden" name="image" id="ameimg" >
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
    <script src="<?=base_url()?>plugins/image-crop/croppie.js"></script>
    <script>
         $(document).ready(function()
         {
            $('#type').on('change', function() {
              if ( this.value == 'photo')
              //.....................^.......
              {
                $("#add_image").show();
              }
              else
              {
                $("#add_image").hide();
              }

              if(this.value=='video')
              {
                $("#add_video").show();
              }
              else
              {
                $("#add_video").hide();
              }
             
             if(this.value=='audio')
              {
                $("#add_audio").show();
              }
              else
              {
                $("#add_audio").hide();
              }

              if(this.value=='fact_sheet')
              {
                $("#add_sheet").show();
              }
              else
              {
                $("#add_sheet").hide();
              }
            });
        });

    function preview_audio(id)
     {
       var id = id.id;
       var x = document.getElementById(id);
       var size = x.files[0].size;
       if (size > 50000000) {
         alert('Please select an image with size less than 5 mb.');
         document.getElementById(id).value = "";
       }
       else {
         var val = x.files[0].type;
         var type = val.substr(val.indexOf("/") + 1);
         s_type = ['mp3','ogg','wav','mpa'];
         var flag = 0;
         for (var i = 0; i < s_type.length; i++) {
           if (s_type[i] == type) {
             flag = flag + 1;
           }
         }
         if (flag == 0) {
           alert('This file format is not supported.');
           document.getElementById(id).value = "";
         }
       }
     }
    

    function preview_sheet(id)
     {
       var id = id.id;
       var x = document.getElementById(id);
       var size = x.files[0].size;
       if (size > 50000000) {
         alert('Please select an image with size less than 5 mb.');
         document.getElementById(id).value = "";
       }
       else {
         var val = x.files[0].type;
         var type = val.substr(val.indexOf("/") + 1);
         s_type = ['pdf','doc','docx','xsl','xslx'];
         var flag = 0;
         for (var i = 0; i < s_type.length; i++) {
           if (s_type[i] == type) {
             flag = flag + 1;
           }
         }
         if (flag == 0) {
           alert('This file format is not supported.');
           document.getElementById(id).value = "";
         }

       }
     }
     </script>
    <script type="text/javascript">
    $uploadCrop = $('#upload-demo').croppie({
      enableExif: true,
      viewport: {
          width: 300,
          height: 180,
          type: 'rectangle'
      },
      boundary: {
          width: 400,
          height: 400
      }
    });


   $('#upload').on('change', function () {
    $("#submit-button").css("display", "none");
    var file = $("#upload")[0].files[0];
    var val = file.type;
    var type = val.substr(val.indexOf("/") + 1);
    if (type == 'png' || type == 'jpg' || type == 'jpeg') {

      $("#current-image").css("display", "none");
      $("#submit-button").css("display", "none");

      $(".upload-div").css("display", "block");
      $("#submit-button").css("display", "none");
      var reader = new FileReader();
        reader.onload = function (e) {
          $uploadCrop.croppie('bind', {
            url: e.target.result
          }).then(function(){
            console.log('jQuery bind complete');
          });

        }
        reader.readAsDataURL(this.files[0]);
    }
    else {
      alert('This file format is not supported.');
      document.getElementById("upload").value = "";
      $("#upload-result").css("display", "none");
      $("#submit-button").css("display", "none");
      $("#current-image").css("display", "block");
      $('#ameimg').val('');
    }
  });


  $('#crop-button').on('click', function (ev) {
      $("#submit-button").css("display", "block");
    $uploadCrop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function (resp) {
      html = '<img src="' + resp + '" />';
      $("#upload-result").html(html);
      $("#upload-result").css("display", "block");
      $(".upload-div").css("display", "none");
      $("#submit-button").css("display", "block");
      $('#ameimg').val(resp);
    });
  });
  </script>
  </body>
</html>

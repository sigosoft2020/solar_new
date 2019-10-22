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
                <h3 style="color: #ff6600;">Banners</h3>
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
                      <form class="form form-horizontal" method="POST" action="<?=site_url('admin/banners/insert_data')?>" enctype="multipart/form-data">
                               <div class="row">
                                  <div class="col-md-5">
                                      <div class="">
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="title" class="form-control" placeholder="Banner Title" maxlength="100" required>
                                              </div>
                                          </div>
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Product ID</label>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="number" min="0" name="product_id" class="form-control" placeholder="Product ID" required>
                                              </div>
                                          </div>
                                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <input type="file" class="form-control" placeholder="Default Input" id="upload">
                                            </div>
                                          </div>                                              
                                      </div>
                                    </div>

                                    <div class="col-md-7">     
                                       
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
                                        <button type="submit" class="btn btn-warning btn-rounded waves-light waves-effect w-md pull-right" id="submit-button" style="display:none;">Add</button>
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
    <script type="text/javascript">
     $uploadCrop = $('#upload-demo').croppie({
      enableExif: true,
      viewport: {
          width: 450,
          height: 250,
          type: 'rectangle'
      },
      boundary: {
          width: 600,
          height: 600
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

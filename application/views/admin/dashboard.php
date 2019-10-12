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
             <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                  <div class="count"><?php echo @$enquiries;?></div>
                  <h3>Pending Enquiries</h3>
                  <p></p>
                </div>
              </div>
              
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i></div>
                  <div class="count"><?php echo @$documents;?></div>
                  <h3>Total Documents</h3>
                  <p></p>
                </div>
              </div>
              
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                  <div class="count"><?php echo @$feedback;?></div>
                  <h3>Feedbacks</h3>
                  <p></p>
                </div>
              </div>
              
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o"></i></div>
                  <div class="count"><?php echo @$reviews;?></div>
                      <h3>Product Reviews</h3>
                      <p></p>
                  </div>
               </div>
              </div>
            
            
              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Enquiries</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  
                  <div class="x_content">
                    <?php foreach($enquiry as $en) {?>  
                    <article class="media event">
                       <a class="pull-left border-aero profile_thumb">
                         <i class="fa fa-user aero"></i>
                       </a>
                       <div class="media-body">
                          <a class="title" href="#"><?php echo @$en->product_name;?></a>
                          <p><strong><?php echo @$en->customer_name;?>. </strong> <?php echo @$en->customer_phone;?> </p>
                          <p> <small><?php echo @$en->comments;?></small>
                          </p>
                       </div>
                    </article>
                   <?php };?>
                  </div>
                </div>
              </div>
              
              
              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Product Reviews</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php foreach($review as $rev) {?>  
                     <article class="media event">
                       <a class="pull-left border-aero profile_thumb">
                         <i class="fa fa-user aero"></i>
                       </a>
                       <div class="media-body">
                          <a class="title" href="#"><?php echo @$rev->product_name;?></a>
                          <p><strong><?php echo @$rev->customer_name;?>. </strong></p>
                          <p> <strong><?php echo @$rev->star_rating;?><i class="fa fa-star"></i>.</strong><small><?php echo @$rev->product_review;?></small></p>
                         
                       </div>
                    </article>
                   <?php };?>
                  </div>
                </div>
              </div>
              
              
              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Latest Feedbacks</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php foreach($feedbacks as $feedback) {?>  
                     <article class="media event">
                       <a class="pull-left border-aero profile_thumb">
                         <i class="fa fa-user aero"></i>
                       </a>
                       <div class="media-body">
                          <a class="title" href="#"><?php echo @$feedback->customer_name;?></a>
                          <p><strong><?php echo @$feedback->customer_comments;?>. </strong> <?php echo @$feedback->no_of_stars;?> </p>
                          
                       </div>
                    </article>
                   <?php };?> 
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

   <?php $this->load->view('admin/includes/scripts');?>
  
  </body>
</html>

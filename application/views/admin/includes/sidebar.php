    <?php $user = $this->session->userdata['admin']; ?>
          <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?=base_url()?>assets/images/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $user['name'];?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />
         <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="<?=site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> Dashborad</a></li>
                  <li><a><i class="fa fa-desktop"></i> Banner <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?=site_url('admin/banners/add')?>">Add</a></li>
                      <li><a href="<?=site_url('admin/banners')?>">Manage</a></li>
                    </ul>
                  </li>
                  <li><a href="<?=site_url('admin/enquiry')?>"><i class="fa fa-bell"></i> Enquiry</a></li>
                  <li><a><i class="fa fa-file"></i> My documents <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?=site_url('admin/documents/add')?>">Add</a></li>
                      <li><a href="<?=site_url('admin/documents')?>">Manage</a></li>
                    </ul>
                  </li>
                  <li><a href="<?=site_url('admin/about')?>"><i class="fa fa-pencil"></i> About Solar Now</a>
                    <!--<ul class="nav child_menu">-->
                    <!--  <li><a href="<?=site_url('admin/about/add')?>">Add</a></li>-->
                    <!--  <li><a href="<?=site_url('admin/about')?>">Manage</a></li>-->
                    <!--</ul>-->
                  </li>
                  <li><a><i class="fa fa-book"></i>How To Use<span class="fa fa-chevron-down"></span></a>
                     <ul class="nav child_menu">
                       <li><a href="<?=site_url('admin/how_to_use/add')?>">Add</a></li>
                       <li><a href="<?=site_url('admin/how_to_use')?>">Manage</a></li>
                     </ul>
                  </li>
                  <li><a><i class="fa fa-question-circle"></i>FAQ <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?=site_url('admin/faq/add')?>">Add</a></li>
                      <li><a href="<?=site_url('admin/faq')?>">Manage</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-certificate"></i>Certificate <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?=site_url('admin/certificate/add')?>">Add</a></li>
                      <li><a href="<?=site_url('admin/certificate')?>">Manage</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-newspaper-o"></i>News<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?=site_url('admin/news/add')?>">Add</a></li>
                      <li><a href="<?=site_url('admin/news')?>">Manage</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-question"></i>Polls<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?=site_url('admin/polls/upcoming')?>">Upcoming polls</a></li>
                      <li><a href="<?=site_url('admin/polls/completed')?>">Completed polls</a></li>
                      <li><a href="<?=site_url('admin/polls/add')?>">Add polls</a></li>
                    </ul>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/product_review')?>"><i class="fa fa-star"></i> Product Reviews</a>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/feedback')?>"><i class="fa fa-comments-o"></i> Feedback</a>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/chats')?>"><i class="fa fa-commenting-o"></i> Chats</a>
                  </li>
                  <!-- <li><a><i class="fa fa-envelope"></i>SMS Gateway <span class="fa fa-chevron-down"></span></a>-->
                  <!--  <ul class="nav child_menu">-->
                  <!--    <li><a href="<?=site_url('admin/sms/add')?>">Add</a></li>-->
                  <!--    <li><a href="<?=site_url('admin/sms')?>">Manage</a></li>-->
                  <!--  </ul>-->
                  <!--</li>-->
                  <li><a><i class="fa fa-phone"></i>Call Button<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?=site_url('admin/calls/add')?>">Add</a></li>
                      <li><a href="<?=site_url('admin/calls')?>">Manage</a></li>
                    </ul>
                  </li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->


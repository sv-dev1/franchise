<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo site_url() ?>assets/images/favicon.ico" type="image/ico" />

    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <!-- Bootstrap -->
    <link href="<?php echo site_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <!-- iCheck -->
    <link href="<?php echo site_url() ?>assets/css/green.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo site_url() ?>assets/css/custom.min.css" rel="stylesheet">
  </head>
<?php
$uid =  $this->session->userdata('user_id'); 
$query = $this->db->get_where('users',array('id' => $uid));
$result = $query->row();
$uname = $result->username;
?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo site_url(); ?>" class="site_title"><i class="fa fa-paw"></i> <span>Admin Panel</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo site_url() ?>assets/images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <span><?php echo ucfirst($uname);?></span>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home</a></li>
                  <?php if($this->ion_auth->logged_in() && $this->ion_auth->is_admin()){ ?>
                  <li><a><i class="fa fa-edit"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url(); ?>register">Add User</a></li>
                      <li><a href="<?php echo site_url(); ?>list_user">List Users</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-desktop"></i> Plans <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url(); ?>user/addPlan">Add Plan</a></li>
                      <li><a href="<?php echo site_url(); ?>user/allPlan">List Plans</a></li>
                    </ul>
                  </li>
                <?php }else{ ?>
                    <li><a><i class="fa fa-edit"></i> Upgrade  <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url('edit_user/').$uid ?>">Upgrade Pack</a></li>
                    </ul>
                  </li>
               <?php  } ?>
                 
                   <li><a><i class="fa fa-clone"></i> Affiliate Link <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url(); ?>user/viewAflink/">View Affiliate Link</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-clone"></i> View Bonus <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url(); ?>user/bonus/">Bonus</a></li>
                    </ul>
                  </li>
                 </ul>
              </div>
           </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo site_url() ?>assets/images/img.jpg" alt=""><?php echo ucfirst($uname); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo site_url('edit_user/').$uid ?>"> Profile</a></li>
                  
                 
                    <li><a href="<?php echo site_url() ?>logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
	.login-form {
		width: 550px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
        background: #26B99A;
        border: 1px solid #169F85;
    }
</style>
</head>
<body> 
<div class="login-form">
  <div class="clearfix"></div>
    <div class="row">
       <?php
        //$link = '';
        //$form_data = array();
        if (validation_errors()) :
        ?>
        <div class="col-md-12">
          <div class="alert alert-danger" role="alert">
            <?= validation_errors() ?>
          </div>
        </div>
      <?php endif; ?>
       <?php if ($this->session->flashdata('message') != '') : ?>
        <div class="col-md-12">
          <div class="alert alert-success alert-main" role="alert">
            <?php echo $this->session->flashdata('message'); ?>
          </div>
        </div>
      <?php endif; ?>
      <?php if (isset($message1) && !empty($message1)) : ?>
        <div class="col-md-12">
          <div class="alert alert-danger" role="alert">
            <?php echo $message1; ?>
          </div>
        </div>
      <?php endif; ?>
       <?php if (isset($cntmssg) && !empty($cntmssg)) : ?>
        <div class="col-md-12">
          <div class="alert alert-danger" role="alert">
            <?php echo $cntmssg; ?>
          </div>
        </div>
      <?php endif; ?>
</div>
   <?php echo form_open("register");?>
        <h2 class="text-center">Register</h2>  
              <?php
      if($identity_column!=='email') {
          echo '<p>';
          echo lang('create_user_identity_label', 'identity');
          echo '<br />';
          echo form_error('identity');
          echo form_input($identity);
          echo '</p>';
      }
      ?>   
      
         <div class="form-group">
            <?php echo form_input($user_name); ?>
        </div> 
        <div class="form-group">
            <?php echo form_input($identity); ?>
        </div>
        <div class="form-group">
           <?php echo form_input($password); ?>
        </div>
        <div class="form-group">
      
            <?php echo form_input($password_confirm); ?>
        </div>
        <div class="form-group" >
             
            <?php   
              $options = array(
                'select' => 'Select Country',
                'portugal' => 'Portugal',
                'brazil' => 'Brazil',
                'india' => 'India',
                'us' => 'US',
                'aus' => 'Australia',
          );

              echo form_dropdown($country, $options); ?>
        </div>
         <div class="form-group">
           <?php 
           echo form_dropdown($plan, $planOptions); ?>
        </div>
       <div class="form-group">
             <?php echo form_input($phone); ?>
        </div>
        <div class="form-group">
           <?php echo form_input($skype); ?>
        </div>
         <div class="form-group">
            <?php echo form_input($aflink); ?>
        </div>
                   
        <div class="form-group"> 
            <button type="submit" class="btn btn-primary btn-block"><?php echo  lang('create_user_submit_btn') ?></button>
        </div>     
    <?php echo form_close();?>
    <p class="text-center"><a href="<?php echo base_url() ?>login">Go to Login Page</a></p>
</div>
</body>
</html>                                		                            
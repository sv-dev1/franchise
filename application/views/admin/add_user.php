<div class="right_col" role="main">
    <div class="clearfix"></div>
      <div class="row">
       <?php if (validation_errors()) :
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
</div>
     <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_title">
        <h2>Add User</h2>
        <div class="clearfix"></div>
      </div>
   <?php echo form_open("register",['class' => 'form-horizontal form-label-left']);?>
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
           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User Name <span class="required">*</span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control" placeholder="Username" required="required" name="user_name">
          </div>
        </div> 
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
            <input type="text"  class="form-control" placeholder="Email" required="required" name="identity">
          </div>
        </div>
        <div class="form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
            <input type="password" class="form-control" placeholder="Password" required="required" name="password">
          </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Confirm Password <span class="required">*</span>
                </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="password" class="form-control" placeholder="Confirm Password" required="required" name="password_confirm">
          </div>
        </div>
        <div class="form-group" >
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Select Country<span class="required">*</span>
                </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="country" class="form-control" data-parsley-group="first">
               <option value="">Select Country</option>
              <option value="india">India</option>
              <option value="us">US</option>
              <option value="aus">Australia</option>
            </select>
        </div>
      </div>
         <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Select Plan<span class="required">*</span>
                </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
            <select id="plan" name='plan' class="form-control" data-parsley-group="first">
                        <option value="">Select Plan</option>
                        <?php foreach ($plan as $option) {
                         ?>
                          <option value="<?php  echo $option['plan']; ?>"><?php  echo $option['plan']; ?></option>
                        <?php } ?>
            </select>
        </div>
      </div>
       <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Whatsapp<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control" placeholder="Whatsapp" required="required" name="phone">
        </div>
      </div>
        <div class="form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Skype<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control" placeholder="Skype" required="required" name="skype">
        </div>
      </div>
      <div class="form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Affiliate Link<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control" placeholder="Affiliate Link" required="required" value="<?php echo $link; ?>" name="aflink">
        </div>
      </div>
        <div class="form-group"> 
             <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button class="btn btn-primary" type="reset">Reset</button>
            <button type="submit" class="btn btn-success"><?php echo  lang('create_user_submit_btn') ?></button>
        </div>   
        </div>  
    <?php echo form_close();?>
</div>
</div>
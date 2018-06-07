<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
       <?php if (validation_errors()) : ?>
        <div class="col-md-12">
          <div class="alert alert-danger" role="alert">
            <?= validation_errors() ?>
          </div>
        </div>
      <?php endif; ?>
       <?php if (isset($message)) : ?>
        <div class="col-md-12">
          <div class="alert alert-success" role="alert">
            <?php echo $message;?>
          </div>
        </div>
      <?php endif; ?>
       <?php if (isset($error)) : ?>
        <div class="col-md-12">
          <div class="alert alert-success" role="alert">
            <?= $error ?>
          </div>
        </div>
      <?php endif; ?>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit User</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
         
            <!-- <form id="demo-form2" method='post' data-parsley-validate class="form-horizontal form-label-left"> -->
              <?php echo form_open(uri_string(),['class' => 'form-horizontal form-label-left', 'data-parsley-validate' => '']);?>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">User Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <!--  <input type="text" id="first-name" name="first-name" required="required" class="form-control col-md-7 col-xs-12"> -->
                 <?php echo form_input($username);?>
                </div>
              </div>                   
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Whatsapp <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <!-- <input type="email" id="email-address" name="email-address" required="required" class="form-control col-md-7 col-xs-12"> -->
                  <?php 
                  echo form_input($phone);?>
                </div>
              </div>
               <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cause-name">Plan <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <select id="cause" name='plan' class="form-control col-md-7 col-xs-12" data-parsley-group="first">
                        <option value="">Select Plan</option>
                        <?php 
                        $plan_query = $this->db->get_where('plans',array('id' => $user->plan));
                        $plan_result = $plan_query->row();
                        $plan_name = $plan_result->plan;
                        foreach ($plans as $option) {  ?>
                          <option value="<?php  echo $option->plan; ?>" <?php echo $option->plan == $plan_name ? "selected" : "";?>><?php echo $option->plan; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                  </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password: (if changing password)
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <!-- <input type="email" id="email-address" name="email-address" required="required" class="form-control col-md-7 col-xs-12"> -->
                  <?php echo form_input($password);?>
                </div>
              </div>
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Confirm Password: (if changing password) <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <!-- <input type="text" id="email-address" name="password" required="required" class="form-control col-md-7 col-xs-12"> -->
                  <?php echo form_input($password_confirm);?>
                </div>
              </div>

              <?php if ($this->ion_auth->is_admin()): ?>
                 <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><?php echo lang('edit_user_groups_heading');?> </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php foreach ($groups as $group):?>
                      <label class="checkbox">
                      <?php
                          $gID=$group['id'];
                          $checked = null;
                          $item = null;
                          foreach($currentGroups as $grp) {
                              if ($gID == $grp->id) {
                                  $checked= ' checked="checked"';
                              break;
                              }
                          }
                      ?>
                      <input type="checkbox" class='' name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                      <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                      </label>
                    
                  <?php endforeach?>
                  </div>
                </div>
              <?php endif ?>

              <?php echo form_hidden('id', $user->id);?>
              <?php echo form_hidden($csrf); ?>

            
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button class="btn btn-primary" type="reset">Reset</button>
                  <?php echo form_submit('submit', 'Update User', ['class' => 'btn btn-success']);?>
                </div>
              </div>
            <?php echo form_close();?>
          </div>
        </div>
      </div>
    </div>             
  </div>
</div>

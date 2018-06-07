<div class="right_col" role="main">
  <div class="">
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
       <?php if ($this->session->flashdata('success') != '') : ?>
        <div class="col-md-12">
          <div class="alert alert-success alert-main" role="alert">
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        </div>
      <?php endif; ?>

    </div>

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Update Plan</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <br />
           <!--  <form id="demo-form2" method='post' data-parsley-validate class="form-horizontal form-label-left"> -->
            <?php echo form_open("user/editPlan/".$data->id,['class' => 'form-horizontal form-label-left']);?>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Plan Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <!-- <input type="text" name="plan" id="plan" placeholder="Plan Name" value="<?php echo $data->plan; ?>" class="form-control col-md-7 col-xs-12"> -->
                  <?php echo form_input('plan', set_value('plan',$data->plan,TRUE)); ?>

                </div>
                 <input type="hidden" name="id" value="<?php echo $data->id; ?>">
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Aquisition<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <!--  <input type="text" name="points" id="points" placeholder="Plan points" value="<?php echo $data->points; ?>" class="form-control col-md-7 col-xs-12"> -->
                  <?php echo form_input('aquisition', set_value('aquisition',$data->aquisition,TRUE)); ?>
                </div> 
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Points<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <!--  <input type="text" name="points" id="points" placeholder="Plan points" value="<?php echo $data->points; ?>" class="form-control col-md-7 col-xs-12"> -->
                  <?php echo form_input('points', set_value('points',$data->points,TRUE)); ?>
                </div> 
              </div>
              
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Plan Royaltie <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php echo form_input('royaltie', set_value('royaltie',$data->royaltie,TRUE)); ?>
                </div> 
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bonus Estagio <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php echo form_input('bonus_estagio', set_value('bonus_estagio',$data->bonus_estagio,TRUE)); ?>
                </div> 
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fast Bonus <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php echo form_input('fast_bonus', set_value('fast_bonus',$data->fast_bonus,TRUE)); ?>
                </div> 
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bonus Direct <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php echo form_input('bonus_direct', set_value('bonus_direct',$data->bonus_direct,TRUE)); ?>
                </div> 
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bonus Indirect<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php echo form_input('bonus_indirect', set_value('bonus_indirect',$data->bonus_indirect,TRUE)); ?>
                </div> 
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assistant Bonus<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php echo form_input('assistant_bonus', set_value('assistant_bonus',$data->assistant_bonus,TRUE)); ?>
                </div> 
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Guests<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php echo form_input('guests', set_value('guests',$data->guests,TRUE)); ?>
                </div> 
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Equivalence Bonus<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php echo form_input('equivalence_bonus', set_value('equivalence_bonus',$data->equivalence_bonus,TRUE)); ?>
                </div> 
              </div>


              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?php echo form_submit('submit', 'Save Plan', ['class' => 'btn btn-success']);?>
                 <!--  <button type="submit" class="btn btn-success">Submit</button> -->
                </div>
              </div>
            <?php echo form_close();?>
          </div>
        </div>
      </div>
    </div>             
  </div>
</div>

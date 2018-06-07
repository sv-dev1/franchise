
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
            <h2>Add Plan</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
           <!--  <form id="demo-form2" method='post' data-parsley-validate class="form-horizontal form-label-left"> -->
            <?php echo form_open("user/addPlan",['class' => 'form-horizontal form-label-left']);?>
            <!--  <input type="hidden" name="id" value="<?php echo $id++; ?>"> -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Plan Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="plan" id="cause" placeholder="Plan Name" class="form-control col-md-7 col-xs-12">
                  
                </div>
              </div>
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Aquisition<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="aquisition" id="aquisition" placeholder="Plan Aquisition" class="form-control col-md-7 col-xs-12">
                </div> 
              </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Points<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="points" id="points" placeholder="Plan Points" class="form-control col-md-7 col-xs-12">
                </div> 
              </div>              
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Plan Royaltie <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="royaltie" id="royaltie" placeholder="Plan Royaltie" class="form-control col-md-7 col-xs-12">
                </div> 
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bonus Estagio <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="bonus_estagio" id="bonus_estagio" placeholder="Bonus Estagio" class="form-control col-md-7 col-xs-12">
                </div> 
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fast Bonus <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="fast_bonus" id="fast_bonus" placeholder="Fast Bonus" class="form-control col-md-7 col-xs-12">
                </div> 
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bonus Direct<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="bonus_direct" id="bonus_direct" placeholder="Bonus Direct" class="form-control col-md-7 col-xs-12">
                </div> 
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bonus Indirect <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="bonus_indirect" id="bonus_indirect" placeholder="Bonus Indirect" class="form-control col-md-7 col-xs-12">
                </div> 
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assistant Bonus<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="assistant_bonus" id="assistant_bonus" placeholder="Assistant Bonus" class="form-control col-md-7 col-xs-12">
                </div> 
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Guests<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="guests" id="guests" placeholder="Enter comma seperated values.." class="form-control col-md-7 col-xs-12">
                </div> 
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Equivalence Bonus<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="equivalence_bonus" id="equivalence_bonus" placeholder="Equivalence Bonus" class="form-control col-md-7 col-xs-12">
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

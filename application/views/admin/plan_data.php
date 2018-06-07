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
          <?php if ($this->session->flashdata('success') != '') : ?>
        <div class="col-md-12">
          <div class="alert alert-success alert-main" role="alert">
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        </div>
      <?php endif; ?>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Manage Plans</h2>
            <div class="clearfix"></div>
          </div>
           <div class='table_buttons'>  
             <button><?php echo anchor('user/addPlan', 'Create New Plan', ['class' => 'custom_new_btn'])?></button>
          </div>
          <div class="x_content">
            <div class="table-responsive">
              <table id='causeData' class="table table-striped jambo_table bulk_action">
                <thead>
                  <tr class="headings">
                    <th class="column-title">ID </th>
                    <th class="column-title">Plan Name</th>
                    <th class="column-title">Actions</th>
                  </tr>
                </thead>

                <tbody>
                  <?php $i=1; ?>
                 <?php foreach ($data as $row)  {?>
                  <tr class="even pointer">
                    <td class=" "><?php echo $i++; ?></td>
                    <td class=" "><?php echo $row->plan; ?></td>
                    <td class=" last">
                      <a href="<?php echo site_url('/user/editPlan/'. $row->id.''); ?>" style="font-size: 20px;color: #1ABB9C;"><i class="fa fa-edit"></i></a> &nbsp; <a href="<?php echo site_url('/user/deletePlan/'. $row->id.''); ?>" class="remCF"><i class="fa fa-remove delete_btn"></i></a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

    //  var selectedID = [];
/*  function deleteCause()
  {
    oTable.$('input[type="checkbox"]').each(function()
    {
        if(this.checked)
        {
            selectedID.push(this.value);
        } 
    });

    if(selectedID != '')
    {
      $.ajax({
        type : 'POST',
        url  : 'delete_select_cause',
        data : {
          selctedIds : JSON.stringify(selectedID),
        },
        success : function(response){
          alert("Selected Course deleted successfully.");
          location.reload();
        }
      });
        selectedID.length = 0;
    }
    else
    {
      alert('Please select any Course which you want to delete.')
    }
  }
*/
         var oTable = $("#causeData").DataTable({
        order: [],
         columnDefs: [ { orderable: false, targets: [0]},{ orderable: false, targets: [3]}],

    }); 
</script>



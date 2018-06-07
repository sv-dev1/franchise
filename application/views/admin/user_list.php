<!-- page content -->
          <div class="right_col" role="main">
            <!-- top tiles -->
        
          <a href="<?php echo site_url('register'); ?>"><button>Add User</button></a>

          <div id="infoMessage"><h1><?php echo $message;?></h1></div>
          <table id="userData" cellpadding=0 cellspacing=10>
           <thead>
                  <tr class="headings">
                    <th class="column-title">Id </th>
                    <th class="column-title">Username </th>
                    <th class="column-title">Email </th>
                    <th class="column-title">Country </th>
                    <th class="column-title">Whatsapp </th>
                    <th class="column-title">Groups </th>
                    <th class="column-title">Status </th>
                    <th class="column-title">Action </th>
                  </tr>
                </thead>
                <tbody>
           <?php foreach ($users as $user):?>
          <tr>
              <td><?php echo htmlspecialchars($user->id,ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($user->country,ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($user->phone,ENT_QUOTES,'UTF-8');?></td>
          <td>
          <?php foreach ($user->groups as $group):?>
                      <label><?php echo $group->name ?></label>,
            <!-- <?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br /> -->
                  <?php endforeach?>
          </td>
          <td><button class="btn-btn-success"><?php echo ($user->active) ? anchor("deactivate/".$user->id, lang('index_active_link')) : anchor("activate/". $user->id, lang('index_inactive_link'));?></button></td>
          <td><?php echo anchor("edit_user/".$user->id, 'Edit') ;?></td>
          </tr>
          <?php endforeach;?>
        </tbody>
          </table>
          </div>
        <!-- /page content -->
<script>
$(document).ready( function () {
    $('#userData').DataTable( {
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    } )
} );
</script>

       

<!-- page content -->
          <div class="right_col" role="main">
            <!-- top tiles -->
          <h1><?php echo lang('index_heading');?></h1>
          <p><?php echo lang('index_subheading');?></p>

          <div id="infoMessage"><h1><?php echo $message;?></h1></div>

          <table cellpadding=0 cellspacing=10>
          <tr>
          <th><?php echo lang('index_fname_th');?></th>
          <th><?php echo lang('index_lname_th');?></th>
          <th><?php echo lang('index_email_th');?></th>
          <th><?php echo lang('index_groups_th');?></th>
          <th><?php echo lang('index_status_th');?></th>
          <th><?php echo lang('index_action_th');?></th>
          </tr>
          <?php foreach ($users as $user):?>
          <tr>
              <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
          <td>
          <?php foreach ($user->groups as $group):?>
                      <label><?php echo $group->name ?></label>,
            <!-- <?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br /> -->
                  <?php endforeach?>
          </td>
          <td><?php echo ($user->active) ? anchor("deactivate/".$user->id, lang('index_active_link')) : anchor("activate/". $user->id, lang('index_inactive_link'));?></td>
          <td><?php echo anchor("edit_user/".$user->id, 'Edit') ;?></td>
          </tr>
          <?php endforeach;?>
          </table>
          </div>
        <!-- /page content -->

       

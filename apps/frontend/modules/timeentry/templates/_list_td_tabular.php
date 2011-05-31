<td class="sf_admin_date sf_admin_list_td_date">
  <?php echo false !== strtotime($timeentry->getDate()) ? format_date($timeentry->getDate(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_description">
  <?php echo $timeentry->getDescription() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_hours">
  <?php echo $timeentry->getHours() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_person_id">
  <a href="<?php echo url_for('person_edit', array('id'=>$timeentry->getPersonDbId())) ?>">
    Link
  </a>
</td>
<td class="sf_admin_text sf_admin_list_td_project_id">
  <a href="<?php echo url_for('person_edit', array('id'=>$timeentry->getProjectDbId())) ?>">
    Link
  </a>
</td>

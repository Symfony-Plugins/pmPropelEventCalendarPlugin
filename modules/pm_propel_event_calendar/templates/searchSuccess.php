<?php use_helper('I18N') ?>

<?php if (count($results)): ?>
  <table>
    <tr>
      <th><?php echo $class ?></th>
    </tr>
    <?php foreach ($results as $result): ?>
      <tr>
        <td><?php echo $result ?></td>
      </tr>
    <?php endforeach ?>
  </table>
<?php else: ?>
  <?php echo __('No result', array(), 'sf_admin') ?>
<?php endif ?>

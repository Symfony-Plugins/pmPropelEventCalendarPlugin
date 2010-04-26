<?php use_helper('I18N', 'Date') ?>

<?php include_partial('pm_propel_event_calendar/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo $title ?></h1>

  <div id="pm_propel_event_calendar"></div>

  <script>
    $(function()
    {
      $('#pm_propel_event_calendar').datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, inst)
        {
          $.ajax({
            url: '<?php echo url_for('@pm_propel_event_calendar_search') ?>?date='+dateText,
            success: function(data)
            {
              $('#sf_admin_content').html(data);
            }
          });
        }
      });
    });
  </script>

  <div id="sf_admin_content" style="margin-top: 20px;"></div>
</div>

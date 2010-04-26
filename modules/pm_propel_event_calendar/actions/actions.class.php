<?php

/**
 * pm_propel_event_calendar actions.
 *
 * @package pm_event_calendar
 * @author     Patricio Mac Adden <pmacadden@cespi.unlp.edu.ar>
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class pm_propel_event_calendarActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->title = sfConfig::get('app_pm_propel_event_calendar_title', 'Event calendar');
  }

 /**
  * Executes search action
  *
  * @param sfRequest $request A request object
  */
  public function executeSearch(sfWebRequest $request)
  {
    $selected_date = $request->getParameter('date');
    $this->class = sfConfig::get('app_pm_propel_event_calendar_class', 'Event');
    $peer_class = $this->class.'Peer';
    $column = sfConfig::get('app_pm_propel_event_calendar_column', 'DATE');
    $peer_method = sfConfig::get('app_pm_propel_event_calendar_peer_method', 'doSelect');
    $order = sfConfig::get('app_pm_propel_event_calendar_order', 'desc');
    $module = sfConfig::get('app_pm_propel_event_calendar_module');

    $c = new Criteria();
    $c->add(constant("$peer_class::$column"), $selected_date);

    if ($order == 'desc')
    {
      $c->addDescendingOrderByColumn(constant("$peer_class::$column"));
    }
    else
    {
      $c->addAscendingOrderByColumn(constant("$peer_class::$column"));
    }

    if (!is_null($module))
    {
      $filters = array(
        sfInflector::underscore($column) => array(
          "from" => $selected_date,
          "to" => $selected_date
        )
      );

      $this->getUser()->setAttribute(sfInflector::underscore($this->class).".filters", $filters, 'admin_module');
      $this->redirect(sfInflector::underscore($this->class)."/index");
    }
    else
    {
      $this->results = call_user_func(array($peer_class, $peer_method), $c);
    }
  }
}

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
    $this->selected_date = $request->getParameter('date');
    $this->class = sfConfig::get('app_pm_propel_event_calendar_class', 'Event');
    $this->peer_class = $this->class.'Peer';
    $this->column = sfConfig::get('app_pm_propel_event_calendar_column', 'DATE');
    $this->peer_method = sfConfig::get('app_pm_propel_event_calendar_peer_method', 'doSelect');
    $this->order_by_column = sfConfig::get('app_pm_propel_event_calendar_order_by_column', 'DATE');
    $this->order = sfConfig::get('app_pm_propel_event_calendar_order', 'desc');
    $this->module = sfConfig::get('app_pm_propel_event_calendar_module');

    $c = new Criteria();
    $c->add(constant($this->peer_class."::".$this->column), $this->selected_date);

    if ($this->order == 'desc')
    {
      $c->addDescendingOrderByColumn(constant($this->peer_class."::".$this->order_by_column));
    }
    else
    {
      $c->addAscendingOrderByColumn(constant($this->peer_class."::".$this->order_by_column));
    }

    if (!is_null($this->module))
    {
      $filters = array(
        sfInflector::underscore($this->column) => array(
          "from" => $this->selected_date,
          "to" => $this->selected_date
        )
      );

      $this->getUser()->setAttribute(sfInflector::underscore($this->class).".filters", $filters, 'admin_module');
      $this->redirect(sfInflector::underscore($this->class)."/index");
    }
    else
    {
      $this->results = call_user_func(array($this->peer_class, $this->peer_method), $c);
    }
  }
}

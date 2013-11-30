<?php
/**
 * @package    ExecSQL
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       28.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */


defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * Class ExecSQLViewLog
 *
 * @since  1.0.0
 */
class ExecSQLViewLogs extends JViewLegacy
{
	/**
	 * Displays the s overview list
	 *
	 * @param   string  $tpl  - The template
	 *
	 * @return  mixed|void
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('state');
		$this->items = $this->get('Items');
		$this->status = $this->get('status');
		$this->pagination = $this->get('Pagination');

		$filter_state2 = JFactory::getApplication()->getUserStateFromRequest('com_execsql.logs.list.' . 'filter_state', 'filter_state', '', 'word');
		$this->filter['state'] = JHTML::_('grid.state', $filter_state2, 'JPUBLISHED', 'JUNPUBLISHED');

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Ads the toolbar buttons
	 *
	 * @return void
	 */
	public function addToolbar()
	{
		JToolBarHelper::title(JText::sprintf('COM_EXECSQL_LOG', 'sites'));
	}
}

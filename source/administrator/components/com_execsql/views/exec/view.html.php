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
 * Class ExecSQLExec
 *
 * @since  1.0
 */
class ExecSQLViewExec extends JViewLegacy
{
	/**
	 * Displays the form
	 *
	 * @param   string  $tpl  - The template
	 *
	 * @return  mixed|void
	 */
	public function display($tpl = null)
	{
		$this->addToolbar();
		parent::display();
	}

	/**
	 * Adds the toolbar buttons
	 *
	 * @return  void
	 */
	public function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_EXECSQL_EXEC'), 'levels');
	}
}

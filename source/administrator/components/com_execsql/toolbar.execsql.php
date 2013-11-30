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

$language = JFactory::getLanguage();
$language->load('com_execsql.sys', JPATH_ADMINISTRATOR, null, true);

$view = JFactory::getApplication()->input->get('task');

// $active2 = ($view == 'controlcenter');
// JSubMenuHelper::addEntry(JText::_('COM_CADVANCEDSLIDESHOW_CONTROLCENTER'), 'index.php?option=com_execsql&view=controlcenter', $active2);

$subMenus = array(
	'exec' => 'COM_EXECSQL_EXEC',
	'logs' => 'COM_EXECSQL_LOGS',
//	'settings' => 'COM_EXECSQL_SETTINGS',
	'information' => 'COM_EXECSQL_INFORMATIONS',

);

foreach ($subMenus as $key => $name)
{
	$active = ($view == $key);

	if ($key == 'categories')
	{
		JSubMenuHelper::addEntry(JText::_($name), 'index.php?option=com_categories&extension=com_execsql', $active);
	}
	else
	{
		JSubMenuHelper::addEntry(JText::_($name), "index.php?option=com_execsql&view=" . $key, $active);
	}
}

$active = ($view == 'liveupdate');
// JSubMenuHelper::addEntry(JText::_('COM_CADVANCEDSLIDESHOW_LIVEUPDATE'), 'index.php?option=com_execsql&view=liveupdate', $active);

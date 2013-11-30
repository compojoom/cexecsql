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

jimport('joomla.application.component.controller');

// ACL Check
if (!JFactory::getUser()->authorise('core.manage', 'com_execsql'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$input = JFactory::getApplication()->input;

JLoader::register('ExecSQLHelperSettings', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/settings.php');
JLoader::register('ExecSQLHelperBasic', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/basic.php');

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

// Toolbar
require_once JPATH_COMPONENT_ADMINISTRATOR . "/toolbar.execsql.php";

$jlang = JFactory::getLanguage();
$jlang->load('com_execsql', JPATH_SITE, 'en-GB', true);
$jlang->load('com_execsql', JPATH_SITE, $jlang->getDefault(), true);
$jlang->load('com_execsql', JPATH_SITE, null, true);
$jlang->load('com_execsql', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_execsql', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_execsql', JPATH_ADMINISTRATOR, null, true);

if ($input->get('view', '') == 'liveupdate')
{
	require_once JPATH_COMPONENT_ADMINISTRATOR . '/liveupdate/liveupdate.php';
	JToolBarHelper::preferences('com_execsql');
	LiveUpdate::handleRequest();

	return;
}

if ($input->get('view', '') == 'controlcenter')
{
	require_once JPATH_COMPONENT_ADMINISTRATOR . '/controlcenter/controlcenter.php';
	JToolBarHelper::preferences('com_execsql');
	CompojoomControlCenter::handleRequest();

	return;
}

if ($input->get('view', '') == 'information')
{
	require_once JPATH_COMPONENT_ADMINISTRATOR . '/controlcenter/controlcenter.php';
	JToolBarHelper::preferences('com_execsql');
	CompojoomControlCenter::handleRequest('information');

	return;
}

$controller = JControllerLegacy::getInstance('execsql');
$controller->execute($input->get('task'));
$controller->redirect();

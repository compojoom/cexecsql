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

$input = JFactory::getApplication()->input;
$task = $input->get('task', null);

// Checking if task is set
if (!$task)
{
	echo "No task specified";

	return;
}

// URL index.php?option=com_execsql&format=raw&view=requests&task=executesql
if ($task == 'executesql')
{
	JError::$legacy = false;

	$com = $input->get("com", '', 'string');

	echo JText::_("COM_EXECSQL_EXECUTED_COMMAND") . ": ";

	echo $com;

	echo "<br /><br />";

	if (empty($com))
	{
		ExecSQLHelperBasic::logExec($com, JText::_("COM_EXECSQL_EMPTY_COMMAND"));
		echo JText::_("COM_EXECSQL_EMPTY_COMMAND");

		return;
	}

	echo JText::_("COM_EXECSQL_RESULT") . ":<br />";

	try
	{
		$db = JFactory::getDbo();

		$db->setQuery($com);

		$rs = $db->execute();

		var_dump($rs);

		// Check String result
		if (is_string($rs))
		{
			$erg = $rs;
		}
		elseif(is_object($rs))
		{
			$rs = $db->loadObjectList();
			$erg = var_export($rs, true);
			var_dump($rs);
		}
		else
		{
			echo "Type mysql result";
			$rs = $db->loadObjectList();
			$erg = var_export($rs, true);
		}

		ExecSQLHelperBasic::logExec($com, $erg);
		echo $erg;
	}
	catch (Exception $e)
	{
		ExecSQLHelperBasic::logExec($com, JText::_("COM_EXECSQL_CAUGHT_EXCEPTION") . ": <br />" . $e->getMessage(), "\n");
		echo JText::_("COM_EXECSQL_CAUGHT_EXCEPTION") . ": <br />" . $e->getMessage(), "\n";
	}
}

jexit();

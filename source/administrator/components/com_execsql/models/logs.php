<?php
/**
 * @package    FFGate
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       26.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com - Yves Hoppe. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

/**
 * Class ExecSQLModelLogs
 *
 * @since  1.0.0
 */
class ExecSQLModelLogs extends JModelList
{
	/**
	 * The constructor
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'cc.id',
				'sitename', 'cc.sitename',
				'fbuser', 'cc.fbuser',
				'title', 'cc.title',
				'caption', 'cc.caption',
				'description', 'cc.description'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		parent::populateState('cc.created', 'asc');
	}

	/**
	 * Get the context
	 *
	 * @return null|string
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return  JDatabaseQuery   A JDatabaseQuery object to retrieve the data set.
	 */
	public function getListQuery()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*')->from('#__execsql AS cc');

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			$searchfields = array(
				'cc.command',
				'cc.result',
				'cc.created',
				'cc.user_id'
			);

			if (stripos($search, 'id:') === 0)
			{
				$query->where('cc.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where(implode(" LIKE " . $search . " OR ", $searchfields));
			}
		}

		$orderCol = $this->state->get('list.ordering');
		$orderDir = $this->state->get('list.direction');

		$query->order($orderCol . ' ' . $orderDir);

		return $query;
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return    JTable    A database object
	 */
	public function getTable($type = 'ExecSQL', $prefix = 'Table', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
}
